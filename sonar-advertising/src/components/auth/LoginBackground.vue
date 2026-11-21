<template>
  <div class="login-bg-root absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
    <!-- Grid overlay with radial mask -->
    <div class="grid-layer"></div>

    <!-- 3 Ambient Drifting Orbs -->
    <div class="orb orb-a"></div>
    <div class="orb orb-b"></div>
    <div class="orb orb-c"></div>

    <!-- 8 Floating Advertising Icons with Mouse Parallax -->
    <div ref="iconsLayer" class="icons-layer">
      <!-- 1. Megafon (Orange) -->
      <div class="floating-icon d1" style="top: 9%; left: 8%; width: 64px; height: 64px">
        <svg viewBox="0 0 24 24">
          <path d="m3 11 18-5v12L3 14v-3z" />
          <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
        </svg>
      </div>

      <!-- 2. Pen Tool (White) -->
      <div class="floating-icon icon-white d2" style="top: 30%; left: 17%; width: 46px; height: 46px">
        <svg viewBox="0 0 24 24">
          <path d="m12 19 7-7 3 3-7 7-3-3z" />
          <path d="m18 13-1.5-7.5L2 2l3.5 14.5L13 18l5-5z" />
          <path d="m2 2 7.586 7.586" />
          <circle cx="11" cy="11" r="2" />
        </svg>
      </div>

      <!-- 3. Printer (Orange) -->
      <div class="floating-icon d3" style="bottom: 12%; left: 9%; width: 68px; height: 68px">
        <svg viewBox="0 0 24 24">
          <polyline points="6 9 6 2 18 2 18 9" />
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
          <rect x="6" y="14" width="12" height="8" />
        </svg>
      </div>

      <!-- 4. Palet Warna (White) -->
      <div class="floating-icon icon-white d4" style="bottom: 34%; left: 4%; width: 44px; height: 44px">
        <svg viewBox="0 0 24 24">
          <circle cx="13.5" cy="6.5" r=".5" />
          <circle cx="17.5" cy="10.5" r=".5" />
          <circle cx="8.5" cy="7.5" r=".5" />
          <circle cx="6.5" cy="12.5" r=".5" />
          <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
        </svg>
      </div>

      <!-- 5. Kamera (Orange) -->
      <div class="floating-icon d5" style="top: 10%; right: 9%; width: 66px; height: 66px">
        <svg viewBox="0 0 24 24">
          <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
          <circle cx="12" cy="13" r="3" />
        </svg>
      </div>

      <!-- 6. Lampu Ide (White) -->
      <div class="floating-icon icon-white d6" style="top: 31%; right: 15%; width: 46px; height: 46px">
        <svg viewBox="0 0 24 24">
          <path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5" />
          <path d="M9 18h6" />
          <path d="M10 22h4" />
        </svg>
      </div>

      <!-- 7. Grafik Batang (Orange) -->
      <div class="floating-icon d7" style="bottom: 11%; right: 8%; width: 64px; height: 64px">
        <svg viewBox="0 0 24 24">
          <line x1="12" y1="20" x2="12" y2="10" />
          <line x1="18" y1="20" x2="18" y2="4" />
          <line x1="6" y1="20" x2="6" y2="16" />
        </svg>
      </div>

      <!-- 8. Gambar / Frame (White) -->
      <div class="floating-icon icon-white d8" style="bottom: 35%; right: 4%; width: 44px; height: 44px">
        <svg viewBox="0 0 24 24">
          <rect x="3" y="3" width="18" height="18" rx="2" />
          <circle cx="9" cy="9" r="2" />
          <path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const iconsLayer = ref(null)
let rafId = 0

function handlePointerMove(e) {
  if (!iconsLayer.value) return
  cancelAnimationFrame(rafId)
  rafId = requestAnimationFrame(() => {
    if (!iconsLayer.value) return
    const x = ((e.clientX / window.innerWidth) - 0.5) * 24
    const y = ((e.clientY / window.innerHeight) - 0.5) * 24
    iconsLayer.value.style.transform = `translate(${-x}px, ${-y}px)`
  })
}

onMounted(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const finePointer = window.matchMedia('(pointer: fine)').matches
  if (!reduce && finePointer) {
    window.addEventListener('pointermove', handlePointerMove, { passive: true })
  }
})

onBeforeUnmount(() => {
  window.removeEventListener('pointermove', handlePointerMove)
  cancelAnimationFrame(rafId)
})
</script>

<style scoped>
.grid-layer {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background-image: 
    linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
  background-size: 44px 44px;
  -webkit-mask-image: radial-gradient(circle at 50% 50%, #000 20%, transparent 75%);
  mask-image: radial-gradient(circle at 50% 50%, #000 20%, transparent 75%);
}

.orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(90px);
  background: #ff7a00;
  animation: drift 18s ease-in-out infinite;
}

.orb-a {
  width: 380px;
  height: 380px;
  top: -110px;
  right: -70px;
  opacity: 0.24;
}

.orb-b {
  width: 320px;
  height: 320px;
  bottom: -100px;
  left: -70px;
  opacity: 0.15;
  animation-duration: 22s;
  animation-delay: -7s;
}

.orb-c {
  width: 220px;
  height: 220px;
  top: 40%;
  left: 55%;
  opacity: 0.07;
  animation-duration: 26s;
  animation-delay: -3s;
}

@keyframes drift {
  0%, 100% {
    transform: translate(0, 0) scale(1);
  }
  50% {
    transform: translate(-50px, 36px) scale(1.15);
  }
}

.icons-layer {
  position: absolute;
  inset: 0;
  transition: transform 0.25s ease-out;
  opacity: 0;
  animation: fadeInIcons 1s ease 1.15s forwards;
}

@keyframes fadeInIcons {
  to {
    opacity: 1;
  }
}

.floating-icon {
  position: absolute;
  color: #ff7a00;
  opacity: 0.3;
  will-change: transform;
  animation: floatIcon 7s ease-in-out infinite;
}

.floating-icon svg {
  display: block;
  width: 100%;
  height: 100%;
  fill: none;
  stroke: currentColor;
  stroke-width: 1.5;
  stroke-linecap: round;
  stroke-linejoin: round;
  filter: drop-shadow(0 0 10px rgba(255, 122, 0, 0.35));
}

.floating-icon.icon-white {
  color: #ffffff;
  opacity: 0.13;
}

.floating-icon.icon-white svg {
  filter: none;
}

@keyframes floatIcon {
  0%, 100% {
    transform: translateY(0) rotate(-5deg);
  }
  50% {
    transform: translateY(-26px) rotate(7deg);
  }
}

.d1 { animation-duration: 7s;   animation-delay: 0s; }
.d2 { animation-duration: 8.5s; animation-delay: -2s; }
.d3 { animation-duration: 6.5s; animation-delay: -4s; }
.d4 { animation-duration: 9s;   animation-delay: -1s; }
.d5 { animation-duration: 7.5s; animation-delay: -3s; }
.d6 { animation-duration: 8s;   animation-delay: -5s; }
.d7 { animation-duration: 6s;   animation-delay: -2.5s; }
.d8 { animation-duration: 9.5s; animation-delay: -6s; }

@media (max-width: 640px) {
  .floating-icon {
    opacity: 0.16;
  }
  .floating-icon.icon-white {
    opacity: 0.08;
  }
}

@media (prefers-reduced-motion: reduce) {
  .orb,
  .floating-icon {
    animation: none !important;
  }
  .icons-layer {
    opacity: 1 !important;
    animation: none !important;
    transition: none !important;
  }
}
</style>
