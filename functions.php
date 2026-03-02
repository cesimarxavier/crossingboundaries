<?php
if (! defined('ABSPATH')) exit;

// Carrega os módulos do Core
require_once get_template_directory() . '/core/class-navigation.php';
require_once get_template_directory() . '/core/class-queries.php';
require_once get_template_directory() . '/core/class-project-metaboxes.php';
require_once get_template_directory() . '/core/class-theme-init.php';
require_once get_template_directory() . '/core/class-member-module.php';
// Módulo da Página Inicial (Meta Boxes)
require_once get_template_directory() . '/core/class-home-module.php';


// Adiciona suportes nativos do tema
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
});


/**
 * Altera a consulta principal da página de Arquivo de Membros
 * Força a ordem alfabética (A-Z) e exibe todos os membros de uma vez.
 */
add_action('pre_get_posts', function ($query) {
    // Verifica se estamos no front-end, na consulta principal e na página de membros
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('member')) {
        $query->set('orderby', 'title'); // Ordem alfabética
        $query->set('order', 'ASC');     // A -> Z
        $query->set('posts_per_page', -1); // -1 exibe todos na mesma página (sem paginação)
    }
});

/**
 * Registra os textos fixos do tema no Polylang
 */
add_action('init', function () {
    if (function_exists('pll_register_string')) {
        pll_register_string('Theme', 'Minds Behind the Project', 'Crossing Boundaries');
        pll_register_string('Theme', 'Meet the full team & curricula', 'Crossing Boundaries');
        pll_register_string('Theme', 'Project Collaborators', 'Crossing Boundaries');
        pll_register_string('Theme', 'View Full Profile', 'Crossing Boundaries');
        pll_register_string('Theme', 'Biography', 'Crossing Boundaries');
        pll_register_string('Theme', 'Selected Publications', 'Crossing Boundaries');
        pll_register_string('Theme', 'Research Interests', 'Crossing Boundaries');

        // --- 1. CABEÇALHO: UPDATES ---
        pll_register_string('Updates', 'RESEARCH CHRONICLE', 'Crossing Boundaries - Updates');
        pll_register_string('Updates Updates', 'Updates', 'Crossing Boundaries - Updates');
        pll_register_string('Updates', 'A continuous archive of scientific developments, field expeditions, and scholarly dissemination resulting from the Durham-UFRJ intercultural partnership.', 'Crossing Boundaries - Updates', true);
        pll_register_string('Updates', 'All', 'Crossing Boundaries');
        pll_register_string('Updates', 'Search Placeholder', 'Crossing Boundaries');
        pll_register_string('Updates', 'Read more', 'Crossing Boundaries');
        pll_register_string('Updates', 'Clear filters and view all updates', 'Crossing Boundaries');
        pll_register_string('Updates', 'No updates found', 'Crossing Boundaries');
        pll_register_string('Updates', 'No updates found - Message', 'Crossing Boundaries');
        pll_register_string('Updates', 'Filtered by Category', 'Crossing Boundaries');
        pll_register_string('Updates', 'Explore the latest updates', 'Crossing Boundaries');

        // --- 2. CABEÇALHO: MEMBERS ---
        pll_register_string('Members', 'Título Members', 'Crossing Boundaries');
        pll_register_string('Members', 'Subtitulo Members', 'Crossing Boundaries');

        // --- 3. BLOCO ESTÁTICO: INTERSECTION OF KNOWLEDGE ---
        // (Nota: Se este bloco já estiver a vir daquele Meta Box do "The Project", não precisa disto. Mas se for fixo no layout, use estas strings!)
        pll_register_string('Título Intersection', 'The Intersection of Knowledge', 'Crossing Boundaries - Interseção');
        pll_register_string('Texto Intersection', 'The project transcends pure chemistry. We incorporate researchers from Applied Linguistics and Education to monitor the process.', 'Crossing Boundaries - Interseção', true);
        pll_register_string('Botão Intersection', 'Meet our Researchers', 'Crossing Boundaries - Interseção');

        // Ícones do Grid da Interseção (se forem estáticos)
        pll_register_string('Grid Hard Science', 'Hard Science', 'Crossing Boundaries - Interseção');
        pll_register_string('Grid Culture', 'Culture', 'Crossing Boundaries - Interseção');
        pll_register_string('Grid Sustainability', 'Sustainability', 'Crossing Boundaries - Interseção');
        pll_register_string('Grid Education', 'Education', 'Crossing Boundaries - Interseção');
    }
});
