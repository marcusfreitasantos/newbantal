<?php /* Template Name: Page Template 1 */ ?>

<?php get_header(); ?>

<?php 
$hero = get_field("banner");
$benefits = get_field("benefits_section"); 

?>

<section class="free__warning_section">
    <div class="row align-items-center">
        <div class="col-md-10 mb-3">
            <h2 class="free__warning_title">Você está na Bantal gratuita</h2>
            <p class="free__warning_text">Assine o Bantal Premium e mergulhe em um universo de possiblidades!</p>
        </div>

        <div class="col-md-2 d-flex justify-content-end">
            <div class="d-block w-100">
                <?= ButtonLink("#", "Assine já", "attention") ?>
            </div>
        </div>
    </div>  
</section>

<section class="hero__carousel_section">
    <div class="container h-100">
        <div class="hero__carousel">
            <div class="swiper-wrapper">

                <?php foreach($hero as $heroBanner){ ?>
    
                    <div class="swiper-slide">
                        <div class="row p-5  h-100" style="background: url('<?= $heroBanner['background_image']; ?>'); border-radius: 15px; overflow: hidden;">
                            <div class="col-md-4 d-flex flex-column justify-content-end">
                                <div class="hero__content">

                                    <?php if($heroBanner['title']){ ?>
                                        <h2 class="hero__content_title"><?= $heroBanner['title']; ?></h2>
                                    <?php } ?>

                                    <?php  if($heroBanner['subtitle']){ ?>
                                        <p class="hero__content_text"><?= $heroBanner['subtitle']; ?> </p>
                                    <?php } ?>

                                    <?php  if($heroBanner['link']){ ?>
                                        <div class="button__link_wrapper mt-5">
                                            <?= ButtonLink($heroBanner['link']['url'], $heroBanner['link']['title'], "primary", $heroBanner['link']['target']); ?>
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

<?= CompaniesLogoCarousel(); ?>

<?php if($benefits){ ?>
    <section class="benefits__section">
        <div class="container">

        <?php if($benefits["section_title"]){ ?>
            <h2 class="section__title">
                <?= $benefits["section_title"]; ?>
            </h2>
        <?php } ?>

        <?php if($benefits["benefits_list"]){ ?>
            <div class="row">
                <?php $benefitsCount = 0 ?>
                <?php foreach($benefits["benefits_list"] as $benefit){ ?>
                    <?php $benefitsCount++ ?>
                    <div class="col-md-3 mb-3">
                        <div class="benefits__card">
                            <span class="benefits__card_icon"><?= $benefitsCount; ?></span>

                            <?php if($benefit["title"]){ ?>
                                <h3 class="benefits__card_title"><?= $benefit["title"]; ?></h3>
                            <?php } ?>

                            <?php if($benefit["description"]){ ?>
                                <p class="benefits__card_text"><?= $benefit["description"]; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        </div>
    </section>
<?php } ?>

<script>
    const heroCarousel = new Swiper(".hero__carousel", {
        direction: "horizontal",
        loop: true,
        slidesPerView: 1.1,
        spaceBetween: 30,
        initialSlide: 1,
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