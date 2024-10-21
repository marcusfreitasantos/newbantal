<?php function PostCard($post){
    ob_start();  
    $categories = wp_get_post_categories($post->ID, array("fields" => "all"));
    ?>

    <a class="post__card"  href="<?php echo get_permalink($post->ID); ?>" >
        <?php echo  get_the_post_thumbnail($post->ID, "full"); ?>

        <span class="post__card_title"><?php echo $post->post_title; ?></span>
        
        <p class="post__card_text"><?php echo get_the_excerpt($post->ID); ?></p>

        <?php echo ButtonLink(get_permalink($post->ID), "Leia mais"); ?>
    </a>

    <?php
    return ob_get_clean();
} 
