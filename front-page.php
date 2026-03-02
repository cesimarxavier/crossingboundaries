<?php
get_header();

// ==========================================
// FUNÇÃO HELPER PARA LER OS JSONS COM SEGURANÇA
// ==========================================
function get_safe_json_meta($post_id, $meta_key)
{
    $data = get_post_meta($post_id, $meta_key, true);
    if (is_string($data)) {
        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : [];
    }
    return is_array($data) ? $data : [];
}

?>

<main id="main-content">
    <?php while (have_posts()) : the_post();

        // O Polylang já cuida do ID correto para cada idioma!
        $id = get_the_ID();

        // 1. DADOS DO HERO
        $hero_tag   = get_post_meta($id, '_home_hero_tag', true) ?: 'Interdisciplinary Project';
        $hero_title = get_post_meta($id, '_home_hero_title', true) ?: 'Crossing Boundaries: <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-white">Uniting Cultures</span> for Sustainability.';
        $hero_desc  = get_post_meta($id, '_home_hero_desc', true) ?: 'An innovative collaboration between Durham University and UFRJ, bringing students together to solve global SDG challenges through COIL methodology.';
        $hero_bg    = get_post_meta($id, '_home_hero_bg', true) ?: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80';

        // 2. DADOS DO ABOUT
        $about_tag     = get_post_meta($id, '_home_about_tag', true) ?: 'About the Initiative';
        $about_title   = get_post_meta($id, '_home_about_title', true) ?: 'Preparing the Next Generation of Scientists';
        $about_content = get_post_meta($id, '_home_about_content', true);
        $about_img     = get_post_meta($id, '_home_about_img', true) ?: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';

        // 3. METHODOLOGY
        $method_tag      = get_post_meta($id, '_home_methodology_tag', true) ?: 'Methodology';
        $method_title    = get_post_meta($id, '_home_methodology_title', true) ?: 'The Project Explained';
        $method_blocks   = get_safe_json_meta($id, '_home_methodology_blocks');
        $method_btn_link = get_post_meta($id, '_home_methodology_btn_link', true) ?: home_url('/the-project');

        // 4. OUTCOMES (Context)
        $outcomes_tag       = get_post_meta($id, '_home_outcomes_tag', true) ?: 'Outcomes';
        $outcomes_title     = get_post_meta($id, '_home_outcomes_title', true) ?: 'Context and <br>Motivation';
        $outcomes_desc      = get_post_meta($id, '_home_outcomes_desc', true);
        $outcomes_btn_label = get_post_meta($id, '_home_outcomes_btn_label', true) ?: 'See Solutions in Practice';
        $outcomes_btn_link  = get_post_meta($id, '_home_outcomes_btn_link', true) ?: home_url('/solutions');
        $outcomes_blocks    = get_safe_json_meta($id, '_home_outcomes_blocks');
    ?>

        <section class="relative h-[90vh] min-h-[600px] flex items-center">
            <div class="absolute inset-0 z-0">
                <img src="<?php echo esc_url($hero_bg); ?>" alt="Hero Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/90 via-neutral-900/60 to-transparent"></div>
            </div>

            <div class="container mx-auto px-6 relative z-10 pt-20">
                <div class="max-w-2xl animate-fade-in-up">
                    <span class="inline-block py-1 px-3 rounded-full border text-xs font-bold uppercase tracking-wider mb-6 bg-white/10 text-white border-white/20">
                        <?php echo esc_html($hero_tag); ?>
                    </span>
                    <h1 class="font-serif font-black text-4xl md:text-5xl lg:text-6xl text-white leading-tight mb-6">
                        <?php echo wp_kses_post($hero_title); ?>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-8 font-light leading-relaxed max-w-lg">
                        <?php echo esc_html($hero_desc); ?>
                    </p>
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10">
                <a href="#about" class="animate-bounce inline-flex items-center justify-center w-12 h-12 rounded-full border border-white/30 text-white hover:bg-white hover:text-durham transition-all">
                    <i class="ph-bold ph-arrow-down text-xl"></i>
                </a>
            </div>
        </section>

        <section id="about" class="py-24 bg-white relative">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    <div class="lg:w-1/2">
                        <span class="text-durham font-bold tracking-wider text-sm uppercase mb-3 block">
                            <?php echo esc_html($about_tag); ?>
                        </span>
                        <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-6">
                            <?php echo esc_html($about_title); ?>
                        </h2>
                        <div class="prose prose-lg text-gray-600 mb-8">
                            <?php
                            // Fallback de texto caso esteja vazio no painel
                            if ($about_content) {
                                echo wp_kses_post($about_content);
                            } else {
                                echo '<p>The <strong>Crossing Boundaries</strong> project is not merely about chemistry or biology; it is fundamentally about <strong>internationalisation</strong>.</p><p>Our mission is to democratise the global experience, ensuring that the new generation of Brazilian and British scientists develops critical intercultural competencies. By connecting research laboratories across virtual and physical borders, we prepare students not only to execute experiments but to lead diverse global teams in solving the greatest challenges of the 21st century.</p>';
                            }
                            ?>
                        </div>
                        <div class="flex items-center gap-4">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-durham-university.svg" class="h-8 opacity-70 grayscale">
                            <div class="w-px h-6 bg-gray-300"></div>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-ufrj.svg" class="h-8 opacity-70 grayscale">
                        </div>
                    </div>
                    <div class="lg:w-1/2 relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-purple-50 rounded-tl-3xl z-0"></div>
                        <img src="<?php echo esc_url($about_img); ?>" alt="About the Initiative" class="relative z-10 rounded-xl shadow-xl w-full object-cover aspect-[4/3]">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-white">
            <div class="container mx-auto px-6 text-center">
                <span class="text-durham font-bold tracking-wider text-sm uppercase block mb-4"><?php echo esc_html($method_tag); ?></span>
                <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-16"><?php echo esc_html($method_title); ?></h2>

                <div class="grid md:grid-cols-3 gap-12 max-w-5xl mx-auto mb-16">
                    <?php foreach ($method_blocks as $block): ?>
                        <div class="relative group">
                            <div class="w-20 h-20 mx-auto bg-neutral-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-purple-50 group-hover:scale-110 transition-all border border-gray-100 shadow-sm">
                                <i class="ph-duotone <?php echo esc_attr($block['icon'] ?? 'ph-desktop'); ?> text-4xl text-durham"></i>
                            </div>
                            <h4 class="font-serif font-bold text-xl mb-3"><?php echo esc_html($block['title'] ?? ''); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo esc_html($block['description'] ?? ''); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <a href="<?php echo esc_url($method_btn_link); ?>" class="inline-flex items-center gap-2 border-2 border-durham text-durham font-bold px-8 py-3 rounded-full hover:bg-durham hover:text-white transition-colors uppercase tracking-wide text-sm">
                    <?php if (function_exists('pll_e')) {
                        pll_e('About - Manifesto Label', 'crossingboundaries');
                    } else {
                        echo 'Read full methodological manifesto';
                    } ?>
                </a>
            </div>
        </section>

        <section id="context" class="py-24 bg-neutral-50 border-t border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-white -skew-x-12 translate-x-20 hidden lg:block shadow-sm"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    <div class="lg:w-1/2">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-1 bg-durham rounded-full"></span>
                            <span class="text-durham font-bold tracking-wider text-sm uppercase"><?php echo esc_html($outcomes_tag); ?></span>
                        </div>
                        <h2 class="font-serif font-bold text-4xl lg:text-5xl text-neutral-900 mb-6 leading-tight">
                            <?php echo wp_kses_post($outcomes_title); ?>
                        </h2>
                        <div class="prose prose-lg text-gray-600 leading-relaxed text-justify mb-8">
                            <?php
                            if ($outcomes_desc) {
                                echo wp_kses_post($outcomes_desc);
                            } else {
                                echo '<p>The complexity of contemporary challenges demands a reshaping of how new scientists are trained. Problems such as food security and soil contamination do not respect geopolitical borders.</p><p>Our actions aim for concrete outcomes in Transnational Education (TNE), creating learning ecosystems that benefit institutions and societies bidirectionally.</p>';
                            }
                            ?>
                        </div>
                        <a href="<?php echo esc_url($outcomes_btn_link); ?>" class="inline-flex items-center bg-durham text-white px-8 py-3 rounded-full font-bold shadow-md hover:bg-durham-dark transition-colors">
                            <?php echo esc_html($outcomes_btn_label); ?> <i class="ph-bold ph-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div class="lg:w-1/2 flex flex-col gap-5 w-full">
                        <?php foreach ($outcomes_blocks as $block): ?>
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 flex gap-6 items-start shadow-sm hover:shadow-md hover:border-durham/30 transition-all group">
                                <div class="w-14 h-14 rounded-full bg-purple-50 text-durham flex items-center justify-center shrink-0 group-hover:bg-durham group-hover:text-white transition-colors">
                                    <i class="ph-fill <?php echo esc_attr($block['icon'] ?? 'ph-flask'); ?> text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-serif font-bold text-xl text-neutral-900 mb-2"><?php echo esc_html($block['title'] ?? ''); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo esc_html($block['description'] ?? ''); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>


    <?php
    /**
     * ========================================================================
     * CORE CPT: VOICES (Depoimentos)
     * Abertura da seção
     * ========================================================================
     */
    // 1. FAZ A CONSULTA ANTES DE ABRIR O HTML
    $voices_query = new WP_Query([
        'post_type'      => 'voice',
        'posts_per_page' => 10,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    ]);

    // 2. A REGRA: Se houver posts, mostra a secção inteira. Se não houver, ignora este bloco inteiro.
    if ($voices_query->have_posts()) :
    ?>
        <section id="voices" class="py-24 bg-durham-dark relative overflow-hidden">
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="flex flex-col lg:flex-row gap-12 items-stretch">

                    <div class="lg:w-1/3 flex flex-col justify-center text-white">
                        <div class="mb-8 inline-flex items-center justify-center w-20 h-20 rounded-full bg-white text-durham shadow-lg">
                            <i class="ph-fill ph-quotes text-5xl" aria-hidden="true"></i>
                        </div>

                        <h2 class="font-serif font-bold text-4xl md:text-5xl mb-6 leading-tight">
                            <?php if (function_exists('pll_e')) pll_e('Vozes que Cruzam Fronteiras'); ?>
                        </h2>

                        <p class="text-lg text-purple-100 mb-8 leading-relaxed max-w-md">
                            <?php if (function_exists('pll_e')) pll_e('O impacto real do projeto vai além dos dados. Histórias de quem viveu a ciência intercultural na prática.'); ?>
                        </p>

                        <a href="#" class="group inline-flex items-center font-bold text-white hover:text-purple-300 transition-colors mb-12">
                            <?php if (function_exists('pll_e')) pll_e('Ler todas as histórias'); ?>
                            <i class="ph-bold ph-arrow-circle-right ml-2 text-2xl group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                        </a>

                        <div class="flex gap-4">
                            <button onclick="document.getElementById('voices-slider').scrollBy({left: -320, behavior: 'smooth'})" aria-label="Anterior" class="w-12 h-12 rounded-full border border-white/30 hover:bg-white hover:text-durham flex items-center justify-center transition-all focus:outline-none focus:ring-2 focus:ring-white">
                                <i class="ph-bold ph-caret-left text-xl" aria-hidden="true"></i>
                            </button>
                            <button onclick="document.getElementById('voices-slider').scrollBy({left: 320, behavior: 'smooth'})" aria-label="Próximo" class="w-12 h-12 rounded-full bg-white text-durham hover:bg-purple-100 flex items-center justify-center transition-all shadow-lg focus:outline-none focus:ring-2 focus:ring-white">
                                <i class="ph-bold ph-caret-right text-xl" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="lg:w-2/3 w-full min-w-0">
                        <div id="voices-slider" class="flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory no-scrollbar pr-6 cursor-grab active:cursor-grabbing" style="scroll-behavior: smooth;">

                            <?php
                            // 3. O LOOP DOS CARDS
                            while ($voices_query->have_posts()) : $voices_query->the_post();
                                $voice_id = get_the_ID();
                                $area     = get_post_meta($voice_id, '_voice_area', true);
                                $country  = get_post_meta($voice_id, '_voice_country', true);
                            ?>
                                <article class="min-w-[300px] md:min-w-[340px] bg-white rounded-3xl overflow-hidden shadow-xl snap-start flex flex-col h-full transform hover:-translate-y-2 transition-all duration-300 relative border border-gray-100">

                                    <div class="absolute top-4 right-6 text-purple-50 opacity-50 pointer-events-none">
                                        <i class="ph-fill ph-quotes text-8xl" aria-hidden="true"></i>
                                    </div>

                                    <div class="p-8 flex-1 flex flex-col relative z-10">
                                        <div class="mb-6 pb-6 border-b border-gray-100">
                                            <h4 class="font-serif font-bold text-2xl text-neutral-900 leading-tight">
                                                <?php the_title(); ?>
                                            </h4>

                                            <?php if ($area || $country): ?>
                                                <p class="text-xs font-bold text-durham uppercase tracking-widest mt-2">
                                                    <?php
                                                    $meta_text = [];
                                                    if ($area) $meta_text[] = esc_html($area);
                                                    if ($country) $meta_text[] = esc_html($country);
                                                    echo implode(' &bull; ', $meta_text);
                                                    ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text-neutral-600 text-base leading-relaxed italic relative">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                </article>

                            <?php
                            endwhile;
                            wp_reset_postdata(); // Restaura a query global do WP
                            ?>

                            <div class="min-w-[20px] md:min-w-[40px] snap-end"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    <?php endif;
    // FIM DA REGRA: Se não houver posts, o código acima é 100% ignorado 
    ?>



    <section id="updates" class="bg-white">
        <div class="container mx-auto px-6 py-24 border-t border-gray-200">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-durham font-bold tracking-wider text-sm uppercase"><?php pll_e('Updates - Header', 'crossingboundaries'); ?></span>
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mt-2"><?php pll_e('Updates - Title', 'crossingboundaries'); ?></h2>
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
                        <?php //esc_html_e('No updates available at the moment.', 'crossingboundaries'); 
                        ?>
                        <?php pll_e('Updates - No Data', 'crossingboundaries'); ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="mt-12 text-center md:text-right">
                <a href="<?php pll_e('Updates - Link Button', 'crossingboundaries'); ?>" class="inline-block w-full md:w-auto px-8 py-3 border border-gray-300 text-neutral-700 font-semibold rounded-lg hover:border-durham hover:text-durham transition-all text-center">
                    <?php pll_e('Updates - Label Button', 'crossingboundaries'); ?>
                    <i class="ph ph-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="team" class="py-24 bg-neutral-50 border-t border-gray-200">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-serif font-bold text-3xl text-neutral-900 mb-12">
                <?php pll_e('Our Team - Title', 'crossingboundaries'); ?>
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
                    //echo '<p class="text-gray-500 italic w-full">Nenhum membro encontrado. Verifique se estão publicados no menu "Members" e se possuem um idioma atribuído (caso o Polylang esteja ativo).</p>';
                    pll_e('Our Team - No Data', 'crossingboundaries');
                endif;
                ?>
            </div>

            <a href="<?php pll_e('Our Team - Link', 'crossingboundaries'); ?>" class="inline-block border-b border-durham text-durham font-semibold hover:text-durham-dark pb-1 transition-colors">
                <?php pll_e('Our Team - Label', 'crossingboundaries'); ?>
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>