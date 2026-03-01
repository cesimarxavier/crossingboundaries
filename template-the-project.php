<?php

/**
 * Template Name: The Project
 * Description: Template customizado para a página de Metodologia e Contexto.
 */

get_header();

// ==========================================
// FUNÇÃO HELPER PARA LER OS JSONS
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

        $id = get_the_ID();

        // 1. HERO
        $hero_header   = get_post_meta($id, '_hero_header', true) ?: 'Institutional Vision';
        // Se o gestor não preencher um título customizado no Hero, usamos o título oficial da página
        $hero_title    = get_post_meta($id, '_hero_title', true) ?: get_the_title();
        $hero_subtitle = get_post_meta($id, '_hero_subtitle', true);

        // 2. CONTEXT & MOTIVATION
        $context_title  = get_post_meta($id, '_context_title', true) ?: 'Context and Motivation';
        $context_blocks = get_safe_json_meta($id, '_context_blocks');

        // 3. PEDAGOGICAL APPROACH & COIL
        $pedagogical_title = get_post_meta($id, '_pedagogical_title', true) ?: 'The Pedagogical Approach';
        $coil_title        = get_post_meta($id, '_coil_title', true) ?: 'What is COIL?';
        $coil_description  = get_post_meta($id, '_coil_description', true);
        $coil_manifesto    = get_post_meta($id, '_coil_manifesto', true);

        // 3.1 TIMELINE
        $timeline = get_safe_json_meta($id, '_project_timeline');

        // 4. RESEARCH AREAS
        $areas_title    = get_post_meta($id, '_areas_title', true) ?: 'Areas of Activity & Research';
        $areas_subtitle = get_post_meta($id, '_areas_subtitle', true);
        $research_areas = get_safe_json_meta($id, '_research_areas');

        // 5. INTERSECTION OF KNOWLEDGE
        $intersection_title    = get_post_meta($id, '_intersection_title', true);
        $intersection_text     = get_post_meta($id, '_intersection_text', true);
        $intersection_btn_text = get_post_meta($id, '_intersection_btn_text', true);
        $intersection_btn_link = get_post_meta($id, '_intersection_btn_link', true);
        $intersection_grid     = get_safe_json_meta($id, '_intersection_grid');
    ?>

        <section class="relative bg-durham-dark py-32 flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
            <div class="container mx-auto px-6 relative z-10 text-center">
                <span class="inline-block py-1.5 px-4 rounded-full border border-white/20 text-purple-100 text-xs font-bold uppercase tracking-widest mb-6">
                    <?php echo esc_html($hero_header); ?>
                </span>
                <h1 class="font-serif font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight">
                    <?php echo esc_html($hero_title); ?>
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
                            <?php echo esc_html($context_title); ?>
                        </h2>
                        <div class="prose prose-lg text-neutral-600 leading-relaxed text-justify">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="lg:w-1/2 grid gap-6">
                        <?php foreach ($context_blocks as $block) : ?>
                            <div class="bg-neutral-50 p-8 rounded-xl border border-gray-100 hover:border-durham/30 transition-colors shadow-sm">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-durham flex items-center justify-center shrink-0 mt-1">
                                        <i class="ph-fill <?php echo esc_attr($block['icon'] ?? 'ph-flask'); ?> text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-serif font-bold text-neutral-900 text-lg mb-2">
                                            <?php echo esc_html($block['title'] ?? ''); ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            <?php echo esc_html($block['description'] ?? ''); ?>
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
                    <span class="text-durham font-bold tracking-wider text-sm uppercase block mb-4"><?php echo esc_html($pedagogical_title); ?></span>
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-6"><?php echo esc_html($coil_title); ?></h2>
                    <div class="text-lg text-gray-600 leading-relaxed mb-10 max-w-3xl mx-auto prose prose-p:font-medium">
                        <?php echo wp_kses_post($coil_description); ?>
                    </div>

                    <?php if ($coil_manifesto) : ?>
                        <button id="open-coil-modal" class="inline-flex items-center px-8 py-3 bg-white border border-durham text-durham font-bold rounded-full hover:bg-durham hover:text-white transition-all text-sm uppercase tracking-wide shadow-sm hover:shadow-md">
                            <?php if (function_exists('pll_e')) {
                                pll_e('Read full methodological manifesto');
                            } else {
                                echo 'Read full methodological manifesto';
                            } ?>
                            <i class="ph-bold ph-plus-circle ml-2 text-xl" aria-hidden="true"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <div class="max-w-5xl mx-auto space-y-12 md:space-y-24 relative">
                    <?php
                    foreach ($timeline as $index => $step) :
                        $is_even = ($index % 2 === 0);
                    ?>
                        <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16 relative">
                            <div class="md:w-1/2 <?php echo $is_even ? 'md:text-right order-2 md:order-1 pl-12 md:pl-0' : 'order-2 md:order-3 pl-12 md:pl-0'; ?>">
                                <div class="inline-block bg-white border border-gray-200 px-4 py-1.5 rounded-full text-xs font-bold text-durham mb-4 shadow-sm tracking-wider uppercase">
                                    <?php echo esc_html($step['weeks'] ?? ''); ?>
                                </div>
                                <h3 class="font-serif font-bold text-2xl text-neutral-900 mb-3"><?php echo esc_html($step['title'] ?? ''); ?></h3>
                                <p class="text-gray-600 leading-relaxed"><?php echo esc_html($step['description'] ?? ''); ?></p>
                            </div>

                            <div class="absolute left-0 md:left-1/2 w-full md:w-auto flex justify-start md:justify-center pl-[2px] md:pl-0 order-1 md:order-2 pointer-events-none">
                                <div class="w-4 h-4 <?php echo $is_even ? 'bg-durham border-4 border-white' : 'bg-white border-4 border-durham'; ?> rounded-full shadow-md z-10"></div>
                            </div>

                            <div class="md:w-1/2 <?php echo $is_even ? 'order-3 pl-12 md:pl-0' : 'order-3 md:order-1 pl-12 md:pl-0'; ?>">
                                <?php if (!empty($step['images'])) : ?>
                                    <figure class="relative rounded-xl overflow-hidden shadow-lg border border-gray-100 bg-white p-2 <?php echo $is_even ? 'rotate-2 hover:rotate-0' : '-rotate-1 hover:rotate-0'; ?> transition-transform duration-500">
                                        <div class="<?php echo count($step['images']) > 1 ? 'grid grid-cols-2 gap-2' : ''; ?>">
                                            <?php foreach ($step['images'] as $img_url) : ?>
                                                <div class="h-48 overflow-hidden rounded group relative">
                                                    <img src="<?php echo esc_url($img_url); ?>" alt="Timeline Step" class="w-full h-full object-cover cursor-zoom-in lightbox-trigger transition-transform duration-700 group-hover:scale-105">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (!empty($step['caption'])): ?>
                                            <figcaption class="text-[10px] text-gray-400 mt-3 mb-1 text-center uppercase tracking-wider font-bold"><?php echo esc_html($step['caption']); ?></figcaption>
                                        <?php endif; ?>
                                    </figure>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="py-24 bg-white border-t border-gray-200">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16 max-w-3xl mx-auto">
                    <h2 class="font-serif font-bold text-3xl md:text-4xl text-neutral-900 mb-6"><?php echo esc_html($areas_title); ?></h2>
                    <?php if ($areas_subtitle): ?>
                        <p class="text-lg text-gray-600 leading-relaxed"><?php echo esc_html($areas_subtitle); ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <?php foreach ($research_areas as $area) : ?>
                        <div class="p-8 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md hover:border-durham transition-all group">

                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-full bg-purple-50 text-durham flex items-center justify-center text-2xl group-hover:bg-durham group-hover:text-white transition-colors">
                                    <i class="ph-fill <?php echo esc_attr($area['icon'] ?? 'ph-flask'); ?>" aria-hidden="true"></i>
                                </div>
                                <h3 class="font-serif font-bold text-xl text-neutral-900"><?php echo esc_html($area['title'] ?? ''); ?></h3>
                            </div>

                            <p class="text-gray-600 mb-4 text-sm leading-relaxed"><?php echo esc_html($area['description'] ?? ''); ?></p>

                            <?php if (!empty($area['bullets'])): ?>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <?php
                                    $bullets = explode("\n", $area['bullets']);
                                    foreach ($bullets as $bullet):
                                        if (trim($bullet) !== '') {
                                            // Adicionado o ícone de check do seu layout
                                            echo '<li class="flex items-start gap-2"><i class="ph-bold ph-check text-durham mt-0.5" aria-hidden="true"></i> ' . esc_html(trim($bullet)) . '</li>';
                                        }
                                    endforeach;
                                    ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="py-24 bg-neutral-50 border-t border-gray-200">
            <div class="container mx-auto px-6">
                <div class="bg-durham-dark rounded-2xl p-10 md:p-16 relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/20 rounded-full blur-2xl -ml-10 -mb-10"></div>

                    <div class="relative z-10 flex flex-col md:flex-row gap-12 items-center">
                        <div class="md:w-1/2 text-white">
                            <h2 class="font-serif font-bold text-3xl mb-6"><?php echo esc_html($intersection_title); ?></h2>
                            <p class="text-purple-100 text-lg leading-relaxed mb-8">
                                <?php echo esc_html($intersection_text); ?>
                            </p>
                            <?php if ($intersection_btn_text && $intersection_btn_link) : ?>
                                <a href="<?php echo esc_url($intersection_btn_link); ?>" class="inline-flex items-center bg-white text-durham font-bold px-8 py-3 rounded-lg hover:bg-purple-50 transition-colors shadow-md">
                                    <?php echo esc_html($intersection_btn_text); ?> <i class="ph-bold ph-arrow-right ml-2" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="md:w-1/2 w-full">
                            <div class="grid grid-cols-2 gap-4">
                                <?php
                                $count = 0;
                                foreach ($intersection_grid as $item):
                                    $margin_class = ($count % 2 !== 0) ? 'mt-8' : '';
                                ?>
                                    <div class="bg-white/10 backdrop-blur border border-white/10 p-6 rounded-2xl text-center <?php echo $margin_class; ?> hover:bg-white/20 transition-colors">
                                        <i class="ph-fill <?php echo esc_attr($item['icon'] ?? 'ph-flask'); ?> text-3xl text-purple-200 mb-3" aria-hidden="true"></i>
                                        <h4 class="text-white font-bold text-sm tracking-wide"><?php echo esc_html($item['title'] ?? ''); ?></h4>
                                    </div>
                                <?php
                                    $count++;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<div id="coil-modal" role="dialog" aria-modal="true" class="fixed inset-0 z-[100] hidden modal-backdrop bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 md:p-6">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto relative animate-modal">
        <button id="coil-modal-close" aria-label="Close manifesto" class="absolute top-6 right-6 z-50 text-gray-400 hover:text-gray-800 transition-colors">
            <i class="ph ph-x text-2xl" aria-hidden="true"></i>
        </button>
        <div class="p-8 md:p-16">
            <span class="text-durham font-bold text-xs uppercase tracking-widest mb-6 block border-b border-gray-100 pb-4">
                <?php if (function_exists('pll_e')) {
                    pll_e('Methodological Manifesto');
                } else {
                    echo 'Methodological Manifesto';
                } ?>
            </span>
            <div class="prose prose-lg text-neutral-600 leading-relaxed space-y-5">
                <?php echo wp_kses_post($coil_manifesto); ?>
            </div>
        </div>
    </div>
</div>

<div id="image-modal" role="dialog" aria-modal="true" class="fixed inset-0 z-[110] hidden bg-black/95 backdrop-blur-sm transition-opacity duration-300">
    <button id="modal-close" aria-label="Close image" class="absolute top-6 right-6 text-white hover:text-gray-300 z-50 p-2"><i class="ph ph-x text-4xl" aria-hidden="true"></i></button>
    <div class="w-full h-full flex items-center justify-center p-4 md:p-12 relative">
        <img id="modal-image" src="" alt="Full view" class="max-w-full max-h-full object-contain shadow-2xl rounded-sm">
        <p id="modal-caption" class="absolute bottom-6 left-0 w-full text-center text-gray-300 text-sm font-medium tracking-wide bg-black/50 py-2"></p>
    </div>
    <button id="modal-prev" aria-label="Previous image" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition-colors"><i class="ph-bold ph-caret-left text-3xl" aria-hidden="true"></i></button>
    <button id="modal-next" aria-label="Next image" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition-colors"><i class="ph-bold ph-caret-right text-3xl" aria-hidden="true"></i></button>
</div>

<script>
    // Controle do Modal COIL e Galeria
    const coilModal = document.getElementById('coil-modal');
    const openCoilBtn = document.getElementById('open-coil-modal');
    const closeCoilBtn = document.getElementById('coil-modal-close');

    if (openCoilBtn && coilModal) {
        function toggleCoilModal() {
            coilModal.classList.toggle('hidden');
            document.body.style.overflow = coilModal.classList.contains('hidden') ? '' : 'hidden';
            if (!coilModal.classList.contains('hidden')) closeCoilBtn.focus();
        }
        openCoilBtn.addEventListener('click', toggleCoilModal);
        closeCoilBtn.addEventListener('click', toggleCoilModal);
        coilModal.addEventListener('click', (e) => {
            if (e.target === coilModal) toggleCoilModal();
        });
    }

    const images = Array.from(document.querySelectorAll('.lightbox-trigger'));
    const imgModal = document.getElementById('image-modal');
    const modalImg = document.getElementById('modal-image');
    const modalCaption = document.getElementById('modal-caption');
    const closeImgBtn = document.getElementById('modal-close');
    const nextBtn = document.getElementById('modal-next');
    const prevBtn = document.getElementById('modal-prev');
    let currentIndex = 0;

    if (imgModal && images.length > 0) {
        function openImgModal(index) {
            currentIndex = index;
            modalImg.src = images[currentIndex].src;
            modalCaption.innerText = images[currentIndex].alt || '';
            imgModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            closeImgBtn.focus();
        }

        function closeImgModal() {
            imgModal.classList.add('hidden');
            if (!coilModal || coilModal.classList.contains('hidden')) document.body.style.overflow = '';
        }

        function showNext() {
            openImgModal((currentIndex + 1) % images.length);
        }

        function showPrev() {
            openImgModal((currentIndex - 1 + images.length) % images.length);
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