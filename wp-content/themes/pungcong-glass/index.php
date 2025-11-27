<?php get_header(); ?>

<div class="container mx-auto px-4 py-24">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="mb-12">
            <h1 class="text-4xl font-bold text-slate-900 mb-6"><?php the_title(); ?></h1>
            <div class="prose max-w-none text-slate-600">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
