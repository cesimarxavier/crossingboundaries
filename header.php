<?php

$url_theme = get_template_directory_uri();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="<?php echo $url_theme; ?>/assets/img/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php
    /**
     * O gancho wp_head() é obrigatório.
     * É aqui que o WordPress e os plugins vão injetar:
     * - A tag <title> correta da página
     * - O script do Tailwind e ícones (que configuramos no functions.php)
     * - As tags de SEO (Meta description, Open Graph, Twitter Cards)
     */
    wp_head();
    ?>
</head>

<body <?php body_class('font-sans text-neutral-600 antialiased bg-white selection:bg-durham selection:text-white'); ?>>
    <?php wp_body_open(); ?>

    <a href="#main-content" class="skip-to-content rounded-b-lg font-bold shadow-lg">Skip to main content</a>

    <header class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50 border-b border-gray-100 transition-all duration-300" id="header">
        <div class="container mx-auto px-6 h-24 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col group shrink-0">
                    <span class="font-serif font-black text-2xl text-durham leading-none tracking-tight group-hover:opacity-80 transition-opacity">
                        Crossing <br>Boundaries
                    </span>
                </a>
                <div class="hidden md:block h-10 w-px bg-gray-300"></div>
                <div class="hidden md:flex items-center gap-4 opacity-100">
                    <a href="https://www.durham.ac.uk/" target="_blank" class="md:mr-2" title="Durham University">
                        <img src="<?php echo $url_theme ?>/assets/img/logo-durham-university.svg" alt="Durham University" class="h-8 w-auto object-contain md:scale-[1]">
                    </a>
                    <a href="https://ufrj.br/" target="_blank" class="md:mr-2" title="Federal University of Rio de Janeiro">
                        <img src="<?php echo $url_theme ?>/assets/img/logo-ufrj.svg" alt="UFRJ" class="h-8 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity md:scale-[1]">
                    </a>
                    <a href="https://www.britishcouncil.org/" target="_blank" class="md:mr-2" title="British Council">
                        <img src="<?php echo $url_theme ?>/assets/img/british-council-1.svg" alt="British Council" class="h-6 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity md:scale-[1]">
                    </a>
                </div>
            </div>

            <nav class="hidden lg:flex items-center gap-8" aria-label="Main Navigation">

                <?php ModularPress_Navigation::render_desktop_menu(); ?>
                <?php ModularPress_Navigation::render_language_switcher(false); ?>

            </nav>

            <button id="mobile-menu-btn" class="lg:hidden text-neutral-900 p-2 focus:outline-none focus:ring-2 focus:ring-durham rounded-md">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 absolute top-24 left-0 w-full shadow-lg z-40 h-screen sm:h-auto">
            <nav class="flex flex-col p-6 gap-6 text-center sm:text-left">
                <div class="flex justify-center gap-6 mb-4 border-b border-gray-100 pb-4 sm:hidden">
                    <img src="<?php echo $url_theme ?>/assets/img/logo-durham-university.svg" alt="Durham" class="h-10 w-auto object-contain">
                    <img src="<?php echo $url_theme ?>/assets/img/logo-ufrj.svg" alt="UFRJ" class="h-10 w-auto object-contain opacity-80">
                    <img src="<?php echo $url_theme ?>/assets/img/british-council-1.svg" alt="UFRJ" class="h-10 w-auto object-contain opacity-80">
                </div>

                <?php

                /*** carregando do menu versão mobile */

                ModularPress_Navigation::render_mobile_menu();
                ModularPress_Navigation::render_language_switcher(true);

                ?>
            </nav>
        </div>
    </header>