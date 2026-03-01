<?php

/**
 * Módulo Nativo de Meta Boxes para a Página Inicial (Home)
 */
class ModularPress_Home_MetaBoxes
{
    private $config = [
        // 1. HERO SECTION
        'home_hero_meta' => [
            'title'  => '1. Hero Section (Topo)',
            'fields' => [
                ['id' => '_home_hero_title', 'label' => 'Título Principal', 'type' => 'text', 'default' => ''],
                ['id' => '_home_hero_subtitle', 'label' => 'Subtítulo', 'type' => 'textarea', 'default' => ''],
                ['id' => '_home_hero_bg', 'label' => 'URL da Imagem de Fundo (Background)', 'type' => 'url', 'default' => '']
            ]
        ],

        // 2. ABOUT THE INITIATIVE
        'home_about_meta' => [
            'title'  => '2. About the Initiative',
            'fields' => [
                ['id' => '_home_about_tag', 'label' => 'Tag/Etiqueta (ex: About the Initiative)', 'type' => 'text', 'default' => 'About the Initiative'],
                ['id' => '_home_about_title', 'label' => 'Título Principal', 'type' => 'text', 'default' => ''],
                ['id' => '_home_about_text', 'label' => 'Texto / Descrição', 'type' => 'wysiwyg', 'default' => ''],
                ['id' => '_home_about_img', 'label' => 'URL da Imagem Lateral', 'type' => 'url', 'default' => ''],
                ['id' => '_home_about_btn_text', 'label' => 'Texto do Botão', 'type' => 'text', 'default' => 'Read More'],
                ['id' => '_home_about_btn_link', 'label' => 'Link do Botão', 'type' => 'url', 'default' => '']
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
        // Garante que estes campos SÓ aparecem na página que está definida como "Página Inicial" nas configurações do WP
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
        echo '<p style="color:#666; margin-bottom:15px;"><em>Dica para Imagens: Vá ao menu "Mídia" do WordPress, faça o upload da sua imagem, clique em "Copiar URL" e cole no campo correspondente abaixo.</em></p>';

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
                    echo '<input type="url" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_url($value) . '" style="width:100%;" placeholder="https://seudominio.com/wp-content/uploads/...">';
                    break;
                case 'textarea':
                    echo '<textarea id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" style="width:100%; height:80px;">' . esc_textarea($value) . '</textarea>';
                    break;
                case 'wysiwyg':
                    wp_editor($value, $field['id'], ['textarea_name' => $field['id'], 'textarea_rows' => 8, 'media_buttons' => false]);
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
new ModularPress_Home_MetaBoxes();
