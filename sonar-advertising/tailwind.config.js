/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          orange: '#FF7A00',
          'orange-light': '#FFA726',
          'orange-dark': '#E86800',
          dark: '#151515',
          'dark-2': '#1B1B1B',
          white: '#FFFFFF',
          surface: '#F6F6F6',
          border: '#E5E5E5',
          'text-primary': '#202020',
          'text-secondary': '#666666',
        }
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
        display: ['"Plus Jakarta Sans"', '"Barlow Condensed"', 'sans-serif'],
      },
      animation: {
        'marquee': 'marquee 30s linear infinite',
        'marquee2': 'marquee2 30s linear infinite',
        'fade-up': 'fadeUp 0.6s ease forwards',
        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
        'kenburns': 'kenburns 28s ease-in-out infinite alternate',
        'line-up': 'lineUp 1.1s cubic-bezier(.22, 1, .36, 1) forwards',
        'sweep': 'sweep 7s ease-in-out infinite alternate',
        'fade-up-hero': 'fadeUp 1s cubic-bezier(.22, 1, .36, 1) forwards',
        'drop-in': 'dropIn 0.9s cubic-bezier(.22, 1, .36, 1) both',
        'ring': 'ring 3s ease-out infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-100%)' }
        },
        marquee2: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0%)' }
        },
        fadeUp: {
          '0%': { opacity: '0', transform: 'translate3d(0, 18px, 0)' },
          '100%': { opacity: '1', transform: 'translate3d(0, 0, 0)' }
        },
        pulseGlow: {
          '0%, 100%': { boxShadow: '0 0 20px rgba(255,138,0,0.4)' },
          '50%': { boxShadow: '0 0 40px rgba(255,138,0,0.8)' }
        },
        kenburns: {
          '0%': { transform: 'scale(1) translate3d(0, 0, 0)' },
          '100%': { transform: 'scale(1.07) translate3d(-1.2%, -0.8%, 0)' }
        },
        lineUp: {
          '0%': { transform: 'translate3d(0, 110%, 0)' },
          '100%': { transform: 'translate3d(0, 0, 0)' }
        },
        sweep: {
          '0%': { backgroundPosition: '0% 0' },
          '100%': { backgroundPosition: '100% 0' }
        },
        dropIn: {
          '0%': { opacity: '0', transform: 'translate3d(0, -14px, 0)' },
          '100%': { opacity: '1', transform: 'translate3d(0, 0, 0)' }
        },
        ring: {
          '0%': { transform: 'scale(1)', opacity: '0.6' },
          '100%': { transform: 'scale(1.7)', opacity: '0' }
        }
      }
    }
  },
  plugins: []
}