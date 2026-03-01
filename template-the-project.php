<?php
/**
 * Template Name: The Project
 * Description: Template customizado para a página de Metodologia e Contexto.
 */

get_header();

// ==========================================
// FUNÇÃO HELPER PARA LER OS JSONS COM SEGURANÇA
// ==========================================
function get_safe_json_meta($post_id, $meta_key) {
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

        // 1. HERÓI
        $hero_subtitle = get_post_meta($id, '_hero_subtitle', true);

        // 2. PEDAGOGICAL APPROACH & COIL
        $pedagogical_title = get_post_meta($id, '_pedagogical_title', true) ?: 'The Pedagogical Approach';
        $coil_title        = get_post_meta($id, '_coil_title', true) ?: 'What is COIL?';
        $coil_description  = get_post_meta($id, '_coil_description', true);
        $coil_manifesto    = get_post_meta($id, '_coil_manifesto', true);

        // 3. RESEARCH AREAS (Contexto e Motivação)
        $areas_title    = get_post_meta($id, '_areas_title', true) ?: 'Context and Motivation';
        $areas_subtitle = get_post_meta($id, '_areas_subtitle', true);
        $research_areas = get_safe_json_meta($id, '_research_areas');

        // 4. INTERSECTION OF KNOWLEDGE
        $intersection_title    = get_post_meta($id, '_intersection_title', true);
        $intersection_text     = get_post_meta($id, '_intersection_text', true);
        $intersection_btn_text = get_post_meta($id, '_intersection_btn_text', true);
        $intersection_btn_link = get_post_meta($id, '_intersection_btn_link', true);
        $intersection_grid     = get_safe_json_meta($id, '_intersection_grid');

        // 5. TIMELINE
        $timeline = get_safe_json_meta($id, '_project_timeline');
    ?>

        <section class="relative bg-durham-dark py-32 flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff33_1px,transparent_1px)] [background-size:20px_20px]"></div>
            <div class="container mx-auto px-6 relative z-10 text-center">
                <span class="inline-block py-1.5 px-4 rounded-full border border-white/20 text-purple-100 text-xs font-bold uppercase tracking-widest mb-6">
                    <?php 
                    // Se o Polylang estiver ativo, tenta traduzir. Senão exibe o padrão.
                    if(function_exists('pll_e')) { pll_e('Institutional Vision'); } else { echo 'Institutional Vision'; } 
                    ?>
                </span>
                <h1 class="font-serif font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight">
                    <?php the_title(); ?>
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
                            <?php echo esc_html($areas_title); ?>
                        </h2>
                        <?php if ($areas_subtitle): ?>
                            <p class="text-lg text-gray-600 mb-8 leading-relaxed"><?php echo esc_html($areas_subtitle); ?></p>
                        <?php endif; ?>
                        
                        <div class="prose prose-lg text-neutral-600 leading-relaxed text-justify">
                            <?php the_content(); // Usa o editor principal do WordPress ?>
                        </div>
                    </div>

                    <div class="lg:w-1/2 grid gap-6">
                        <?php foreach ($research_areas as $block) : ?>
                            <div class="bg-neutral-50 p-8 rounded-xl border border-gray-100 hover:border-durham/30 transition-colors shadow-sm">
                                <div class="flex items-start gap-5">
                                    <div class="w-12 h-12 rounded-full bg-purple-100 text-durham flex items-center justify-center shrink-0 mt-1">
                                        <i class="ph-fill <?php echo esc_attr($block['icon'] ?? 'ph-flask'); ?> text-2xl" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-serif font-bold text-neutral-900 text-lg mb-2">
                                            <?php echo esc_html($block['title'] ?? ''); ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 leading-relaxed mb-3">
                                            <?php echo esc_html($block['description'] ?? ''); ?>
                                        </p>
                                        <?php if (!empty($block['bullets'])): ?>
                                            <ul class="text-sm text-gray-500 list-disc pl-4 space-y-1">
                                                <?php 
                                                $bullets = explode("\n", $block['bullets']);
                                                foreach($bullets as $bullet): 
                                                    if(trim($bullet) !== '') {
                                                        echo '<li>' . esc_html(trim($bullet)) . '</li>';
                                                    }
                                                endforeach; 
                                                ?>
                                            </ul>
                                        <?php endif; ?>
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