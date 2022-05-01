<?php /* @var $this Home */ ?>
<section class="hero_home home_monter">
    <!-- carousel -->
    <div id="carousel-slider-home" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">
        <div class="carousel-inner">
            <div class="item active" style="background: url('<?php echo base_url(); ?>assets/img/banniere/img_competence.jpg') center center no-repeat;-webkit-background-size: cover;
                    background-size: cover;">
            </div>
            <div class="item" style="background: url('<?php echo base_url(); ?>assets/img/banniere/img_competence.jpg') center center no-repeat;-webkit-background-size: cover;
                    background-size: cover;">
            </div>
            <div class="item" style="background: url('<?php echo base_url(); ?>assets/img/banniere/img_competence.jpg') center center no-repeat;-webkit-background-size: cover;
                    background-size: cover;">
            </div>
        </div>
    </div>
    <!-- and carousel -->
    <div class="container">
        <div class="row text-center text_hero">
            <div class="col-md-12">
                <p class="p_1"><?php echo $this->lang->line("p_1"); ?></p>
                <p class="p_2"><?php echo $this->lang->line("p_3"); ?></p>
                <p class="p_5"><?php echo $this->lang->line("p_2"); ?></p>
            </div>
        </div>
    </div>
    <!-- blcok search 2 -->
    <div class="search_container ">
        <div class="container ">
            <form action="<?php echo base_url(); ?>recherche/comp" method="get" class="row" autocomplete="off">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 search_row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col-md-5 col-sm-6 padr-0">
                                <input type="text" id="competence" placeholder="Compétences">
                                <div class="drop_list drop_list_c" style="display:none;">
                                    <ul id="cmp_list">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 field_talent padlr_0 hidden-xs">
                                <span class="icon_close" onclick="initializeClose();"><i class="fa fa-angle-down"></i></span> <input name="secteur" id="secteur_id" value="0" type="hidden">
                                <input type="text" id="secteur" placeholder="Secteur d'activité">
                                <div class="drop_list drop_list_s">
                                    <ul id="secteur_list">
                                        <?php
                                        foreach ($secteur_activites as $item):

                                            ?>
                                            <li class="auto_cat_s" item="<?php echo $item->nom; ?>" item_id="<?php echo $item->id; ?>"><a href="#"><?php echo $item->nom; ?></a></li>
                                        <?php
                                        endforeach ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 padl-0">
                                <button type="submit" class="btn_srch w100b" name="touver" value="Trouver">Trouver un mentor</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="sp_comp sp_langues1">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end block search 2 -->
</section>
<!-- end hero home -->
<section class="second_block">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img src="<?php echo base_url(); ?>assets/img/ico_mentor.png" alt="">
                <?php $trouver = $this->user_info->getBlock(8); ?>
                <h2><?php echo $trouver->titre; ?></h2>
                <p><?php echo strip_tags($trouver->description); ?></p>
            </div>
            <div class="col-sm-3 text-center">
                <img src="<?php echo base_url(); ?>assets/img/ico_calendar.png" alt="">
                <?php $prenez = $this->user_info->getBlock(9); ?>
                <h2><?php echo $prenez->titre; ?></h2>
                <p><?php echo $prenez->description; ?></p>
            </div>
            <div class="col-sm-3 text-center">
                <?php $discuter = $this->user_info->getBlock(10); ?>
                <img src="<?php echo base_url(); ?>assets/img/ico_phone.png" alt="">
                <h2><?php echo $discuter->titre; ?></h2>
                <p><?php echo $discuter->description; ?></p>
            </div>
            <div class="col-sm-3 text-center">
                <img src="<?php echo base_url(); ?>assets/img/ico_card.png" alt="">
                <?php $reglez = $this->user_info->getBlock(11); ?>
                <h2><?php echo $reglez->titre; ?></h2>
                <p><?php echo $reglez->description; ?></p>
            </div>
        </div>
    </div>
</section>
<section class="block_decouvert bg_dark">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 title_decouvert">
                <?php $liee = $this->user_info->getBlock(7); ?>
                <h2>Ulyss.co crée le lien</h2>
                <p><?php echo $liee->titre; ?></p>
            </div>
        </div>
        <div class="row content_decouvert">
            <div class="col-md-5 col-sm-6">
                <img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $liee->image; ?>" alt="">
            </div>
            <div class="col-md-7 col-sm-6">
                <p><?php echo $liee->description; ?></p>
            </div>
        </div>
    </div>
</section>
<section class="savoir_faire_temoin bg_white">
    <div class="container">
        <div class="row">
            <div class=" title_savoir text-center">
                <h1>Ils témoignent</h1>
            </div>
        </div>
        <div class="row block_temoins text-center">
            <?php foreach ($temoignages as $key => $item): ?>
                <div class="col-sm-4 temoin_decouvert">
                    <p><img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $item->image; ?>" alt=""></p>
                    <h3><?php echo $item->user; ?></h3>
                    <h4><?php echo $item->titre; ?></h4>
                    <p><?php echo $item->description; ?></p>
                </div>
            <?php endforeach ?>
        </div>
        <!--    <div class="row text-center btn_tem_ment">
           <div class="col-md-12">
              <a href="#">Trouver un mentor</a>
              <a href="#">Devenir Mentor</a>
           </div>
           </div> -->
    </div>
</section>
<section class="coup_de_coeur bg_grey">
    <div class="container">
        <div class="row text-center title_laune">
            <h1 class="col-md-12"><?php echo $this->lang->line("coup_de_coeur"); ?></h1>
        </div>
        <div class="row mg_7">
            <div id="carousel_coup">
                <?php foreach ($coup_de_coueur as $coup): ?>
                    <a href="<?php echo base_url() . $coup->alias_u . '/' . $coup->alias_t . '/apropos'; ?>" class="plus">
                        <div class="item">
                            <div class="cover" style="background:url('<?php echo $this->s3file->getUrl("{$this->config->item('upload_talents')}{$coup->photo_coup_de_coeur}"); ?>');">
                           <span class="rating">
                           <?php
                           $nbr_cmt       = $this->talent->GetcountCompTalent($coup->id);
                           $sum_note      = $this->talent->GetSumNoteCmtTalent($coup->id);
                           $nombre_etoile = 0;
                           if (!empty($sum_note) && $nbr_cmt > 0) {
                               $nombre_etoile = round($sum_note->note / $nbr_cmt);
                           }
                           ?>
                               <?php for ($i = 0; $i < 5; $i++) { ?>
                                   <?php if ($i < $nombre_etoile) { ?>
                                       <i class="fa fa-star active"></i>
                                   <?php } else { ?>
                                       <i class="fa fa-star active"></i>
                                   <?php }
                               } ?>
                           </span>
                                <div class="bot_cover">
                                    <span class="name"><?php echo $coup->titre; ?></span>
                                    <div class="media">
                                        <div class="media-body pull-left info_name">
                                            <h4 class="media-heading"><?php echo $coup->prenom; ?></h4>
                                            <h5>Chef de produit</h5>
                                        </div>
                                        <div class="media-right pull-right text-right">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section class="block_decouvert bg_dark">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 title_decouvert">
                <?php $rejoin = $this->user_info->getBlock(5); ?>
                <h2 class="mgb_15"><?php echo $rejoin->titre; ?></h2>
                <p><?php echo $rejoin->description; ?></p>
            </div>
        </div>
        <div class="row text-center btn_tem_ment mgt00">
            <div class="col-md-12">
                <?php if (!$this->session->userdata('logged_in_site_web')) { ?>
                    <a href="#" data-toggle="modal" data-target="#ModalConnexion"><?php echo $this->lang->line("revelez_vos_talent"); ?></a>
                <?php } else { ?>
                    <a href="<?php echo base_url(); ?>mentor"><?php echo $this->lang->line("revelez_vos_talent"); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="block_categorie">
    <div class="container">
        <div class="row text-center">
            <h1 class="col-md-12 title_block"><?php echo $this->lang->line("categories"); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row galerie_cat">
                    <?php foreach ($categories as $categorie): ?>
                        <?php if ($categorie->affiche_home == 1) { ?>
                            <div class="col-md-4 col-sm-6 col_items">
                                <a href="<?php echo base_url(); ?>recherche/<?php echo $categorie->id; ?>">
                                    <div class="col col_5" style="background:url(<?php echo base_url(); ?>image.php/<?php echo $categorie->image; ?>?height=276&width=276&cropratio=1:1&image=<?php echo $this->s3file->getUrl("{$this->config->item('upload_categories')}{$categorie->image}"); ?>)">
                                        <div class="title_blog">
                                            <p class="title"><?php echo $categorie->nom; ?></p>
                                            <!-- <p class="desc"><?php echo $categorie->description; ?></p>  -->
                                            <span>Découvrez</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php endforeach ?>
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="block_decouvert bg_dark" style="background: url(//res.cloudinary.com/hrscywv4p/image/upload/c_limit,fl_lossy,h_1500,w_2000,f_auto,q_auto/v1/1173222/aaaaaaaaaaaaaaaacareer-success_kq3kvi.jpg) center center no-repeat;    background-size: cover;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 title_decouvert">
                <h2>Partagez notre page pour que chacun puisse trouver un Mentor dans son domaine</h2>
            </div>
        </div>
        <div class="row text-center btn_tem_ment mgt00">
            <div class="col-md-12 btn_share_social">
                <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url(); ?>monter" target="_BLANK"><i class="fa fa-facebook"></i>Partager sur Facebook</a>
                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>monter&source=Ulyss" target="_BLANK"><i class="fa fa-linkedin"></i>Partager sur Linkedin</a>
                <a href="https://twitter.com/intent/tweet/?url=<?php echo base_url(); ?>monter&text=ulyss&via=ulyss" target="_BLANK"><i class="fa fa-twitter"></i>Partager sur Twitter</a>
            </div>
        </div>
    </div>
</section>
<section class="savoir_faire_temoin bg_grey">
    <div class="container">
        <div class="row">
            <div class=" title_savoir text-center">
                <h1>Ils en parlent</h1>
            </div>
        </div>
        <div class="row logos_partenaire">
            <div class="col-md-12" id="carousel_partenaire">
                <?php foreach ($parlents as $key => $item): ?>
                    <div class="item">
                        <a href="<?php echo $item->link; ?>"> <img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $item->image; ?>" alt=""> </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	$(document).ready(function () {
		$(".chargement_b").hide();
		$("#carousel_coup ").owlCarousel({

			autoPlay: 3000, //Set AutoPlay to 3 seconds

			items: 3,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [979, 3]

		});
		$(" #carousel_savoir").owlCarousel({

			autoPlay: 3000, //Set AutoPlay to 3 seconds
			items: 1


		});
		$(".next").click(function () {
			$(" #carousel_savoir").trigger('owl.next');
		});
		$(".prev").click(function () {
			$(" #carousel_savoir").trigger('owl.prev');
		});

		$('.date-picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			startDate: '1d',
			language: 'fr'
		});
		$('.date-picker-n').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			language: 'fr'
		});

	});
	$(" #carousel_partenaire").owlCarousel({

		autoPlay: 3000, //Set AutoPlay to 3 seconds
		items: 6,
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 2]

	});


</script>