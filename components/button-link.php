<?php 
    function ButtonLink($url, $text, $target = "_self"){ 
        ob_start(); 
        ?>
        <a href="<?php echo $url; ?>" class="button__link" target="<?php echo $target;?>" >
            <span><?php echo $text; ?></span>
        </a>
        <?php
        return ob_get_clean();
    }


