<?php get_header(); ?>
<?php $companiesList = getAllCompaniesFromDatabase(100); ?>

<section class="py-5 my-5">
    <div class="container">
        <h1 class="section__title mb-5">Empresas que estão anunciando na Bantal</h1>

        <div class="row">
            <?php foreach($companiesList as $company){
                if($company->photo){ ?>
                    <div class="col-md-2 mb-5">
                        <a class="clients__card" href=<?= "https://recrutamento.bantal.com.br/empresa-vagas/lista-vagas-por-empresa/$company->user_id"; ?> target="_blank">
                            <img src="data:image/png; base64, <?= $company->photo; ?>" />
                        </a>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>