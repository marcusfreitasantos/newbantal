<?php /* Template Name: Page Template 1 */ ?>

<?php get_header(); ?>

<?php 
$siteUrl = site_url();
$hero = get_field("banner");
$benefits = get_field("benefits_section"); 

function heroBannerBgConfig($imgUrl){
    $heroBannerStyle = 
    "background-image:
    linear-gradient(-145deg, rgba(245, 246, 252, 0), rgba(0, 0, 0, 0.3)),
    url('$imgUrl');
    border-radius: 15px; 
    overflow: hidden;";


    return $heroBannerStyle;
};

$agoraNaBantalIcon = "<svg aria-hidden='true' class='btn__bantal_now' xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 21 14' fill='#f0903a'><path fill-rule='evenodd' clip-rule='evenodd' d='M3.19242 0.366828C3.5605 -0.000526622 4.15783 0.064257 4.48445 0.468919C4.80836 0.870219 4.74254 1.45406 4.38662 1.82727C3.10305 3.17321 2.31494 4.99584 2.31494 7.00255C2.31494 9.0234 3.11419 10.8576 4.41382 12.2062C4.77295 12.5789 4.84074 13.1652 4.51567 13.5679C4.19032 13.971 3.59589 14.037 3.22734 13.6729C1.50641 11.9732 0.439941 9.61244 0.439941 7.00255C0.439941 4.41036 1.492 2.06389 3.19242 0.366828ZM5.7961 2.8195C6.14517 2.43223 6.74678 2.49745 7.07425 2.90315C7.39749 3.30363 7.32813 3.88475 7.00857 4.28818C6.41774 5.03407 6.06494 5.97711 6.06494 7.00255C6.06494 8.04102 6.42675 8.99498 7.0312 9.74526C7.3559 10.1483 7.42857 10.7334 7.1035 11.1361C6.77815 11.5392 6.18128 11.6062 5.83127 11.2243C4.81198 10.1122 4.18994 8.63001 4.18994 7.00255C4.18994 5.39389 4.79769 3.92718 5.7961 2.8195ZM13.8056 2.90315C13.4824 3.30363 13.5518 3.88475 13.8713 4.28817C14.4621 5.03407 14.8149 5.97711 14.8149 7.00255C14.8149 8.04102 14.4531 8.99498 13.8487 9.74526C13.524 10.1483 13.4513 10.7334 13.7764 11.1361C14.1017 11.5392 14.6986 11.6062 15.0486 11.2243C16.0679 10.1122 16.6899 8.63001 16.6899 7.00255C16.6899 5.39389 16.0822 3.92718 15.0838 2.8195C14.7347 2.43223 14.1331 2.49745 13.8056 2.90315ZM16.3954 0.468919C16.0715 0.870219 16.1373 1.45406 16.4933 1.82727C17.7768 3.17321 18.5649 4.99584 18.5649 7.00255C18.5649 9.0234 17.7657 10.8576 16.4661 12.2062C16.1069 12.5789 16.0391 13.1652 16.3642 13.5679C16.6896 13.971 17.284 14.037 17.6525 13.6729C19.3735 11.9732 20.4399 9.61244 20.4399 7.00255C20.4399 4.41036 19.3879 2.06389 17.6875 0.366828C17.3194 -0.000526547 16.7221 0.0642572 16.3954 0.468919ZM10.4399 9.50256C11.8207 9.50256 12.9399 8.38327 12.9399 7.00256C12.9399 5.62184 11.8207 4.50256 10.4399 4.50256C9.05923 4.50256 7.93994 5.62184 7.93994 7.00256C7.93994 8.38327 9.05923 9.50256 10.4399 9.50256Z'></path></svg>";

?>

<section class="free__warning_section">
    <div class="row align-items-center">
        <div class="col-md-10 mb-3">
            <h2 class="free__warning_title">Você está na Bantal gratuita</h2>
            <p class="free__warning_text">Assine o Bantal Premium e mergulhe em um universo de possibilidades!</p>
        </div>

        <div class="col-md-2 d-flex justify-content-end">
            <div class="d-block w-100 btn__bantal_sign_now">
                <?= ButtonLink("$siteUrl/planos", "Assine já", "attention") ?>
            </div>
        </div>
    </div>  
</section>

<section class="hero__carousel_section">
    <div class="hero__carousel_container">
        <div class="hero__carousel">
            <div class="swiper-wrapper">

                <?php foreach($hero as $heroBanner){ ?>
    
                    <div class="swiper-slide">
                        <div class="row p-5  h-100" style="<?= heroBannerBgConfig($heroBanner['background_image']); ?> ">
                            <div class="col-md-4 d-flex flex-column justify-content-end">
                                <div class="hero__content">

                                    <?php if($heroBanner['title']){ ?>
                                        <h2 class="hero__content_title"><?= $heroBanner['title']; ?> <?= str_contains(strtolower($heroBanner['title']), "agora na bantal") ? $agoraNaBantalIcon : ''; ?>  </h2>
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
            <div id="hero__carousel_prev_btn" class="swiper-button-prev"></div>
            <div id="hero__carousel_next_btn" class="swiper-button-next"></div>


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
        slidesPerView: 1,
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