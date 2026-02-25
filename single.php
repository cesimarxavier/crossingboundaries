<?php

/**
 * O template para exibir posts individuais (100% Autoral, Sem Plugins)
 */
get_header();
?>

<main class="pt-24 pb-24 print:pt-0 print:pb-0" id="main-content">

    <?php while (have_posts()) : the_post(); ?>

        <div class="bg-neutral-50 border-b border-gray-200 print:bg-white print:border-none print:p-0">
            <div class="container mx-auto px-6 py-16 text-center print:text-left print:p-0">

                <div class="breadcrumb flex items-center justify-center gap-2 text-xs text-gray-500 uppercase tracking-wide font-bold mb-6">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="hover:text-durham transition-colors">
                        <?php esc_html_e('Updates', 'crossingboundaries'); ?>
                    </a>
                    <i class="ph-bold ph-caret-right"></i>
                    <span class="text-durham">
                        <?php
                        $categories = get_the_category();
                        if (! empty($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                        ?>
                    </span>
                </div>

                <h1 class="font-serif font-black text-4xl md:text-5xl lg:text-6xl text-neutral-900 mb-8 max-w-4xl mx-auto leading-tight print:m-0 print:text-black">
                    <?php the_title(); ?>
                </h1>

                <div class="meta-data-print flex flex-wrap justify-center items-center gap-6 text-sm text-gray-600 print:justify-start print:gap-4 print:text-xs">
                    <span class="font-bold"><?php esc_html_e('Author:', 'crossingboundaries'); ?> <?php the_author(); ?></span> |
                    <span><time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('j M Y'); ?></time></span>

                    <?php
                    // 100% NATIVO: Buscando o dado direto do banco de dados do WP
                    $location = get_post_meta(get_the_ID(), '_event_location', true);
                    if (!empty($location)): ?>
                        | <span><i class="ph-bold ph-map-pin mr-1"></i> <?php echo esc_html($location); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <article id="post-<?php the_ID(); ?>" <?php post_class('container mx-auto px-6 py-12 max-w-4xl print:max-w-none print:p-0'); ?>>

            <?php if (has_post_thumbnail()) : ?>
                <figure class="mb-12 print:mb-4">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-auto rounded-xl shadow-lg print:rounded-none print:shadow-none print:grayscale']); ?>
                    <?php
                    $caption = get_the_post_thumbnail_caption();
                    if ($caption) : ?>
                        <figcaption class="text-center text-sm text-gray-500 mt-4 italic">
                            <?php echo wp_kses_post($caption); ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
            <?php endif; ?>

            <div class="wp-content">
                <?php the_content(); ?>
            </div>

            <div id="print-footer" class="hidden">
                <div class="qr-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode(get_permalink()); ?>" alt="Scan to read online">
                </div>
                <div class="citation-info">
                    <p><strong><?php esc_html_e('Scan to read online & access supplementary materials.', 'crossingboundaries'); ?></strong></p>
                    <p><?php the_author_meta('last_name'); ?>, <?php echo substr(get_the_author_meta('first_name'), 0, 1); ?>. (<?php echo get_the_date('Y'); ?>). <em><?php the_title(); ?></em>. Crossing Boundaries Project Updates.</p>
                    <p>URL: <?php echo esc_html(get_permalink()); ?></p>
                </div>
            </div>

            <div id="share-section" class="border-t border-gray-200 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex flex-wrap gap-2">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                        foreach ($tags as $tag) {
                            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide hover:bg-durham hover:text-white transition-colors">' . esc_html($tag->name) . '</a>';
                        }
                    }
                    ?>
                </div>
                <div class="flex items-center gap-4 text-sm font-bold text-gray-600">
                    <span><?php esc_html_e('Share this update:', 'crossingboundaries'); ?></span>
                    <?php
                    $share_url = urlencode(get_permalink());
                    $share_title = urlencode(get_the_title());
                    ?>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="hover:text-durham transition-colors" title="Share on LinkedIn">
                        <i class="ph-fill ph-linkedin-logo text-2xl"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="hover:text-durham transition-colors" title="Share on X (Twitter)">
                        <i class="ph-fill ph-x-logo text-xl"></i>
                    </a>
                </div>
            </div>

            <div id="post-navigation" class="grid grid-cols-2 gap-4 mt-12 pt-12 border-t border-gray-200">
                <div class="text-left">
                    <?php
                    $prev_post = get_previous_post();
                    if (!empty($prev_post)): ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="group block">
                            <span class="block text-xs font-bold text-gray-400 uppercase mb-1 group-hover:text-durham"><i class="ph-bold ph-arrow-left"></i> <?php esc_html_e('Previous Update', 'crossingboundaries'); ?></span>
                            <span class="font-serif font-bold text-lg text-neutral-900 group-hover:underline line-clamp-2"><?php echo esc_html($prev_post->post_title); ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="text-right">
                    <?php
                    $next_post = get_next_post();
                    if (!empty($next_post)): ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="group block">
                            <span class="block text-xs font-bold text-gray-400 uppercase mb-1 group-hover:text-durham"><?php esc_html_e('Next Update', 'crossingboundaries'); ?> <i class="ph-bold ph-arrow-right"></i></span>
                            <span class="font-serif font-bold text-lg text-neutral-900 group-hover:underline line-clamp-2"><?php echo esc_html($next_post->post_title); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

    <section id="related-posts" class="bg-neutral-50 border-t border-gray-200 py-16">
        <div class="container mx-auto px-6">
            <h3 class="font-serif font-bold text-2xl text-neutral-900 mb-8"><?php esc_html_e('Related Updates', 'crossingboundaries'); ?></h3>

            <div class="grid md:grid-cols-3 gap-8">
                <?php
                $related_args = array(
                    'category__in'   => wp_get_post_categories(get_the_ID()),
                    'post__not_in'   => array(get_the_ID()),
                    'posts_per_page' => 3,
                    'orderby'        => 'date'
                );

                $related_query = new WP_Query($related_args);

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                        <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group flex flex-col h-full">
                            <a href="<?php the_permalink(); ?>" class="block h-48 overflow-hidden relative bg-gray-100">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700']); ?>
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ph-duotone ph-image text-4xl"></i></div>
                                <?php endif; ?>
                            </a>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                    <i class="ph-bold ph-calendar-blank"></i> <?php echo get_the_date('d M Y'); ?>
                                </div>
                                <h3 class="font-serif font-bold text-lg text-neutral-900 mb-2 group-hover:text-durham transition-colors line-clamp-2">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="text-gray-500 italic">' . esc_html__('No related updates found.', 'crossingboundaries') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>