<?php function CompaniesLogoCarousel(){
    ob_start();
    $siteUrl = site_url();

    $companiesList = getAllCompaniesFromDatabase(15);

    ?>

        <div class="clients__wrapper position-relative">
            <div id="clients__carousel">
                <div class="swiper-wrapper">

                <?php foreach($companiesList as $company){
                    if($company->company_logo){ ?>

                        <a class="clients__card swiper-slide" href=<?= "$siteUrl/empresa/$company->company_id"; ?> target="_blank">
                            <img src="data:image/png; base64, <?= $company->company_logo; ?>" />
                        </a>

                    <?php }
                } ?>
                </div>
    
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    
        <script>
            const swiper = new Swiper("#clients__carousel", {
                direction: "horizontal",
                loop: true,
                slidesPerView: 8,
                spaceBetween: 12,
                autoplay: {
                    delay: 3000,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    1024: {
                    slidesPerView: 8,
                    spaceBetween: 12,
                    },
                },
            });
        </script>


    <?php return ob_get_clean(); ?>

<?php } ?>




