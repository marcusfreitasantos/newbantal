<?php

function generalOptionsMenu() {
    add_menu_page(
        'Theme general options', 
        'General Options',
        'manage_options', 
        'theme-general-options-page', 
        'generalOptionsPage',  
        'dashicons-admin-settings', 
        100                       
    );
}
add_action('admin_menu', 'generalOptionsMenu');


function generalOptionsPage(){
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    if (isset($_POST['whatsapp_custom_btn_number']) || isset($_POST['whatsapp_custom_btn_msg'])) {
        update_option('whatsapp_custom_btn_number', sanitize_text_field($_POST['whatsapp_custom_btn_number']));
        update_option('whatsapp_custom_btn_msg', sanitize_text_field($_POST['whatsapp_custom_btn_msg']));
        echo '<div class="updated"><p>Options saved!</p></div>';
    }

    if(isset($_POST['update_users'])){
        do_action("getUsersFromApiHook");
        echo '<div class="updated"><p>Users updated!</p></div>';
    }

    $whatsappCustomBtnNumber = get_option('whatsapp_custom_btn_number', '');
    $whatsappCustomBtnMsg = get_option('whatsapp_custom_btn_msg', '');

    ?>
    <div class="wrap">
        <h1>Opções gerais do tema</h1>
        
        <h2>Configurar Whatsapp</h2>
        <form method="post" action="">
            <?php wp_nonce_field('whatsapp_custom_btn_number_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Whatsapp Number (Only numbers, no spaces or "-")</th>
                    <td><input type="text" name="whatsapp_custom_btn_number" value="<?php echo esc_attr($whatsappCustomBtnNumber); ?>" /></td>
                </tr>
   

                <tr valign="top">
                    <th scope="row">Whatsapp Default Message</th>
                    <td><input type="text" name="whatsapp_custom_btn_msg" value="<?php echo esc_attr($whatsappCustomBtnMsg); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>

        <h2>Atualizar base de usuários</h2>
        <form method="post">
            <?php submit_button("Atualizar", "primary", "update_users"); ?>
        </form>
    </div>
    <?php
}



function renderWhatsappButton(){
    $whatsappCustomBtnNumber = get_option('whatsapp_custom_btn_number', '');
    $whatsappCustomBtnMsg = get_option('whatsapp_custom_btn_msg', '');
    $whatsappCustomLink = "https://api.whatsapp.com/send?phone=$whatsappCustomBtnNumber&text=$whatsappCustomBtnMsg";
    $btnSize = "60px";

    if($whatsappCustomBtnNumber){ ?>
        <style>
            .whatsapp__custom_btn{
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: <?php echo $btnSize; ?>;
                height: <?php echo $btnSize; ?>;
                border-radius: 50%;
                background-color: black;
                font-size: 4rem;
                transition: 0.5s;
                text-decoration: none;
                z-index: 5;
            }

            .whatsapp__custom_btn:hover{
                opacity: 0.5;
            }

            .whatsapp__custom_btn i{
                color: white;
            }
        </style>

        <a class="whatsapp__custom_btn" href="<?php echo $whatsappCustomLink; ?>" target="_blank">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    <?php }
}