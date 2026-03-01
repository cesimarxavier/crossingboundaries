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

        <section class="relative h-screen flex items-center justify-center overflow-hidden bg-durham-dark"
            style="<?php echo $hero_bg ? 'background-image: url(\'' . esc_url($hero_bg) . '\'); background-size: cover; background-position: center;' : ''; ?>">

            <div class="absolute inset-0 bg-durham-dark/70"></div>

            <div class="container mx-auto px-6 relative z-10 text-center text-white mt-16">
                <h1 class="font-serif font-bold text-5xl md:text-6xl lg:text-7xl mb-6 leading-tight fade-in">
                    <?php echo esc_html($hero_title); ?>
                </h1>

                <?php if ($hero_subtitle): ?>
                    <p class="text-xl md:text-2xl text-purple-100 max-w-3xl mx-auto font-light leading-relaxed mb-10 fade-in" style="animation-delay: 0.2s;">
                        <?php echo esc_html($hero_subtitle); ?>
                    </p>
                <?php endif; ?>
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
</main>

<?php get_footer(); ?>