<template>
  <div class="login-page min-h-screen grid place-items-center relative overflow-hidden font-sans text-white">
    <!-- Opening Splash Animation (Plays only on initial load) -->
    <LoginSplash :skip="splashAlreadyPlayed" @finish="onSplashFinished" />

    <!-- Animated Floating Background & Advertising Icons -->
    <LoginBackground />

    <!-- Login Card Wrapper with Rotating Conic Glow Border -->
    <main
      class="card-wrap"
      :class="[
        cardEntered ? 'card-entered' : '',
        splashAlreadyPlayed ? 'card-immediate' : ''
      ]"
    >
      <div class="card">
        <!-- Logo Container (Real Sonar Advertising Logo Image) -->
        <div class="logo-box rise" :style="{ '--d': '0s' }">
          <RouterLink to="/" title="Kembali ke Beranda" class="flex items-center justify-center w-full h-full">
            <img
              src="/logo.png"
              alt="Sonar Advertising"
              class="w-10 h-10 object-contain"
            />
          </RouterLink>
        </div>

        <!-- Title & Subtitle -->
        <h1 class="rise" :style="{ '--d': '0.08s' }">Admin Panel</h1>
        <p class="sub rise" :style="{ '--d': '0.14s' }">Masuk untuk mengelola website</p>

        <!-- Form -->
        <form @submit.prevent="onSubmit" novalidate>
          <!-- Email Field -->
          <div class="rise" :style="{ '--d': '0.22s' }">
            <label for="email">EMAIL ADDRESS</label>
            <div class="field">
              <!-- Email Icon -->
              <svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="4" />
                <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
              </svg>
              <input
                id="email"
                ref="emailInput"
                v-model="email"
                type="email"
                placeholder="nama@email.com"
                autocomplete="username"
                @input="onInputSync"
              />
            </div>
          </div>

          <!-- Password Field -->
          <div class="rise" :style="{ '--d': '0.3s' }">
            <label for="pw">PASSWORD</label>
            <div class="field">
              <!-- Lock Icon -->
              <svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="11" width="16" height="10" rx="2" />
                <path d="M8 11V7a4 4 0 0 1 8 0v4" />
              </svg>
              <input
                id="pw"
                ref="passwordInput"
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                placeholder="••••••••"
                autocomplete="current-password"
                @input="onInputSync"
              />
              <!-- Password Eye Toggle -->
              <button
                type="button"
                class="eye"
                :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                @click="showPassword = !showPassword"
              >
                <!-- Eye Show -->
                <svg v-if="!showPassword" viewBox="0 0 24 24">
                  <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" />
                  <circle cx="12" cy="12" r="3" />
                </svg>
                <!-- Eye Hide -->
                <svg v-else viewBox="0 0 24 24">
                  <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                  <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                  <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                  <line x1="2" y1="2" x2="22" y2="22" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Server Error Message (Soft Red Box) -->
          <div
            v-if="error"
            class="mt-4 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs text-left flex items-center gap-2.5"
            role="alert"
          >
            <svg class="w-4 h-4 shrink-0 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>{{ error }}</span>
          </div>

          <!-- Dodging Login Button Zone -->
          <div
            ref="btnZone"
            class="btn-zone rise"
            :style="{ '--d': '0.38s' }"
            @pointermove="onZonePointerMove"
          >
            <button
              ref="loginBtn"
              type="submit"
              :class="[
                'login-btn',
                !isFormReady ? 'locked' : 'ready-pop',
                isShaking ? 'shake' : ''
              ]"
              :style="btnStyle"
              :aria-disabled="String(!isFormReady)"
              :disabled="loading"
              @pointerdown="onBtnPointerDown"
            >
              <!-- Loading Spinner -->
              <span v-if="loading" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
              </span>
              <span v-else>Login</span>
            </button>

            <!-- Hint text after 3 dodges -->
            <p class="hint" aria-live="polite">{{ hintText }}</p>
          </div>
        </form>

        <!-- Back to Website Link -->
        <RouterLink to="/" class="back rise" :style="{ '--d': '0.46s' }">
          ← Kembali ke Website
        </RouterLink>
      </div>
    </main>
  </div>
</template>

<script>
// Module-scoped flag: splash only plays once per browser session
let hasInitialSplashPlayed = false
</script>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import LoginSplash from '@/components/auth/LoginSplash.vue'
import LoginBackground from '@/components/auth/LoginBackground.vue'

const router = useRouter()
const authStore = useAuthStore()

// Authentication & Form States
const email = ref('')
const password = ref('')
const showPassword = ref(false)
const error = ref('')
const loading = ref(false)

// DOM Element References
const emailInput = ref(null)
const passwordInput = ref(null)
const btnZone = ref(null)
const loginBtn = ref(null)

// Animation & Dodge States
const splashAlreadyPlayed = ref(hasInitialSplashPlayed)
const cardEntered = ref(false)
const isShaking = ref(false)
const hintText = ref('')
let triesCount = 0

const btnStyle = ref({
  width: '100%',
  left: '0px',
  transform: 'none'
})

const isFormReady = computed(() => {
  return email.value.trim() !== '' && password.value !== ''
})

function onSplashFinished() {
  hasInitialSplashPlayed = true
  splashAlreadyPlayed.value = true
  cardEntered.value = true
}

onMounted(() => {
  if (splashAlreadyPlayed.value) {
    cardEntered.value = true
  }
})

// Dodging behavior
function dodgeButton() {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (reduce) {
    triggerShake()
    return
  }

  if (!btnZone.value || !loginBtn.value) return

  const zoneWidth = btnZone.value.clientWidth
  const zoneHeight = btnZone.value.clientHeight
  const btnHeight = loginBtn.value.offsetHeight || 48

  btnStyle.value = {
    width: '62%',
    left: '19%',
    transform: `translate(${(Math.random() * 2 - 1) * zoneWidth * 0.19}px, ${Math.max(8, Math.random() * (zoneHeight - btnHeight - 22))}px)`
  }

  triesCount++
  if (triesCount > 3) {
    hintText.value = 'Isi email dan password dulu, ya 🙂'
  }
}

function resetButton() {
  btnStyle.value = {
    width: '100%',
    left: '0px',
    transform: 'none'
  }
  hintText.value = ''
  triesCount = 0
}

function triggerShake() {
  isShaking.value = false
  requestAnimationFrame(() => {
    isShaking.value = true
    hintText.value = 'Isi email dan password dulu, ya 🙂'
    setTimeout(() => {
      isShaking.value = false
    }, 400)
  })
}

function onInputSync() {
  if (isFormReady.value) {
    resetButton()
  }
}

function onZonePointerMove(e) {
  if (isFormReady.value || loading.value) return
  if (!loginBtn.value) return

  const r = loginBtn.value.getBoundingClientRect()
  if (
    e.clientX > r.left - 30 &&
    e.clientX < r.right + 30 &&
    e.clientY > r.top - 30 &&
    e.clientY < r.bottom + 30
  ) {
    dodgeButton()
  }
}

function onBtnPointerDown(e) {
  if (!isFormReady.value && !loading.value) {
    e.preventDefault()
    dodgeButton()
  }
}

async function onSubmit() {
  if (!isFormReady.value) {
    triggerShake()
    if (email.value.trim() === '') {
      emailInput.value?.focus()
    } else {
      passwordInput.value?.focus()
    }
    return
  }

  error.value = ''
  loading.value = true

  try {
    await authStore.login(email.value, password.value)
    router.push('/admin')
  } catch (err) {
    if (err.response?.status !== 422) {
      console.error('Login failed:', err)
    }
    error.value = err.response?.data?.message || 'Email atau password yang Anda masukkan salah'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@property --ang {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}

.login-page {
  background: radial-gradient(ellipse at 50% 0%, #1b1410 0%, #0d0e10 60%);
}

/* Card Outer Container */
.card-wrap {
  position: relative;
  z-index: 10;
  width: min(92vw, 440px);
  padding: 1.5px;
  border-radius: 22px;
  /* Fallback border gradient */
  background: linear-gradient(135deg, rgba(255, 122, 0, 0.4), rgba(255, 255, 255, 0.08));
  /* Conic animated border gradient */
  background: conic-gradient(
    from var(--ang),
    rgba(255, 255, 255, 0.08) 0 55%,
    #ff7a00 80%,
    #ffb066 88%,
    rgba(255, 255, 255, 0.08) 100%
  );
  animation: spinBorder 6s linear infinite;
  box-shadow: 0 40px 80px -30px rgba(0, 0, 0, 0.8), 0 0 80px -30px rgba(255, 122, 0, 0.35);
  opacity: 0;
  transform: translateY(40px) scale(0.94);
  filter: blur(6px);
}

.card-wrap.card-entered {
  animation: spinBorder 6s linear infinite, cardIn 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

.card-wrap.card-immediate {
  opacity: 1 !important;
  transform: none !important;
  filter: none !important;
  animation: spinBorder 6s linear infinite !important;
}

@keyframes spinBorder {
  to {
    --ang: 360deg;
  }
}

@keyframes cardIn {
  from {
    opacity: 0;
    transform: translateY(40px) scale(0.94);
    filter: blur(6px);
  }
  to {
    opacity: 1;
    transform: none;
    filter: none;
  }
}

/* Inner Card */
.card {
  position: relative;
  padding: 40px 38px 32px;
  border-radius: 21px;
  background: linear-gradient(180deg, #1d1e22, #16171a);
  text-align: center;
  overflow: hidden;
}

/* Subtle orange radial glow at the top inside the card */
.card::after {
  content: "";
  position: absolute;
  top: -80px;
  left: 50%;
  width: 280px;
  height: 160px;
  transform: translateX(-50%);
  background: radial-gradient(closest-side, rgba(255, 122, 0, 0.22), transparent);
  pointer-events: none;
}

/* Stagger entrance */
.rise {
  opacity: 0;
  animation: riseIn 0.65s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
  animation-delay: calc(1.25s + var(--d, 0s));
}

.card-immediate .rise {
  animation-delay: var(--d, 0s);
}

@keyframes riseIn {
  from {
    opacity: 0;
    transform: translateY(16px);
  }
  to {
    opacity: 1;
    transform: none;
  }
}

/* Logo Box */
.logo-box {
  position: relative;
  z-index: 1;
  width: 64px;
  height: 64px;
  margin: 0 auto 18px;
  display: grid;
  place-items: center;
  border-radius: 18px;
  background: rgba(255, 122, 0, 0.1);
  border: 1px solid rgba(255, 122, 0, 0.35);
  box-shadow: 0 0 30px -6px rgba(255, 122, 0, 0.5);
}

h1 {
  position: relative;
  z-index: 1;
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -0.01em;
  background: linear-gradient(180deg, #ffffff, #cfd2d8);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

p.sub {
  position: relative;
  z-index: 1;
  margin-top: 6px;
  font-size: 14px;
  color: #aeb1b8;
}

label {
  display: block;
  text-align: left;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  color: #c9ccd2;
  margin: 22px 0 8px;
}

.field {
  position: relative;
}

.field > svg.ic {
  position: absolute;
  left: 14px;
  top: 50%;
  width: 18px;
  height: 18px;
  transform: translateY(-50%);
  fill: none;
  stroke: #7e828b;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: stroke 0.2s;
  pointer-events: none;
}

.field:focus-within > svg.ic {
  stroke: #ff7a00;
}

input {
  width: 100%;
  padding: 14px 44px;
  border-radius: 12px;
  background: #101114;
  border: 1px solid rgba(255, 255, 255, 0.09);
  color: #ffffff;
  font-size: 14px;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}

input::placeholder {
  color: #6c7078;
}

input:focus {
  outline: none;
  border-color: #ff7a00;
  background: #131417;
  box-shadow: 0 0 0 4px rgba(255, 122, 0, 0.16);
}

.eye {
  position: absolute;
  right: 8px;
  top: 50%;
  transform: translateY(-50%);
  width: 34px;
  height: 34px;
  display: grid;
  place-items: center;
  border: 0;
  border-radius: 8px;
  background: transparent;
  color: #7e828b;
  cursor: pointer;
  transition: color 0.2s;
}

.eye:hover {
  color: #ff7a00;
}

.eye svg {
  width: 18px;
  height: 18px;
  fill: none;
  stroke: currentColor;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* Button Zone & Dodging Button */
.btn-zone {
  position: relative;
  margin-top: 22px;
  height: 112px;
}

.login-btn {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  padding: 14px;
  border: 0;
  border-radius: 12px;
  overflow: hidden;
  color: #ffffff;
  font-weight: 700;
  font-size: 15px;
  letter-spacing: 0.02em;
  cursor: pointer;
  background: linear-gradient(135deg, #ff8a1f, #ff6a00);
  box-shadow: 0 12px 28px -10px rgba(255, 122, 0, 0.7);
  transition: transform 0.3s cubic-bezier(0.3, 1.4, 0.5, 1), width 0.3s, left 0.3s, box-shadow 0.2s, opacity 0.2s;
}

.login-btn::after {
  content: "";
  position: absolute;
  top: 0;
  left: -60%;
  width: 40%;
  height: 100%;
  background: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.45), transparent);
  transform: skewX(-20deg);
}

.login-btn:not(.locked):hover {
  box-shadow: 0 16px 34px -10px rgba(255, 122, 0, 0.9);
}

.login-btn:not(.locked):hover::after {
  animation: buttonShine 0.8s ease;
}

.login-btn.ready-pop {
  animation: buttonPop 0.5s ease;
}

.login-btn.locked {
  opacity: 0.88;
}

.login-btn.shake {
  animation: buttonShake 0.35s;
}

@keyframes buttonShine {
  to {
    left: 130%;
  }
}

@keyframes buttonPop {
  0% { transform: scale(0.96); }
  60% { transform: scale(1.03); }
  100% { transform: none; }
}

@keyframes buttonShake {
  0%, 100% { margin-left: 0; }
  25% { margin-left: -6px; }
  75% { margin-left: 6px; }
}

.hint {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 4px;
  font-size: 12px;
  color: #ffb066;
  min-height: 16px;
  pointer-events: none;
}

.back {
  position: relative;
  z-index: 1;
  display: inline-block;
  margin-top: 14px;
  font-size: 12px;
  color: #aeb1b8;
  text-decoration: none;
  transition: color 0.2s;
}

.back:hover {
  color: #ff7a00;
}

@media (max-width: 640px) {
  .card {
    padding: 34px 24px 26px;
  }
}

@media (prefers-reduced-motion: reduce) {
  .card-wrap {
    animation: none !important;
    opacity: 1 !important;
    transform: none !important;
    filter: none !important;
  }
  .rise {
    opacity: 1 !important;
    animation: none !important;
  }
  .login-btn {
    transition: none !important;
  }
}
</style>
