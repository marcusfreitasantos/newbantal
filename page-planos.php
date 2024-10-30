<?php get_header();?>
<?php
$bannerBg = get_field("banner_background");
?>

<?php
    $args = array(
		'posts_per_page'      => -1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => 'plano',
        'status'           => 'publish'
	);	
    
    $getCurrentPlans = new WP_Query($args);
?>

<style>
    .bantal__plans_section{
        padding: 60px 0;
        background: url(<?= $bannerBg; ?>) center center;
        background-size: cover;
        background-repeat: no-repeat;
        text-align: center;
    }

    .annual__plans{
        display: none;
    }
</style>


<section class="bantal__plans_section">
    <div class="container">
        <div class="row">
            <div class="col-12 bantal__plans_title_wrapper">
                <h1 class="bantal__plans_title"><?= the_field('title'); ?></h1>
                <h2 class="bantal__plans_subtitle"><?= the_field('subtitle'); ?></h2>
            </div>
        </div>
    </div>

    <div class="plan__category_btn_wrapper">
        <button class="plan__category_btn active" id="plan__category_month">Mensal</button>
        <button class="plan__category_btn" id="plan__category_year">Anual</button>
    </div>
</section>



<section class="bantal__plans_section_cards py-2">
    <div class="bantal__plans_cards_container">

        <div class="row justify-content-center month__plans">
            <?php if($getCurrentPlans->have_posts()){
                while($getCurrentPlans->have_posts()):
                    $getCurrentPlans->the_post();
                    global $post;
                    if(has_term("mensal", "plan_category", $post->id)){ ?>
                        <div class="col-md-2 mb-3">
                            <?= BantalPlanCard($post); ?>
                        </div> 
                    <?php }
                    ?>
                <?php endwhile; ?>
            <?php } ?>
        </div>

        <div class="row justify-content-center annual__plans">
            <?php if($getCurrentPlans->have_posts()){
                while($getCurrentPlans->have_posts()):
                    $getCurrentPlans->the_post();
                    global $post;
                    if(has_term("anual", "plan_category", $post->id)){ ?>
                        <div class="col-md-2 mb-3">
                            <?= BantalPlanCard($post); ?>
                        </div> 
                    <?php }
                    ?>
                <?php endwhile; ?>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    const moreDetailsBtn = [...document.querySelectorAll(".more__details")];
    const lessDetails = [...document.querySelectorAll(".less__details")];
    const planResources = [...document.querySelectorAll(".bantal__plans_card_resources")];
    
    moreDetailsBtn.map((openBtn, index) => {
        openBtn.addEventListener("click", (e) => {
            openBtn.style.display = "none";
            planResources[index].classList.add("show-resources")
        })
    })


    lessDetails.map((closeBtn, index) => {
        closeBtn.addEventListener("click", (e) => {
            moreDetailsBtn[index].style.display = "flex";
            planResources[index].classList.remove("show-resources")
        })
    })

    const btnCategoryPlan = [...document.querySelectorAll(".plan__category_btn")];
    btnCategoryPlan.map((categoryBtn) => {
        categoryBtn.addEventListener("click", function(e){

            btnCategoryPlan.map((categoryBtnInactive => {
                categoryBtnInactive.classList.remove("active")
            }))
            
            e.currentTarget.classList.add("active")

            if(e.currentTarget.id === "plan__category_month"){
                document.querySelector(".month__plans").style.display = "flex";
                document.querySelector(".annual__plans").style.display = "none";
            }else{
                document.querySelector(".month__plans").style.display = "none";
                document.querySelector(".annual__plans").style.display = "flex";
            }
        })
    })
</script>
<?php get_footer();?>