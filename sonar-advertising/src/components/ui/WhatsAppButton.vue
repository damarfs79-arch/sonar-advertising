<template>
  <a
    href="https://wa.me/6285540000007?text=Halo%20Sonar%20Advertising%2C%20saya%20ingin%20memesan%20signage"
    target="_blank"
    rel="noopener noreferrer"
    class="wa"
    aria-label="Chat via WhatsApp"
  >
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.7-5.4A8.4 8.4 0 1 1 21 11.5Z" />
      <path d="M9 9.5c.3 2 2.2 4 4.5 4.5l1.3-1.2-1.8-1-.8.6c-.7-.3-1.4-1-1.7-1.7l.6-.8-1-1.8Z" />
    </svg>
  </a>
</template>

<style scoped>
.wa {
  position: fixed;
  right: 24px;
  bottom: 24px;
  z-index: 40;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: #22c55e;
  display: grid;
  place-items: center;
  box-shadow: 0 12px 28px -8px rgba(34,197,94,.6);
  animation: dropIn 1s var(--ease) 1.6s both;
  transition: transform .45s var(--ease);
}
.wa:hover {
  transform: scale(1.06);
}
.wa::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  border: 2px solid #22c55e;
  animation: ring 3s ease-out infinite;
}
.wa svg {
  width: 28px;
  height: 28px;
  fill: none;
  stroke: #fff;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}
@keyframes ring {
  0% { transform: scale(1); opacity: .6; }
  100% { transform: scale(1.7); opacity: 0; }
}
@keyframes dropIn {
  from { opacity: 0; transform: translate3d(0,-14px,0); }
  to { opacity: 1; transform: none; }
}

@media (prefers-reduced-motion: reduce) {
  .wa {
    animation: none !important;
  }
  .wa::after {
    animation: none !important;
    display: none;
  }
}
</style>
