<?php get_header(); ?>

<section class="">
    <div class="custom__map_container">
            <div class="row">  
                <div class="col-md-4 p-5">
                   <h1 class="page__title">Qual empresa ou profissional deseja falar? Dê o play no ChatBan!</h1>

                   <form class="row gap-4 custom__map_form">
                        <div class="input__wrapper col-12">
                            <input id="map__input_address" class="" type="text" value="" placeholder="Qual o local? Informe bairro, cidade ou endereço." />
                        </div>

                        <div class="input__wrapper col-12">
                            <input id="map__input_services" class="" type="text" value="" placeholder="Qual a empresa, serviço ou profissional?" />
                        </div>

                        <div class="input__wrapper col-12">
                            <input id="map__input_field" class="col-12" type="text" value="" placeholder="Qual a área de atuação ou segmento?" />
                        </div>


                        <div class="col-md-6">
                            <?= ButtonLink("#", "Localizar", "submit"); ?>
                        </div>
                   </form>

                   <div class="filtered__users_wrapper"></div>
                </div>

                <div class="col-md-8">
                    <?= GoogleMaps(); ?>
                </div>
            </div>
    </div>
</section>

<?php get_footer(); ?>