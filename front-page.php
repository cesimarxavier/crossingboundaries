<?php
get_header();
?>

<main id="main-content">
    <?php while (have_posts()) : the_post();
        $id = get_the_ID();

        // Lendo os dados do Hero
        $hero_title    = get_post_meta($id, '_home_hero_title', true) ?: get_the_title();
        $hero_subtitle = get_post_meta($id, '_home_hero_subtitle', true);
        $hero_bg       = get_post_meta($id, '_home_hero_bg', true);

        // Lendo os dados do About
        $about_tag      = get_post_meta($id, '_home_about_tag', true);
        $about_title    = get_post_meta($id, '_home_about_title', true);
        $about_text     = get_post_meta($id, '_home_about_text', true);
        $about_img      = get_post_meta($id, '_home_about_img', true);
        $about_btn_text = get_post_meta($id, '_home_about_btn_text', true);
        $about_btn_link = get_post_meta($id, '_home_about_btn_link', true);
    ?>


        <section class="relative h-[90vh] min-h-[600px] flex items-center">
            <div class="absolute inset-0 z-0">
                <img src="<?php echo $hero_bg ?  esc_url($hero_bg)  : ''; ?>" alt="Students collaborating" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/90 via-neutral-900/60 to-transparent"></div>
            </div>

            <div class="container mx-auto px-6 relative z-10 pt-20">
                <div class="max-w-2xl animate-fade-in-up">
                    <span class="inline-block py-1 px-3 rounded-full border text-xs font-bold uppercase tracking-wider mb-6 bg-white/10 text-white border-white/20">
                        Interdisciplinary Project
                    </span>
                    <h1 class="font-serif font-black text-4xl md:text-5xl lg:text-6xl text-white leading-tight mb-6">
                        <?php echo esc_html($hero_title); ?>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-8 font-light leading-relaxed max-w-lg">
                        <?php if ($hero_subtitle): ?>
                            <?php echo esc_html($hero_subtitle); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10">
                <a href="#about" class="animate-bounce inline-flex items-center justify-center w-12 h-12 rounded-full border border-white/30 text-white hover:bg-white hover:text-durham transition-all">
                    <i class="ph-bold ph-arrow-down text-xl"></i>
                </a>
            </div>
        </section>

        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-16 items-center">

                    <div class="lg:w-1/2">
                        <span class="text-durham font-bold tracking-wider text-sm uppercase block mb-4">
                            <?php echo esc_html($about_tag); ?>
                        </span>
                        <h2 class="font-serif font-bold text-4xl text-neutral-900 mb-6">
                            <?php echo esc_html($about_title); ?>
                        </h2>

                        <div class="prose prose-lg text-neutral-600 leading-relaxed mb-8">
                            <?php echo wp_kses_post($about_text); ?>
                        </div>

                        <?php if ($about_btn_text && $about_btn_link): ?>
                            <a href="<?php echo esc_url($about_btn_link); ?>" class="inline-flex items-center px-8 py-3 bg-durham text-white font-bold rounded-full hover:bg-durham-light transition-colors shadow-md">
                                <?php echo esc_html($about_btn_text); ?> <i class="ph-bold ph-arrow-right ml-2 text-xl" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="lg:w-1/2 w-full">
                        <?php if ($about_img): ?>
                            <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                                <img src="<?php echo esc_url($about_img); ?>" alt="About the Initiative" class="w-full h-auto object-cover aspect-[4/3]">
                                <div class="absolute inset-0 border border-white/20 rounded-2xl"></div>
                            </div>
                        <?php else: ?>
                            <div class="bg-neutral-100 rounded-2xl aspect-[4/3] flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                <span>Upload an image in the painel</span>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>

    <?php endwhile; ?>

    <section id="updates" class="bg-white">
        <div class="container mx-auto px-6 py-24 border-t border-gray-200">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-durham font-bold tracking-wider text-sm uppercase">Stay Connected</span>
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mt-2">Latest Updates</h2>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <?php
                // Chama o controlador para buscar os dados (Sem sujar a View com arrays e args)
                $latest_updates = ModularPress_Queries::get_latest_updates(3);

                if ($latest_updates->have_posts()) :
                    // Faz o loop chamando o componente reutilizável de UI
                    while ($latest_updates->have_posts()) : $latest_updates->the_post();

                        get_template_part('template-parts/components/card-update-home');

                    endwhile;
                    wp_reset_postdata(); // Restaura o contexto global
                else :
                ?>
                    <p class="col-span-3 text-gray-500 text-center py-8">
                        <?php esc_html_e('No updates available at the moment.', 'crossingboundaries'); ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="mt-12 text-center md:text-right">
                <a href="<?php echo esc_url(home_url('/updates')); ?>" class="inline-block w-full md:w-auto px-8 py-3 border border-gray-300 text-neutral-700 font-semibold rounded-lg hover:border-durham hover:text-durham transition-all text-center">
                    View all news & events
                    <i class="ph ph-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="team" class="py-24 bg-neutral-50 border-t border-gray-200">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-serif font-bold text-3xl text-neutral-900 mb-12">
                <?php esc_html_e('Minds Behind the Project', 'crossingboundaries'); ?>
            </h2>

            <div class="flex flex-wrap justify-center gap-12 mb-12">
                <?php
                // QUERY DIRETA E EXPLÍCITA (À prova de falhas)
                $team_args = array(
                    'post_type'      => 'member', // Puxando o novo CPT
                    'posts_per_page' => 10,
                    'post_status'    => 'publish',
                    'orderby'        => 'title',
                    'order'          => 'ASC'
                );
                $team_query = new WP_Query($team_args);

                if ($team_query->have_posts()) :
                    while ($team_query->have_posts()) : $team_query->the_post();

                        $member_id = get_the_ID();
                        $role      = get_post_meta($member_id, '_member_role', true);
                        $img_url   = get_the_post_thumbnail_url($member_id, 'thumbnail');
                ?>

                        <div class="flex flex-col items-center group">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-4 group-hover:border-durham transition-colors flex items-center justify-center bg-gray-100">
                                <?php if ($img_url) : ?>
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                                <?php else : ?>
                                    <i class="ph-fill ph-user text-4xl text-gray-300"></i>
                                <?php endif; ?>
                            </div>

                            <h4 class="font-bold text-neutral-900"><?php the_title(); ?></h4>

                            <?php if ($role) : ?>
                                <span class="text-xs text-gray-500 uppercase font-medium mt-1">
                                    <?php echo esc_html($role); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // MENSAGEM DE DEBUG: Se cair aqui, sabemos que a query rodou, mas não achou nada no banco!
                    echo '<p class="text-gray-500 italic w-full">Nenhum membro encontrado. Verifique se estão publicados no menu "Members" e se possuem um idioma atribuído (caso o Polylang esteja ativo).</p>';
                endif;
                ?>
            </div>

            <a href="<?php echo esc_url(home_url('/our-team')); ?>" class="inline-block border-b border-durham text-durham font-semibold hover:text-durham-dark pb-1 transition-colors">
                <?php esc_html_e('Meet the full team & curricula', 'crossingboundaries'); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>