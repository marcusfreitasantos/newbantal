<?php /* Template Name: Page Template 1 */ ?>

<?php get_header(); ?>
<?php $hero = get_field("banner"); ?>

<section class="hero__carousel_section">
    <div class="container h-100">
        <div class="hero__carousel">
            <div class="swiper-wrapper">

                <?php foreach($hero as $heroBanner){ ?>
    
                    <div class="swiper-slide">
                        <div class="row p-5  h-100" style="background: url('<?= $heroBanner['background_image']; ?>')">
                            <div class="col-md-4 d-flex flex-column justify-content-end">
                                <div class="hero__content">

                                    <?php if($heroBanner['title']){ ?>
                                        <h2 class="hero__content_title"><?= $heroBanner['title']; ?></h2>
                                    <?php } ?>

                                    <?php  if($heroBanner['subtitle']){ ?>
                                        <p class="hero__content_text"><?= $heroBanner['subtitle']; ?> </p>
                                    <?php } ?>

                                    <?php  if($heroBanner['link']){ ?>
                                        <div class="mt-5 d-flex">
                                            <?php echo ButtonLink($heroBanner['link']['url'], $heroBanner['link']['title'], $heroBanner['link']['target']); ?>
                                        </div>
                                    <?php } ?>

        
                                </div>
                            </div>
        
                            <div class="col-md-8">
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
            </div>


            <div class="swiper-pagination"></div>

        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <?php echo CompaniesLogoCarousel(); ?>
        </div>
    </div>
</section>

<script>
    const heroCarousel = new Swiper(".hero__carousel", {
        direction: "horizontal",
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 6000,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function (index, className) {
            return '<span class="' + className + '">'  + "</span>";
            },
        },
        navigation: {
            nextEl: "#hero__carousel_next_btn",
            prevEl: "#hero__carousel_prev_btn",
        },
    });

</script>
<?php get_footer(); ?>