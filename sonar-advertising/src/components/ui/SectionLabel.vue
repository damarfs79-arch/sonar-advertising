<template>
  <div class="flex items-center gap-3 mb-3">
    <span class="w-8 h-0.5 bg-brand-orange"></span>
    <span class="section-label">{{ text }}</span>
  </div>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    required: true
  }
})
</script>