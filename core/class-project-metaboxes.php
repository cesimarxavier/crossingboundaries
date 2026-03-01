<?php

/**
 * Módulo Nativo de Meta Boxes para a Página "The Project"
 * Arquitetura modular corrigida para compatibilidade de tipos (Array vs String)
 */
class ModularPress_Project_MetaBoxes
{
    private $config = [
        // 1. HERO
        'project_hero_meta' => [
            'title'  => '1. Hero & Contexto',
            'fields' => [
                ['id' => '_hero_subtitle', 'label' => 'Subtítulo do Hero', 'type' => 'textarea', 'default' => '']
            ]
        ],

        // 2. THE PEDAGOGICAL APPROACH & COIL
        'project_coil_meta' => [
            'title'  => '2. The Pedagogical Approach & COIL',
            'fields' => [
                ['id' => '_pedagogical_title', 'label' => 'Título (The Pedagogical Approach)', 'type' => 'text', 'default' => 'The Pedagogical Approach'],
                ['id' => '_coil_title', 'label' => 'Título (What is COIL?)', 'type' => 'text', 'default' => 'What is COIL?'],
                ['id' => '_coil_description', 'label' => 'Descrição do COIL', 'type' => 'wysiwyg', 'default' => '<p>Collaborative Online International Learning is a methodology that connects classrooms in different countries, creating a shared environment where knowledge is co-constructed through cultural diversity.</p>'],
                ['id' => '_coil_manifesto', 'label' => 'Manifesto COIL (Conteúdo do Modal)', 'type' => 'wysiwyg', 'default' => '']
            ]
        ],

        // 3. TIMELINE
        'project_timeline_meta' => [
            'title'  => '3. Linha do Tempo (Timeline)',
            'fields' => [
                ['id' => '_project_timeline', 'label' => 'Linha do Tempo (Edite em JSON)', 'type' => 'json', 'default' => "[\n  {\n    \"weeks\": \"Weeks 1-2\",\n    \"title\": \"Connection\",\n    \"description\": \"Texto aqui\",\n    \"caption\": \"Foto\",\n    \"images\": [\"URL_DA_FOTO\"]\n  }\n]"]
            ]
        ],

        // 4. RESEARCH AREAS
        'project_areas_meta' => [
            'title'  => '4. Áreas de Atuação (Research Areas)',
            'fields' => [
                ['id' => '_areas_title', 'label' => 'Título da Seção', 'type' => 'text', 'default' => 'Research Areas'],
                ['id' => '_areas_subtitle', 'label' => 'Subtítulo', 'type' => 'textarea', 'default' => ''],
                ['id' => '_research_areas', 'label' => 'Blocos de Áreas (Edite em JSON)', 'type' => 'json', 'default' => "[\n  {\n    \"icon\": \"ph-flask\",\n    \"title\": \"Scientific Innovation\",\n    \"description\": \"Descrição\",\n    \"bullets\": \"Item 1\\nItem 2\"\n  },\n  {\n    \"icon\": \"ph-translate\",\n    \"title\": \"Internationalisation\",\n    \"description\": \"Descrição\",\n    \"bullets\": \"Item 1\"\n  },\n  {\n    \"icon\": \"ph-users\",\n    \"title\": \"Social Impact\",\n    \"description\": \"Descrição\",\n    \"bullets\": \"Item 1\"\n  }\n]"]
            ]
        ],

        // 5. INTERSECTION OF KNOWLEDGE
        'project_intersection_meta' => [
            'title'  => '5. The Intersection of Knowledge',
            'fields' => [
                ['id' => '_intersection_title', 'label' => 'Título Principal', 'type' => 'text', 'default' => 'The Intersection of Knowledge'],
                ['id' => '_intersection_text', 'label' => 'Texto / Descrição', 'type' => 'textarea', 'default' => 'The project transcends pure chemistry. We incorporate researchers from Applied Linguistics and Education to monitor the process.'],
                ['id' => '_intersection_btn_text', 'label' => 'Texto do Botão', 'type' => 'text', 'default' => 'Meet our Researchers'],
                ['id' => '_intersection_btn_link', 'label' => 'Link do Botão', 'type' => 'url', 'default' => '/our-team/'],
                ['id' => '_intersection_grid', 'label' => 'Grid de 4 Ícones (Edite em JSON)', 'type' => 'json', 'default' => "[\n  {\"icon\": \"ph-flask\", \"title\": \"Hard Science\"},\n  {\"icon\": \"ph-translate\", \"title\": \"Culture\"},\n  {\"icon\": \"ph-globe\", \"title\": \"Sustainability\"},\n  {\"icon\": \"ph-student\", \"title\": \"Education\"}\n]"]
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
        if (empty($post) || get_page_template_slug($post->ID) !== 'template-the-project.php') return;

        foreach ($this->config as $box_id => $box) {
            add_meta_box($box_id, $box['title'], [$this, 'render_metabox'], 'page', 'normal', 'high', ['fields' => $box['fields']]);
        }
    }

    public function render_metabox($post, $metabox)
    {
        // Garante que o nonce só seja impresso uma vez para evitar lixo HTML
        static $nonce_printed = false;
        if (!$nonce_printed) {
            wp_nonce_field('save_project_data', 'project_data_nonce');
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
                    // CORREÇÃO CRÍTICA: Se o dado legado vier do banco como Array, converte para String antes de exibir!
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
        if (!isset($_POST['project_data_nonce']) || !wp_verify_nonce($_POST['project_data_nonce'], 'save_project_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_page', $post_id)) return;

        foreach ($this->config as $box) {
            foreach ($box['fields'] as $field) {
                if (!isset($_POST[$field['id']])) continue;

                $raw_value = wp_unslash($_POST[$field['id']]);

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
                    case 'json':
                        // Salvamos estritamente como String. Se o cliente esquecer a vírgula, ele não perde o texto.
                        update_post_meta($post_id, $field['id'], $raw_value);
                        break;
                }
            }
        }
    }
}
new ModularPress_Project_MetaBoxes();
