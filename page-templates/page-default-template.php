<?php /* Template Name: Page Default Template */ ?>

<?php get_header(); ?>

<section>
    <div class="container">
        <div class="page__content">
            <h1 class="page__title"><?php echo the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>

