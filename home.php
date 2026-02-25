<?php

/**
 * O template principal para a página de Posts (Notícias/Updates)
 */
get_header(); ?>

<main class="pt-24" id="main-content">

    <section class="bg-durham-dark py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <span class="inline-block py-1 px-3 rounded-full border border-white/20 text-purple-100 text-xs font-bold uppercase tracking-widest mb-4">
                    <?php esc_html_e('Research Chronicle', 'crossingboundaries'); ?>
                </span>
                <h1 class="font-serif font-bold text-4xl md:text-5xl text-white mb-4">
                    <?php
                    // Mostra o título da página definida nas opções do WP como "Página de Posts"
                    single_post_title();
                    ?>
                </h1>
                <p class="text-purple-100 text-lg font-light leading-relaxed">
                    <?php esc_html_e('A continuous archive of scientific developments, field expeditions, and scholarly dissemination resulting from the Durham-UFRJ intercultural partnership.', 'crossingboundaries'); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white border-b border-gray-200 sticky top-24 z-40 shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">

                <div class="flex flex-wrap gap-2 justify-center lg:justify-start w-full lg:w-auto">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"
                        class="<?php echo !is_category() ? 'bg-durham text-white border-durham' : 'text-gray-600 border-gray-200 hover:border-durham hover:text-durham'; ?> px-4 py-2 rounded-full border text-sm font-bold transition-all">
                        <?php esc_html_e('All', 'crossingboundaries'); ?>
                    </a>

                    <?php
                    // Pega todas as categorias que têm posts
                    $categories = get_categories(array('hide_empty' => true));
                    foreach ($categories as $category) {
                        $is_active = is_category($category->term_id) ? 'bg-durham text-white border-durham' : 'text-gray-600 border-gray-200 hover:border-durham hover:text-durham';
                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="px-4 py-2 rounded-full border text-sm font-medium transition-all ' . esc_attr($is_active) . '">';
                        echo esc_html($category->name);
                        echo '</a>';
                    }
                    ?>
                </div>

                <div class="relative w-full lg:w-80">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="text" name="s" placeholder="<?php esc_attr_e('Search updates...', 'crossingboundaries'); ?>" value="<?php echo get_search_query(); ?>"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-durham focus:ring-1 focus:ring-durham transition-all">
                        <input type="hidden" name="post_type" value="post" /> <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-durham">
                            <i class="ph-bold ph-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-neutral-50 min-h-screen">
        <div class="container mx-auto px-6">

            <?php if (have_posts()) : ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full'); ?>>

                            <div class="h-56 overflow-hidden relative bg-gray-100">
                                <?php
                                // Pegando a primeira categoria para a tag
                                $categories = get_the_category();
                                if (! empty($categories)) {
                                    echo '<span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-xs font-bold text-gray-800 px-3 py-1 rounded shadow-sm uppercase tracking-wide z-10">' . esc_html($categories[0]->name) . '</span>';
                                }

                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700']);
                                } else {
                                    // Placeholder caso não tenha imagem
                                    echo '<div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ph-duotone ph-image text-5xl"></i></div>';
                                }
                                ?>
                            </div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                    <i class="ph-bold ph-calendar-blank"></i> <?php echo get_the_date('d M Y'); ?>

                                    <?php
                                    // Exemplo de como usar um custom field (ACF) para "Localização", se existir
                                    $location = get_field('event_location');
                                    if ($location): ?>
                                        <span>•</span>
                                        <span><?php echo esc_html($location); ?></span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="font-serif font-bold text-xl text-neutral-900 mb-3 group-hover:text-durham transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="text-sm text-gray-600 line-clamp-3 mb-4 flex-1">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-durham flex items-center mt-auto group/link">
                                    <?php esc_html_e('Read More', 'crossingboundaries'); ?>
                                    <i class="ph-bold ph-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>

                </div>

                <div class="mt-16 flex justify-center">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<i class="ph-bold ph-caret-left mr-1"></i> ' . __('Previous', 'crossingboundaries'),
                        'next_text' => __('Next', 'crossingboundaries') . ' <i class="ph-bold ph-caret-right ml-1"></i>',
                        'class'     => 'pagination-links flex items-center gap-2' // Precisaremos de um pequeno CSS auxiliar para isso ficar 100% igual ao Tailwind
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 text-gray-400 mb-6">
                        <i class="ph-duotone ph-article text-4xl"></i>
                    </div>
                    <h2 class="font-serif font-bold text-2xl text-neutral-900 mb-4"><?php esc_html_e('No updates found', 'crossingboundaries'); ?></h2>
                    <p class="text-gray-500"><?php esc_html_e('Check back later for new publications and events.', 'crossingboundaries'); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>