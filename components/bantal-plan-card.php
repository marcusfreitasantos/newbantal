<?php
function BantalPlanCard(){
     ob_start(); 

     ?>
        <div class="bantal__plans_card">
            <img src="https://newbantal.mafreitas.com.br/wp-content/uploads/2024/10/bantal-play.svg" alt="plan-logo" />
            <span class="bantal__plans_price">R$0,00</span>
            <span class="bantal__plans_period">Gratuito</span>
            <?= ButtonLink('/', 'Escolher', 'secondary', 'blank'); ?>

            <div class="bantal__plans_card_details_btn">
                <span>Ver detalhes</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
     <?php
     return ob_get_clean();
}