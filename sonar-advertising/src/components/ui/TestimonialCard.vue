<template>
  <article class="card-light p-6 flex flex-col gap-4">
    <!-- Stars -->
    <div class="flex gap-1" aria-label="5 bintang">
      <svg
        v-for="i in 5"
        :key="i"
        class="w-4 h-4 text-brand-orange"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
      </svg>
    </div>

    <blockquote class="text-brand-text-secondary text-sm leading-relaxed flex-1">
      "{{ testimonial.text }}"
    </blockquote>

    <div class="flex items-center gap-3 pt-2 border-t border-white/5">
      <div class="w-9 h-9 rounded-full bg-brand-orange/20 border border-brand-orange/30 flex items-center justify-center font-display font-bold text-brand-orange text-sm">
        {{ testimonial.name.charAt(0) }}
      </div>
      <div>
        <p class="text-white text-sm font-semibold">{{ testimonial.name }}</p>
        <p class="text-brand-text-secondary text-xs">{{ testimonial.role }}</p>
      </div>
    </div>
  </article>
</template>

<script setup>
defineProps({
  testimonial: {
    type: Object,
    required: true
  }
})
</script>