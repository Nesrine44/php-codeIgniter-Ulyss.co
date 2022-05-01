<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 29/10/2018
 * Time: 15:26
 *
 * @var BusinessEntreprise $BusinessEntrepriseW
 * @var BusinessOffre      $BusinessOffreW
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
            <img src="<?php echo $BusinessEntrepriseW->getLogo() ?>" alt="logo-entreprise"> Ces mentors <?php echo $BusinessEntrepriseW->getNom() ?>
            sont prêt à partager leur expérience
            <!-- navigation buttons -->
        </header>

        <?php $images   = $BusinessEntrepriseW->getImages();
        $BusinessMentor = $BusinessOffreW->getBusinessMontorAffiliated(); ?>
        <div class="blocSwiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if ($BusinessMentor != null) {
                        foreach ($BusinessMentor as $mentor) {
                            $url = base_url() . $mentor->avatar;
                            echo '<div class="swiper-slide" style="background-image: url(' . $url . ');"> 
            <div class="infosMentor" ><a href="' . base_url() . $mentor->url . 'apropos" class="button">Contactez '
                                . $mentor->prenom . ' ' . substr($mentor->nom, 0, 1) . '.</br>'
                                . $mentor->titre_mission . '</br>'
                                . $mentor->lieu . '</a></br>
                                    </div></div>';
                        }
                    } ?>
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
	var l      = <?php echo json_encode($c);?>;
	var c      = <?php echo json_encode($l);?>;
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: c,
		slidesPerColumn: l,
		spaceBetween: 0,
		hashnav: true,
		pagination: '.swiper-pagination',
		paginationClickable: true,

	});

</script>

