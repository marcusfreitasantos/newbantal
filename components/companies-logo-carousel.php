<?php function CompaniesLogoCarousel(){
    ob_start();
    $siteUrl = site_url();
    $companiesList = getAllCompaniesFromDatabase(15);

    

    ?>
    <section class="clients__carousel_section">
        <div class="container">
            <h2 class="section__title">Empresas que estão anunciando na Bantal</h2>
            <div class="row">
                <div class="clients__wrapper position-relative">
                    <div id="clients__carousel">
                        <div class="swiper-wrapper">
            
                            <?php foreach($companiesList as $company){
                                if($company->company_logo){ ?>
            
                                    <a class="clients__card swiper-slide" href=<?= "https://recrutamento.bantal.com.br/empresa-vagas/lista-vagas-por-empresa/$company->company_id"; ?> target="_blank">
                                        <img src="data:image/png; base64, <?= $company->company_logo; ?>" />
                                    </a>
            
                                <?php }
                            } ?>
                        </div>
            
                        <div id="clients__carousel_prev_btn" class="swiper-button-prev"></div>
                        <div id="clients__carousel_next_btn" class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
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
                    slidesPerView: 8,
                    spaceBetween: 12,
                    },
                },
            });
        </script>


    <?php return ob_get_clean(); ?>

<?php }





