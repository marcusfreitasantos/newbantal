<?php function CompaniesLogoCarousel(){
    ob_start();
    $childThemeDirectory = get_stylesheet_directory_uri();
    ?>

        <div class="clients__wrapper position-relative">
            <div id="clients__carousel">
                <div class="swiper-wrapper">
                    <a class="clients__card swiper-slide" href="" target="_blank">
                        <img src="<?= $childThemeDirectory; ?>/assets/img/favicon.png" />
                    </a>
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




