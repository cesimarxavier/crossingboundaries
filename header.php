<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); /* Gancho vital do WordPress */ ?>
</head>

<body <?php body_class('font-sans text-neutral-600 antialiased bg-white selection:bg-durham selection:text-white flex flex-col min-h-screen'); ?>>
    <?php wp_body_open(); ?>

    <header class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50 border-b border-gray-100 transition-all duration-300" id="header">
        <div class="container mx-auto px-6 h-24 flex items-center justify-between">
            <div class="flex items-center gap-4 md:gap-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col group shrink-0">
                    <span class="font-serif font-black text-xl md:text-2xl text-durham leading-none tracking-tight group-hover:opacity-80 transition-opacity">
                        Crossing <br>Boundaries
                    </span>
                </a>
                <div class="hidden lg:block h-10 w-px bg-gray-300"></div>
                <div class="hidden lg:flex items-center gap-4 opacity-100">
                    <a href="https://www.britishcouncil.org/" target="_blank" title="British Council">
                        <img src="https://placehold.co/120x40/white/000000?text=British+Council&font=roboto" alt="British Council" class="h-8 w-auto object-contain">
                    </a>
                    <div class="h-6 w-px bg-gray-200 mx-1"></div>
                    <a href="https://www.durham.ac.uk/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-durham-university.svg" class="h-10 w-auto object-contain">
                    </a>
                    <a href="https://ufrj.br/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-ufrj.svg" class="h-10 w-auto object-contain opacity-80">
                    </a>
                </div>
            </div>

            <nav class="hidden xl:flex items-center gap-6">
                <a href="<?php echo esc_url(home_url('/o-projeto')); ?>" class="text-sm font-medium uppercase text-neutral-900 hover:text-durham transition-all">O Projeto</a>
                <a href="<?php echo esc_url(home_url('/solucoes')); ?>" class="text-sm font-medium uppercase text-neutral-900 hover:text-durham transition-all">Soluções</a>
                <a href="<?php echo esc_url(home_url('/nossa-equipe')); ?>" class="text-sm font-medium uppercase text-neutral-900 hover:text-durham transition-all">Equipe</a>
                <div class="ml-2 flex items-center gap-2 text-sm border-l border-gray-300 pl-4">
                    <span class="font-bold text-durham">PT</span><span class="text-gray-300">/</span><a href="#" class="text-gray-400">EN</a>
                </div>
            </nav>
            <button id="mobile-menu-btn" class="xl:hidden text-neutral-900 p-2"><i class="ph ph-list text-2xl"></i></button>
        </div>
    </header>