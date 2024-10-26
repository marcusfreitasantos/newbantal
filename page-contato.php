<?php get_header(); ?>
<?php $childThemeDirectory = get_stylesheet_directory_uri(); ?>


<section class="contact__section py-5 my-5">
    <div class="container">

        <div class="contact__form_wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="<?= $childThemeDirectory;?>/assets/img/contact-img.jpg" />
                </div>
    
                <div class="col-md-6 p-5">
                   <h1 class="page__title_invert"><?php echo the_title(); ?></h1>
                   <?php echo do_shortcode('[contact-form-7 id="cf9d0f3" title="Formulário de contato 1"]'); ?>
                </div>
    
            </div>
        </div>
    </div>

</section>

<?php get_footer(); ?>