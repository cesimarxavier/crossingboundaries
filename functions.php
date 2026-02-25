<?php
if (! defined('ABSPATH')) exit;

// Carrega os módulos do Core
require_once get_template_directory() . '/core/class-navigation.php';
require_once get_template_directory() . '/core/class-queries.php';


// Adiciona suportes nativos do tema
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
});


// Carrega os scripts e estilos no <head>
add_action('wp_enqueue_scripts', function () {
    // Phosphor Icons
    wp_enqueue_script('phosphor-icons', 'https://unpkg.com/@phosphor-icons/web', [], null, false);

    // Tailwind CSS (CDN para a fase de prototipagem estática)
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', [], null, false);

    // Configuração do Tailwind (Injetada no Head)
    $tailwind_config = "
        tailwind.config = {
            theme: {
                extend: {
                    colors: { durham: { DEFAULT: '#68246D', dark: '#4E1A52', light: '#8A3E8F' }, neutral: { 50: '#F8F9FA', 900: '#1A1A1A', 600: '#4B5563' } },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Merriweather', 'serif'] }
                }
            }
        }
    ";
    wp_add_inline_script('tailwindcss', $tailwind_config, 'before');

    // Fontes do Google
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap', [], null);

    // Lógica Condicional de Impressão
    if (is_single()) {
        wp_enqueue_style(
            'crossingboundaries-print', // ID do estilo
            get_template_directory_uri() . '/assets/css/print-article.css', // Caminho do arquivo
            [], // Dependências
            '1.0.0', // Versão
            'print' //
        );
    }
});
