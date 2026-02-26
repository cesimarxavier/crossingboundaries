<?php

/**
 * Template Name: Our Team
 */
get_header(); ?>

<style>
    /* CSS Específico do Modal da Equipe */
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
</style>

<main class="pt-24" id="main-content">

    <?php while (have_posts()) : the_post(); ?>
        <section class="bg-durham-dark py-20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
            <div class="container mx-auto px-6 text-center relative z-10">
                <h1 class="font-serif font-bold text-4xl md:text-5xl text-white mb-6"><?php the_title(); ?></h1>
                <div class="text-purple-100 text-lg max-w-2xl mx-auto font-light leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endwhile; ?>

    <section class="py-24 bg-neutral-50">
        <div class="container mx-auto px-6">
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-12">
                    <div class="h-px bg-gray-200 flex-1"></div>
                    <span class="text-durham font-bold tracking-wider text-sm uppercase"><?php esc_html_e('Project Collaborators', 'crossingboundaries'); ?></span>
                    <div class="h-px bg-gray-200 flex-1"></div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    // BUSCA OS MEMBROS NO BANCO
                    $team_query = new WP_Query([
                        'post_type'      => 'team',
                        'posts_per_page' => -1,
                        'order'          => 'ASC'
                    ]);

                    $js_team_data = []; // Array que vai virar o JSON para o Modal JS

                    if ($team_query->have_posts()) :
                        while ($team_query->have_posts()) : $team_query->the_post();

                            $member_id = get_the_ID();
                            $key       = 'member_' . $member_id; // Ex: member_45
                            $role      = get_post_meta($member_id, '_team_role', true);
                            $img_url   = get_the_post_thumbnail_url($member_id, 'large');
                            $interests = array_filter(array_map('trim', explode(',', get_post_meta($member_id, '_team_interests', true))));
                            $pubs      = array_filter(array_map('trim', explode("\n", get_post_meta($member_id, '_team_publications', true))));

                            // Popula o Array para o JS
                            $js_team_data[$key] = [
                                'name'      => get_the_title(),
                                'role'      => $role,
                                'img'       => $img_url ?: '',
                                'interests' => $interests,
                                'bio'       => apply_filters('the_content', get_the_content()), // Biografia completa formatada com tags <p>
                                'pubs'      => $pubs
                            ];
                    ?>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full cursor-pointer"
                                onclick="openProfile('<?php echo $key; ?>')">
                                <div class="p-8 flex flex-col items-center text-center h-full">
                                    <div class="w-32 h-32 rounded-full overflow-hidden mb-6 border-4 border-neutral-50 group-hover:border-durham/20 transition-colors shadow-sm flex items-center justify-center bg-gray-50">
                                        <?php if ($img_url) : ?>
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                                        <?php else : ?>
                                            <i class="ph-fill ph-user text-5xl text-gray-300"></i>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="font-serif font-bold text-xl text-neutral-900 mb-1"><?php echo get_the_title(); ?></h3>

                                    <?php if ($role) : ?>
                                        <p class="text-xs font-bold text-durham uppercase tracking-wider mb-4"><?php echo esc_html($role); ?></p>
                                    <?php endif; ?>

                                    <p class="text-sm text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                    </p>

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
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
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
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Research Interests</p>
                <div id="modal-tags" class="flex flex-wrap gap-2"></div>
            </div>
        </div>

        <div class="md:w-2/3 p-8 md:p-12 overflow-y-auto">
            <div class="mb-8">
                <h4 class="font-serif font-bold text-xl text-neutral-900 mb-4 border-b border-gray-100 pb-2">Biography</h4>
                <div id="modal-bio" class="prose prose-sm text-gray-600 leading-relaxed space-y-4"></div>
            </div>

            <div>
                <h4 class="font-serif font-bold text-xl text-neutral-900 mb-4 border-b border-gray-100 pb-2">Selected Publications</h4>
                <ul id="modal-pubs" class="space-y-4 text-sm text-gray-600"></ul>
            </div>
        </div>
    </div>
</div>

<script>
    // A MÁGICA: O PHP IMPRIME O JSON DIRETAMENTE PARA O JS LER!
    const teamData = <?php echo wp_json_encode($js_team_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    // --- LÓGICA DO MODAL (Intacta) ---
    const modal = document.getElementById('profile-modal');
    const modalImgContainer = document.getElementById('modal-img-container');
    const modalName = document.getElementById('modal-name');
    const modalRole = document.getElementById('modal-role');
    const modalTags = document.getElementById('modal-tags');
    const modalBio = document.getElementById('modal-bio');
    const modalPubs = document.getElementById('modal-pubs');

    function openProfile(key) {
        const data = teamData[key];
        if (!data) return;

        if (data.img) {
            modalImgContainer.innerHTML = `<img src="${data.img}" class="w-full h-full object-cover">`;
        } else {
            modalImgContainer.innerHTML = `<div class="w-full h-full bg-gray-100 flex items-center justify-center"><i class="ph-fill ph-user text-5xl text-gray-300"></i></div>`;
        }

        if (modalName) modalName.innerText = data.name;
        if (modalRole) modalRole.innerText = data.role;
        if (modalBio) modalBio.innerHTML = data.bio;

        if (modalTags) {
            modalTags.innerHTML = data.interests.map(tag =>
                `<span class="px-2 py-1 bg-purple-50 text-durham text-xs font-bold uppercase rounded border border-purple-100">${tag}</span>`
            ).join('');
        }

        if (modalPubs) {
            if (data.pubs && data.pubs.length > 0) {
                modalPubs.innerHTML = data.pubs.map(pub =>
                    `<li class="pl-4 border-l-2 border-durham/30 leading-snug">${pub}</li>`
                ).join('');
            } else {
                modalPubs.innerHTML = '<li class="text-gray-400 italic">No recent publications listed.</li>';
            }
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeProfile() {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
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