<template>
  <div
    v-if="visible"
    :class="[
      'splash-container fixed inset-0 z-50 grid place-items-center bg-[#0d0e10]',
      fadingOut ? 'splash-fading' : ''
    ]"
    aria-hidden="true"
  >
    <div class="pulse-circle"></div>
    <div class="ring-circle"></div>
    <div class="logo-mark">
      <img
        src="/logo.png"
        alt="Sonar Advertising"
        class="w-16 h-16 object-contain drop-shadow-[0_0_16px_rgba(255,122,0,0.5)]"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  skip: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['finish'])

const visible = ref(!props.skip)
const fadingOut = ref(false)

onMounted(() => {
  if (props.skip) {
    visible.value = false
    emit('finish')
    return
  }

  // Check if reduced motion is requested
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    visible.value = false
    emit('finish')
    return
  }

  // Trigger fade out after 1000ms
  setTimeout(() => {
    fadingOut.value = true
  }, 1000)

  // Remove splash completely after 1550ms
  setTimeout(() => {
    visible.value = false
    emit('finish')
  }, 1550)
})
</script>

<style scoped>
.splash-container {
  pointer-events: none;
}

.splash-fading {
  animation: splashFadeOut 0.55s ease forwards;
}

.logo-mark {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: markScaleIn 0.7s cubic-bezier(0.2, 0.9, 0.3, 1.3) both;
}

.ring-circle {
  position: absolute;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 2px solid transparent;
  border-top-color: #ff7a00;
  border-right-color: rgba(255, 122, 0, 0.35);
  animation: spinRing 0.9s linear infinite, ringScaleIn 0.5s ease both;
}

.pulse-circle {
  position: absolute;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: #ff7a00;
  opacity: 0;
  animation: pulseOut 1.1s ease-out 0.2s;
}

@keyframes splashFadeOut {
  to {
    opacity: 0;
    visibility: hidden;
  }
}

@keyframes markScaleIn {
  from {
    opacity: 0;
    transform: scale(0.4) rotate(-12deg);
  }
  to {
    opacity: 1;
    transform: none;
  }
}

@keyframes ringScaleIn {
  from {
    opacity: 0;
    transform: scale(0.6);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes spinRing {
  to {
    transform: rotate(360deg);
  }
}

@keyframes pulseOut {
  0% {
    opacity: 0.35;
    transform: scale(0.6);
  }
  100% {
    opacity: 0;
    transform: scale(3.2);
  }
}

@media (prefers-reduced-motion: reduce) {
  .splash-container {
    display: none !important;
  }
}
</style>
