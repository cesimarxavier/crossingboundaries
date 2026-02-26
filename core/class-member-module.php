<?php
// Registra o CPT "Member" com Arquivo Nativo
add_action('init', function () {
    register_post_type('member', [
        'labels'      => [
            'name'          => __('Members', 'crossingboundaries'),
            'singular_name' => __('Member', 'crossingboundaries'),
            'add_new_item'  => __('Add New Member', 'crossingboundaries'),
        ],
        'public'      => true, // Precisa ser true para o Archive funcionar
        'has_archive' => 'our-team', // A MÁGICA: O WP cria a rota /our-team/ sozinho!
        'rewrite'     => ['slug' => 'member'],
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-groups',
        'supports'    => ['title', 'editor', 'thumbnail', 'excerpt'],
    ]);
});

// Registra as Caixas de Meta
add_action('add_meta_boxes', function () {
    add_meta_box('member_details', 'Member Details', 'render_member_metaboxes', 'member', 'normal', 'high');
});

function render_member_metaboxes($post)
{
    wp_nonce_field('save_member_data', 'member_nonce');
    $role = get_post_meta($post->ID, '_member_role', true);
    $interests = get_post_meta($post->ID, '_member_interests', true);
    $pubs = get_post_meta($post->ID, '_member_publications', true);
?>
    <p>
        <label><strong>Role / Institution:</strong></label><br>
        <input type="text" name="_member_role" value="<?php echo esc_attr($role); ?>" style="width:100%;" placeholder="e.g. UFRJ • Microbiology">
    </p>
    <p>
        <label><strong>Research Interests (comma separated):</strong></label><br>
        <input type="text" name="_member_interests" value="<?php echo esc_attr($interests); ?>" style="width:100%;">
    </p>
    <p>
        <label><strong>Selected Publications:</strong></label><br>
        <textarea name="_member_publications" style="width:100%; height:100px;"><?php echo esc_textarea($pubs); ?></textarea>
    </p>
<?php
}

// Salva os dados
add_action('save_post_member', function ($post_id) {
    if (!isset($_POST['member_nonce']) || !wp_verify_nonce($_POST['member_nonce'], 'save_member_data')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['_member_role'])) update_post_meta($post_id, '_member_role', sanitize_text_field($_POST['_member_role']));
    if (isset($_POST['_member_interests'])) update_post_meta($post_id, '_member_interests', sanitize_text_field($_POST['_member_interests']));
    if (isset($_POST['_member_publications'])) update_post_meta($post_id, '_member_publications', sanitize_textarea_field($_POST['_member_publications']));
});
