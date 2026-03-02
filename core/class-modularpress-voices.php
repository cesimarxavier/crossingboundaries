<?php

/**
 * ========================================================================
 * CORE CPT: VOICES (Depoimentos)
 * Registo do Post Type, Polylang Strings e Meta Boxes associados.
 * ========================================================================
 */
class ModularPress_Voices
{
    public function __construct()
    {
        // 1. Registar CPT
        add_action('init', [$this, 'register_cpt']);

        // 2. Registar Strings do Polylang
        add_action('init', [$this, 'register_strings']);

        // 3. Registar e Guardar Meta Boxes
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_data']);
    }

    /**
     * Regista o Custom Post Type "Voices"
     */
    public function register_cpt()
    {
        $labels = [
            'name'          => 'Voices',
            'singular_name' => 'Voice',
            'menu_name'     => 'Voices',
            'add_new'       => 'Add New',
            'add_new_item'  => 'Add New Voice',
            'edit_item'     => 'Edit Voice',
            'all_items'     => 'All Voices',
            'search_items'  => 'Search Voices',
        ];

        $args = [
            'labels'              => $labels,
            'public'              => false, // Não precisa de URL singular (página própria)
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 21,
            'menu_icon'           => 'dashicons-testimonial',
            // 'page-attributes' permite o uso do campo "Ordem" (menu_order)
            'supports'            => ['title', 'editor', 'page-attributes'],
        ];

        register_post_type('voice', $args);
    }

    /**
     * Regista os textos da secção para tradução no Polylang
     */
    public function register_strings()
    {
        if (function_exists('pll_register_string')) {
            pll_register_string('Título Voices', 'Vozes que Cruzam Fronteiras', 'Crossing Boundaries - Vozes');
            pll_register_string('Texto Voices', 'O impacto real do projeto vai além dos dados. Histórias de quem viveu a ciência intercultural na prática.', 'Crossing Boundaries - Vozes', true);
            pll_register_string('Link Voices', 'Ler todas as histórias', 'Crossing Boundaries - Vozes');
        }
    }

    /**
     * Adiciona os Meta Boxes para Detalhes da Voz
     */
    public function add_meta_boxes()
    {
        add_meta_box(
            'voice_details_meta',
            'Voice Details (Área e País)',
            [$this, 'render_metabox'],
            'voice',
            'normal',
            'high'
        );
    }

    /**
     * Renderiza o HTML do Meta Box
     */
    public function render_metabox($post)
    {
        // Segurança
        wp_nonce_field('save_voice_data', 'voice_meta_nonce');

        // Puxar valores do banco de dados
        $area    = get_post_meta($post->ID, '_voice_area', true);
        $country = get_post_meta($post->ID, '_voice_country', true);

        // O HTML herda o estilo CSS limpo que injetámos no admin-input.css
        echo '<div style="padding: 5px 0 15px;">';

        echo '<div style="margin-bottom: 20px;">';
        echo '<label for="_voice_area" style="font-weight:bold; display:block; margin-bottom:8px;">Área de Pesquisa (ex: Nanopesticidas):</label>';
        echo '<input type="text" id="_voice_area" name="_voice_area" value="' . esc_attr($area) . '" style="width:100%;">';
        echo '</div>';

        echo '<div>';
        echo '<label for="_voice_country" style="font-weight:bold; display:block; margin-bottom:8px;">País (ex: Reino Unido):</label>';
        echo '<input type="text" id="_voice_country" name="_voice_country" value="' . esc_attr($country) . '" style="width:100%;">';
        echo '</div>';

        echo '</div>';
    }

    /**
     * Guarda os dados quando o Post é salvo
     */
    public function save_data($post_id)
    {
        // Verificações de Segurança
        if (!isset($_POST['voice_meta_nonce']) || !wp_verify_nonce($_POST['voice_meta_nonce'], 'save_voice_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        // Salvar os campos (Sanitização rígida para texto simples)
        if (isset($_POST['_voice_area'])) {
            update_post_meta($post_id, '_voice_area', sanitize_text_field($_POST['_voice_area']));
        }

        if (isset($_POST['_voice_country'])) {
            update_post_meta($post_id, '_voice_country', sanitize_text_field($_POST['_voice_country']));
        }
    }
}

// Iniciar a classe
new ModularPress_Voices();
