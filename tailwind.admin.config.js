/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./functions.php",
    "./inc/**/*.php", // Se tiver os seus meta boxes numa pasta inc/
    "./template-parts/admin/**/*.php" // Caso crie páginas de opções no futuro
  ],
  theme: {
    extend: {
      colors: {
        durham: { DEFAULT: '#68246D', dark: '#4E1A52', light: '#8A3E8F' },
        neutral: { 50: '#F8F9FA', 900: '#1A1A1A', 600: '#4B5563' },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        serif: ['Merriweather', 'serif'],
      }
    }
  },
  // O important é necessário para termos prioridade sobre o CSS velho do WordPress
  important: '.wrap, .postbox', 
}