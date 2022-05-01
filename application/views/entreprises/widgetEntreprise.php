<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 29/10/2018
 * Time: 15:26
 *
 * @var BusinessEntreprise $BusinessEntrepriseW
 * @var array              $picturesW
 * @var array              $videoW
 * @var string             $l
 * @var string             $c
 */
?>
<link rel="stylesheet" href="/assets/css/widget.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js"></script>
<div class="widgetContainer">
    <div class="contain">
        <header>
            <img src="<?php echo $BusinessEntrepriseW->getLogo() ?>" alt="logo-entreprise"> Découvrez notre Page Employeur & nos ambassadeurs prêt à vous conseiller sur Ulyss.co
        </header>

        <?php $images = $BusinessEntrepriseW->getImages(); ?>
        <div class="blocSwiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if ($images != null) {
                        foreach ($images as $image) {
                            $url = base_url() . "upload/files/" . $image["image_name"];
                            echo '<div class="swiper-slide" style="background-image: url(' . $url . '); background-repeat: no-repeat; background-position: center; background-size: cover;"></div>';
                        }
                    } ?>
                </div>
                <!-- Add Pagination -->

            </div>
        </div>
        <div class="row" style="background-color: #2d2d2d; margin: 0;">
            <img src="/assets/img/logo.png" alt="ulyss.co" style="height: 20px; margin: 5px;">
        </div>
    </div>
</div>


<script>
	var line   = <?php echo json_encode($col);?>;
	var col    = <?php echo json_encode($line);?>;
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: line,
		slidesPerColumn: col,
		spaceBetween: 0,
		hashnav: true,
		pagination: '.swiper-pagination',
		paginationClickable: true,

	});

</script>

