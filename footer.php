<footer class="bg-durham-dark border-t border-purple-900/50 pt-16 pb-8 mt-auto">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-12 mb-12 text-white">
            <div class="md:col-span-2">
                <span class="font-serif font-bold text-2xl leading-tight block mb-4">Crossing Boundaries</span>
                <p class="text-sm text-purple-200 mb-6 max-w-sm">Conectando Durham e Brasil para preparar cientistas globais e criar soluções sustentáveis.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-purple-100">Contato</h4>
                <ul class="space-y-3 text-sm text-purple-200">
                    <li class="flex items-start gap-3"><i class="ph ph-envelope-simple text-lg"></i> contact@crossingboundaries.ac.uk</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-purple-900/50 pt-8 text-center text-xs text-purple-300">
            <p>&copy; <?php echo date('Y'); ?> Durham University. Todos os direitos reservados. Fomentado pelo British Council.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); /* Gancho vital do WordPress para scripts no rodapé */ ?>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu'); // Assumindo que você colocará a div do menu mobile no header.php
    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }
</script>
</body>

</html>