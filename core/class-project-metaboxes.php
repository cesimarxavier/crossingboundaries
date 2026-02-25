<?php

/**
 * Módulo Nativo de Meta Boxes para a Página "The Project"
 */
class ModularPress_Project_MetaBoxes
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_boxes']);
        add_action('save_post', [$this, 'save_data']);
    }

    public function add_boxes()
    {
        // Aplica o metabox APENAS nas páginas que usam o template "template-the-project.php"
        global $post;
        if (empty($post) || get_page_template_slug($post->ID) !== 'template-the-project.php') {
            return;
        }

        add_meta_box('project_hero_meta', '1. Hero & Configurações', [$this, 'render_hero'], 'page', 'normal', 'high');
        add_meta_box('project_coil_meta', '2. Manifesto COIL', [$this, 'render_coil'], 'page', 'normal', 'default');
        add_meta_box('project_timeline_meta', '3. Linha do Tempo (Timeline)', [$this, 'render_timeline'], 'page', 'normal', 'default');
        add_meta_box('project_areas_meta', '4. Áreas de Atuação', [$this, 'render_areas'], 'page', 'normal', 'default');
    }

    // 1. HERÓI E CONTEXTO
    public function render_hero($post)
    {
        wp_nonce_field('save_project_data', 'project_data_nonce');
        $subtitle = get_post_meta($post->ID, '_hero_subtitle', true);

        echo '<p><label><strong>Subtítulo do Hero:</strong></label><br>';
        echo '<textarea name="hero_subtitle" style="width:100%; height:60px;">' . esc_textarea($subtitle) . '</textarea></p>';
        echo '<p class="description">As 3 caixas laterais do "Contexto" podem ser gerenciadas preenchendo o array no código ou via ACF posteriormente. Para este setup nativo, recomendamos manter estático no template se não mudar com frequência.</p>';
    }

    // 2. TEXTO RICO DO MODAL COIL
    public function render_coil($post)
    {
        $manifesto = get_post_meta($post->ID, '_coil_manifesto', true);
        echo '<p>Este texto aparecerá no Modal ao clicar em "Read full methodological manifesto".</p>';

        // Usa o editor nativo do WordPress!
        wp_editor($manifesto, 'coil_manifesto', [
            'textarea_name' => 'coil_manifesto',
            'media_buttons' => false,
            'textarea_rows' => 10,
        ]);
    }

    // 3. LINHA DO TEMPO (Repetidor em formato JSON simplificado)
    public function render_timeline($post)
    {
        $timeline = get_post_meta($post->ID, '_project_timeline', true) ?: [];
        // Converte o array para JSON formatado para que o administrador possa editar facilmente
        $json_timeline = empty($timeline) ? "[\n  {\n    \"weeks\": \"Weeks 1-2\",\n    \"title\": \"Connection\",\n    \"description\": \"Texto aqui\",\n    \"caption\": \"Foto\",\n    \"images\": [\"URL_DA_FOTO\"]\n  }\n]" : wp_json_encode($timeline, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        echo '<p><strong>Edite a Linha do Tempo em formato JSON.</strong></p>';
        echo '<p class="description">Cole as URLs das imagens na matriz "images". Envie as fotos pelo menu Mídia do WP e copie as URLs.</p>';
        echo '<textarea name="project_timeline" style="width:100%; height:300px; font-family: monospace; background:#f0f0f1;">' . esc_textarea($json_timeline) . '</textarea>';
    }

    // 4. ÁREAS DE ATUAÇÃO
    public function render_areas($post)
    {
        $title = get_post_meta($post->ID, '_areas_title', true);
        $subtitle = get_post_meta($post->ID, '_areas_subtitle', true);
        $areas = get_post_meta($post->ID, '_research_areas', true) ?: [];

        $json_areas = empty($areas) ? "[\n  {\n    \"icon\": \"ph-flask\",\n    \"title\": \"Natural Sciences\",\n    \"description\": \"Descrição\",\n    \"bullets\": \"Item 1\\nItem 2\"\n  }\n]" : wp_json_encode($areas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        echo '<p><label><strong>Título da Seção:</strong></label><br>';
        echo '<input type="text" name="areas_title" value="' . esc_attr($title) . '" style="width:100%;"></p>';

        echo '<p><label><strong>Subtítulo:</strong></label><br>';
        echo '<textarea name="areas_subtitle" style="width:100%; height:60px;">' . esc_textarea($subtitle) . '</textarea></p>';

        echo '<hr><p><strong>Blocos de Áreas (Edite em JSON):</strong></p>';
        echo '<textarea name="research_areas" style="width:100%; height:300px; font-family: monospace; background:#f0f0f1;">' . esc_textarea($json_areas) . '</textarea>';
    }

    // SALVAMENTO NATIVO
    public function save_data($post_id)
    {
        if (!isset($_POST['project_data_nonce']) || !wp_verify_nonce($_POST['project_data_nonce'], 'save_project_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_page', $post_id)) return;

        // Salva Textos Simples
        if (isset($_POST['hero_subtitle'])) update_post_meta($post_id, '_hero_subtitle', sanitize_textarea_field($_POST['hero_subtitle']));
        if (isset($_POST['areas_title'])) update_post_meta($post_id, '_areas_title', sanitize_text_field($_POST['areas_title']));
        if (isset($_POST['areas_subtitle'])) update_post_meta($post_id, '_areas_subtitle', sanitize_textarea_field($_POST['areas_subtitle']));

        // Salva HTML (Manifesto COIL)
        if (isset($_POST['coil_manifesto'])) update_post_meta($post_id, '_coil_manifesto', wp_kses_post(wp_unslash($_POST['coil_manifesto'])));

        // Salva Arrays (Timeline e Áreas) decodificando o JSON do painel
        if (isset($_POST['project_timeline'])) {
            $timeline = json_decode(wp_unslash($_POST['project_timeline']), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                update_post_meta($post_id, '_project_timeline', $timeline);
            }
        }

        if (isset($_POST['research_areas'])) {
            $areas = json_decode(wp_unslash($_POST['research_areas']), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                update_post_meta($post_id, '_research_areas', $areas);
            }
        }
    }
}
new ModularPress_Project_MetaBoxes();
