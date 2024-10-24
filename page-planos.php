<?php get_header();?>
<?php
$bannerBg = get_field("banner_background");
?>

<style>
    .bantal__plans_section{
        padding: 200px 0;
        background: url(<?= $bannerBg; ?>) center center;
        background-size: cover;
        background-repeat: no-repeat;
        text-align: center;
    }
</style>


<section class="bantal__plans_section">
    <div class="container">
        <div class="row">
            <div class="col-12 bantal__plans_title_wrapper">
                <h1 class="bantal__plans_title"><?= the_field('title'); ?></h1>
                <h2 class="bantal__plans_subtitle"><?= the_field('subtitle'); ?></h2>
            </div>
        </div>
    </div>
</section>

<section class="bantal__plans_section_cards">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>

            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>

            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>

            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>

            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>

            <div class="col-md-2">
                <?= BantalPlanCard(); ?>
            </div>    
        </div>
    </div>
</section>
<?php get_footer();?>