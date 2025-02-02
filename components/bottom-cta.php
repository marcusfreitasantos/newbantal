<?php function BottomCTA(){ ?>
    <?php ob_start(); ?>
    <?php $childThemeDirectory = get_stylesheet_directory_uri(); ?>

    <section class="bottom__cta_section" style="background: url(<?php echo $childThemeDirectory; ?>/assets/img/bottom-cta-background.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="bottom__cta_title">Baixe o nosso app</h2>
                    <p class="bottom__cta_text">E tenha as oportunidades na palma da sua mão.</p>

                    <div class="login__form_divisor_line"></div>

                    <span class="bottom__cta_text">Baixe gratuitamente</span>

                    <div class="app__stores_btn_wrapper_row">
                        <div class="">
                            <img width="150px" height="150px" src="<?php echo $childThemeDirectory; ?>/assets/img/qr-code-app-play-store.svg" alt="qr code para o app" />
                        </div>

                        <div class="app__stores_btn_wrapper_col">
                            <div class="">
                                <a href="https://play.google.com/store/apps/details?id=com.bantal" target="_blank" class="app__stores_btn">
                                    <img src="<?php echo $childThemeDirectory; ?>/assets/img/playstore-img.png" />
                                </a>
                            </div>

                            <div>
                                <a href="#" class="app__stores_btn">
                                    <img src="<?php echo $childThemeDirectory; ?>/assets/img/appstore-img.png" />
                                </a>
                            </div>                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
    return ob_get_clean();
}