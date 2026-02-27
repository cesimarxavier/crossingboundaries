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

<div id="profile-modal" role="dialog" aria-modal="true" aria-labelledby="modal-name" class="fixed inset-0 z-[100] hidden modal-backdrop bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 md:p-6">

    <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[95vh] overflow-y-auto relative modal-content flex flex-col md:flex-row">

        <button onclick="closeProfile()" aria-label="Close profile" class="absolute top-6 right-6 z-50 text-gray-400 hover:text-gray-800 transition-colors">
            <i class="ph ph-x text-2xl" aria-hidden="true"></i>
        </button>

        <div class="md:w-1/3 bg-neutral-50 p-8 md:p-12 flex flex-col items-center text-center border-r border-gray-100">

            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white shadow-sm mb-6 bg-white" id="modal-img-container"></div>

            <h3 id="modal-name" class="font-serif font-bold text-3xl text-neutral-900 mb-2 leading-tight"></h3>

            <div id="modal-role" class="text-xs font-bold text-durham uppercase tracking-widest mb-10 text-center leading-relaxed"></div>

            <div class="w-full text-left mt-4">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Research Interests</p>
                <div id="modal-tags" class="flex flex-col gap-3"></div>
            </div>

            <div id="modal-social-links" class="mt-10 pt-8 border-t border-gray-200 w-full flex justify-center gap-5 hidden">
                <a id="modal-linkedin" href="#" target="_blank" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-fill ph-linkedin-logo" aria-hidden="true"></i></a>
                <a id="modal-email" href="#" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-fill ph-envelope-simple" aria-hidden="true"></i></a>
                <a id="modal-lattes" href="#" target="_blank" class="text-gray-400 hover:text-durham text-2xl transition-colors hidden"><i class="ph-bold ph-graduation-cap" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="md:w-2/3 p-8 md:p-12 lg:p-16 overflow-y-auto">
            <div class="mb-10">
                <h4 class="font-serif font-bold text-2xl text-neutral-900 mb-6 border-b border-gray-100 pb-4"><?php esc_html_e('Biography', 'crossingboundaries'); ?></h4>
                <div id="modal-bio" class="text-base text-gray-600 leading-relaxed space-y-5"></div>
            </div>

            <div>
                <h4 class="font-serif font-bold text-2xl text-neutral-900 mb-6 border-b border-gray-100 pb-4"><?php esc_html_e('Selected Publications', 'crossingboundaries'); ?></h4>
                <ul id="modal-pubs" class="space-y-4 text-sm text-gray-600 leading-relaxed"></ul>
            </div>
        </div>
    </div>
</div>

<script>
    const teamData = <?php echo wp_json_encode($js_team_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    const modal = document.getElementById('profile-modal');
    let lastFocusedElement;

    function openProfile(key) {
        const data = teamData[key];
        if (!data) return;

        lastFocusedElement = document.activeElement;

        document.getElementById('modal-img-container').innerHTML = data.img ? `<img src="${data.img}" class="w-full h-full object-cover">` : `<div class="w-full h-full bg-gray-100 flex items-center justify-center"><i class="ph-fill ph-user text-5xl text-gray-300"></i></div>`;
        document.getElementById('modal-name').innerText = data.name;

        // Formata o cargo quebrando linha se tiver o bullet (•), igual ao print
        let roleHtml = data.role.replace(' • ', '<br>•<br>');
        document.getElementById('modal-role').innerHTML = roleHtml;

        document.getElementById('modal-bio').innerHTML = data.bio;

        // Renderiza as tags EXATAMENTE como no design da direita (Texto limpo, roxo, sem background)
        document.getElementById('modal-tags').innerHTML = data.interests.map(tag => `<span class="text-durham text-xs font-bold uppercase tracking-wider block">${tag}</span>`).join('');

        // Renderiza as publicações sem a borda lateral grossa (mais clean)
        document.getElementById('modal-pubs').innerHTML = (data.pubs && data.pubs.length > 0) ? data.pubs.map(pub => `<li class="pl-0">${pub}</li>`).join('') : '<li class="text-gray-400 italic"><?php esc_html_e('No publications listed.', 'crossingboundaries'); ?></li>';

        // Redes Sociais
        const sLinkedin = document.getElementById('modal-linkedin');
        const sEmail = document.getElementById('modal-email');
        const sLattes = document.getElementById('modal-lattes');
        const sContainer = document.getElementById('modal-social-links');

        let hasSocial = false;
        if (data.social && data.social.linkedin) {
            sLinkedin.href = data.social.linkedin;
            sLinkedin.classList.remove('hidden');
            hasSocial = true;
        } else {
            sLinkedin.classList.add('hidden');
        }
        if (data.social && data.social.email) {
            sEmail.href = data.social.email.startsWith('mailto:') ? data.social.email : 'mailto:' + data.social.email;
            sEmail.classList.remove('hidden');
            hasSocial = true;
        } else {
            sEmail.classList.add('hidden');
        }
        if (data.social && data.social.lattes) {
            sLattes.href = data.social.lattes;
            sLattes.classList.remove('hidden');
            hasSocial = true;
        } else {
            sLattes.classList.add('hidden');
        }

        if (hasSocial) {
            sContainer.classList.remove('hidden');
        } else {
            sContainer.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('active');
            modal.querySelector('button[aria-label="Close profile"]').focus();
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeProfile() {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            if (lastFocusedElement) lastFocusedElement.focus();
        }, 300);
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeProfile();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeProfile();
    });
</script>

<?php get_footer(); ?>