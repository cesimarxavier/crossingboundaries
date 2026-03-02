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
        pll_register_string('Members', 'Titulo Members', 'Crossing Boundaries');
        pll_register_string('Members', 'Subtitulo Members', 'Crossing Boundaries');
    }
});

/**
 * Estilos Customizados para o Painel Admin do WordPress
 */
function crossingboundaries_admin_styles()
{
    // Carrega as fontes do Google (Inter e Merriweather) no Admin
    wp_enqueue_style('cb-admin-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@400;700;900&display=swap', false);

    // Carrega o Tailwind compilado para o Admin
    wp_enqueue_style('cb-admin-css', get_template_directory_uri() . '/assets/css/admin-style.min.css', array(), filemtime(get_template_directory() . '/assets/css/admin-style.min.css'));
}
add_action('admin_enqueue_scripts', 'crossingboundaries_admin_styles');

/**
 * Bónus: Muda a logo na tela de Login do WordPress
 */
function crossingboundaries_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-durham-university.svg);
            height: 65px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }

        body.login {
            background-color: #F8F9FA;
        }

        .login form {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .login #wp-submit {
            background-color: #68246D;
            border-color: #68246D;
            text-shadow: none;
            box-shadow: none;
            border-radius: 6px;
        }

        .login #wp-submit:hover {
            background-color: #4E1A52;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'crossingboundaries_login_logo');


/**
 * ========================================================================
 * CUSTOMIZAR A LISTAGEM (TABELA) DO CPT "MEMBER" NO ADMIN
 * ========================================================================
 */

// 1. Criar e reordenar as colunas
add_filter('manage_member_posts_columns', function ($columns) {
    $new_columns = [];

    // Mantém a checkbox de seleção em massa
    $new_columns['cb'] = $columns['cb'];

    // Adiciona a nossa coluna de Foto logo a seguir à checkbox
    $new_columns['member_photo'] = __('Photo', 'crossingboundaries');

    // Mantém o Título (Nome do Membro)
    $new_columns['title'] = __('Name', 'crossingboundaries');

    // Adiciona o Cargo / Instituição
    $new_columns['member_role'] = __('Role / Institution', 'crossingboundaries');

    // Mantém as restantes colunas nativas (Data, Idiomas do Polylang, etc.)
    foreach ($columns as $key => $value) {
        if (!isset($new_columns[$key])) {
            $new_columns[$key] = $value;
        }
    }

    return $new_columns;
});

// 2. Preencher os dados nas nossas novas colunas
add_action('manage_member_posts_custom_column', function ($column_name, $post_id) {

    // Renderiza a Fotografia
    if ($column_name === 'member_photo') {
        if (has_post_thumbnail($post_id)) {
            // Usa as classes Tailwind que já estão no nosso painel para criar um avatar redondo perfeito
            echo get_the_post_thumbnail($post_id, [50, 50], [
                'class' => 'w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm'
            ]);
        } else {
            // Fallback caso não tenham carregado foto
            echo '<div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200"><span class="text-gray-400 font-bold text-xs">?</span></div>';
        }
    }

    // Renderiza o Role / Institution
    if ($column_name === 'member_role') {
        $role = get_post_meta($post_id, '_member_role', true);
        if ($role) {
            echo '<span class="font-sans text-sm text-neutral-600 font-medium">' . esc_html($role) . '</span>';
        } else {
            echo '<span class="text-gray-400 italic text-xs">Not defined</span>';
        }
    }
}, 10, 2);

// 3. Ajustar a largura das colunas via CSS para ficar esteticamente perfeito
add_action('admin_head', function () {
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'member') {
        echo '<style>
            .column-member_photo { width: 70px; text-align: center !important; }
            .column-member_role { width: 25%; }
        </style>';
    }
});
