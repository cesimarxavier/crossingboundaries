/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./functions.php",
    "./inc/**/*.php",
    "./template-parts/admin/**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        durham: { DEFAULT: '#68246D', dark: '#4E1A52', light: '#8A3E8F' },
        neutral: { 50: '#F8F9FA', 900: '#151515', 800: '#232323', 600: '#4B5563' },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        serif: ['Merriweather', 'serif'],
      }
    }
  },
  // Mudámos para 'true' para forçar o !important em todas as classes utilitárias
  important: true, 
}