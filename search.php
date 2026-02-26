<?php

/**
 * Template para exibir a página de Resultados de Busca
 */
get_header(); ?>

<main class="pt-24 flex-grow bg-neutral-50" id="main-content">

    <section class="bg-white border-b border-gray-200 py-16">
        <div class="container mx-auto px-6 max-w-4xl">
            <h1 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-8 text-center">
                <?php esc_html_e('Search Results', 'crossingboundaries'); ?>
            </h1>

            <div class="relative">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="text" name="s" id="main-search" value="<?php echo get_search_query(); ?>"
                        class="w-full pl-14 pr-32 py-5 rounded-xl border-2 border-gray-200 text-lg focus:outline-none focus:border-durham focus:ring-4 focus:ring-durham/10 transition-all shadow-sm font-medium text-neutral-800"
                        placeholder="<?php esc_attr_e('Type to search again...', 'crossingboundaries'); ?>">
                    <input type="hidden" name="post_type" value="post" />

                    <i class="ph-bold ph-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-2xl pointer-events-none"></i>

                    <button type="submit" id="search-btn"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-durham text-white px-6 py-2 rounded-lg font-bold hover:bg-durham-dark transition-colors shadow-sm">
                        <?php esc_html_e('Search', 'crossingboundaries'); ?>
                    </button>
                </form>
            </div>

            <div class="mt-6 flex items-center justify-between text-sm text-gray-500 border-t border-gray-100 pt-4">
                <p id="search-status" class="flex items-center gap-2">
                    <i class="ph-fill ph-info text-durham"></i>
                    <?php esc_html_e('Showing results for:', 'crossingboundaries'); ?>
                    <span class="font-bold text-neutral-900 text-lg" id="query-term">"<?php echo get_search_query(); ?>"</span>
                </p>
                <p id="result-count" class="font-semibold bg-gray-100 px-3 py-1 rounded-full">
                    <?php
                    global $wp_query;
                    $total = $wp_query->found_posts;
                    printf(esc_html(_n('%d result found', '%d results found', $total, 'crossingboundaries')), $total);
                    ?>
                </p>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container mx-auto px-6 max-w-4xl">

            <?php if (have_posts()) : ?>
                <div id="results-container" class="space-y-4">

                    <?php
                    // Início do The Loop
                    while (have_posts()) : the_post();

                        // Captura a categoria para exibir o badge dinâmico
                        $categories = get_the_category();
                        $cat_name = !empty($categories) ? esc_html($categories[0]->name) : __('Update', 'crossingboundaries');
                        $cat_slug = !empty($categories) ? strtolower($categories[0]->slug) : '';

                        // Lógica de cores baseada no slug da categoria
                        $badge_class = 'bg-gray-100 text-gray-700'; // Padrão
                        if (in_array($cat_slug, ['event', 'evento', 'events'])) {
                            $badge_class = 'bg-orange-100 text-orange-700';
                        } elseif (in_array($cat_slug, ['publication', 'publicacao', 'publicacoes'])) {
                            $badge_class = 'bg-green-100 text-green-700';
                        } elseif (in_array($cat_slug, ['podcast', 'voices'])) {
                            $badge_class = 'bg-blue-100 text-blue-700';
                        } elseif (in_array($cat_slug, ['institutional', 'institucional'])) {
                            $badge_class = 'bg-purple-100 text-durham';
                        } elseif (in_array($cat_slug, ['update', 'noticia', 'news'])) {
                            $badge_class = 'bg-yellow-100 text-yellow-800';
                        }
                    ?>
                        <article class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-durham/30 transition-all flex flex-col md:flex-row gap-5 items-start fade-in">

                            <div class="shrink-0 pt-1">
                                <a href="<?php echo !empty($categories) ? esc_url(get_category_link($categories[0]->term_id)) : '#'; ?>" class="inline-block px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest w-28 text-center <?php echo esc_attr($badge_class); ?> hover:opacity-80 transition-opacity">
                                    <?php echo $cat_name; ?>
                                </a>
                            </div>

                            <div class="flex-1">
                                <h3 class="font-serif font-bold text-xl text-durham mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:underline decoration-2 underline-offset-2">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="text-sm text-gray-600 mb-3 leading-relaxed line-clamp-2">
                                    <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                                </div>
                                <div class="text-xs text-gray-400 font-medium flex items-center gap-2">
                                    <i class="ph-bold ph-calendar-blank"></i> <?php echo get_the_date('d M, Y'); ?>
                                </div>
                            </div>

                            <div class="shrink-0 self-center hidden md:block">
                                <a href="<?php the_permalink(); ?>" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-durham hover:border-durham hover:bg-neutral-50 transition-all" aria-label="Read more">
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </div>

                        </article>
                    <?php endwhile; ?>

                </div>

                <div id="pagination" class="mt-16 flex justify-center">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<i class="ph-bold ph-caret-left"></i>',
                        'next_text' => '<i class="ph-bold ph-caret-right"></i>',
                        'class'     => 'pagination-links flex items-center gap-2',
                        'screen_reader_text' => ' ' // Remove o texto "Navegação de posts" visualmente
                    ));
                    ?>
                </div>

            <?php else : ?>

                <div id="no-results" class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm fade-in">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph-duotone ph-magnifying-glass text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-neutral-900 mb-2">
                        <?php esc_html_e('No results found', 'crossingboundaries'); ?>
                    </h3>
                    <p class="text-gray-500 mb-6">
                        <?php esc_html_e('Try using different keywords or checking your spelling.', 'crossingboundaries'); ?>
                    </p>
                    <button onclick="document.getElementById('main-search').focus();" class="text-durham font-bold hover:underline">
                        <?php esc_html_e('Try a new search', 'crossingboundaries'); ?>
                    </button>
                </div>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>