<?php

/**
 * Template Name: The Project
 * Description: Template customizado para a página de Metodologia e Contexto.
 */

get_header(); ?>

<main id="main-content">
    <?php while (have_posts()) : the_post();

        // --- BUSCANDO OS DADOS NATIVOS DO BANCO ---
        $hero_subtitle = get_post_meta(get_the_ID(), '_hero_subtitle', true);

        // As Três Áreas (Array)
        $context_blocks = get_post_meta(get_the_ID(), '_context_blocks', true) ?: [];

        // Linha do Tempo (Array de Semanas, Título, Texto e Imagens)
        $timeline = get_post_meta(get_the_ID(), '_project_timeline', true) ?: [];

        // Áreas de Atividade
        $areas_title = get_post_meta(get_the_ID(), '_areas_title', true) ?: __('Areas of Activity & Research', 'crossingboundaries');
        $areas_subtitle = get_post_meta(get_the_ID(), '_areas_subtitle', true);
        $research_areas = get_post_meta(get_the_ID(), '_research_areas', true) ?: [];

        // Manifesto COIL (HTML)
        $coil_manifesto = get_post_meta(get_the_ID(), '_coil_manifesto', true);
    ?>

        <section class="relative bg-durham-dark py-32 flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
            <div class="container mx-auto px-6 relative z-10 text-center">
                <span class="inline-block py-1.5 px-4 rounded-full border border-white/20 text-purple-100 text-xs font-bold uppercase tracking-widest mb-6">
                    <?php esc_html_e('Institutional Vision', 'crossingboundaries'); ?>
                </span>
                <h1 class="font-serif font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight">
                    <?php the_title(); // Ex: Methodology & Strategic Objectives 
                    ?>
                </h1>
                <?php if ($hero_subtitle) : ?>
                    <p class="text-lg md:text-xl text-purple-100 max-w-2xl mx-auto font-light leading-relaxed">
                        <?php echo esc_html($hero_subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <section class="py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-16 items-start">

                    <div class="lg:w-1/2">
                        <h2 class="font-serif font-bold text-3xl text-neutral-900 mb-8 border-l-4 border-durham pl-6">
                            <?php esc_html_e('Context and Motivation', 'crossingboundaries'); ?>
                        </h2>
                        <div class="prose prose-lg text-neutral-600 leading-relaxed text-justify">
                            <?php the_content(); // Usa o editor principal do WordPress 
                            ?>
                        </div>
                    </div>

                    <div class="lg:w-1/2 grid gap-6">
                        <?php foreach ($context_blocks as $block) : ?>
                            <div class="bg-neutral-50 p-8 rounded-xl border border-gray-100 hover:border-durham/30 transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-durham flex items-center justify-center shrink-0 mt-1">
                                        <i class="ph-fill <?php echo esc_attr($block['icon'] ?: 'ph-flask'); ?> text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-serif font-bold text-neutral-900 text-lg mb-2">
                                            <?php echo esc_html($block['title']); ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            <?php echo esc_html($block['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-24 bg-neutral-50 border-t border-gray-200 relative overflow-hidden timeline-line">
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-24">
                    <span class="text-durham font-bold tracking-wider text-sm uppercase block mb-4"><?php esc_html_e('The Pedagogical Approach', 'crossingboundaries'); ?></span>
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-6"><?php esc_html_e('What is COIL?', 'crossingboundaries'); ?></h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-2xl mx-auto">
                        <strong>Collaborative Online International Learning</strong> is a methodology that connects classrooms in different countries...
                    </p>
                    <button id="open-coil-modal" class="inline-flex items-center px-6 py-2 border border-durham text-durham font-bold rounded-full hover:bg-durham hover:text-white transition-all text-sm uppercase tracking-wide">
                        <?php esc_html_e('Read full methodological manifesto', 'crossingboundaries'); ?> <i class="ph-bold ph-plus-circle ml-2 text-lg"></i>
                    </button>
                </div>

                <div class="max-w-5xl mx-auto space-y-12 md:space-y-24">
                    <?php
                    // Renderiza a linha do tempo dinamicamente alternando os lados
                    foreach ($timeline as $index => $step) :
                        $is_even = ($index % 2 === 0); // Define a alternância
                    ?>
                        <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16">

                            <div class="md:w-1/2 <?php echo $is_even ? 'md:text-right order-2 md:order-1 pl-20 md:pl-0' : 'order-2 md:order-3'; ?>">
                                <div class="inline-block bg-white border border-gray-200 px-3 py-1 rounded-full text-xs font-bold text-durham mb-3 shadow-sm">
                                    <?php echo esc_html($step['weeks']); ?>
                                </div>
                                <h3 class="font-serif font-bold text-2xl text-neutral-900 mb-3"><?php echo esc_html($step['title']); ?></h3>
                                <p class="text-gray-600 leading-relaxed"><?php echo esc_html($step['description']); ?></p>
                            </div>

                            <div class="absolute left-0 md:left-1/2 w-full md:w-auto flex justify-start md:justify-center pl-6 md:pl-0 order-1 md:order-2 pointer-events-none">
                                <div class="w-4 h-4 <?php echo $is_even ? 'bg-durham border-4 border-white' : 'bg-white border-4 border-durham'; ?> rounded-full shadow-md z-10"></div>
                            </div>

                            <div class="md:w-1/2 <?php echo $is_even ? 'order-3 pl-12 md:pl-0' : 'order-3 md:order-1 pl-12 md:pl-0'; ?>">
                                <figure class="relative rounded-lg overflow-hidden shadow-lg border border-gray-200 bg-white p-2 <?php echo $is_even ? 'rotate-2 hover:rotate-0' : '-rotate-1 hover:rotate-0'; ?> transition-transform duration-500">

                                    <div class="<?php echo count($step['images']) > 1 ? 'grid grid-cols-2 gap-2' : ''; ?>">
                                        <?php foreach ($step['images'] as $img_url) : ?>
                                            <div class="h-48 overflow-hidden rounded group relative">
                                                <img src="<?php echo esc_url($img_url); ?>" alt="Timeline Step" class="w-full h-full object-cover cursor-zoom-in lightbox-trigger transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if (!empty($step['caption'])): ?>
                                        <figcaption class="text-[10px] text-gray-400 mt-2 text-center uppercase tracking-wide"><?php echo esc_html($step['caption']); ?></figcaption>
                                    <?php endif; ?>
                                </figure>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="py-24 bg-white border-t border-gray-200">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-4"><?php echo esc_html($areas_title); ?></h2>
                    <?php if ($areas_subtitle): ?>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($areas_subtitle); ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <?php foreach ($research_areas as $area) : ?>
                        <div class="p-8 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md hover:border-durham transition-all group">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-full bg-purple-50 text-durham flex items-center justify-center text-2xl group-hover:bg-durham group-hover:text-white transition-colors">
                                    <i class="ph-fill <?php echo esc_attr($area['icon'] ?: 'ph-flask'); ?>"></i>
                                </div>
                                <h3 class="font-serif font-bold text-xl text-neutral-900"><?php echo esc_html($area['title']); ?></h3>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed"><?php echo esc_html($area['description']); ?></p>

                            <ul class="space-y-2 text-sm text-gray-500">
                                <?php
                                // Separa os itens da lista por quebra de linha
                                $bullets = explode("\n", $area['bullets']);
                                foreach ($bullets as $bullet):
                                    if (trim($bullet) !== ''):
                                ?>
                                        <li class="flex items-start gap-2"><i class="ph-bold ph-check text-durham mt-0.5"></i> <?php echo esc_html(trim($bullet)); ?></li>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<div id="coil-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="coil-modal-backdrop"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative animate-modal">
            <button id="coil-modal-close" class="absolute top-4 right-4 text-gray-400 hover:text-durham transition-colors p-2"><i class="ph-bold ph-x text-2xl"></i></button>
            <div class="p-8 md:p-12">
                <span class="text-durham font-bold text-xs uppercase tracking-widest mb-4 block">Methodological Manifesto</span>

                <div class="prose text-neutral-600 leading-relaxed space-y-4">
                    <?php
                    // O conteúdo em HTML que o gestor escreveu no painel
                    echo wp_kses_post($coil_manifesto);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="image-modal" class="fixed inset-0 z-[110] hidden bg-black/95 backdrop-blur-sm transition-opacity duration-300">
    <button id="modal-close" class="absolute top-6 right-6 text-white hover:text-gray-300 z-50 p-2"><i class="ph ph-x text-4xl"></i></button>
    <div class="w-full h-full flex items-center justify-center p-4 md:p-12 relative">
        <img id="modal-image" src="" alt="Full view" class="max-w-full max-h-full object-contain shadow-2xl rounded-sm">
        <p id="modal-caption" class="absolute bottom-6 left-0 w-full text-center text-gray-300 text-sm font-medium tracking-wide bg-black/50 py-2"></p>
    </div>
    <button id="modal-prev" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition-colors"><i class="ph-bold ph-caret-left text-3xl"></i></button>
    <button id="modal-next" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition-colors"><i class="ph-bold ph-caret-right text-3xl"></i></button>
</div>

<script>
    // Modal COIL
    const coilModal = document.getElementById('coil-modal');
    const openCoilBtn = document.getElementById('open-coil-modal');
    const closeCoilBtn = document.getElementById('coil-modal-close');
    const coilBackdrop = document.getElementById('coil-modal-backdrop');

    if (openCoilBtn && coilModal) {
        function toggleCoilModal() {
            coilModal.classList.toggle('hidden');
            document.body.style.overflow = coilModal.classList.contains('hidden') ? '' : 'hidden';
        }
        openCoilBtn.addEventListener('click', toggleCoilModal);
        closeCoilBtn.addEventListener('click', toggleCoilModal);
        coilBackdrop.addEventListener('click', toggleCoilModal);
    }

    // Modal de Galeria
    const images = Array.from(document.querySelectorAll('.lightbox-trigger'));
    const imgModal = document.getElementById('image-modal');
    const modalImg = document.getElementById('modal-image');
    const modalCaption = document.getElementById('modal-caption');
    const closeImgBtn = document.getElementById('modal-close');
    const nextBtn = document.getElementById('modal-next');
    const prevBtn = document.getElementById('modal-prev');
    let currentIndex = 0;

    if (imgModal) {
        function openImgModal(index) {
            currentIndex = index;
            modalImg.src = images[currentIndex].src;
            modalCaption.innerText = images[currentIndex].alt;
            imgModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImgModal() {
            imgModal.classList.add('hidden');
            if (!coilModal || coilModal.classList.contains('hidden')) document.body.style.overflow = '';
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % images.length;
            openImgModal(currentIndex);
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            openImgModal(currentIndex);
        }

        images.forEach((img, index) => {
            img.addEventListener('click', () => openImgModal(index));
        });
        closeImgBtn.addEventListener('click', closeImgModal);
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            showNext();
        });
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            showPrev();
        });
        imgModal.addEventListener('click', (e) => {
            if (e.target === imgModal || e.target.parentElement === imgModal) closeImgModal();
        });

        document.addEventListener('keydown', (e) => {
            if (!imgModal.classList.contains('hidden')) {
                if (e.key === 'Escape') closeImgModal();
                if (e.key === 'ArrowRight') showNext();
                if (e.key === 'ArrowLeft') showPrev();
            } else if (coilModal && !coilModal.classList.contains('hidden')) {
                if (e.key === 'Escape') toggleCoilModal();
            }
        });
    }
</script>

<?php get_footer(); ?>