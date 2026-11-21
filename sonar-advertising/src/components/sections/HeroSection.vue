<template>
  <section class="hero" aria-label="Hero section">
    <!-- Real Photo Background (when heroImage prop is provided and valid) -->
    <div v-if="hasHeroImage && !imageError" class="hero-bg">
      <img
        :src="heroImage"
        alt=""
        :class="{ loaded: imageLoaded }"
        @load="imageLoaded = true"
        @error="imageError = true"
      />
    </div>

    <!-- Fallback: Warm Realistic Full-Width Brick Wall -->
    <div v-else class="hero-fallback" aria-hidden="true"></div>

    <!-- Directional Warm Scrim Overlay: Soft translucent dark vignette on left, completely open on right -->
    <div class="hero-overlay" aria-hidden="true"></div>

    <!-- Main Content -->
    <div class="wrap">
      <div class="content">
        <!-- 3D Stainless Steel Signage (Desktop: right side; Mobile: positioned above headline) -->
        <div v-if="!hasHeroImage || imageError" class="sign3d-container" aria-hidden="true">
          <div class="sign3d">
            <!-- Bright Warm Amber Backlit LED Halo Glow -->
            <div class="w-halo"></div>

            <!-- 3D Extruded Metal Side Depth Shadow & Bright Backlight -->
            <div class="w-depth">
              <span class="sign-top">Huruf Timbul</span>
              <span class="sign-bottom">Stainless Steel</span>
            </div>

            <!-- Brushed Polished Stainless Steel Specular Face -->
            <div class="w-face">
              <span class="sign-top">Huruf Timbul</span>
              <span class="sign-bottom">Stainless Steel</span>
            </div>
          </div>
        </div>

        <h1>
          <span class="line"><span style="--d:0s">Visualkan</span></span>
          <span class="line"><span style="--d:.12s">Identitas <span class="grad">Bisnis Anda</span></span></span>
        </h1>
        <p class="lead fade" style="--d:.45s">
          Solusi signage, huruf timbul, neon box, dan reklame berkualitas tinggi dengan pengerjaan presisi untuk memperkuat citra profesional bisnis Anda di seluruh Jawa Timur.
        </p>
        <div class="cta fade" style="--d:.6s">
          <a
            href="https://wa.me/6285540000007?text=Halo%20Sonar%20Advertising%2C%20saya%20ingin%20memesan%20signage"
            target="_blank"
            rel="noopener noreferrer"
            class="btn primary"
          >
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.7-5.4A8.4 8.4 0 1 1 21 11.5Z" />
            </svg>
            Pesan via WhatsApp
          </a>
          <a href="#stats" class="btn ghost">
            Lihat Portofolio
            <svg class="arr" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M5 12h14" />
              <path d="m12 5 7 7-7 7" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  heroImage: {
    type: String,
    default: ''
  }
})

const hasHeroImage = computed(() => !!props.heroImage && props.heroImage.trim() !== '')
const imageLoaded = ref(false)
const imageError = ref(false)
</script>

<style scoped>
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  padding-top: 78px;
  isolation: isolate;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  color: #ffffff;
  background: #231a15;
}

/* Background image & Ken Burns */
.hero-bg {
  position: absolute;
  inset: -4%;
  z-index: -3;
  background: radial-gradient(ellipse at 70% 40%, #3a2a1c 0%, #1b1a19 55%, #111 100%);
  animation: kenburns 28s ease-in-out infinite alternate;
  will-change: transform;
}
.hero-bg img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: 70% center;
  opacity: 0;
  transition: opacity 1.4s ease;
}
.hero-bg img.loaded {
  opacity: 1;
}

/* Fallback: Warm Full-Width Brick Wall */
.hero-fallback {
  position: absolute;
  inset: 0;
  z-index: -3;
  overflow: hidden;
  background: #231a15 url('/warm-brick-wall.jpg') center center / cover no-repeat;
}

/* Directional Scrim Overlay: Warm, translucent vignette on left, completely open on right */
.hero-overlay {
  position: absolute;
  inset: 0;
  z-index: -2;
  background: 
    linear-gradient(90deg, rgba(20, 18, 16, 0.72) 0%, rgba(20, 18, 16, 0.6) 38%, rgba(20, 18, 16, 0.22) 65%, transparent 100%),
    linear-gradient(180deg, rgba(20, 18, 16, 0.4) 0%, transparent 20%, transparent 85%, rgba(20, 18, 16, 0.45) 100%);
}

/* 3D Signage container: Responsive positioning */
@media (min-width: 769px) {
  .sign3d-container {
    position: absolute;
    right: 6%;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .sign3d {
    transform: perspective(1000px) rotateY(-14deg) rotateX(4deg);
    padding: 30px 40px;
  }
}

@media (max-width: 1280px) and (min-width: 769px) {
  .sign3d-container {
    right: 3%;
    transform: translateY(-50%) scale(0.88);
  }
}

@media (max-width: 1024px) and (min-width: 769px) {
  .sign3d-container {
    right: 0%;
    opacity: 0.75;
    transform: translateY(-45%) scale(0.75);
  }
}

/* Mobile: Displayed clearly right above the headline */
@media (max-width: 768px) {
  .sign3d-container {
    position: relative;
    display: inline-flex;
    margin-bottom: 20px;
    z-index: 2;
    pointer-events: none;
  }
  .sign3d {
    transform: perspective(600px) rotateY(-10deg) rotateX(3deg) scale(0.68);
    transform-origin: left center;
    padding: 10px 0;
  }
}

.sign3d {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transform-style: preserve-3d;
  transition: transform 0.6s var(--ease, cubic-bezier(.22, 1, .36, 1));
}

/* Bright warm golden/amber halo backlight glowing onto the bricks */
.w-halo {
  position: absolute;
  inset: -60px -80px;
  border-radius: 50%;
  background: radial-gradient(ellipse at center, rgba(255, 185, 65, 0.85) 0%, rgba(255, 135, 25, 0.5) 45%, rgba(255, 105, 0, 0.18) 70%, transparent 85%);
  filter: blur(45px);
  z-index: 1;
  pointer-events: none;
  animation: pulseGlow 4s ease-in-out infinite alternate;
}
@keyframes pulseGlow {
  0% { opacity: 0.75; transform: scale(0.96); }
  100% { opacity: 1; transform: scale(1.04); }
}

/* 3D Extruded Metal Side Depth & Strong Backlight */
.w-depth {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  user-select: none;
}
.w-depth .sign-top {
  font-size: clamp(38px, 5.2vw, 76px);
  font-weight: 800;
  letter-spacing: -0.01em;
  line-height: 1.1;
  color: #1a1c20;
  text-shadow:
    1px 1px 0 #cbd5e1,
    2px 2px 0 #94a3b8,
    3px 3px 0 #64748b,
    4px 4px 0 #475569,
    5px 6px 0 #334155,
    6px 8px 18px rgba(0, 0, 0, 0.85),
    0 0 35px rgba(255, 185, 65, 0.95),
    0 0 75px rgba(255, 135, 25, 0.65);
}
.w-depth .sign-bottom {
  font-size: clamp(26px, 3.4vw, 48px);
  font-weight: 800;
  letter-spacing: 0.05em;
  line-height: 1.1;
  color: #1a1c20;
  margin-top: 6px;
  text-shadow:
    1px 1px 0 #cbd5e1,
    2px 2px 0 #94a3b8,
    3px 3px 0 #64748b,
    4px 4px 0 #475569,
    5px 6px 0 #334155,
    6px 8px 18px rgba(0, 0, 0, 0.85),
    0 0 35px rgba(255, 185, 65, 0.95),
    0 0 75px rgba(255, 135, 25, 0.65);
}

/* Brushed Polished Stainless Steel Front Face */
.w-face {
  position: absolute;
  inset: 0;
  z-index: 3;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  pointer-events: none;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  user-select: none;
}
.w-face .sign-top {
  font-size: clamp(38px, 5.2vw, 76px);
  font-weight: 800;
  letter-spacing: -0.01em;
  line-height: 1.1;
  background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 25%, #cbd5e1 50%, #f8fafc 75%, #ffffff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 2px 4px rgba(255, 255, 255, 0.85));
}
.w-face .sign-bottom {
  font-size: clamp(26px, 3.4vw, 48px);
  font-weight: 800;
  letter-spacing: 0.05em;
  line-height: 1.1;
  margin-top: 6px;
  background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 30%, #94a3b8 55%, #e2e8f0 80%, #ffffff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 1px 3px rgba(255, 255, 255, 0.75));
}

@keyframes kenburns {
  from { transform: scale(1) translate3d(0,0,0); }
  to { transform: scale(1.07) translate3d(-1.2%, -.8%, 0); }
}

.wrap {
  max-width: 1280px;
  width: 100%;
  margin: 0 auto;
  padding: 40px 24px 60px;
}
.content {
  max-width: 780px;
}
h1 {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  font-size: clamp(38px, 6vw, 72px);
  line-height: 1.05;
  font-weight: 800;
  letter-spacing: -.025em;
  color: #ffffff !important;
  text-shadow: 0 3px 18px rgba(0, 0, 0, 0.95), 0 1px 4px rgba(0, 0, 0, 0.9);
}
.line {
  display: block;
  overflow: hidden;
  padding-bottom: .08em;
}
.line > span {
  display: block;
  color: #ffffff !important;
  transform: translate3d(0,110%,0);
  animation: lineUp 1.1s var(--ease, cubic-bezier(.22, 1, .36, 1)) forwards;
  animation-delay: calc(.35s + var(--d, 0s));
}
@keyframes lineUp {
  to { transform: none; }
}
.grad {
  background: linear-gradient(100deg, #ff8a00 0%, #ffc078 35%, #ff7a00 70%);
  background-size: 220% 100%;
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent !important;
  animation: sweep 7s ease-in-out infinite alternate;
  filter: drop-shadow(0 2px 10px rgba(255, 122, 0, 0.45));
}
@keyframes sweep {
  to { background-position: 100% 0; }
}

.lead {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  margin-top: 24px;
  max-width: 580px;
  font-size: 18px;
  line-height: 1.65;
  color: #f3f4f6 !important;
  font-weight: 400;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.95);
}
.cta {
  margin-top: 32px;
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}
.fade {
  opacity: 0;
  transform: translate3d(0,18px,0);
  animation: fadeUp 1s var(--ease, cubic-bezier(.22, 1, .36, 1)) forwards;
  animation-delay: calc(.4s + var(--d, 0s));
}
@keyframes fadeUp {
  to { opacity: 1; transform: none; }
}

.btn {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 13px 22px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 14px;
  border: 1px solid transparent;
  cursor: pointer;
  transition: transform .45s var(--ease, cubic-bezier(.22, 1, .36, 1)), box-shadow .45s var(--ease, cubic-bezier(.22, 1, .36, 1)), background .3s, border-color .3s;
}
.btn.primary {
  background: linear-gradient(135deg, #ff8a1f, #ff6a00);
  color: #fff;
  box-shadow: 0 12px 26px -14px rgba(255,122,0,.8);
}
.btn.primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 30px -14px rgba(255,122,0,.95);
}
.btn.ghost {
  background: rgba(255,255,255,.06);
  border-color: rgba(255,255,255,.3);
  color: #fff;
}
.btn.ghost:hover {
  transform: translateY(-2px);
  border-color: var(--o, #ff7a00);
  background: rgba(255,122,0,.12);
}
.btn svg {
  width: 18px;
  height: 18px;
  fill: none;
  stroke: currentColor;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: transform .45s var(--ease, cubic-bezier(.22, 1, .36, 1));
}
.btn:hover .arr {
  transform: translateX(4px);
}

@media (max-width: 900px) {
  .lead { font-size: 16px; }
}
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; transition: none !important; }
  .line > span, .fade { opacity: 1 !important; transform: none !important; }
  .hero-bg img { opacity: 1; }
  .w-halo { animation: none !important; }
}
</style>
