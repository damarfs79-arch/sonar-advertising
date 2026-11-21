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

    <!-- Fallback: Reactive Brick Wall Illustration + 3D Stainless Steel Lettering -->
    <div v-else class="hero-fallback" aria-hidden="true">
      <!-- Dark Industrial Brick Wall Pattern -->
      <div class="brick-wall">
        <svg class="brick-svg" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <pattern id="brick-pat" width="140" height="70" patternUnits="userSpaceOnUse">
              <rect width="140" height="70" fill="#131416" />
              <!-- Row 1 -->
              <rect x="2" y="2" width="136" height="31" rx="3" fill="#1b1c20" stroke="#0e0f11" stroke-width="2" />
              <!-- Row 2 (Staggered) -->
              <rect x="-68" y="37" width="136" height="31" rx="3" fill="#1c1d22" stroke="#0e0f11" stroke-width="2" />
              <rect x="72" y="37" width="136" height="31" rx="3" fill="#191a1d" stroke="#0e0f11" stroke-width="2" />
            </pattern>
            <radialGradient id="brick-spot" cx="72%" cy="48%" r="65%">
              <stop offset="0%" stop-color="#ff7a00" stop-opacity="0.22" />
              <stop offset="35%" stop-color="#ff7a00" stop-opacity="0.08" />
              <stop offset="70%" stop-color="#0d0e10" stop-opacity="0.85" />
              <stop offset="100%" stop-color="#0a0a0c" stop-opacity="0.98" />
            </radialGradient>
          </defs>
          <rect width="100%" height="100%" fill="url(#brick-pat)" />
          <rect width="100%" height="100%" fill="url(#brick-spot)" />
        </svg>
      </div>

      <!-- 3D Stainless Steel Signage Showcase on Brick Wall -->
      <div class="sign3d-container">
        <div class="sign3d">
          <!-- Warm Amber Backlit LED Halo Glow -->
          <div class="w-halo"></div>

          <!-- 3D Extruded Metal Side Depth Shadow -->
          <div class="w-depth">
            <span class="sign-tag">HURUF TIMBUL</span>
            <span class="sign-title">STAINLESS STEEL</span>
            <span class="sign-sub">SONAR ADVERTISING</span>
          </div>

          <!-- Brushed Stainless Steel Specular Face -->
          <div class="w-face">
            <span class="sign-tag">HURUF TIMBUL</span>
            <span class="sign-title">STAINLESS STEEL</span>
            <span class="sign-sub">SONAR ADVERTISING</span>
          </div>

          <!-- Wall mounting studs -->
          <div class="sign-studs">
            <span class="stud stud-tl"></span>
            <span class="stud stud-tr"></span>
            <span class="stud stud-bl"></span>
            <span class="stud stud-br"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Directional Gradient Scrim Overlay for Crystal Clear Text Readability -->
    <div class="hero-overlay" aria-hidden="true"></div>

    <!-- Main Content -->
    <div class="wrap">
      <div class="content">
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
  background: #0d0e10;
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
  filter: brightness(0.65) contrast(1.15);
  transition: opacity 1.4s ease;
}
.hero-bg img.loaded {
  opacity: 1;
}

/* Fallback: Brick Wall & 3D Signage */
.hero-fallback {
  position: absolute;
  inset: 0;
  z-index: -3;
  overflow: hidden;
}
.brick-wall {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
}
.brick-svg {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* 3D Signage on Brick Wall */
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

@media (max-width: 1180px) {
  .sign3d-container {
    right: 2%;
    transform: translateY(-50%) scale(0.85);
  }
}
@media (max-width: 1024px) {
  .sign3d-container {
    right: -2%;
    opacity: 0.45;
    transform: translateY(-40%) scale(0.72);
  }
}
@media (max-width: 768px) {
  .sign3d-container {
    display: none;
  }
}

.sign3d {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 44px 60px;
  background: rgba(18, 19, 22, 0.78);
  border: 1px solid rgba(255, 255, 255, 0.09);
  border-radius: 20px;
  backdrop-filter: blur(8px);
  transform-style: preserve-3d;
  transform: perspective(900px) rotateY(-11deg) rotateX(5deg);
  box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.9);
}

/* Backlit warm amber LED glow */
.w-halo {
  position: absolute;
  inset: -22px;
  border-radius: 30px;
  background: radial-gradient(ellipse at center, rgba(255, 122, 0, 0.42) 0%, rgba(255, 176, 102, 0.22) 42%, transparent 70%);
  filter: blur(28px);
  z-index: 1;
  pointer-events: none;
  animation: pulseGlow 5s ease-in-out infinite alternate;
}
@keyframes pulseGlow {
  0% { opacity: 0.65; transform: scale(0.97); }
  100% { opacity: 1; transform: scale(1.03); }
}

/* 3D Extruded Metal Side Depth */
.w-depth {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
}
.w-depth .sign-tag {
  font-size: clamp(14px, 1.8vw, 20px);
  font-weight: 800;
  letter-spacing: 0.16em;
  color: #111317;
  text-shadow:
    1px 1px 0 #9ca3af,
    2px 2px 0 #6b7280,
    3px 3px 0 #4b5563,
    4px 5px 12px rgba(0, 0, 0, 0.95);
}
.w-depth .sign-title {
  font-size: clamp(24px, 3.2vw, 42px);
  font-weight: 900;
  letter-spacing: 0.1em;
  color: #111317;
  margin-top: 6px;
  text-shadow:
    1px 1px 0 #9ca3af,
    2px 2px 0 #6b7280,
    3px 3px 0 #4b5563,
    4px 4px 0 #374151,
    5px 5px 0 #1f2937,
    6px 8px 18px rgba(0, 0, 0, 0.98);
}
.w-depth .sign-sub {
  font-size: clamp(10px, 1.2vw, 13px);
  font-weight: 700;
  letter-spacing: 0.28em;
  color: #111317;
  margin-top: 10px;
  text-shadow:
    1px 1px 0 #9ca3af,
    2px 2px 0 #6b7280,
    3px 4px 10px rgba(0, 0, 0, 0.9);
}

/* Brushed Stainless Steel Front Face */
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
}
.w-face .sign-tag {
  font-size: clamp(14px, 1.8vw, 20px);
  font-weight: 800;
  letter-spacing: 0.16em;
  background: linear-gradient(135deg, #ffffff 0%, #fed7aa 35%, #ff7a00 75%, #ffffff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 1px 1px rgba(255, 255, 255, 0.6));
}
.w-face .sign-title {
  font-size: clamp(24px, 3.2vw, 42px);
  font-weight: 900;
  letter-spacing: 0.1em;
  margin-top: 6px;
  background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 25%, #94a3b8 50%, #e2e8f0 75%, #ffffff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 1px 2px rgba(255, 255, 255, 0.7));
}
.w-face .sign-sub {
  font-size: clamp(10px, 1.2vw, 13px);
  font-weight: 700;
  letter-spacing: 0.28em;
  margin-top: 10px;
  background: linear-gradient(135deg, #cbd5e1 0%, #ffffff 50%, #94a3b8 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

/* Mounting studs */
.sign-studs .stud {
  position: absolute;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #ffffff 0%, #9ca3af 50%, #374151 100%);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
}
.stud-tl { top: 12px; left: 14px; }
.stud-tr { top: 12px; right: 14px; }
.stud-bl { bottom: 12px; left: 14px; }
.stud-br { bottom: 12px; right: 14px; }

/* Directional Scrim Overlay */
.hero-overlay {
  position: absolute;
  inset: 0;
  z-index: -2;
  background: 
    linear-gradient(90deg, rgba(13,14,16,0.97) 0%, rgba(13,14,16,0.92) 40%, rgba(13,14,16,0.72) 65%, rgba(13,14,16,0.35) 100%),
    linear-gradient(0deg, #141516 0%, transparent 40%),
    linear-gradient(180deg, rgba(13,14,16,0.85) 0%, transparent 30%);
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
  text-shadow: 0 2px 16px rgba(0, 0, 0, 0.85);
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
  animation: lineUp 1.1s var(--ease) forwards;
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
  color: #e5e7eb !important;
  font-weight: 400;
  text-shadow: 0 1px 8px rgba(0, 0, 0, 0.8);
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
  animation: fadeUp 1s var(--ease) forwards;
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
  transition: transform .45s var(--ease), box-shadow .45s var(--ease), background .3s, border-color .3s;
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
  background: rgba(255,255,255,.04);
  border-color: rgba(255,255,255,.22);
  color: #fff;
}
.btn.ghost:hover {
  transform: translateY(-2px);
  border-color: var(--o, #ff7a00);
  background: rgba(255,122,0,.08);
}
.btn svg {
  width: 18px;
  height: 18px;
  fill: none;
  stroke: currentColor;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: transform .45s var(--ease);
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
