<?php

/**
 * Módulo Nativo de Meta Boxes para a Página Inicial (Home)
 * Arquitetura baseada nas 4 seções principais mapeadas.
 */
class ModularPress_Home_MetaBoxes
{
    private $config = [
        // 1. HERO SECTION
        'home_hero_meta' => [
            'title'  => '1. Hero Section',
            'fields' => [
                ['id' => '_home_hero_tag', 'label' => 'Tag/Etiqueta (ex: Interdisciplinary Project)', 'type' => 'text', 'default' => 'Interdisciplinary Project'],
                ['id' => '_home_hero_title', 'label' => 'Título Principal (Pode usar HTML como <span> ou <br>)', 'type' => 'text', 'default' => 'Crossing Boundaries: <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-white">Uniting Cultures</span> for Sustainability.'],
                ['id' => '_home_hero_desc', 'label' => 'Descrição / Subtítulo', 'type' => 'textarea', 'default' => 'An innovative collaboration between Durham University and UFRJ...'],
                ['id' => '_home_hero_bg', 'label' => 'URL da Imagem de Fundo', 'type' => 'url', 'default' => '']
            ]
        ],

        // 2. ABOUT THE INITIATIVE
        'home_about_meta' => [
            'title'  => '2. About the Initiative',
            'fields' => [
                ['id' => '_home_about_tag', 'label' => 'Tag/Etiqueta', 'type' => 'text', 'default' => 'About the Initiative'],
                ['id' => '_home_about_title', 'label' => 'Título', 'type' => 'text', 'default' => 'Preparing the Next Generation of Scientists'],
                ['id' => '_home_about_content', 'label' => 'Descrição (HTML)', 'type' => 'wysiwyg', 'default' => ''],
                ['id' => '_home_about_img', 'label' => 'URL da Imagem Lateral', 'type' => 'url', 'default' => '']
            ]
        ],

        // 3. METHODOLOGY
        'home_methodology_meta' => [
            'title'  => '3. Methodology',
            'fields' => [
                ['id' => '_home_methodology_tag', 'label' => 'Tag/Etiqueta', 'type' => 'text', 'default' => 'Methodology'],
                ['id' => '_home_methodology_title', 'label' => 'Título', 'type' => 'text', 'default' => 'The Project Explained'],
                ['id' => '_home_methodology_blocks', 'label' => '3 Itens da Metodologia (Edite em JSON: icon, title, description)', 'type' => 'json', 'default' => "[\n  {\n    \"icon\": \"ph-desktop\",\n    \"title\": \"Digital Connection\",\n    \"description\": \"Virtually paired classrooms working on identical problems...\"\n  },\n  {\n    \"icon\": \"ph-users-three\",\n    \"title\": \"Peer-to-Peer Interaction\",\n    \"description\": \"Students manage time zones, languages...\"\n  },\n  {\n    \"icon\": \"ph-lightbulb\",\n    \"title\": \"Scientific Co-creation\",\n    \"description\": \"The ultimate goal is not an essay, but a viable prototype...\"\n  }\n]"],
                ['id' => '_home_methodology_btn_link', 'label' => 'Link do Botão "Read Full Manifesto"', 'type' => 'url', 'default' => '/the-project/']
            ]
        ],

        // 4. OUTCOMES (Context & Motivation)
        'home_outcomes_meta' => [
            'title'  => '4. Outcomes (Context and Motivation)',
            'fields' => [
                ['id' => '_home_outcomes_tag', 'label' => 'Tag/Etiqueta', 'type' => 'text', 'default' => 'Outcomes'],
                ['id' => '_home_outcomes_title', 'label' => 'Título', 'type' => 'text', 'default' => 'Context and Motivation'],
                ['id' => '_home_outcomes_desc', 'label' => 'Descrição (HTML)', 'type' => 'wysiwyg', 'default' => ''],
                ['id' => '_home_outcomes_btn_label', 'label' => 'Label do Botão', 'type' => 'text', 'default' => 'See Solutions in Practice'],
                ['id' => '_home_outcomes_btn_link', 'label' => 'Link do Botão', 'type' => 'url', 'default' => '/solutions/'],
                ['id' => '_home_outcomes_blocks', 'label' => '3 Campos Laterais (Edite em JSON: icon, title, description)', 'type' => 'json', 'default' => "[\n  {\n    \"icon\": \"ph-flask\",\n    \"title\": \"Projects & Innovation\",\n    \"description\": \"Developing tangible solutions, uniting nanotechnology...\"\n  },\n  {\n    \"icon\": \"ph-translate\",\n    \"title\": \"International Learning\",\n    \"description\": \"Fostering intercultural competence...\"\n  },\n  {\n    \"icon\": \"ph-buildings\",\n    \"title\": \"Institutional Collaboration\",\n    \"description\": \"Strengthening relationships between Global North and South...\"\n  }\n]"]
            ]
        ]
    ];

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_boxes']);
        add_action('save_post', [$this, 'save_data']);
    }

    public function add_boxes()
    {
        global $post;
        // Só carrega se a página for a Home Oficial do WP
        if (empty($post) || $post->ID != get_option('page_on_front')) return;

        foreach ($this->config as $box_id => $box) {
            add_meta_box($box_id, $box['title'], [$this, 'render_metabox'], 'page', 'normal', 'high', ['fields' => $box['fields']]);
        }
    }

    public function render_metabox($post, $metabox)
    {
        static $nonce_printed = false;
        if (!$nonce_printed) {
            wp_nonce_field('save_home_data', 'home_data_nonce');
            $nonce_printed = true;
        }

        $fields = $metabox['args']['fields'];
        echo '<div style="padding: 10px 0;">';

        foreach ($fields as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            if (empty($value) && !empty($field['default'])) {
                $value = $field['default'];
            }

            echo '<div style="margin-bottom: 20px;">';
            echo '<label for="' . esc_attr($field['id']) . '" style="font-weight:bold; display:block; margin-bottom:8px;">' . esc_html($field['label']) . '</label>';

            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" style="width:100%;">';
                    break;
                case 'url':
                    echo '<input type="url" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_url($value) . '" style="width:100%;">';
                    break;
                case 'textarea':
                    echo '<textarea id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" style="width:100%; height:80px;">' . esc_textarea($value) . '</textarea>';
                    break;
                case 'wysiwyg':
                    wp_editor($value, $field['id'], ['textarea_name' => $field['id'], 'textarea_rows' => 8, 'media_buttons' => false]);
                    break;
                case 'json':
                    if (is_array($value)) {
                        $value = wp_json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    }
                    echo '<textarea id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" style="width:100%; height:250px; font-family: monospace; background:#f0f0f1; padding: 10px;">' . esc_textarea($value) . '</textarea>';
                    break;
            }
            echo '</div>';
        }
        echo '</div>';
    }

    public function save_data($post_id)
    {
        if (!isset($_POST['home_data_nonce']) || !wp_verify_nonce($_POST['home_data_nonce'], 'save_home_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_page', $post_id)) return;

        foreach ($this->config as $box) {
            foreach ($box['fields'] as $field) {
                if (!isset($_POST[$field['id']])) continue;
                $raw_value = wp_unslash($_POST[$field['id']]);

                switch ($field['type']) {
                    case 'text':
                        echo '<input type="text" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '">';
                        break;
                    case 'url':
                        echo '<input type="url" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_url($value) . '" placeholder="https://...">';
                        break;
                    case 'textarea':
                        echo '<textarea id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '">' . esc_textarea($value) . '</textarea>';
                        break;
                    case 'wysiwyg':
                        wp_editor($value, $field['id'], ['textarea_name' => $field['id'], 'textarea_rows' => 5, 'media_buttons' => true]);
                        break;
                    case 'json':
                        if (is_array($value)) {
                            $value = wp_json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        }
                        echo '<textarea id="' . esc_attr($field['id']) . '" class="json-textarea" name="' . esc_attr($field['id']) . '">' . esc_textarea($value) . '</textarea>';
                        break;
                }
            }
            // Para permitir o HTML no Hero title
            if (isset($_POST['_home_hero_title'])) {
                update_post_meta($post_id, '_home_hero_title', wp_kses_post(wp_unslash($_POST['_home_hero_title'])));
            }
        }
    }
}
new ModularPress_Home_MetaBoxes();
