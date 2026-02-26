<?php

/**
 * Arquivo Nativo do WP para listar o CPT "member"
 * Rota automática: /our-team/
 */
get_header();
?>

<style>
    .modal-backdrop {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-content {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-backdrop.active .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<main class="pt-24" id="main-content">

    <section class="bg-durham-dark py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="font-serif font-bold text-4xl md:text-5xl text-white mb-6">
                <?php post_type_archive_title('', true); ?>
            </h1>
            <p class="text-purple-100 text-lg max-w-2xl mx-auto font-light leading-relaxed">
                <?php esc_html_e('Meet the academic leaders and dedicated researchers from Durham University and UFRJ bridging science and culture.', 'crossingboundaries'); ?>
            </p>
        </div>
    </section>

    <section class="py-24 bg-neutral-50">
        <div class="container mx-auto px-6">

            <div class="flex items-center gap-4 mb-12">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-durham font-bold tracking-wider text-sm uppercase"><?php esc_html_e('Project Collaborators', 'crossingboundaries'); ?></span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $js_team_data = []; // Guardará os dados para o Modal JS

                if (have_posts()) :
                    while (have_posts()) : the_post();

                        $member_id = get_the_ID();
                        $key       = 'member_' . $member_id;
                        $role      = get_post_meta($member_id, '_member_role', true);
                        $img_url   = get_the_post_thumbnail_url($member_id, 'large');
                        $interests = array_filter(array_map('trim', explode(',', get_post_meta($member_id, '_member_interests', true))));
                        $pubs      = array_filter(array_map('trim', explode("\n", get_post_meta($member_id, '_member_publications', true))));

                        // Puxando redes sociais (pode cadastrar os campos no painel posteriormente)
                        $linkedin = get_post_meta($member_id, '_member_linkedin', true);
                        $email    = get_post_meta($member_id, '_member_email', true);
                        $lattes   = get_post_meta($member_id, '_member_lattes', true);

                        // Empacota os dados para o Javascript do Modal
                        $js_team_data[$key] = [
                            'name'      => get_the_title(),
                            'role'      => $role,
                            'img'       => $img_url ?: '',
                            'interests' => $interests,
                            'bio'       => apply_filters('the_content', get_the_content()),
                            'pubs'      => $pubs,
                            'social'    => [
                                'linkedin' => $linkedin,
                                'email'    => $email,
                                'lattes'   => $lattes
                            ]
                        ];
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

                                <div class="text-sm text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="mt-auto w-full">
                                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                                        <?php
                                        $card_tags = array_slice($interests, 0, 2);
                                        foreach ($card_tags as $tag): ?>
                                            <span class="px-2 py-1 bg-purple-50 text-durham text-[10px] font-bold uppercase rounded"><?php echo esc_html($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="text-durham font-bold text-sm flex items-center justify-center gap-2 group-hover:gap-3 transition-all">
                                        <?php esc_html_e('View Full Profile', 'crossingboundaries'); ?> <i class="ph-bold ph-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                <?php
                    endwhile;
                else :
                    echo '<p class="text-center text-gray-500 col-span-3">' . esc_html__('No members found.', 'crossingboundaries') . '</p>';
                endif;
                ?>
            </div>

            <div class="mt-12 flex justify-center">
                <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '<', 'next_text' => '>']); ?>
            </div>

        </div>
    </section>
</main>

<div id="profile-modal" class="fixed inset-0 z-[100] hidden modal-backdrop bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative modal-content flex flex-col md:flex-row overflow-hidden">

        <button onclick="closeProfile()" class="absolute top-4 right-4 z-50 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-durham transition-colors shadow-sm">
            <i class="ph-bold ph-x text-xl"></i>
        </button>

        <div class="md:w-1/3 bg-neutral-50 p-8 flex flex-col items-center text-center border-r border-gray-100">
            <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-lg mb-6" id="modal-img-container"></div>
            <h3 id="modal-name" class="font-serif font-bold text-2xl text-neutral-900 mb-2 leading-tight"></h3>
            <p id="modal-role" class="text-sm font-bold text-durham uppercase tracking-wider mb-6"></p>

            <div class="w-full text-left">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3"><?php esc_html_e('Research Interests', 'crossingboundaries'); ?></p>
                <div id="modal-tags" class="flex flex-col gap-2"></div>
            </div>

            <div id="modal-social-links" class="mt-8 pt-8 border-t border-gray-200 w-full flex justify-center gap-4 hidden">
                <a id="modal-linkedin" href="#" target="_blank" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-fill ph-linkedin-logo"></i></a>
                <a id="modal-email" href="#" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-fill ph-envelope-simple"></i></a>
                <a id="modal-lattes" href="#" target="_blank" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-bold ph-graduation-cap"></i></a>
            </div>
        </div>

        <div class="md:w-2/3 p-8 md:p-12 overflow-y