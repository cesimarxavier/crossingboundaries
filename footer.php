<div class="bg-neutral-100 border-t border-gray-200 pt-16 pb-20">
    <div class="container mx-auto px-6">
        <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-10">Organised & Funded by</p>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 opacity-70 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-durham-university.svg" alt="Durham University" title="Durham University" class="h-12 w-auto object-contain">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-ufrj.svg" alt="UFRJ" title="Federal University of Rio de Janeiro" class="h-12 w-auto object-contain">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/british-council-1.svg" alt="British Council" title="British Council" class="h-10 w-auto object-contain">
        </div>
    </div>
</div>

<footer class="bg-durham-dark border-t border-purple-900/50 pt-12 pb-8">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-12 mb-12 text-white">
            <div class="md:col-span-1">
                <span class="font-serif font-bold text-xl leading-tight block mb-4">Crossing <br>Boundaries</span>
                <p class="text-sm text-purple-200 mb-6">Connecting Durham and Brazil for a sustainable future.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-purple-200 hover:text-white transition-colors"><i class="ph ph-x-logo text-xl"></i></a>
                    <a href="#" class="text-purple-200 hover:text-white transition-colors"><i class="ph ph-linkedin-logo text-xl"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-purple-100">Quick Links</h4>
                <ul class="space-y-2 text-sm text-purple-200">
                    <li><a href="<?php echo esc_url(home_url('/the-project')); ?>" class="hover:text-white transition-colors">The Project</a></li>
                    <li><a href="<?php echo esc_url(home_url('/solutions')); ?>" class="hover:text-white transition-colors">Solutions</a></li>
                    <li><a href="<?php echo esc_url(home_url('/our-team')); ?>" class="hover:text-white transition-colors">Our Team</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-purple-100">Contact</h4>
                <ul class="space-y-3 text-sm text-purple-200">
                    <li class="flex items-start gap-3"><i class="ph ph-envelope-simple text-lg"></i> <a href="mailto:contact@crossingboundaries.ac.uk" class="hover:text-white underline">contact@crossingboundaries.ac.uk</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/25 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-purple-300 gap-4">
            <p>&copy; <?php echo date('Y'); ?> Durham University. All rights reserved.</p>
            <div class="flex gap-6"><a href="#" class="hover:text-white">Accessibility</a><a href="#" class="hover:text-white">Privacy Policy</a></div>
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