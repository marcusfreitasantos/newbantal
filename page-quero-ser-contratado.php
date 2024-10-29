<?php get_header(); ?>

<section class="contact__section py-5 my-5">
    <div class="container">
        <div class="contact__form_wrapper">
            <div class="row align-items-center">  
                <div class="col-md-4 p-5">
                   <h1 class="page__title_invert">Encontre a oportunidade que você precisa na Bantal</h1>
                   <?php the_content(); ?>
                </div>

                <div class="col-md-8">
                    <?= GoogleMaps(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>