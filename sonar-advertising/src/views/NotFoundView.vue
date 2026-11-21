<template>
  <div class="not-found-page min-h-screen flex flex-col bg-[#131313] text-white selection:bg-[#ff7a1a] selection:text-white">
    <header class="px-[clamp(20px,6vw,96px)] py-7">
      <RouterLink
        to="/"
        class="brand text-white no-underline font-extrabold text-[1.05rem] tracking-tight hover:opacity-90 transition-opacity inline-flex items-center gap-2.5"
        aria-label="Sonar Advertising Beranda"
      >
        <img
          src="/logo.png"
          alt="Sonar Advertising"
          class="h-8 w-auto object-contain"
          width="140"
          height="32"
        />
        <span>Sonar <span class="text-[#ff7a1a]">Advertising</span></span>
      </RouterLink>
    </header>

    <main class="flex-1 flex flex-col justify-center px-[clamp(20px,6vw,96px)] pb-16 max-w-[880px]">
      <!-- Neon-sign 404: the "0" is the tube that flickers on at load -->
      <div class="sign" aria-hidden="true">
        4<span class="tube">0</span>4
      </div>

      <h1 class="text-[clamp(1.5rem,4vw,2.1rem)] font-bold tracking-tight text-white mb-3">
        Halaman tidak ditemukan
      </h1>

      <p class="text-[#a3a3a3] text-[1.05rem] leading-[1.7] max-w-[46ch] mb-9 font-normal">
        Alamat yang Anda buka tidak tersedia atau sudah dipindahkan. Periksa kembali tautannya, atau lanjut ke halaman utama.
      </p>

      <div class="actions flex flex-wrap gap-3.5">
        <RouterLink
          to="/"
          class="btn btn-primary bg-[#ff7a1a] hover:bg-[#e8590c] text-white font-bold text-[0.95rem] no-underline px-6 py-3.5 rounded-lg shadow-[0_8px_24px_rgba(255,122,26,0.25)] transition-all cursor-pointer focus-visible:outline-2 focus-visible:outline-[#ff7a1a] focus-visible:outline-offset-2"
        >
          Kembali ke beranda
        </RouterLink>

        <RouterLink
          to="/portfolio"
          class="btn btn-ghost text-white no-underline border border-[#333333] hover:border-[#a3a3a3] font-bold text-[0.95rem] px-6 py-3.5 rounded-lg transition-all cursor-pointer focus-visible:outline-2 focus-visible:outline-[#ff7a1a] focus-visible:outline-offset-2"
        >
          Lihat portofolio
        </RouterLink>
      </div>
    </main>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Halaman tidak ditemukan | Sonar Advertising',
  description: 'Alamat yang Anda buka tidak tersedia atau sudah dipindahkan di website Sonar Advertising.',
  robots: 'noindex, nofollow'
})
</script>

<style scoped>
.not-found-page {
  font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
  background-color: #131313;
}

/* Neon-sign 404: the "0" is the tube that flickers on at load */
.sign {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  font-weight: 800;
  font-size: clamp(6rem, 24vw, 13rem);
  line-height: 1;
  letter-spacing: -0.04em;
  color: #ff7a1a;
  text-shadow: 0 0 12px rgba(255, 122, 26, 0.55), 0 0 42px rgba(255, 122, 26, 0.3);
  margin-bottom: 28px;
  user-select: none;
}

.sign .tube {
  display: inline-block;
  animation: nyala 1.6s steps(1, end) 0.3s both;
}

@keyframes nyala {
  0%   { opacity: 0.12; text-shadow: none; }
  12%  { opacity: 1; }
  18%  { opacity: 0.12; text-shadow: none; }
  34%  { opacity: 1; }
  40%  { opacity: 0.12; text-shadow: none; }
  62%  { opacity: 1; }
  100% { opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
  .sign .tube {
    animation: none !important;
    opacity: 1 !important;
  }
}
</style>
