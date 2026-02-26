<?php

/**
 * Componente: Cartão de Membro da Equipe
 * @var array $args Espera receber $args['key'] com o ID único para o Modal JS
 */

$member_id = get_the_ID();
$key       = $args['key'] ?? 'member_' . $member_id;
$role      = get_post_meta($member_id, '_team_role', true);
$img_url   = get_the_post_thumbnail_url($member_id, 'large');
$interests = array_filter(array_map('trim', explode(',', get_post_meta($member_id, '_team_interests', true))));
$card_tags = array_slice($interests, 0, 10); // Pega apenas os 2 primeiros para não quebrar o layout do card
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full cursor-pointer"
    onclick="openProfile('<?php echo esc_js($key); ?>')">
    <div class="p-8 flex flex-col items-center text-center h-full">

        <div class="w-32 h-32 rounded-full overflow-hidden mb-6 border-4 border-neutral-50 group-hover:border-durham/20 transition-colors shadow-sm flex items-center justify-center bg-gray-50">
            <?php if ($img_url) : ?>
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
            <?php else : ?>
                <i class="ph-fill ph-user text-5xl text-gray-300"></i>
            <?php endif; ?>
        </div>

        <h3 class="font-serif font-bold text-xl text-neutral-900 mb-1"><?php the_title(); ?></h3>
        <?php if ($role) : ?>
            <p class="text-xs font-bold text-durham uppercase tracking-wider mb-4"><?php echo esc_html($role); ?></p>
        <?php endif; ?>

        <p class="text-sm text-gray-600 mb-6 line-clamp-3 leading-relaxed">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </p>

        <div class="mt-auto w-full">
            <div class="flex flex-wrap justify-center gap-2 mb-6">
                <?php foreach ($card_tags as $tag): ?>
                    <span class="px-2 py-1 bg-purple-50 text-durham text-[10px] font-bold uppercase rounded"><?php echo esc_html($tag); ?></span>
                <?php endforeach; ?>
            </div>
            <button class="text-durham font-bold text-sm flex items-center justify-center gap-2 group-hover:gap-3 transition-all">
                <?php esc_html_e('View Full Profile', 'crossingboundaries'); ?> <i class="ph-bold ph-arrow-right"></i>
            </button>
        </div>

    </div>
</div>