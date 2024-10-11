<?php function PostPagination($posts){ ?>
    <?php ob_start(); ?>

    <?php $bigNumber = 999999; ?>
    <div class="col-12 text-center mt-5 pt-5">
        <?php
            echo paginate_links(array(
                'base'      => str_replace($bigNumber, '%#%', esc_url(get_pagenum_link($bigNumber))),
                'format'    => '?paged=%#%',
                'current'   => max(1, get_query_var('paged')),
                'total'     => $posts->max_num_pages,
                'prev_text' => __('«'),
                'next_text' => __('»'),
            ));
            
        ?>
    </div>
    <?php return ob_get_clean(); ?>
<?php }