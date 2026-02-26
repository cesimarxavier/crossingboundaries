<?php

add_action('wp_enqueue_scripts', function () {
    // 1. Ícones (Phosphor)
    wp_enqueue_script('phosphor-icons', 'https://unpkg.com/@phosphor-icons/web', [], null, false);

    // 2. Fontes do Google
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap', [], null);

    // 3. O nosso CSS Compilado do Tailwind (Muito mais rápido e sem erros!)
    wp_enqueue_style(
        'crossingboundaries-style',
        get_template_directory_uri() . '/assets/css/style.min.css',
        [],
        wp_get_theme()->get('Version') // Cache buster baseado na versão do tema
    );
});
