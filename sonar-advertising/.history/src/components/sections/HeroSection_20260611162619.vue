<template>
  <section
    id="hero"
    class="relative min-h-screen flex items-center overflow-hidden"
    aria-label="Hero section"
  >
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
      <img
        src="/hero-bg.png"
        alt="Sonar Advertising Background"
        class="w-full h-full object-cover"
        loading="eager"
      />
    </div>

    <!-- Dark overlay gradient for readability -->
    <div class="absolute inset-0 z-[1] bg-gradient-to-r from-brand-dark/95 via-brand-dark/80 to-brand-dark/40"></div>
    <div class="absolute inset-0 z-[1] bg-gradient-to-t from-brand-dark via-transparent to-brand-dark/60"></div>

    <!-- Animated orange accent glows -->
    <div class="absolute bottom-0 right-0 w-[700px] h-[700px] bg-brand-orange/8 rounded-full blur-[120px] pointer-events-none z-[2] animate-pulse-slow"></div>
    <div class="absolute top-1/4 left-0 w-[400px] h-[400px] bg-brand-orange/5 rounded-full blur-[100px] pointer-events-none z-[2]"></div>

    <!-- Subtle grid overlay -->
    <div class="absolute inset-0 z-[2] bg-grid opacity-20"></div>

    <!-- Animated particles -->
    <div class="absolute inset-0 z-[2] pointer-events-none overflow-hidden">
      <div
        v-for="n in 8"
        :key="n"
        class="particle"
        :style="{
          left: particlePositions[n - 1].x + '%',
          top: particlePositions[n - 1].y + '%',
          animationDelay: (n * 0.7) + 's',
          animationDuration: (4 + n * 0.5) + 's',
        }"
      ></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 md:px-6 relative z-10 py-24 md:py-32">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <!-- Left: Text Content -->
        <div class="hero-text-content">
          <!-- Eyebrow badge -->
          <div
            class="inline-flex items-center gap-2 bg-brand-orange/10 backdrop-blur-sm border border-brand-orange/25 rounded-full px-5 py-2 mb-8 hero-animate hero-animate-1"
          >
            <span class="relative flex h-2.5 w-2.5">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-orange opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brand-orange"></span>
            </span>
            <span class="text-brand-orange text-xs font-semibold tracking-[0.2em] uppercase">
              Solusi Media Advertising Premium
            </span>
          </div>

          <!-- Headline -->
          <h1 class="font-display text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-extrabold text-white leading-[0.92] mb-7 hero-animate hero-animate-2">
            Visualkan<br />
            Identitas
            <span class="text-gradient relative">
              Bisnis Anda
              <!-- Underline accent -->
              <svg class="absolute -bottom-2 left-0 w-full" height="8" viewBox="0 0 300 8" fill="none">
                <path d="M1 5.5C60 1.5 150 1 299 6" stroke="url(#underline-gradient)" stroke-width="3" stroke-linecap="round"/>
                <defs>
                  <linearGradient id="underline-gradient" x1="0" y1="0" x2="300" y2="0">
                    <stop offset="0%" stop-color="#F97316" stop-opacity="0"/>
                    <stop offset="50%" stop-color="#F97316"/>
                    <stop offset="100%" stop-color="#FB923C" stop-opacity="0"/>
                  </linearGradient>
                </defs>
              </svg>
            </span>
          </h1>

          <!-- Subheadline -->
          <p class="text-white/70 text-lg md:text-xl leading-relaxed mb-10 max-w-xl hero-animate hero-animate-3">
            Kami menghadirkan solusi signage berkualitas tinggi — Huruf Timbul, Neon Box, hingga LED Display — untuk memperkuat branding profesional Anda.
          </p>

          <!-- CTAs -->
          <div class="flex flex-col gap-4 mb-14 hero-animate hero-animate-4">
            <div class="flex flex-wrap gap-4">
              <a
                href="https://wa.me/6285540000007?text=Halo%2C%20saya%20ingin%20pesan%20signage"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative inline-flex items-center gap-3 bg-brand-orange hover:bg-brand-orange-dark text-white font-semibold text-base px-8 py-4 rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-brand-orange/25 hover:shadow-brand-orange/40"
              >
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Pesan via WhatsApp
                <!-- Glow effect on hover -->
                <span class="absolute inset-0 rounded-xl bg-brand-orange opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></span>
              </a>
              <RouterLink
                to="/portfolio"
                class="group inline-flex items-center gap-3 border border-white/20 hover:border-brand-orange/60 backdrop-blur-sm bg-white/5 hover:bg-white/10 text-white hover:text-brand-orange-light font-semibold text-base px-8 py-4 rounded-xl transition-all duration-300"
              >
                Lihat Portofolio
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </RouterLink>
            </div>
            
            <div class="flex flex-wrap gap-4 mt-2">
              <a
                href="https://instagram.com/sonaradvertising"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 hover:from-purple-600 hover:via-pink-600 hover:to-orange-600 text-white font-semibold text-base px-8 py-4 rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-pink-500/25 hover:shadow-pink-500/40"
              >
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                Instagram
                <span class="absolute inset-0 rounded-xl bg-pink-500 opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-300"></span>
              </a>
              <a
                href="https://tiktok.com/@sonaradvertising"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative inline-flex items-center gap-3 bg-black hover:bg-neutral-900 border border-white/10 text-white font-semibold text-base px-8 py-4 rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-white/5 hover:shadow-white/10"
              >
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                TikTok
                <span class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 blur-xl transition-opacity duration-300"></span>
              </a>
            </div>
          </div>

          <!-- Stats -->
          <div class="flex gap-8 md:gap-12 hero-animate hero-animate-5">
            <div v-for="stat in stats" :key="stat.label" class="stat-item">
              <p class="font-display text-3xl md:text-4xl font-extrabold text-gradient leading-none">{{ stat.value }}</p>
              <p class="text-white/40 text-sm mt-2 tracking-wide">{{ stat.label }}</p>
            </div>
          </div>
        </div>

        <!-- Right: Glassmorphism card visual -->
        <div class="hidden lg:flex items-center justify-center hero-animate hero-animate-6">
          <div class="relative w-full max-w-md">
            <!-- Glow behind card -->
            <div class="absolute -inset-6 bg-brand-orange/15 rounded-[2rem] blur-3xl"></div>

            <!-- Main card -->
            <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
              <div class="aspect-video bg-gradient-to-br from-brand-dark-4/80 to-brand-dark-2/80 rounded-2xl mb-5 flex items-center justify-center overflow-hidden border border-white/5 relative">
                <!-- Neon scan line -->
                <div class="neon-scan-line"></div>
                <div class="text-center relative z-10">
                  <p class="font-display text-5xl font-extrabold text-gradient tracking-wide">SONAR</p>
                  <p class="font-display text-2xl font-bold text-white/50 tracking-[0.35em]">ADVERTISING</p>
                  <div class="mt-4 flex justify-center gap-2">
                    <div class="w-28 h-1 bg-brand-orange rounded-full neon-glow"></div>
                  </div>
                </div>
              </div>

              <!-- Service preview chips -->
              <div class="grid grid-cols-3 gap-3">
                <div
                  v-for="swatch in swatches"
                  :key="swatch.label"
                  :class="['rounded-xl h-16 flex items-end p-3 transition-all duration-300 hover:scale-105 cursor-default', swatch.bg]"
                >
                  <span class="text-white/80 text-xs font-semibold">{{ swatch.label }}</span>
                </div>
              </div>
            </div>

            <!-- Floating badge - top right -->
            <div class="absolute -top-5 -right-5 bg-gradient-to-br from-brand-orange to-brand-orange-dark rounded-2xl px-5 py-2.5 shadow-xl shadow-brand-orange/30 floating-badge">
              <p class="text-white text-xs font-bold tracking-wider">✦ Premium Quality</p>
            </div>

            <!-- Floating badge - bottom left -->
            <div class="absolute -bottom-4 -left-4 bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl px-4 py-2.5 shadow-xl floating-badge-alt">
              <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                  <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-brand-dark-3"></div>
                  <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-2 border-brand-dark-3"></div>
                  <div class="w-6 h-6 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-brand-dark-3"></div>
                </div>
                <p class="text-white/80 text-xs font-semibold">100+ Happy Clients</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom fade -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-brand-dark to-transparent z-[3]"></div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 hero-animate hero-animate-7">
      <span class="text-white/30 text-xs tracking-widest uppercase">Scroll</span>
      <div class="scroll-indicator">
        <div class="scroll-dot"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
const stats = [
  { value: '350+', label: 'Projects Completed' },
  { value: '100+', label: 'Happy Clients' },
  { value: '5+', label: 'Years Experience' },
]

const swatches = [
  { label: 'Neon Box', bg: 'bg-gradient-to-br from-blue-900/80 to-blue-600/80' },
  { label: 'Huruf Timbul', bg: 'bg-gradient-to-br from-amber-900/80 to-amber-600/80' },
  { label: 'LED Display', bg: 'bg-gradient-to-br from-orange-900/80 to-brand-orange/80' },
]

const particlePositions = [
  { x: 15, y: 20 },
  { x: 75, y: 15 },
  { x: 85, y: 60 },
  { x: 25, y: 70 },
  { x: 55, y: 30 },
  { x: 90, y: 80 },
  { x: 40, y: 85 },
  { x: 65, y: 50 },
]
</script>

<style scoped>
/* ── Hero Entrance Animations ── */
.hero-animate {
  opacity: 0;
  transform: translateY(24px);
  animation: heroFadeUp 0.8s ease forwards;
}
.hero-animate-1 { animation-delay: 0.1s; }
.hero-animate-2 { animation-delay: 0.25s; }
.hero-animate-3 { animation-delay: 0.4s; }
.hero-animate-4 { animation-delay: 0.55s; }
.hero-animate-5 { animation-delay: 0.7s; }
.hero-animate-6 { animation-delay: 0.5s; }
.hero-animate-7 { animation-delay: 1.2s; }

@keyframes heroFadeUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ── Neon glow line ── */
.neon-glow {
  box-shadow: 0 0 12px #F97316, 0 0 28px rgba(249, 115, 22, 0.5);
}

/* ── Neon scan line (sweeps down across the card) ── */
.neon-scan-line {
  position: absolute;
  top: -100%;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, #F97316, transparent);
  box-shadow: 0 0 20px #F97316, 0 0 60px rgba(249, 115, 22, 0.3);
  animation: scanDown 4s ease-in-out infinite;
  z-index: 5;
}

@keyframes scanDown {
  0% { top: -5%; }
  50% { top: 105%; }
  100% { top: -5%; }
}

/* ── Floating badges ── */
.floating-badge {
  animation: floatBadge 3s ease-in-out infinite;
}
.floating-badge-alt {
  animation: floatBadge 3.5s ease-in-out infinite 0.5s;
}

@keyframes floatBadge {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

/* ── Particles ── */
.particle {
  position: absolute;
  width: 4px;
  height: 4px;
  background: rgba(249, 115, 22, 0.4);
  border-radius: 50%;
  animation: particleFloat 5s ease-in-out infinite;
}

@keyframes particleFloat {
  0%, 100% {
    transform: translateY(0) scale(1);
    opacity: 0.3;
  }
  50% {
    transform: translateY(-30px) scale(1.5);
    opacity: 0.7;
  }
}

/* ── Scroll indicator ── */
.scroll-indicator {
  width: 24px;
  height: 40px;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  display: flex;
  justify-content: center;
  padding-top: 6px;
}

.scroll-dot {
  width: 4px;
  height: 8px;
  background: rgba(249, 115, 22, 0.8);
  border-radius: 2px;
  animation: scrollBounce 2s ease-in-out infinite;
}

@keyframes scrollBounce {
  0%, 100% { transform: translateY(0); opacity: 1; }
  50% { transform: translateY(12px); opacity: 0.3; }
}

/* ── Pulse slow for glow ── */
@keyframes pulseSlow {
  0%, 100% { opacity: 0.5; }
  50% { opacity: 1; }
}
.animate-pulse-slow {
  animation: pulseSlow 4s ease-in-out infinite;
}

/* ── Stat divider ── */
.stat-item {
  position: relative;
}
.stat-item:not(:last-child)::after {
  content: '';
  position: absolute;
  right: -1rem;
  top: 15%;
  height: 70%;
  width: 1px;
  background: linear-gradient(to bottom, transparent, rgba(249, 115, 22, 0.3), transparent);
}

@media (min-width: 768px) {
  .stat-item:not(:last-child)::after {
    right: -1.5rem;
  }
}
</style>