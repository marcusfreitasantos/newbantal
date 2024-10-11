<?php 
$mainMenu = wp_get_nav_menu_items("main_menu");
$mobileMenu = wp_get_nav_menu_items("mobile_menu");
$siteUrl = site_url();
$childThemeDirectory = get_stylesheet_directory_uri();
$logo = "$childThemeDirectory/assets/img/bantal-recrutamento.svg";
$headerIconSize = "24px";


function hasChildren($menuItems, $itemId) {
    foreach ($menuItems as $menuItem) {
        if ($menuItem->menu_item_parent == $itemId) {
            return true;
        }
    }
    return false;
}

function defineNavItemIconName($navItem){
    if(str_contains(strtolower($navItem), "home")){
        return "<i class='fa-solid fa-home'></i>";
    }
    else if(str_contains(strtolower($navItem), "agora")){
        return "<svg aria-hidden='true' class='' xmlns='http://www.w3.org/2000/svg' width='26' height='15' viewBox='0 0 21 14' fill='none'><path fill-rule='evenodd' clip-rule='evenodd' d='M3.19242 0.366828C3.5605 -0.000526622 4.15783 0.064257 4.48445 0.468919C4.80836 0.870219 4.74254 1.45406 4.38662 1.82727C3.10305 3.17321 2.31494 4.99584 2.31494 7.00255C2.31494 9.0234 3.11419 10.8576 4.41382 12.2062C4.77295 12.5789 4.84074 13.1652 4.51567 13.5679C4.19032 13.971 3.59589 14.037 3.22734 13.6729C1.50641 11.9732 0.439941 9.61244 0.439941 7.00255C0.439941 4.41036 1.492 2.06389 3.19242 0.366828ZM5.7961 2.8195C6.14517 2.43223 6.74678 2.49745 7.07425 2.90315C7.39749 3.30363 7.32813 3.88475 7.00857 4.28818C6.41774 5.03407 6.06494 5.97711 6.06494 7.00255C6.06494 8.04102 6.42675 8.99498 7.0312 9.74526C7.3559 10.1483 7.42857 10.7334 7.1035 11.1361C6.77815 11.5392 6.18128 11.6062 5.83127 11.2243C4.81198 10.1122 4.18994 8.63001 4.18994 7.00255C4.18994 5.39389 4.79769 3.92718 5.7961 2.8195ZM13.8056 2.90315C13.4824 3.30363 13.5518 3.88475 13.8713 4.28817C14.4621 5.03407 14.8149 5.97711 14.8149 7.00255C14.8149 8.04102 14.4531 8.99498 13.8487 9.74526C13.524 10.1483 13.4513 10.7334 13.7764 11.1361C14.1017 11.5392 14.6986 11.6062 15.0486 11.2243C16.0679 10.1122 16.6899 8.63001 16.6899 7.00255C16.6899 5.39389 16.0822 3.92718 15.0838 2.8195C14.7347 2.43223 14.1331 2.49745 13.8056 2.90315ZM16.3954 0.468919C16.0715 0.870219 16.1373 1.45406 16.4933 1.82727C17.7768 3.17321 18.5649 4.99584 18.5649 7.00255C18.5649 9.0234 17.7657 10.8576 16.4661 12.2062C16.1069 12.5789 16.0391 13.1652 16.3642 13.5679C16.6896 13.971 17.284 14.037 17.6525 13.6729C19.3735 11.9732 20.4399 9.61244 20.4399 7.00255C20.4399 4.41036 19.3879 2.06389 17.6875 0.366828C17.3194 -0.000526547 16.7221 0.0642572 16.3954 0.468919ZM10.4399 9.50256C11.8207 9.50256 12.9399 8.38327 12.9399 7.00256C12.9399 5.62184 11.8207 4.50256 10.4399 4.50256C9.05923 4.50256 7.93994 5.62184 7.93994 7.00256C7.93994 8.38327 9.05923 9.50256 10.4399 9.50256Z'></path></svg>";
    }
    
    return "";
}
?>

<header class="custom__header">
    <div class="custom__header_container">
        <div class="row justify-content-between align-items-center">


            <div class="col-8">
                <div class="custom__header_nav_wrapper d-flex align-items-center w-100 gap-5">
                    <a href=<?php echo $siteUrl; ?> class="header__logo_wrapper">
                        <img class="img-fluid" width="160px" src=<?php echo $logo; ?>  alt="bantal logo" />
                    </a>
    
                    <div class="custom__header_nav d-none d-md-flex gap-5 align-items-center">
                        <?php foreach($mainMenu as $menuItem){ ?>                        
                            <a href=<?php echo $menuItem->url; ?> class="custom__header_nav_item">
                                <?php echo defineNavItemIconName($menuItem->title); ?>
                                <span><?php echo $menuItem->title; ?> </span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-4 d-sm-none d-flex justify-content-end custom__header_mobile_btn">
                <div class="header__left_menu">
                    <span class="header__main_menu_btn">
                        <i class="fa-solid fa-bars"></i>
                    </span>

                    <span class="header__main_menu_btn_close">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-4  d-none d-md-block justify-content-end">
                <div class="d-flex align-items-center justify-content-end header__right_menu">
                    
                    <div class="header__search_form">
                        <?php get_search_form(); ?>
                    </div>

                    <a class="header__search_form_btn" onclick="callSearchForm()" >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a class="header__search_form_btn" >
                        <i class="fa-regular fa-bell"></i>
                    </a>

                    <a class="header__login_form_btn">
                        <i class="fa-regular fa-user"></i>
                    </a>
                </div>


                <?= LoginForm(); ?>
            </div>
        </div>

        <div class="header__main_menu">
                <?php foreach($mobileMenu as $menuItem){                     
                    if(!hasChildren($mobileMenu, $menuItem->ID) && $menuItem->menu_item_parent == 0){ ?>
                        <a href=<?php echo $menuItem->url; ?>>
                            <?php echo $menuItem->title; ?>
                        </a>
                    <?php }else if(hasChildren($mobileMenu, $menuItem->ID)){ ?>
                        <div class="header__submenu">
                            <span class="header__submenu_title"><?php echo $menuItem->title; ?></span>

                            <?php foreach($mobileMenu as $submenuItem){ 
                                if($submenuItem->menu_item_parent == $menuItem->ID){ ?>
                                    <a href="<?php echo $submenuItem->url; ?>" class="header__submenu_item">
                                        <?php echo $submenuItem->title; ?> 
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php }
                    ?>
                <?php } ?>
        </div>
    </div>
</header>