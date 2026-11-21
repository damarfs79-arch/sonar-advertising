<template>
  <article
    class="bg-white shadow-sm border border-neutral-200/80 rounded-2xl p-6 group hover:border-brand-orange/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-orange/5 flex flex-col justify-between"
  >
    <div>
      <!-- SVG Icon Container -->
      <div class="w-13 h-13 rounded-xl bg-orange-50 border border-brand-orange/15 flex items-center justify-center mb-5 group-hover:bg-brand-orange group-hover:border-brand-orange text-brand-orange group-hover:text-white transition-all duration-300">
        <component
          :is="service.iconComponent"
          class="w-6 h-6 transition-transform duration-300 group-hover:scale-110"
          aria-hidden="true"
        />
      </div>

      <h3 class="font-sans text-lg sm:text-xl font-bold text-neutral-900 mb-2 group-hover:text-brand-orange transition-colors duration-200">
        {{ service.name }}
      </h3>
      <p class="text-gray-600 text-sm leading-relaxed">{{ service.description }}</p>
    </div>

    <RouterLink
      to="/services"
      class="inline-flex items-center gap-1.5 text-brand-orange text-sm font-semibold mt-5 pt-3 border-t border-neutral-100 group-hover:translate-x-1 transition-all duration-200 cursor-pointer"
    >
      Selengkapnya
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
      </svg>
    </RouterLink>
  </article>
</template>

<script setup>
defineProps({
  service: {
    type: Object,
    required: true
  }
})
</script>
