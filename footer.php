<footer class="bg-durham-dark text-white pt-20 pb-8 mt-auto border-t-[6px] border-durham-light relative z-20">
    <div class="container mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">

            <div class="md:col-span-5">
                <h3 class="font-serif font-bold text-2xl lg:text-3xl mb-4 leading-tight">
                    Crossing<br>Boundaries
                </h3>
                <p class="text-purple-100 text-sm md:text-base mb-6 max-w-sm">
                    <?php if (function_exists('pll_e')) pll_e('Subtitle Footer', 'crossingboundaries'); ?>
                </p>

                <div class="flex gap-4">
                    <?php
                    // Vai buscar as URLs do Customizer
                    $twitter_url  = get_theme_mod('cb_twitter_url');
                    $linkedin_url = get_theme_mod('cb_linkedin_url');

                    // Renderiza o X apenas se não estiver vazio
                    if (!empty($twitter_url)) :
                    ?>
                        <a href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="noopener noreferrer" class="text-purple-200 hover:text-white transition-colors">
                            <i class="ph-bold ph-x-logo text-xl" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>

                    <?php
                    // Renderiza o LinkedIn apenas se não estiver vazio
                    if (!empty($linkedin_url)) :
                    ?>
                        <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener noreferrer" class="text-purple-200 hover:text-white transition-colors">
                            <i class="ph-bold ph-linkedin-logo text-2xl" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="md:col-span-3">
                <h4 class="font-bold text-lg mb-6 tracking-wide">
                    <?php if (function_exists('pll_e')) pll_e('Title Links', 'crossingboundaries'); ?>
                </h4>

                <nav class="footer-nav">
                    <?php
                    if (has_nav_menu('footer_menu')) {
                        wp_nav_menu([
                            'theme_location' => 'footer_menu',
                            'container'      => false,
                            'menu_class'     => 'flex flex-col gap-3 text-sm text-purple-100',
                            'depth'          => 1,
                            'fallback_cb'    => false
                        ]);
                    } else {
                        echo '<p class="text-sm text-purple-200 opacity-60">Atribua um menu em Aparência > Menus</p>';
                    }
                    ?>
                </nav>
            </div>

            <div class="md:col-span-4">
                <h4 class="font-bold text-lg mb-6 tracking-wide">
                    <?php if (function_exists('pll_e')) pll_e('Title Contact', 'crossingboundaries'); ?>
                </h4>

                <?php
                // Puxa o e-mail do Customizer (com um fallback seguro se estiver vazio)
                $contact_email = get_theme_mod('cb_contact_email', 'contact@crossingboundaries.ac.uk');

                if (!empty($contact_email)) :
                ?>
                    <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="inline-flex items-center gap-3 text-sm md:text-base text-purple-100 hover:text-white transition-colors underline underline-offset-4 decoration-purple-100/30 hover:decoration-white">
                        <i class="ph-bold ph-envelope-simple text-xl" aria-hidden="true"></i>
                        <?php echo esc_html($contact_email); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>

        <div class="pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-6 text-xs md:text-sm text-purple-200">
            <p>
                <?php if (function_exists('pll_e')) pll_e('Copyright Footer', 'crossingboundaries'); ?>
            </p>

            <div class="flex gap-6"></div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>

<script>
    // Menu Mobile Global
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = btn ? btn.querySelector('i') : null;

    if (btn && menu) {
        function toggleMenu() {
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.classList.remove('ph-x');
                icon.classList.add('ph-list');
            } else {
                icon.classList.remove('ph-list');
                icon.classList.add('ph-x');
            }
        }
        btn.addEventListener('click', toggleMenu);
    }

    // Logic Slider (Apenas roda se existir na página)
    const slider = document.getElementById('voices-slider');
    if (slider) {
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Speed multiplier
            slider.scrollLeft = scrollLeft - walk;
        });
    }
</script>
</body>

</html>