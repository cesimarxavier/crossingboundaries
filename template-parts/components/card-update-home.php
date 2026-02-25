<?php

/**
 * Componente: Cartão de Update (Versão Home)
 */

// Extrai a categoria usando a lógica do nosso Core
$categories    = get_the_category();
$cat_name      = !empty($categories) ? esc_html($categories[0]->name) : __('Update', 'crossingboundaries');
$cat_slug      = !empty($categories) ? strtolower($categories[0]->slug) : '';
$badge_classes = ModularPress_Queries::get_category_badge_classes($cat_slug);
?>

<div class="flex flex-col group border-b border-gray-100 pb-8 md:border-none">

    <div class="mb-4">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wide <?php echo esc_attr($badge_classes); ?>">
            <?php echo $cat_name; ?>
        </span>
        <span class="text-xs text-gray-400 font-medium ml-2">
            <?php echo get_the_date('M j, Y'); ?>
        </span>
    </div>

    <h3 class="font-serif font-bold text-xl text-neutral-900 mb-3 group-hover:text-durham transition-colors">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>

    <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-1">
        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
    </p>

    <a href="<?php the_permalink(); ?>" class="text-sm font-semibold text-durham flex items-center mt-auto group/link">
        <?php esc_html_e('Read more', 'crossingboundaries'); ?>
        <i class="ph ph-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
    </a>

</div>