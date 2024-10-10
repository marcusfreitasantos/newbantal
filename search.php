<?php get_header(); ?>
<?php
    if(isset($_GET["s"])){
        $searchTerm = $_GET["s"];
    }
?>

<section class="py-5">
    <div class="container">
        <h1 class="text-center search__result_title p-5">Resultados de busca para: <?php echo $searchTerm; ?></h1>
        <div class="row gx-5">
				<?php if ( have_posts() ) : ?>
						<?php
						while ( have_posts() ) :
							the_post();
                            global $post;
							?>

                            <div class="col-md-4 mb-5">
                                <?php echo PostCard($post); ?>
                            </div>

						<?php endwhile; ?>

					<?php oceanwp_pagination(); ?>

				<?php else : ?>
                    <div  class="col-12 text-center p-5">
                        <span>Nada encontrado.</span>
                    </div>
				<?php endif; ?>


        </div>
    </div>
</section>
<?php get_footer(); ?>