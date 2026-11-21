<template>
  <footer class="bg-neutral-950 border-t border-white/10 pt-16 pb-8">
    <div class="container mx-auto px-4 md:px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
        <!-- Brand -->
        <div class="lg:col-span-1">
          <RouterLink to="/" class="flex items-center mb-4" aria-label="Sonar Advertising">
            <img src="/logo.png" alt="Sonar Advertising" class="h-10 w-auto object-contain" width="160" height="40" />
          </RouterLink>
          <p class="text-gray-400 text-sm leading-relaxed mb-6">
            Spesialis pembuatan huruf timbul, neon box, signage, dan reklame berkualitas tinggi untuk memperkuat identitas brand bisnis Anda.
          </p>

          <!-- Social Media Icons (Clean SVG) -->
          <div class="flex items-center gap-3">
            <!-- Facebook -->
            <a href="https://www.facebook.com/share/195r6jnMJE/?mibextid=wwXIfr" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-gray-300 hover:border-brand-orange hover:text-brand-orange transition-colors cursor-pointer" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
              </svg>
            </a>
            <!-- Instagram -->
            <a href="https://www.instagram.com/sonar.advertising?igsh=NTJwYTB4ZHg4djFw&utm_source=qr" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-gray-300 hover:border-brand-orange hover:text-brand-orange transition-colors cursor-pointer" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
              </svg>
            </a>
            <!-- WhatsApp -->
            <a href="https://wa.me/6285540000007" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-gray-300 hover:border-brand-orange hover:text-brand-orange transition-colors cursor-pointer" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </a>
            <!-- TikTok -->
            <a href="https://www.tiktok.com/@sonar.adv?_r=1&_t=ZS-97B5uEXXqIW" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-gray-300 hover:border-brand-orange hover:text-brand-orange transition-colors cursor-pointer" aria-label="TikTok" target="_blank" rel="noopener noreferrer">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.12-3.44-3.17-3.63-5.46-.22-2.19.46-4.44 1.88-6.14 1.34-1.65 3.39-2.73 5.56-2.94.27-.03.54-.04.81-.04.01 1.42 0 2.85.01 4.27-.45.03-.91.07-1.36.17-1.18.25-2.22.95-2.87 1.95-.57.87-.84 1.95-.69 2.99.16 1.19.8 2.29 1.76 2.96 1.09.77 2.47 1.03 3.75.76 1.49-.31 2.74-1.37 3.28-2.78.29-.73.43-1.52.41-2.31-.03-4.88-.01-9.76-.02-14.64.01-.58.01-1.16.02-1.74z" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Tautan Cepat -->
        <div>
          <h3 class="text-white font-semibold mb-4 text-sm tracking-wide">Tautan Cepat</h3>
          <ul class="space-y-2.5">
            <li v-for="link in quickLinks" :key="link.path">
              <RouterLink :to="link.path" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200">
                {{ link.label }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- Layanan -->
        <div>
          <h3 class="text-white font-semibold mb-4 text-sm tracking-wide">Layanan</h3>
          <ul class="space-y-2.5">
            <li v-for="service in services" :key="service">
              <RouterLink to="/services" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200">
                {{ service }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- Bantuan -->
        <div>
          <h3 class="text-white font-semibold mb-4 text-sm tracking-wide">Bantuan</h3>
          <ul class="space-y-2.5">
            <li>
              <a href="https://wa.me/6285540000007" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200" target="_blank" rel="noopener noreferrer">WhatsApp</a>
            </li>
            <li>
              <a href="mailto:sonaradvertising@gmail.com" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200">Email</a>
            </li>
            <li>
              <RouterLink to="/privacy" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200">Kebijakan Privasi</RouterLink>
            </li>
            <li>
              <RouterLink to="/terms" class="text-gray-400 hover:text-brand-orange text-sm transition-colors duration-200">Syarat & Ketentuan</RouterLink>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom -->
      <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-gray-400 text-xs sm:text-sm">
          © 2026 SONAR ADVERTISING. Hak Cipta Dilindungi.
        </p>
        <p class="text-gray-500 text-xs">
          Signmaker & Outdoor Advertising Specialist • Jawa Timur
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
const quickLinks = [
  { path: '/', label: 'Beranda' },
  { path: '/services', label: 'Layanan' },
  { path: '/portfolio', label: 'Portofolio' },
  { path: '/blog', label: 'Artikel' },
  { path: '/about', label: 'Tentang Kami' },
]

const services = [
  'Huruf Timbul Stainless & Akrilik',
  'Neon Box Profil Custom',
  'Fasad ACP & Pylon Sign',
  'Neon Flex & LED Display'
]
</script>
