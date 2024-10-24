<?php 
    function ButtonLink($url, $text, $type="primary", $target = "_self", $disabled = false){ 
        ob_start(); 
        ?>
        <a href="<?php echo $url; ?>" class="<?= $type =='primary' ? 'button__link' : 'button__link_attention';  ?> <?= $disabled ? 'disabled' : ''; ?>" target="<?php echo $target;?>" >
            <?php echo $text; ?>
        </a>
        <?php
        return ob_get_clean();
    }


