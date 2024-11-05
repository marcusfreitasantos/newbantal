<?php get_header(); ?>

<section class="">
    <div class="custom__map_container">
            <div class="row">  
                <div class="col-md-4 p-5">
                   <h1 class="page__title">Qual empresa ou profissional deseja falar? <br>Dê o play no ChatBan!</h1>

                   <form class="row gap-4 custom__map_form">
                        <input id="map__input_address" class="col-12" type="text" value="" placeholder="Endereço, bairro, cidade" />
                        <input id="map__input_services" class="col-12" type="text" value="" placeholder="Profissional ou serviço" />
                        <input id="map__input_field" class="col-12" type="text" value="" placeholder="Área de atuação" />
                        <div class="col-md-6">
                            <?= ButtonLink("#", "Pesquisar", "submit"); ?>
                        </div>
                   </form>
                </div>

                <div class="col-md-8">
                    <?= GoogleMaps(); ?>
                </div>
            </div>
    </div>
</section>

<?php get_footer(); ?>