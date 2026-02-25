<?php

/**
 * Módulo de Consultas (Queries) do ModularPress
 * Gerencia a lógica de extração de dados do banco.
 */
class ModularPress_Queries
{

    /**
     * Busca os posts mais recentes.
     * * @param int $count Quantidade de posts para retornar.
     * @return WP_Query
     */
    public static function get_latest_updates($count = 3)
    {
        return new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => $count,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ]);
    }

    /**
     * Retorna as classes Tailwind de cor para as tags (badges) baseadas no slug da categoria.
     */
    public static function get_category_badge_classes($cat_slug)
    {
        if (in_array($cat_slug, ['event', 'evento', 'events'])) {
            return 'bg-purple-100 text-purple-800';
        } elseif (in_array($cat_slug, ['publication', 'publicacao', 'publicacoes'])) {
            return 'bg-blue-100 text-blue-800';
        } elseif (in_array($cat_slug, ['news', 'noticia', 'noticias'])) {
            return 'bg-green-100 text-green-800';
        }

        return 'bg-gray-100 text-gray-800'; // Default fallback
    }
}
