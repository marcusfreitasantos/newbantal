<?php get_header(); ?>

<?php
$title = get_field('title');
$subTitle = get_field('subtitle');
$mainText = get_field('main_text');
$image = get_field('img');
$contentCards = get_field('content_cards');
?>

<section class="py-5 my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php if($title){ ?>
                    <h1 class="page__title"><?= $title; ?></h1>
                <?php } ?>

                <?php if($subTitle){ ?>
                    <h2 class="page__subtitle"><?= $subTitle; ?></h2>
                <?php } ?>

                <?php if($mainText){ ?>
                    <div class="page__content"><?= $mainText; ?></div>
                <?php } ?>
            </div>

            <div class="col-md-6">
                <?php if($image){ ?>
                    <img class="page__main_img" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                <?php } ?>
            </div>
        </div>

        <hr style="background-color: var(--secondary_color);" class="my-5"/>

        <div class="row">
            <?php if($contentCards){ ?>
                <?php foreach($contentCards as $card){ ?>
                    <div class="col-md-4">
                        <div class="page__content_card">
                            <img src="<?= $card['icon']['url']; ?>" />
                            <h3><?= $card['title'] ?></h3>
                            <p><?= $card['description'] ?></p>
                        </div>
                    </div>
                <?php } ?>
                
            <?php } ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>