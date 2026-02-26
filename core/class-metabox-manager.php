<?php

/**
 * Módulo de Meta Boxes Automáticos (Orientado a Configuração)
 */
class ModularPress_MetaBox_Manager
{
    private $config;

    public function __construct()
    {
        // Lê a configuração gerada pelo Scaffold
        $this->config = require get_template_directory() . '/config/metaboxes.php';

        add_action('add_meta_boxes', [$this, 'register_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);
    }

    public function register_meta_boxes()
    {
        global $post;
        if (!$post) return;

        foreach ($this->config as $box) {
            // Verifica se tem restrição de template de página
            if (isset($box['template']) && get_page_template_slug($post->ID) !== $box['template']) {
                continue;
            }

            add_meta_box(
                $box['id'],
                $box['title'],
                [$this, 'render_meta_box'],
                $box['screen'],
                'normal',
                'default',
                ['fields' => $box['fields']] // Passa os campos para a função renderizadora
            );
        }
    }

    public function render_meta_box($post, $metabox)
    {
        wp_nonce_field('modularpress_save_meta', 'modularpress_meta_nonce');
        $fields = $metabox['args']['fields'];

        echo '<div style="padding: 10px 0;">';
        foreach ($fields as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);

            echo '<div style="margin-bottom: 20px;">';
            echo '<label style="font-weight:bold; display:block; margin-bottom:5px;">' . esc_html($field['label']) . '</label>';

            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" style="width:100%;">';
                    break;
                case 'textarea':
                    echo '<textarea name="' . esc_attr($field['id']) . '" style="width:100%; height:80px;">' . esc_textarea($value) . '</textarea>';
                    break;
                case 'wysiwyg':
                    wp_editor($value, $field['id'], ['textarea_name' => $field['id'], 'textarea_rows' => 8]);
                    break;
                case 'json':
                    $json_val = empty($value) ? "[]" : wp_json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    echo '<textarea name="' . esc_attr($field['id']) . '" style="width:100%; height:250px; font-family:monospace; background:#f0f0f1;">' . esc_textarea($json_val) . '</textarea>';
                    break;
            }
            echo '</div>';
        }
        echo '</div>';
    }

    public function save_meta_boxes($post_id)
    {
        if (!isset($_POST['modularpress_meta_nonce']) || !wp_verify_nonce($_POST['modularpress_meta_nonce'], 'modularpress_save_meta')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        foreach ($this->config as $box) {
            foreach ($box['fields'] as $field) {
                if (!isset($_POST[$field['id']])) continue;

                $raw_value = wp_unslash($_POST[$field['id']]);

                // Sanitização Dinâmica baseada no tipo
                switch ($field['type']) {
                    case 'text':
                        update_post_meta($post_id, $field['id'], sanitize_text_field($raw_value));
                        break;
                    case 'textarea':
                        update_post_meta($post_id, $field['id'], sanitize_textarea_field($raw_value));
                        break;
                    case 'wysiwyg':
                        update_post_meta($post_id, $field['id'], wp_kses_post($raw_value));
                        break;
                    case 'json':
                        $decoded = json_decode($raw_value, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            update_post_meta($post_id, $field['id'], $decoded);
                        }
                        break;
                }
            }
        }
    }
}
new ModularPress_MetaBox_Manager();
