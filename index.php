<?php
get_header(); ?>

<main class="pt-32 pb-24 flex-grow container mx-auto px-6">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h1 class="font-serif font-bold text-4xl mb-8"><?php the_title(); ?></h1>
            <div class="prose prose-lg max-w-none text-gray-600">
                <?php the_content(); ?>
            </div>
    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>