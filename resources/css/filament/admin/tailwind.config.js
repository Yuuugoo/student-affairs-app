  import preset from '../../../../vendor/filament/filament/tailwind.config.preset'
  /** @type {import('tailwindcss').Config} */

  export default {
      presets: [preset],
      content: [
          './app/Filament/**/*.php',
          './resources/views/filament/**/*.blade.php',
          './vendor/filament/**/*.blade.php',
      ],
      theme: {
        screens: {
          sm: '480px',
          md: '768px',
          lg: '976px',
          xl: '1440px',
        },
        colors: {
          'indigo': {
            500:'#6366f1',
            800:'#3730a3',
          },
          'white': 'ffffff',
          'custom-white': 'f0f0f0',
          'custom-blue': '#2d349a',
          'blue': {
            500:'#0ea5e9',
            900:'#1e3a8a',
          },
          'purple': '#7e5bef',
          'pink': '#ff49db',
          'orange': '#ff7849',
          'green': '#13ce66',
          'yellow': '#ffc82c',
          'gray-dark': '#273444',
          'gray': '#8492a6',
          'gray-light': '#d3dce6',
        },
        fontFamily: {
          sans: ['Graphik', 'sans-serif'],
          serif: ['Merriweather', 'serif'],
        },
        extend: {
          spacing: {
            '128': '32rem',
            '144': '36rem',
          },
          borderRadius: {
            '4xl': '2rem',
          }
        }
      }
  }
