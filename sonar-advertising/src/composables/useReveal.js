let sharedObserver = null
const elementsMap = new Map()

function getObserver() {
  if (!sharedObserver && typeof window !== 'undefined' && 'IntersectionObserver' in window) {
    sharedObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in')
            const callback = elementsMap.get(entry.target)
            if (callback) callback(entry.target)
            elementsMap.delete(entry.target)
            sharedObserver.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.35 }
    )
  }
  return sharedObserver
}

export function observeReveal(element, onIntersect) {
  if (!element) return
  const observer = getObserver()
  if (observer) {
    elementsMap.set(element, onIntersect)
    observer.observe(element)
  } else {
    element.classList.add('in')
    if (onIntersect) onIntersect(element)
  }
}

export function unobserveReveal(element) {
  if (!element) return
  elementsMap.delete(element)
  if (sharedObserver) {
    sharedObserver.unobserve(element)
  }
}
