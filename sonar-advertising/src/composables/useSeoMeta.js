import { watchEffect, onUnmounted } from 'vue'

const DEFAULT_TITLE = 'Sonar Advertising – Jasa Pembuatan Huruf Timbul, Neon Box & Signage'
const DEFAULT_DESCRIPTION = 'Spesialis jasa pembuatan Huruf Timbul (Akrilik, Stainless, Galvanis), Neon Box Custom, Neon Flex, Papan Nama Toko, Fasad ACP & Billboard profesional di Jember, Kediri & Jawa Timur.'
const DEFAULT_KEYWORDS = 'sonar advertising, jasa huruf timbul jember, neon box jember, signmaker jember, advertising jember, huruf timbul stainless, huruf timbul akrilik, neon flex custom, papan nama toko, fasad acp, billboard jawa timur, advertising kediri, reklame jember'
const DEFAULT_IMAGE = '/favicon.png'

export function useSeoMeta(optionsGetter) {
  let scriptElement = null

  const updateMetaTag = (selector, attribute, value) => {
    if (!value) return
    let element = document.querySelector(selector)
    if (!element) {
      const match = selector.match(/meta\[(name|property)="([^"]+)"\]/)
      if (match) {
        element = document.createElement('meta')
        element.setAttribute(match[1], match[2])
        document.head.appendChild(element)
      }
    }
    if (element) {
      element.setAttribute(attribute, value)
    }
  }

  const updateCanonical = (url) => {
    let link = document.querySelector('link[rel="canonical"]')
    if (!link) {
      link = document.createElement('link')
      link.setAttribute('rel', 'canonical')
      document.head.appendChild(link)
    }
    link.setAttribute('href', url)
  }

  const updateJsonLd = (structuredData) => {
    if (scriptElement && scriptElement.parentNode) {
      scriptElement.parentNode.removeChild(scriptElement)
      scriptElement = null
    }
    if (!structuredData) return

    scriptElement = document.createElement('script')
    scriptElement.type = 'application/ld+json'
    scriptElement.textContent = JSON.stringify(structuredData)
    document.head.appendChild(scriptElement)
  }

  watchEffect(() => {
    const opts = typeof optionsGetter === 'function' ? optionsGetter() : optionsGetter || {}
    
    const title = opts.title ? `${opts.title}` : DEFAULT_TITLE
    const description = opts.description || DEFAULT_DESCRIPTION
    const keywords = opts.keywords || DEFAULT_KEYWORDS
    const image = opts.image || (window.location.origin + DEFAULT_IMAGE)
    const url = opts.url || window.location.href
    const type = opts.type || 'website'

    // Update document title
    document.title = title

    // Standard Meta Tags
    updateMetaTag('meta[name="description"]', 'content', description)
    updateMetaTag('meta[name="keywords"]', 'content', keywords)
    updateMetaTag('meta[name="robots"]', 'content', opts.robots || 'index, follow, max-image-preview:large')
    updateCanonical(url)

    // OpenGraph Meta Tags
    updateMetaTag('meta[property="og:title"]', 'content', title)
    updateMetaTag('meta[property="og:description"]', 'content', description)
    updateMetaTag('meta[property="og:image"]', 'content', image)
    updateMetaTag('meta[property="og:url"]', 'content', url)
    updateMetaTag('meta[property="og:type"]', 'content', type)
    updateMetaTag('meta[property="og:site_name"]', 'content', 'Sonar Advertising - Signmaker & Promotion')
    updateMetaTag('meta[property="og:locale"]', 'content', 'id_ID')

    // Twitter Meta Tags
    updateMetaTag('meta[name="twitter:card"]', 'content', 'summary_large_image')
    updateMetaTag('meta[name="twitter:title"]', 'content', title)
    updateMetaTag('meta[name="twitter:description"]', 'content', description)
    updateMetaTag('meta[name="twitter:image"]', 'content', image)
    updateMetaTag('meta[name="twitter:site"]', 'content', '@sonaradv')
    updateMetaTag('meta[name="twitter:creator"]', 'content', '@sonaradv')

    // JSON-LD Structured Data
    if (opts.jsonLd) {
      updateJsonLd(opts.jsonLd)
    }
  })

  onUnmounted(() => {
    if (scriptElement && scriptElement.parentNode) {
      scriptElement.parentNode.removeChild(scriptElement)
    }
  })
}
