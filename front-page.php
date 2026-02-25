<?php get_header(); ?>

<main>
    <section class="relative h-screen flex items-center justify-center overflow-hidden bg-neutral-900">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-durham-dark/90 via-durham-dark/50 to-transparent"></div>
        </div>
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto mt-20">
            <h1 class="font-serif font-black text-5xl md:text-7xl lg:text-8xl text-white mb-6 tracking-tight drop-shadow-lg">Crossing Boundaries</h1>
            <p class="text-xl md:text-2xl text-purple-100 font-light mb-10 max-w-2xl mx-auto">Construindo conhecimento intercultural entre Durham e Rio de Janeiro.</p>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10">
            <a href="#about" class="animate-bounce inline-flex items-center justify-center w-12 h-12 rounded-full border border-white/30 text-white hover:bg-white hover:text-durham transition-all">
                <i class="ph-bold ph-arrow-down text-xl"></i>
            </a>
        </div>
    </section>

    <section id="context" class="py-24 bg-neutral-50 border-t border-gray-100 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="lg:w-1/2">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-8 h-1 bg-durham rounded-full"></span>
                        <span class="text-durham font-bold tracking-wider text-sm uppercase">TNE Outcomes</span>
                    </div>
                    <h2 class="font-serif font-bold text-4xl lg:text-5xl text-neutral-900 mb-6 leading-tight">Contexto e <br>Motivação</h2>
                    <div class="prose prose-lg text-gray-600 leading-relaxed text-justify mb-8">
                        <p>A complexidade dos desafios contemporâneos exige uma reformulação na forma como os novos cientistas são treinados.</p>
                    </div>
                </div>
                <div class="lg:w-1/2 flex flex-col gap-5 w-full">
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>