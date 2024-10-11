<?php 
    function ButtonLink($url, $text, $type="primary", $target = "_self"){ 
        ob_start(); 
        ?>
        <a href="<?php echo $url; ?>" class="<?= $type =='primary' ? 'button__link' : 'button__link_attention';  ?>" target="<?php echo $target;?>" >
            <?php echo $text; ?>
        </a>
        <?php
        return ob_get_clean();
    }


