<?php 
    function ButtonLink($url, $text, $target = "_self"){ 
        ob_start(); 
        ?>
        <a href="<?php echo $url; ?>" class="d-flex flex-row align-items-center post__card_btn mt-3" target="<?php echo $target;?>" >
            <span><?php echo $text; ?></span>
            <i class="fa-solid fa-arrow-right-long"></i>
        </a>
        <?php
        return ob_get_clean();
    }


