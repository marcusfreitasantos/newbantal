<?php function CompaniesLogoCarousel(){
    ob_start();
    $siteUrl = site_url();
    $companiesList = getAllCompaniesFromDatabase(20);
    ?>
    <section class="clients__carousel_section">
            <h2 class="section__title">Empresas que estão anunciando na Bantal</h2>
            <div class="row">
                <div class="clients__wrapper position-relative">
                    <div id="clients__carousel">
                        <div class="swiper-wrapper">
            
                            <?php foreach($companiesList as $company){
                                if($company->photo){ ?>
            
                                    <a class="clients__card swiper-slide" href=<?= "https://recrutamento.bantal.com.br/empresa-vagas/lista-vagas-por-empresa/$company->user_id"; ?> target="_blank">
                                        <img src="data:image/png; base64, <?= $company->photo; ?>" />
                                    </a>
            
                                <?php }
                            } ?>
                        </div>
            
                        <div id="clients__carousel_prev_btn" class="swiper-button-prev"></div>
                        <div id="clients__carousel_next_btn" class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

            <div class="button__link_wrapper mt-2 col-md-2">
                <?= ButtonLink("$siteUrl/empresas", "Ver todas") ?>
            </div>
    </section>

    
        <script>
            const clientsCarousel = new Swiper("#clients__carousel", {
                direction: "horizontal",
                loop: true,
                slidesPerView: 2,
                spaceBetween: 12,
                autoplay: {
                    delay: 3000,
                },
                navigation: {
                    nextEl: "#clients__carousel_next_btn",
                    prevEl: "#clients__carousel_prev_btn",
                },
                breakpoints: {
                    1024: {
                    slidesPerView: 10,
                    spaceBetween: 12,
                    },
                },
            });
        </script>


    <?php return ob_get_clean(); ?>

<?php }





