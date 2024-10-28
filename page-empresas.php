<?php get_header(); ?>
<?php $companiesList = getAllCompaniesFromDatabase(); ?>

<section class="py-5 my-5">
    <div class="container">
        <h1 class="section__title pb-5">Empresas que estão anunciando na Bantal</h1>

        <div class="row">
            <?php foreach($companiesList as $company){
                if($company->company_logo){ ?>
                    <div class="col-md-2 mb-5">
                        <a class="clients__card" href=<?= "https://recrutamento.bantal.com.br/empresa-vagas/lista-vagas-por-empresa/$company->company_id"; ?> target="_blank">
                            <img src="data:image/png; base64, <?= $company->company_logo; ?>" />
                        </a>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>