<?php
get_header();

// 1. DESCUBRE O IDIOMA ATUAL (Olhando para a URL ?lang=pt)
$current_lang = (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? '_pt' : '_en';

$id = get_the_ID();

// 2. PUXA OS DADOS COM O SUFIXO DINÂMICO
$hero_label = get_post_meta($id, '_home_hero_label' . $current_lang, true);
$hero_title = get_post_meta($id, '_home_hero_title' . $current_lang, true);
$hero_desc  = get_post_meta($id, '_home_hero_desc' . $current_lang, true);

$about_label   = get_post_meta($id, '_home_about_label' . $current_lang, true);
$about_title   = get_post_meta($id, '_home_about_title' . $current_lang, true);
$about_content = get_post_meta($id, '_home_about_content' . $current_lang, true);

// A imagem não tem idioma, então não usa o sufixo dinâmico
$about_img = get_post_meta($id, '_home_about_img', true) ?: get_template_directory_uri() . '/assets/img/placeholder-about.jpg';

?>

<main id="main-content">
    <section class="relative h-[90vh] min-h-[600px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Students collaborating" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/90 via-neutral-900/60 to-transparent"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 pt-20">
            <div class="max-w-2xl animate-fade-in-up">
                <span class="inline-block py-1 px-3 rounded-full border text-xs font-bold uppercase tracking-wider mb-6 bg-white/10 text-white border-white/20">
                    Interdisciplinary Project
                </span>
                <h1 class="font-serif font-black text-4xl md:text-5xl lg:text-6xl text-white leading-tight mb-6">
                    Crossing Boundaries: <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-white">Uniting Cultures</span>
                    for Sustainability.
                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-8 font-light leading-relaxed max-w-lg">
                    An innovative collaboration between Durham University and UFRJ, bringing students together to solve global SDG challenges through COIL methodology.
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
                    <span class="text-durham font-bold tracking-wider text-sm uppercase mb-3 block">About the Initiative</span>
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-6">Preparing the Next Generation of Scientists</h2>
                    <div class="prose prose-lg text-gray-600 mb-8">
                        <p>The <strong>Crossing Boundaries</strong> project is not merely about chemistry or biology; it is fundamentally about <strong>internationalisation</strong>.</p>
                        <p>Our mission is to democratise the global experience, ensuring that the new generation of Brazilian and British scientists develops critical intercultural competencies. By connecting research laboratories across virtual and physical borders, we prepare students not only to execute experiments but to lead diverse global teams in solving the greatest challenges of the 21st century.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-durham-university.svg" class="h-8 opacity-70 grayscale">
                        <div class="w-px h-6 bg-gray-300"></div>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-ufrj.svg" class="h-8 opacity-70 grayscale">
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-purple-50 rounded-tl-3xl z-0"></div>
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Students collaborating" class="relative z-10 rounded-xl shadow-xl w-full object-cover aspect-[4/3]">
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 text-center">
            <span class="text-durham font-bold tracking-wider text-sm uppercase block mb-4">Methodology</span>
            <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-16">The Project Explained</h2>

            <div class="grid md:grid-cols-3 gap-12 max-w-5xl mx-auto mb-16">
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-neutral-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-purple-50 group-hover:scale-110 transition-all border border-gray-100 shadow-sm">
                        <i class="ph-duotone ph-desktop text-4xl text-durham"></i>
                    </div>
                    <h4 class="font-serif font-bold text-xl mb-3">Digital Connection</h4>
                    <p class="text-sm text-gray-600">Virtually paired classrooms working on identical problems with different cultural perspectives.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-neutral-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-purple-50 group-hover:scale-110 transition-all border border-gray-100 shadow-sm">
                        <i class="ph-duotone ph-users-three text-4xl text-durham"></i>
                    </div>
                    <h4 class="font-serif font-bold text-xl mb-3">Peer-to-Peer Interaction</h4>
                    <p class="text-sm text-gray-600">Students manage time zones, languages, and working methods in real joint tasks.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 mx-auto bg-neutral-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-purple-50 group-hover:scale-110 transition-all border border-gray-100 shadow-sm">
                        <i class="ph-duotone ph-lightbulb text-4xl text-durham"></i>
                    </div>
                    <h4 class="font-serif font-bold text-xl mb-3">Scientific Co-creation</h4>
                    <p class="text-sm text-gray-600">The ultimate goal is not an essay, but a viable prototype for agriculture and sustainability.</p>
                </div>
            </div>

            <a href="<?php echo esc_url(home_url('/the-project')); ?>" class="inline-flex items-center gap-2 border-2 border-durham text-durham font-bold px-8 py-3 rounded-full hover:bg-durham hover:text-white transition-colors uppercase tracking-wide text-sm">
                Read Full Methodological Manifesto
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
                        <span class="text-durham font-bold tracking-wider text-sm uppercase">Outcomes</span>
                    </div>
                    <h2 class="font-serif font-bold text-4xl lg:text-5xl text-neutral-900 mb-6 leading-tight">Context and <br>Motivation</h2>
                    <div class="prose prose-lg text-gray-600 leading-relaxed text-justify mb-8">
                        <p>The complexity of contemporary challenges demands a reshaping of how new scientists are trained. Problems such as food security and soil contamination do not respect geopolitical borders.</p>
                        <p>Our actions aim for concrete outcomes in Transnational Education (TNE), creating learning ecosystems that benefit institutions and societies bidirectionally.</p>
                    </div>
                    <a href="<?php echo esc_url(home_url('/solutions')); ?>" class="inline-flex items-center bg-durham text-white px-8 py-3 rounded-full font-bold shadow-md hover:bg-durham-dark transition-colors">
                        See Solutions in Practice <i class="ph-bold ph-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="lg:w-1/2 flex flex-col gap-5 w-full">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex gap-6 items-start shadow-sm hover:shadow-md hover:border-durham/30 transition-all group">
                        <div class="w-14 h-14 rounded-full bg-purple-50 text-durham flex items-center justify-center shrink-0 group-hover:bg-durham group-hover:text-white transition-colors">
                            <i class="ph-fill ph-flask text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-xl text-neutral-900 mb-2">Projects & Innovation</h3>
                            <p class="text-sm text-gray-600">Developing tangible solutions, uniting nanotechnology and biology for sustainable agriculture (SDGs 2 and 15).</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex gap-6 items-start shadow-sm hover:shadow-md hover:border-durham/30 transition-all group">
                        <div class="w-14 h-14 rounded-full bg-purple-50 text-durham flex items-center justify-center shrink-0 group-hover:bg-durham group-hover:text-white transition-colors">
                            <i class="ph-fill ph-translate text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-xl text-neutral-900 mb-2">International Learning</h3>
                            <p class="text-sm text-gray-600">Fostering intercultural competence, overcoming linguistic barriers, and shaping multidisciplinary teams.</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex gap-6 items-start shadow-sm hover:shadow-md hover:border-durham/30 transition-all group">
                        <div class="w-14 h-14 rounded-full bg-purple-50 text-durham flex items-center justify-center shrink-0 group-hover:bg-durham group-hover:text-white transition-colors">
                            <i class="ph-fill ph-buildings text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-xl text-neutral-900 mb-2">Institutional Collaboration</h3>
                            <p class="text-sm text-gray-600">Strengthening relationships between Global North and South universities through the support of funding agencies.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC'
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

    <?php
    /**
    <section id="time" class="py-24 bg-neutral-50 border-t border-gray-200">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-serif font-bold text-3xl text-neutral-900 mb-12">Minds Behind the Project</h2>

            <div class="flex flex-wrap justify-center gap-12 mb-12">
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-4 group-hover:border-durham transition-colors">
                        <img src="https://randomuser.me/api/portraits/men/46.jpg" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-neutral-900">Dr. Alan Smith</h4><span class="text-xs text-gray-500 uppercase font-medium">Principal Investigator (UK)</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-4 group-hover:border-durham transition-colors">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-neutral-900">Dr. Maria Costa</h4><span class="text-xs text-gray-500 uppercase font-medium">Principal Investigator (BR)</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-4 group-hover:border-durham transition-colors">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-neutral-900">Dra. Ana Sousa</h4><span class="text-xs text-gray-500 uppercase font-medium">Intercultural Lead</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-4 group-hover:border-durham transition-colors">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-neutral-900">Dra. Emily White</h4><span class="text-xs text-gray-500 uppercase font-medium">Postdoc Researcher</span>
                </div>
            </div>

            <a href="<?php echo esc_url(home_url('/our-team')); ?>" class="inline-block border-b border-durham text-durham font-semibold hover:text-durham-dark pb-1">
                Meet the full team & curricula
            </a>
        </div>
    </section>
     */
    ?>

</main>

<?php get_footer(); ?>