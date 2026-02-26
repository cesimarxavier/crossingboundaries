<?php

/**
 * Módulo da Página Inicial (Arquitetura Modular Baseada em Array)
 */
class ModularPress_Home_Module
{

    /**
     * ARRAY DE CONFIGURAÇÃO (O coração do módulo)
     * Para adicionar um novo campo ou caixa, basta adicionar aqui!
     */
    private $config = [
        // CAIXA 1: HERO SECTION
        'home_hero_meta' => [
            'title'  => 'Hero Section (Topo da Página)',
            'fields' => [
                // LABEL
                ['id' => '_home_hero_label_en', 'label' => '🇬🇧 Label (EN)', 'type' => 'text', 'default' => 'Interdisciplinary Project'],
                ['id' => '_home_hero_label_pt', 'label' => '🇧🇷 Label (PT)', 'type' => 'text', 'default' => 'Projeto Interdisciplinar'],

                // TITLE
                ['id' => '_home_hero_title_en', 'label' => '🇬🇧 Main Title (EN)', 'type' => 'textarea', 'default' => 'Crossing Boundaries: Uniting Cultures for Sustainability.'],
                ['id' => '_home_hero_title_pt', 'label' => '🇧🇷 Título Principal (PT)', 'type' => 'textarea', 'default' => 'Cruzando Fronteiras: Unindo Culturas pela Sustentabilidade.'],

                // DESC
                ['id' => '_home_hero_desc_en', 'label' => '🇬🇧 Subtitle / Description (EN)', 'type' => 'textarea', 'default' => 'An innovative collaboration between Durham University and UFRJ...'],
                ['id' => '_home_hero_desc_pt', 'label' => '🇧🇷 Subtítulo / Descrição (PT)', 'type' => 'textarea', 'default' => 'Uma colaboração inovadora entre a Universidade de Durham e a UFRJ...'],
            ]
        ],

        // CAIXA 2: ABOUT SECTION
        'home_about_meta' => [
            'title'  => 'About Section (Sobre a Iniciativa)',
            'fields' => [
                // LABEL
                ['id' => '_home_about_label_en', 'label' => '🇬🇧 Label (EN)', 'type' => 'text', 'default' => 'About the Initiative'],
                ['id' => '_home_about_label_pt', 'label' => '🇧🇷 Label (PT)', 'type' => 'text', 'default' => 'Sobre a Iniciativa'],

                // TITLE
                ['id' => '_home_about_title_en', 'label' => '🇬🇧 Section Title (EN)', 'type' => 'text', 'default' => 'Preparing the Next Generation of Scientists'],
                ['id' => '_home_about_title_pt', 'label' => '🇧🇷 Título da Secção (PT)', 'type' => 'text', 'default' => 'Preparando a Próxima Geração de Cientistas'],

                // CONTENT
                ['id' => '_home_about_content_en', 'label' => '🇬🇧 Content (HTML - EN)', 'type' => 'wysiwyg', 'default' => '<p>The Crossing Boundaries project is not merely about chemistry or biology; it is fundamentally about internationalisation.</p>'],
                ['id' => '_home_about_content_pt', 'label' => '🇧🇷 Conteúdo (HTML - PT)', 'type' => 'wysiwyg', 'default' => '<p>O projeto Cruzando Fronteiras não é apenas sobre química ou biologia; é fundamentalmente sobre internacionalização.</p>'],

                // A imagem é a mesma para os dois idiomas!
                ['id' => '_home_about_img', 'label' => '🖼️ Image URL (Igual para ambos)', 'type' => 'url', 'default' => '']
            ]
        ]
    ];

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_metaboxes']);
        add_action('save_post', [$this, 'save_data']);
    }

    /**
     * 1. Registra as caixas dinamicamente baseadas no array $config
     */
    public function add_metaboxes()
    {
        global $post;
        if (!$post || $post->ID != get_option('page_on_front')) return;

        foreach ($this->config as $box_id => $box) {
            add_meta_box(
                $box_id,
                $box['title'],
                [$this, 'render_metabox'],
                'page',
                'normal',
                'high',
                ['fields' => $box['fields']] // Passa os campos para a função de renderização
            );
        }
    }

    /**
     * 2. Renderiza o HTML (O Motor Visual)
     */
    public function render_metabox($post, $metabox)
    {
        wp_nonce_field('save_home_data', 'home_nonce');
        $fields = $metabox['args']['fields'];

        echo '<div style="padding: 10px 0;">';

        foreach ($fields as $field) {
            // Tenta pegar do banco, senão usa o default
            $value = get_post_meta($post->ID, $field['id'], true);
            if (empty($value) && !empty($field['default'])) {
                $value = $field['default'];
            }

            echo '<div style="margin-bottom: 20px;">';
            echo '<label for="' . esc_attr($field['id']) . '" style="font-weight:bold; display:block; margin-bottom:8px;">' . esc_html($field['label']) . '</label>';

            // Renderiza o input correto baseado no tipo
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" style="width:100%;">';
                    break;

                case 'url':
                    echo '<input type="url" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_url($value) . '" style="width:100%;" placeholder="https://...">';
                    break;

                case 'textarea':
                    echo '<textarea id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" style="width:100%; height:80px;">' . esc_textarea($value) . '</textarea>';
                    break;

                case 'wysiwyg':
                    wp_editor($value, $field['id'], [
                        'textarea_name' => $field['id'],
                        'textarea_rows' => 10,
                        'media_buttons' => true // Permite adicionar mídia no meio do texto se necessário
                    ]);
                    break;
            }

            echo '</div>';
        }

        echo '</div>';
    }

    /**
     * 3. Salva os dados dinamicamente (O Motor Lógico)
     */
    public function save_data($post_id)
    {
        // Validações de segurança
        if (!isset($_POST['home_nonce']) || !wp_verify_nonce($_POST['home_nonce'], 'save_home_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_page', $post_id)) return;

        // Varre todo o array de configuração para salvar os campos existentes
        foreach ($this->config as $box) {
            foreach ($box['fields'] as $field) {
                if (!isset($_POST[$field['id']])) continue;

                $raw_value = wp_unslash($_POST[$field['id']]);

                // Sanitização dinâmica baseada no tipo de dado
                switch ($field['type']) {
                    case 'text':
                        update_post_meta($post_id, $field['id'], sanitize_text_field($raw_value));
                        break;

                    case 'url':
                        update_post_meta($post_id, $field['id'], esc_url_raw($raw_value));
                        break;

                    case 'textarea':
                        update_post_meta($post_id, $field['id'], sanitize_textarea_field($raw_value));
                        break;

                    case 'wysiwyg':
                        update_post_meta($post_id, $field['id'], wp_kses_post($raw_value));
                        break;
                }
            }
        }
    }
}

new ModularPress_Home_Module();
