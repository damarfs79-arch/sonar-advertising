import { ref, onMounted, onBeforeUnmount } from 'vue'

export function useScrolled(threshold = 24) {
  const isScrolled = ref(false)

  const onScroll = () => {
    isScrolled.value = window.scrollY > threshold
  }

  onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true })
    onScroll()
  })

  onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll)
  })

  return { isScrolled }
}
