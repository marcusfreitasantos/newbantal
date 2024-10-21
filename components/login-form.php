<?php function LoginForm(){
    ob_start();  

    ?>
        <div class="login__form_wrapper">
            <div class="login__form_content">
                <span class="login__form_content_title">Já tem uma conta Bantal?</span>
                <p class="login__form_content_text">Entre com sua conta e conheça os melhores planos para você.</p>

                <div class="d-flex w-100">
                    <?= ButtonLink("https://recrutamento.bantal.com.br/recrutamento", "Entrar"); ?>
                </div>

                <div class="login__form_content_divisor">
                    <div class="login__form_divisor_line"></div>
                    <span>ou</span>
                    <div class="login__form_divisor_line"></div>
                </div>

                <p class="login__form_content_title">Ainda não tem cadastro?</p>
                
                <div class="d-flex w-100">
                    <?= ButtonLink("https://recrutamento.bantal.com.br/cadastro", "Cadastrar"); ?>
                </div>
            </div>            
        </div>
    <?php

    return ob_get_clean();
}
