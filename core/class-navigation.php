<?php

/**
 * Módulo de Navegação e Idiomas do ModularPress
 */
class ModularPress_Navigation
{

    public function __construct()
    {
        // Registra a posição do menu no painel do WordPress (Aparência > Menus)
        add_action('init', [$this, 'register_menus']);
    }

    public function register_menus()
    {
        register_nav_menus([
            'primary' => __('Menu Principal', 'crossingboundaries')
        ]);
    }

    /**
     * Renderiza o Menu Desktop com classes do Tailwind
     */
    public static function render_desktop_menu()
    {
        $menu_items = self::get_menu_items('primary');

        if (!$menu_items) return;

        foreach ($menu_items as $item) {
            // Verifica se é a página atual para destacar (Active State)
            $is_active = ($item->object_id == get_queried_object_id()) ? 'text-durham underline' : 'text-neutral-900 hover:text-durham hover:underline';

            echo '<a href="' . esc_url($item->url) . '" class="text-sm font-medium uppercase ' . $is_active . ' decoration-2 underline-offset-4 transition-all">';
            echo esc_html($item->title);
            echo '</a>';
        }
    }

    /**
     * Renderiza o Menu Mobile com classes do Tailwind
     */
    public static function render_mobile_menu()
    {
        $menu_items = self::get_menu_items('primary');

        if (!$menu_items) return;

        foreach ($menu_items as $item) {
            $is_active = ($item->object_id == get_queried_object_id()) ? 'text-durham font-bold' : 'text-neutral-900 hover:text-durham font-medium';

            echo '<a href="' . esc_url($item->url) . '" class="text-lg ' . $is_active . '">';
            echo esc_html($item->title);
            echo '</a>';
        }
    }

    /**
     * Renderiza o Seletor de Idiomas (Preparado para Polylang)
     */
    public static function render_language_switcher($is_mobile = false)
    {
        // Se o Polylang estiver ativo, puxa dinamicamente
        if (function_exists('pll_the_languages')) {
            $languages = pll_the_languages(['raw' => 1]);

            // Layout Desktop
            if (!$is_mobile) {
                echo '<div class="ml-4 flex items-center gap-2 text-sm border-l border-gray-300 pl-6">';
                $count = 0;
                foreach ($languages as $lang) {
                    if ($count > 0) echo '<span class="text-gray-300">/</span>';

                    if ($lang['current_lang']) {
                        echo '<span class="font-bold text-durham uppercase">' . esc_html($lang['slug']) . '</span>';
                    } else {
                        echo '<a href="' . esc_url($lang['url']) . '" class="text-gray-400 hover:text-neutral-900 transition-colors uppercase">' . esc_html($lang['slug']) . '</a>';
                    }
                    $count++;
                }
                echo '</div>';
            }
            // Layout Mobile
            else {
                echo '<div class="flex justify-center sm:justify-start gap-4 pt-4 border-t border-gray-100">';
                foreach ($languages as $lang) {
                    if ($lang['current_lang']) {
                        echo '<span class="font-bold text-durham uppercase">' . esc_html($lang['slug']) . '</span>';
                    } else {
                        echo '<a href="' . esc_url($lang['url']) . '" class="text-gray-400 uppercase">' . esc_html($lang['slug']) . '</a>';
                    }
                }
                echo '</div>';
            }
        } else {
            // Fallback Estático se o Polylang não estiver instalado ainda
            if (!$is_mobile) {
                echo '<div class="ml-4 flex items-center gap-2 text-sm border-l border-gray-300 pl-6"><span class="font-bold text-durham">EN</span><span class="text-gray-300">/</span><a href="#" class="text-gray-400 hover:text-neutral-900 transition-colors">PT</a></div>';
            } else {
                echo '<div class="flex justify-center sm:justify-start gap-4 pt-4 border-t border-gray-100"><span class="font-bold text-durham">EN</span><a href="#" class="text-gray-400">PT</a></div>';
            }
        }
    }

    /**
     * Função Helper para buscar itens do menu
     */
    private static function get_menu_items($location)
    {
        $locations = get_nav_menu_locations();
        if (!isset($locations[$location])) return false;

        $menu = wp_get_nav_menu_object($locations[$location]);
        return wp_get_nav_menu_items($menu->term_id);
    }
}
new ModularPress_Navigation();
