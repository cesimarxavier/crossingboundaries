<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?> Crossing Boundaries</title>

    <meta name="description"
        content="An innovative collaboration between Durham University and UFRJ. Students united to solve global SDG challenges through science and intercultural dialogue.">
    <meta name="keywords"
        content="COIL, UFRJ, Durham University, SDGs, Sustainability, Chemistry, Intercultural Education, Science, Brazil, UK">
    <meta name="author" content="Durham University & UFRJ">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.crossingboundaries.ac.uk/en">
    <meta property="og:title" content="Crossing Boundaries | Science Beyond Borders">
    <meta property="og:description"
        content="Discover how students from Brazil and the UK are bridging chemistry and culture to solve real-world UN challenges.">
    <meta property="og:image" content="https://www.crossingboundaries.ac.uk/assets/social-share-en.jpg">
    <meta property="og:locale" content="en_GB">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.crossingboundaries.ac.uk/en">
    <meta property="twitter:title" content="Crossing Boundaries | Durham & UFRJ">
    <meta property="twitter:description"
        content="A transatlantic collaboration focused on scientific innovation and intercultural dialogue.">
    <meta property="twitter:image" content="https://www.crossingboundaries.ac.uk/assets/social-share-en.jpg">

    <link rel="icon" type="image/png" href="assets/img/favicon.png">

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=FN129iTWt9DpGIWOEP3rUgmk8VQ7-FhIACLRuY_Dpi2clcsxLmvanEm20-ECYe4MCvGEGwl6nY4CWmf9qPzMs4CrBfPEiPx8SwtuIlGsgfs" charset="UTF-8"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        durham: {
                            DEFAULT: '#68246D',
                            dark: '#4E1A52',
                            light: '#8A3E8F'
                        },
                        neutral: {
                            50: '#F8F9FA',
                            900: '#1A1A1A',
                            600: '#4B5563'
                        },
                        ods: {
                            15: '#56C02B'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>

    <?php wp_head(); ?>
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
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-durham-university.svg" alt="Durham University" class="h-8 w-auto object-contain md:scale-[1]">
                    </a>
                    <a href="https://ufrj.br/" target="_blank" class="md:mr-2" title="Federal University of Rio de Janeiro">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-ufrj.svg" alt="UFRJ" class="h-8 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity md:scale-[1]">
                    </a>
                    <a href="https://www.britishcouncil.org/" target="_blank" class="md:mr-2" title="British Council">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/british-council-1.svg" alt="British Council" class="h-6 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity md:scale-[1]">
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
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-durham-university.svg" alt="Durham" class="h-10 w-auto object-contain">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-ufrj.svg" alt="UFRJ" class="h-10 w-auto object-contain opacity-80">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/british-council-1.svg" alt="UFRJ" class="h-10 w-auto object-contain opacity-80">
                </div>

                <?php

                /*** carregando do menu versão mobile */

                ModularPress_Navigation::render_mobile_menu();
                ModularPress_Navigation::render_language_switcher(true);

                ?>
            </nav>
        </div>
    </header>