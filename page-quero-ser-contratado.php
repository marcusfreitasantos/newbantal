<?php get_header(); ?>

<section class="contact__section py-5 my-5">
    <div class="container">
        <div class="contact__form_wrapper">
            <div class="row align-items-center">  
                <div class="col-md-4 p-5">
                   <h1 class="page__title_invert">Encontre a oportunidade que você precisa na Bantal</h1>

                   <form class="row gap-3 custom__map_form">
                        <input id="map__input_address" class="col-12" type="text" value="" placeholder="Endereço, bairro, cidade" />
                        <input id="map__input_service" class="col-12" type="text" value="" placeholder="Profissional ou serviço" />
                        <input id="map__input_field" class="col-12" type="text" value="" placeholder="Área de atuação" />
                        <?= ButtonLink("#", "Pesquisar", "submit"); ?>
                   </form>
                </div>

                <div class="col-md-8">
                    <?= GoogleMaps(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>