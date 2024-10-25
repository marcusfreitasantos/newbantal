<?php
function BantalPlanCard($planObj){
    $productImg = get_field('product_img', $planObj->ID);
    $price = get_field('price', $planObj->ID);
    $period = get_field('period', $planObj->ID);
    $splits = get_field('splits', $planObj->ID);
    $legalText = get_field('legal_text', $planObj->ID);
    $paymentUrl = get_field('payment_url', $planObj->ID);
    $resources = get_field('resources', $planObj->ID);
    ob_start(); 

    ?>
        <div class="bantal__plans_card">
            <img src="<?= $productImg['url']; ?>" alt="plan-logo" />
            <div class="bantal__plans_card_info">
                <span class="bantal__plans_price">R$<?= $price; ?></span>
                <span class="bantal__plans_period"><?= $period; ?></span>
                <span class="bantal__plans_period"><?= $splits; ?></span>
                <?= ButtonLink($paymentUrl, 'Escolher', 'secondary', 'blank'); ?>
            </div>

            <span class="bantal__plans_legal_txt"><?= $legalText; ?></span>

            <div class="bantal__plans_card_details_btn more__details">
                <span>Ver detalhes</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="bantal__plans_card_resources">
                <h4 class="bantal__plans_card_resources_title">Recursos</h4>

                <?php foreach($resources as $resource){ ?>
                    <div class="bantal__plans_card_resource_item">
                        <i class="fa-solid fa-check"></i>
                        <span><?= $resource['resource']; ?></span>
                    </div>
                <?php } ?> 

                <div class="bantal__plans_card_details_btn less__details">
                    <i class="fa-solid fa-chevron-up"></i>
                    <span>Menos detalhes</span>
                </div>
            </div>
        </div>
    <?php
    return ob_get_clean();
}