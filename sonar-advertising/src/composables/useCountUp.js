import { ref, onBeforeUnmount } from 'vue'

const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4)

export function useCountUp(targetNumber, duration = 1800) {
  const displayValue = ref('0+')
  let rafId = null

  const start = () => {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
    if (prefersReduced) {
      displayValue.value = `${targetNumber}+`
      return
    }

    let startTime = null

    const tick = (timestamp) => {
      if (!startTime) startTime = timestamp
      const progress = Math.min((timestamp - startTime) / duration, 1)
      const current = Math.round(targetNumber * easeOutQuart(progress))
      displayValue.value = `${current}+`

      if (progress < 1) {
        rafId = requestAnimationFrame(tick)
      } else {
        displayValue.value = `${targetNumber}+`
      }
    }

    rafId = requestAnimationFrame(tick)
  }

  onBeforeUnmount(() => {
    if (rafId) {
      cancelAnimationFrame(rafId)
    }
  })

  return { displayValue, start }
}
