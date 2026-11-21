<template>
  <section class="stats" id="stats" aria-label="Statistik Perusahaan">
    <div class="in">
      <div
        v-for="(item, idx) in stats"
        :key="item.label || idx"
        :ref="el => setCardRef(el, idx)"
        class="stat reveal"
        :style="{ '--d': `${idx * 0.12}s` }"
      >
        <b class="tabular-nums">{{ displayValues[idx] }}</b>
        <span>{{ item.label }}</span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  statsData: {
    type: Array,
    default: () => [
      { count: 350, label: 'PROYEK SELESAI' },
      { count: 100, label: 'KLIEN PUAS' },
      { count: 5, label: 'TAHUN PENGALAMAN' }
    ]
  }
})

const stats = computed(() => {
  if (Array.isArray(props.statsData) && props.statsData.length > 0) {
    return props.statsData
  }
  return [
    { count: 350, label: 'PROYEK SELESAI' },
    { count: 100, label: 'KLIEN PUAS' },
    { count: 5, label: 'TAHUN PENGALAMAN' }
  ]
})

const displayValues = ref(stats.value.map(() => '0+'))
const cardRefs = ref([])
let sharedObserver = null
const activeRafs = []

const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4)

const setCardRef = (el, idx) => {
  if (el) cardRefs.value[idx] = el
}

const runCountUp = (target, idx, duration = 1800) => {
  const isReduced = typeof window !== 'undefined' && window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (isReduced) {
    displayValues.value[idx] = `${target}+`
    return
  }

  let startTime = null
  const tick = (timestamp) => {
    if (!startTime) startTime = timestamp
    const progress = Math.min((timestamp - startTime) / duration, 1)
    const current = Math.round(target * easeOutQuart(progress))
    displayValues.value[idx] = `${current}+`

    if (progress < 1) {
      const raf = requestAnimationFrame(tick)
      activeRafs[idx] = raf
    } else {
      displayValues.value[idx] = `${target}+`
    }
  }

  const raf = requestAnimationFrame(tick)
  activeRafs[idx] = raf
}

onMounted(() => {
  if (typeof window !== 'undefined' && 'IntersectionObserver' in window) {
    sharedObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in')
            const idx = cardRefs.value.indexOf(entry.target)
            if (idx !== -1 && stats.value[idx]) {
              runCountUp(stats.value[idx].count, idx)
            }
            sharedObserver.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.35 }
    )

    cardRefs.value.forEach((card) => {
      if (card) sharedObserver.observe(card)
    })
  } else {
    // Fallback if no IntersectionObserver
    stats.value.forEach((item, idx) => {
      if (cardRefs.value[idx]) cardRefs.value[idx].classList.add('in')
      displayValues.value[idx] = `${item.count}+`
    })
  }
})

onBeforeUnmount(() => {
  if (sharedObserver) {
    sharedObserver.disconnect()
    sharedObserver = null
  }
  activeRafs.forEach((raf) => {
    if (raf) cancelAnimationFrame(raf)
  })
})
</script>

<style scoped>
.stats {
  background: #1a1b1d;
  border-top: 1px solid rgba(255,255,255,.07);
}
.stats .in {
  max-width: 1280px;
  margin: 0 auto;
  padding: 36px 24px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  text-align: center;
}
.stat + .stat {
  border-left: 1px solid rgba(255,255,255,.08);
}
.stat b {
  display: block;
  font-size: clamp(36px, 5vw, 56px);
  font-weight: 800;
  color: var(--o, #ff7a00);
  letter-spacing: -.02em;
  font-variant-numeric: tabular-nums;
}
.stat span {
  display: block;
  margin-top: 4px;
  font-size: 13px;
  letter-spacing: .08em;
  color: #aeb1b8;
}
.reveal {
  opacity: 0;
  transform: translate3d(0,26px,0);
  transition: opacity 1s ease, transform 1.1s var(--ease, cubic-bezier(.22, 1, .36, 1));
  transition-delay: var(--d, 0s);
}
.reveal.in {
  opacity: 1;
  transform: none;
}

@media (max-width: 900px) {
  .stats .in {
    padding: 28px 12px;
  }
}
@media (prefers-reduced-motion: reduce) {
  .reveal {
    opacity: 1 !important;
    transform: none !important;
  }
}
</style>
