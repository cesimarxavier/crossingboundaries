<?php get_header(); ?>

<main class="flex-grow flex items-center justify-center pt-32 pb-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#68246D_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="container mx-auto px-6 relative z-10 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-sm mb-8 border border-gray-100">
            <i class="ph-duotone ph-compass text-5xl text-durham"></i>
        </div>

        <h1 class="font-serif font-black text-6xl md:text-8xl text-neutral-900 mb-4 tracking-tight">404</h1>
        <h2 class="font-serif font-bold text-2xl md:text-3xl text-neutral-800 mb-6">Página Não Encontrada</h2>

        <p class="text-lg text-gray-600 max-w-xl mx-auto mb-10 leading-relaxed">
            Parece que você entrou em território não mapeado. A página que você procura pode ter sido movida, excluída ou talvez nunca tenha existido.
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="px-6 py-2.5 bg-durham text-white font-bold rounded-lg hover:bg-durham-dark transition-colors shadow-md">
                Voltar para a Home
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>