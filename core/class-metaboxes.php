<?php

/**
 * Módulo de Meta Boxes Customizados do ModularPress (100% Nativo)
 */
class ModularPress_MetaBoxes
{

    public function __construct()
    {
        // Registra a criação do box na tela de edição de posts
        add_action('add_meta_boxes', [$this, 'add_custom_meta_boxes']);

        // Dispara quando o post é salvo
        add_action('save_post', [$this, 'save_custom_meta_boxes']);
    }

    /**
     * Cria a "Caixa" no painel lateral do editor de Post
     */
    public function add_custom_meta_boxes()
    {
        add_meta_box(
            'event_details_meta_box',       // ID do Meta Box
            __('Detalhes do Evento', 'crossingboundaries'), // Título
            [$this, 'render_event_meta_box'], // Função que renderiza o HTML
            'post',                         // Tela onde vai aparecer (Post)
            'side',                         // Contexto (side = coluna lateral direita)
            'default'                       // Prioridade
        );
    }

    /**
     * Renderiza o HTML do campo de formulário dentro da caixa
     */
    public function render_event_meta_box($post)
    {
        // Adiciona um campo oculto (Nonce) para segurança contra CSRF
        wp_nonce_field('save_event_details', 'event_details_nonce');

        // Busca o valor atual salvo no banco (se existir)
        $location = get_post_meta($post->ID, '_event_location', true);

        // HTML do campo
        echo '<div style="padding: 10px 0;">';
        echo '<label for="event_location" style="display:block; margin-bottom: 5px; font-weight: bold;">' . __('Localização (Opcional):', 'crossingboundaries') . '</label>';
        echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr($location) . '" style="width: 100%;" placeholder="Ex: Rio de Janeiro, BR">';
        echo '</div>';
    }

    /**
     * Lógica de validação e salvamento no banco de dados
     */
    public function save_custom_meta_boxes($post_id)
    {
        // 1. Verifica se o Nonce de segurança é válido
        if (!isset($_POST['event_details_nonce']) || !wp_verify_nonce($_POST['event_details_nonce'], 'save_event_details')) {
            return;
        }

        // 2. Verifica se não é um salvamento automático (Autosave)
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // 3. Verifica se o usuário tem permissão para editar o post
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // 4. Sanitiza e salva/atualiza o campo no banco de dados
        if (isset($_POST['event_location'])) {
            $sanitized_location = sanitize_text_field($_POST['event_location']);
            // O underline "_" no início da chave diz ao WP para não exibir este campo na lista de "Campos Personalizados" padrão.
            update_post_meta($post_id, '_event_location', $sanitized_location);
        }
    }
}

new ModularPress_MetaBoxes();
