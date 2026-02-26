<?php

/**
 * Módulo de Equipe (Custom Post Type & Meta Boxes)
 */
class ModularPress_Team_Module
{

    public function __construct()
    {
        // Registra o CPT
        add_action('init', [$this, 'register_cpt']);

        // Registra os Metaboxes
        add_action('add_meta_boxes', [$this, 'add_metaboxes']);

        // Salva os dados (O gancho 'save_post_{post_type}' é excelente para performance)
        add_action('save_post_team', [$this, 'save_data']);
    }

    /**
     * 1. Registra o Custom Post Type "Team"
     */
    public function register_cpt()
    {
        register_post_type('team', [
            'labels'      => [
                'name'          => __('Our Team', 'crossingboundaries'),
                'singular_name' => __('Team Member', 'crossingboundaries'),
                'add_new_item'  => __('Add New Member', 'crossingboundaries'),
                'edit_item'     => __('Edit Member', 'crossingboundaries'),
            ],
            'public'      => false, // False porque não teremos página individual (usaremos Modal)
            'show_ui'     => true,  // Mostra no painel admin
            'menu_position' => 20,
            'menu_icon'   => 'dashicons-groups',
            'supports'    => ['title', 'editor', 'thumbnail', 'excerpt'],
        ]);
    }

    /**
     * 2. Cria as Caixas no Painel de Edição do Membro
     */
    public function add_metaboxes()
    {
        add_meta_box(
            'team_details_meta',
            __('Team Member Details', 'crossingboundaries'),
            [$this, 'render_metaboxes'],
            'team',
            'normal',
            'high'
        );
    }

    /**
     * 3. Renderiza o HTML das Caixas (Formulário)
     */
    public function render_metaboxes($post)
    {
        // Busca os valores salvos no banco de dados
        $role = get_post_meta($post->ID, '_team_role', true);
        $interests = get_post_meta($post->ID, '_team_interests', true);
        $pubs = get_post_meta($post->ID, '_team_publications', true);

        // Campo de segurança obrigatório
        wp_nonce_field('save_team_data', 'team_nonce');
?>
        <div style="padding: 10px 0;">
            <p style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Role / Institution:</label>
                <input type="text" name="_team_role" value="<?php echo esc_attr($role); ?>" style="width: 100%;" placeholder="e.g. UFRJ • Microbiology">
            </p>
            <p style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Research Interests (Separate by commas):</label>
                <input type="text" name="_team_interests" value="<?php echo esc_attr($interests); ?>" style="width: 100%;" placeholder="Sustainability, COIL, Catalysis">
            </p>
            <p style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Selected Publications (One per line):</label>
                <textarea name="_team_publications" style="width: 100%; height: 120px;" placeholder="Author, Year. Title. Journal."><?php echo esc_textarea($pubs); ?></textarea>
            </p>
        </div>
<?php
    }

    /**
     * 4. Salva e Sanitiza os dados ao clicar em "Publicar/Atualizar"
     */
    public function save_data($post_id)
    {
        // Validações de segurança
        if (!isset($_POST['team_nonce']) || !wp_verify_nonce($_POST['team_nonce'], 'save_team_data')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        // Salva os campos textuais
        if (isset($_POST['_team_role'])) {
            update_post_meta($post_id, '_team_role', sanitize_text_field($_POST['_team_role']));
        }
        if (isset($_POST['_team_interests'])) {
            update_post_meta($post_id, '_team_interests', sanitize_text_field($_POST['_team_interests']));
        }
        if (isset($_POST['_team_publications'])) {
            update_post_meta($post_id, '_team_publications', sanitize_textarea_field($_POST['_team_publications']));
        }
    }
}

// Inicializa a classe
new ModularPress_Team_Module();
