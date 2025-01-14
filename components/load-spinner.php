<?php function LoadSpinner(){ ?>
    <?php ob_start(); ?>
    <?php $childThemeDirectory = get_stylesheet_directory_uri(); ?>
    <?php $lottieFile = "$childThemeDirectory/assets/lottie/loading-spinner-bantal.json"; ?>

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <div class="loading__spinner_wrapper d-flex justify-content-center align-items-center h-100">
        <lottie-player src="<?= $lottieFile; ?>" background="transparent"  speed="1"  style="width: 60px; height: 60px;" loop autoplay></lottie-player>
    </div>
<?php 
    return ob_get_clean();
}