<?php /* @var $this CI_Loader */
/* @var $this Jobs */
/* @var array $offres_disponible */
/* @var $this Entreprises */
/* @var $this Iframe */
/* @var array $EntrepriseMontor */
/* @var BusinessEntreprise $BusinessEntreprise */
/* @var string $secteur_name */
/* @var array $images */
/* @var array $videos */
/* @var array $sections */
?>

<head>
    <title>A propos</title>
    <script>
		zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
		ZC.LICENSE           = ["af485f0913f1881b4e691786587ad569", "323c7c56ecc88dcf2bceddeeec460766"];
    </script>
</head>

<section class="container" style="width: 1170px">
    <div class="block_identity">
        <div class="row">
            <ul>
                <li>Nom <br> <span><?php echo $BusinessEntreprise->getNom() ?></span></li>
                <li>Secteur<br> <span><?php echo $secteur_name ?></span></li>
                <li>Siège<br> <span><?php echo $BusinessEntreprise->getVille() ?></span></li>
                <li>Taille<br> <span><?php echo $BusinessEntreprise->getNumberOfEmployee() . " Employés" ?></span></li>
                <li>Site internet<br> <span><a href="<?php echo $BusinessEntreprise->getSite() ?>"><?php echo $BusinessEntreprise->getSite() ?></a></span></li>
                <li>Nombre d'Insider(s) <br> <span><?php echo $BusinessEntreprise->getNbrMentor() ?></span></li>
            </ul>
        </div>
        <div class="tx_recommand" style="display: none;">
            <div id="TdReco"></div>
        </div>
    </div>

    <aside id="aside">
        <div class="aside_offer">
            <h1>Offres d'emploi</h1>
            <?php if (isset($msg_offre)) {
                echo '<p>' . $msg_offre . '</p>';
            } else {
                foreach ($offres_disponible as $BusinessOffre) { ?>
                    <div class="row jobCard">
                        <div class="col-md-12">
                            <a href="<?php echo base_url() . "entreprise/" . $BusinessEntreprise->getAlias() . "/offresdemploi/" . $BusinessOffre->id; ?>">
                                <?php echo '<h4>' . mb_strtoupper($BusinessOffre->titre_offre) . '</h4>';
                                echo '<p><img src="/assets/img/icons/agreement.png" alt="contrat">' . $BusinessOffre->type_offre .
                                    '<img src="/assets/img/icons/placeholder.png" alt="contrat">' . $BusinessOffre->lieu_offre .
                                    '<img src="/assets/img/icons/medal.png" alt="contrat">' . $BusinessOffre->niveau .
                                    '<img src="/assets/img/icons/time.png" alt="contrat">' .
                                    $this->BusinessOffre->getJourFromDate($BusinessOffre->creation_date) . '</p>'; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row">
                <div class="col-md-12 moreJobs">
                    <button class="seemoreJob">+ d'offres</button>
                    <button class="seelessJob">- d'offres</button>
                </div>
            </div>
        </div>
        <div>
            <h1>Actualité
                <?php if ($this->getController()->companyIsAuthentificate() == true) {
                    if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                        <a data-toggle="modal" data-target="#visiModal"><img class="penModif" src="/assets/img/icons/pen.png" alt="modification"></a>
                    <?php }
                } ?>
            </h1>
            <a class="twitter-timeline" data-height="550" data-chrome="nofooter" href="<?php echo $BusinessEntreprise->getTwitterLink(); ?>"> Tweets by <?php echo $BusinessEntreprise->getNom(); ?>
            </a>
            <hr>
            <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $BusinessEntreprise->getFacebookLink(); ?>&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
        <div class="ico_social">
            <h1>Suivre</h1>
            <a href="<?php echo $BusinessEntreprise->getFacebookLink(); ?>"> <img src="/assets/img/social/fb.png" alt="facebook"></a>
            <a href="<?php echo $BusinessEntreprise->getTwitterLink(); ?>"><img src="/assets/img/social/twitter.png" alt="twitter"></a> <a href="<?php echo $BusinessEntreprise->getLinkedinLink(); ?>"><img src="/assets/img/social/linkedin.png" alt="linkedIn"></a>
            <a href="<?php echo $BusinessEntreprise->getInstagramLink(); ?>"><img src="/assets/img/social/Instagram-logo.png" alt="instagram"></a>
        </div>
        <button class="btnDefault">
            <a data-toggle="modal" data-target="#widgetModal" style="color: #fff">Générez le widget de votre page entreprise</a>
        </button>
    </aside>

    <div class="presentation">
        <h1 id="presentationTitre"><?php echo $BusinessEntreprise->getDescTitre(); ?></h1>
        <?php if ($this->getController()->companyIsAuthentificate() == true) {
            if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                <!-- btn edit -->
                <a href="#" data-toggle="modal" data-target="#presentationModal" class="btn_edit_inf"><img class="penModif" src="/assets/img/icons/pen.png" alt="modification"></a>
            <?php }
        } ?>
        <p id="presentationText"><?php echo $BusinessEntreprise->getDesc(); ?></p>
    </div>

    <div class="mentors_choice">
        <div class="row">
            <h1>Ces Insiders sont prêts à vous conseiller</h1>
            <?php if (isset($EntrepriseMontor)) { ?>
                <?php foreach ($EntrepriseMontor as $key => $mentor) { ?>
                    <div class="col-md-5 bg_white_2 pad_0 mentorCard">
                        <a href="<?php echo $mentor->url; ?>apropos" class="mentorbox" style="display:block;">
                            <div class="row display_flex">
                                <div class="col-md-5 col-sm-5 img_membre">
                                    <?php if ($mentor->avatar != "") { ?>
                                        <img class="avatar img_linkedin" src="<?php echo $mentor->avatar; ?>" style="center center no-repeat; height: 100px; border-radius: 50px; margin: auto;" alt="avatar <?php echo $mentor->prenom; ?>">
                                    <?php } else { ?>
                                        <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;" alt="avatar <?php echo $mentor->prenom; ?>">
                                    <?php } ?>
                                </div>
                                <div class="col-md-7 col-sm-7 padl-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="nom_prenom"><?php echo $mentor->prenom ?></h4>
                                            <p class="titre_mission"><?php echo $mentor->titre_mission; ?></p>
                                            <p class="pos_pers">
                                                <span><i class="fa fa-map-marker"></i> <?php echo $mentor->lieu; ?></span>
                                            </p>
                                            <span class="date">
                                                                <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_debut))); ?>
                                                <?php if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') { ?>
                                                    à Aujourd'hui
                                                <?php } else { ?>
                                                    à <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_fin))); ?>
                                                <?php } ?>
                                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="row pagination_result text-center">
                    <div class="col-md-12">
                        <p>Aucun Insider ne correspond à cette entreprise ... </p>
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="row">
            <div class="col-md-3 col-md-offset-5 moreMentor">
                <button class="seemore">Voir + de Insiders</button>
                <button class="seeles">Voir - de Insiders</button>
            </div>
        </div>

    </div>
    <?php if ($this->getController()->companyIsAuthentificate() == true) {
        if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
            <!-- form pour le bouton ajouter section -->
            <div class="pourquoi">
                <!-- btn ajouter sections -->
                <a href="#" data-toggle="modal" data-target="#addSectionsModal" class="btn_edit_inf"> <span>Ajouter une section</span> </a>
            </div>
        <?php }
    } ?>
    <!----------------------------------------->

    <?php if (isset($sections) && $sections != null) { ?>

        <?php foreach ($sections as $key => $section) { ?>
            <div class="pourquoi" id="section<?php echo $section->id ?>">
                <h1 id="section_titre<?php echo $section->id ?>" style="display: inline"><?php echo $section->titre_sections ?></h1>
                <!-- btn sections edit/supp-->
                <?php if ($this->getController()->companyIsAuthentificate() == true) {
                    if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                        <a href=" #" data-toggle="modal" data-target="#sectionsModal" class="btn_edit_inf" onclick="edit_section(<?php echo $section->id ?>)">
                            <img class="penModif" src="/assets/img/icons/pen.png" alt="modification"> </a>
                    <?php }
                } ?>
                <p id="section_descriptif<?php echo $section->id ?>" style="margin-top: 10px"><?php echo nl2br($section->descriptif_sections) ?></p>
            </div>
        <?php } ?>

    <?php } else {
        if ($this->getController()->companyIsAuthentificate() == true) {
            if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>

                <div class="row pourquoi">
                    <div class="col-md-12">
                        <p>Ajouter une section à votre page ... </p>
                    </div>
                </div>
            <?php }
        } ?>
    <?php } ?>

    <div class="media_ent">
        <h1>Médias</h1>
        <?php if ($this->getController()->companyIsAuthentificate() == true) {
            if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                <form method="post" action="/update_images" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="alias" value="<?php echo $BusinessEntreprise->getAlias() ?>"> <input type="hidden" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>">
                    <div class="form-group">
                        <label>Choisissez votre image <input type="file" id="img_name" name="files[]" multiple/> <span style="position: absolute; margin-left: 30px; color: black;"></span> </label>
                    </div>
                    <div class="form-group">
                        <input class="publier" type="submit" name="fileSubmit" value="Publier !"/>
                    </div>
                </form>
            <?php }
        } ?>

        <div class="row">
            <ul class="gallery">
                <?php if (!empty($images)) {
                    foreach ($images as $image) { ?>
                        <div class="shadow" id="<?php echo $image['id'] ?>">
                            <?php if ($this->getController()->companyIsAuthentificate() == true) {
                                if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                                    <button type="submit" onclick="return del_img_ent(<?php echo $image['id'] ?>)">X</button>
                                <?php }
                            } ?>

                            <div class="col-xs-12 col-md-2">
                                <a href="<?php echo base_url('upload/files/' . $image['image_name']); ?>" data-lightbox="roadtrip">
                                    <li class="item" style="background-image: url('<?php echo base_url('upload/files/' . $image['image_name']); ?>');">

                                    </li>
                                </a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p>Pas de médias disponible.....</p>
                <?php } ?>
            </ul>
        </div>
        <!--VIDEO-->

        <?php if ($this->getController()->companyIsAuthentificate() == true) {
            if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>
                <form method="post" action="/update_video" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="alias" value="<?php echo $BusinessEntreprise->getAlias() ?>"> <input type="hidden" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>">
                    <div class="form-group">
                        <label>Choisissez votre video <input type="file" id="vid_name" name="files[]" multiple/> <span style="position: absolute; margin-left: 30px; color: black;"></span> </label>
                        (format MP4,AVI, 3GP, MPEG)
                    </div>
                    <div class="form-group">
                        <input class="publier" type="submit" name="videoSubmit" value="Publier !"/>
                    </div>
                </form>
            <?php }
        } ?>
        <div class="row">
            <ul class="gallery">
                <?php
                if (!empty($videos)) {
                    foreach ($videos as $video) { ?>
                        <div class="shadowVideo" id="<?php echo $video['video_name'] ?>">
                            <?php if ($this->getController()->companyIsAuthentificate() == true) {
                                $entId = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id_ent']);
                                if ($entId == $BusinessEntreprise->getid()) {
                                    ?>
                                    <button type="submit" onclick="return del_vid_ent(<?php echo $video['id'] ?>)">X</button>
                                <?php }
                            } ?>

                            <div class="col-xs-12 col-md-2">

                                <a href="<?php echo base_url('upload/vids/' . $video['video_name']); ?>">
                                    <li class="" style="display: none">
                                        <!--<div id="frames"></div>-->
                                        <video id="<?php echo $video['id']; ?>" width="220">
                                            <source src="<?php echo base_url('upload/vids/' . $video['video_name']); ?>#t=1"/>
                                        </video>
                                        <!-- Video Controls -->
                                        <div id="video-controls">
                                            <button type="button" id="play-pause"></button>
                                        </div>
                                    </li>
                                </a>

                            </div>
                        </div>
                    <?php }
                } ?>
            </ul>

        </div>

    </div>
    <div class="jobs">
        <h2>Envie de nous rejoindre ? Consultez nos offres d'emploi </h2>
        <a href="<?php echo base_url() . "entreprise/" . $BusinessEntreprise->getAlias() . "/offresdemploi" ?>"><input type="button" value="Voir les offres"></a>
    </div>
</section>


<?php if ($this->getController()->companyIsAuthentificate() == true) {
    if ($this->id_ent_decode == $BusinessEntreprise->getid()) { ?>

        <!-- __________MODALS_ADD_sections_________ -->
        <div class="modal fade text-center modal_home modal_form" id="addSectionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <h1>Ajout de section</h1>
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="formAddSections" method="post" action="/" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" id="entr_sec" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>">
                            <div class="row  ">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <input name="titre_sections_desc" required minlength="4" id="titre_sections_desc" placeholder="Saisir un titre pour votre section"/>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-md-10 col-md-offset-1 editableArea">
                                    <textarea name="sections_desc" id="sections_desc" placeholder="Saisir le contenu de votre section"></textarea>
                                </div>
                            </div>
                            <div class="row btn_inscription ">
                                <div class="col-md-10 col-md-offset-1">
                                    <button class="sendButtondetail" type="submit">Valider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- __________MODALS__Présentation de l'entreprise________ -->
        <div class="modal fade text-center modal_home modal_form" id="presentationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <h1>Edition Présentation</h1>
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="formEditPresentation" method="post" action="/" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" id="entr_id" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>">
                            <div class="row  ">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <input name="titre_description_ent" required minlength="4" id="titre_description_ent" placeholder="Saisir un titre pour votre présentation" value="<?php echo $BusinessEntreprise->getDescTitre() ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 editableArea">

                                    <textarea name="description_ent" id="description_ent" rows="5" placeholder="Présentez votre entreprise en quelques lignes"><?php echo nl2br($BusinessEntreprise->getDesc()) ?></textarea>
                                </div>
                            </div>
                            <div class="row btn_inscription ">
                                <div class="col-md-10 col-md-offset-1">
                                    <button class="sendButtondetail" type="submit">Valider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- __________MODALS_Edit_supprimer_sections_________ -->
        <div class="modal fade text-center modal_home modal_form" id="sectionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <h1>Edition/suppresion section</h1>
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="formEditSections" method="post" action="/" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" id="id_sections_desc_modif" name="id_sections_desc_modif">

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 ">
                                    <input required minlength="4" name="titre_sections_desc_modif" id="titre_sections_desc_modif" placeholder="Saisir un titre pour votre sections"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 editableArea">
                                    <textarea name="sections_desc_modif" id="sections_desc_modif" rows="5" placeholder="Saisir le discriptif de votre sections en quelques lignes"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <button class="sendButtondetail" type="submit">Valider</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <button id="del_section_modif" class="delete_compte">Supprimer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php }
} ?>

<?php include('widgetPageEnt.php') ?>
<script src="/assets/js/nicEdit-latest.js" type="text/javascript"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
	var countMentor = $('.mentorCard').length;
	$('.mentorCard').slice(6).addClass('hideMentor');
	$voirMoins = $('.seeles').addClass("hideDept");
	if (countMentor > 6) {
		$('.seemore').show();
		$('.seemore').on('click', function () {
			$('.mentorCard').slice(6).toggleClass('hideMentor');
			$($voirMoins).toggleClass('hideDept');
			$('.seemore').hide();
		});
		$($voirMoins).on('click', function () {
			$('.mentorCard').slice(6).toggleClass('hideMentor');
			$($voirMoins).toggleClass('hideDept');
			$('.seemore').show();
		})
	}
	if (countMentor < 6) {
		$('.moreMentor').hide();

	}

	var countJobs = $('.jobCard').length;
	$('.jobCard').slice(1).addClass('hideMentor');
	$MoinsJob = $('.seelessJob').addClass("hideDept");
	if (countJobs > 1) {
		$('.seemoreJob').show();
		$('.seemoreJob').on('click', function () {
			$('.jobCard').slice(1).toggleClass('hideMentor');
			$($MoinsJob).toggleClass('hideDept');
			$('.seemoreJob').hide();
		});
		$($MoinsJob).on('click', function () {
			$('.jobCard').slice(1).toggleClass('hideMentor');
			$($MoinsJob).toggleClass('hideDept');
			$('.seemoreJob').show();
		})
	}
	if (countJobs < 6) {
		$('.moreMentor').hide();
		$('.seemoreJob').hide();
	}

</script>
<script>
	bkLib.onDomLoaded(function () {
		new nicEditor({buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'justify', 'ol', 'ul']}).panelInstance('description_ent');
		new nicEditor({buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'justify', 'ol', 'ul']}).panelInstance('sections_desc_modif');
		new nicEditor({buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'justify', 'ol', 'ul']}).panelInstance('sections_desc');
	});
</script>
<script>
    /* Nom image choisie */
	$("input[id='img_name']").change(function (e) {
		var $this = $(this);
		$this.next().html($this.val().split('\\').pop());
	});
    /* Nom vidéo choisie */
	$("input[id='vid_name']").change(function (e) {
		var $this = $(this);
		$this.next().html($this.val().split('\\').pop());
	});
</script>
<script>
	// bkLib.onDomLoaded(nicEditors.allTextAreas);
	//$(document).ready(function () {
	//  $('.sendButtondetail')
	//})

	//function suppression d'image

	function del_img_ent(id) {
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Upload/deleteImage",
			data: {id: id, csrf_token_name: csrf_token},
			success: function () {
				$("<?php echo $image['id'] ?>").remove();
				return false;
			}
		});
		location.reload();
		return false;

	}

	//function suppression video

	function del_vid_ent(id) {
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Upload/deleteVideo",
			data: {id: id, csrf_token_name: csrf_token},
			success: function () {
				$("<?php echo $video['id'] ?>").remove();
				return false;
			}
		});
		location.reload();
		return false;

	}
</script>
<script>
	function edit_section(id_section) {

		titre      = document.getElementById('section_titre' + id_section).innerText;
		descriptif = document.getElementById('section_descriptif' + id_section).innerText;

		document.getElementById('id_sections_desc_modif').value    = id_section;
		document.getElementById('titre_sections_desc_modif').value = titre;
		$('#formEditSections .nicEdit-main').html(descriptif);


		btn_sup = document.getElementById('del_section_modif');

		if (window.addEventListener) {
			btn_sup.addEventListener("click", function () {
				del_sect(id_section);
			}, false);
		} else {
			btn_sup.attachEvent("click", function () {
				del_sect(id_section);
			});
		}
	}

    /*editer description*/
	$("#formEditPresentation").submit(function () {
		var x         = $("#formEditPresentation").find('.nicEdit-main').html();
		var id_ent    = $("#entr_id").val();
		var titre_ent = $("#titre_description_ent").val();
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Entreprises/editDescription",
			data: {csrf_token_name: csrf_token, id_ent: id_ent, titre_description_ent: titre_ent, description_ent: x}, // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				if (json.resultat === true) {
					$('#presentationModal').modal('hide');
					$('#presentationTitre').html(json.description_titre);
					$('#presentationText').html(json.description);
				} else {
					$('#presentationModal').modal('hide');
					window.location.reload();
					return false;
				}
				return false;
			}
		});
		return false;
	});

	//delete section
	function del_sect(id) {
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Entreprises/DeleteSection",
			data: {id: id, csrf_token_name: csrf_token},
			success: function () {
				window.location.reload();
				return false;
			}
		});
		location.reload();
		return false;

	}


	//Add section
	$("#formAddSections").submit(function () {
		var y              = $("#formAddSections").find('.nicEdit-main').html();
		var entr_sec       = $("#entr_sec").val();
		var titre_sections = $("#titre_sections_desc").val();

		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Entreprises/addSection",
			data: {csrf_token_name: csrf_token, id_ent: entr_sec, titre_sections_desc: titre_sections, sections_desc: y}, // serializes the form's elements.
			success: function () {
				window.location.reload();
				return false;
			}
		});
		return false;
	});

    /*editer sections*/
	$("#formEditSections").submit(function () {
		var z         = $("#formEditSections").find('.nicEdit-main').html();
		var id_sec    = $("#id_sections_desc_modif").val();
		var titre_ent = $("#titre_sections_desc_modif").val();
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/Entreprises/EditSection",
			data: {csrf_token_name: csrf_token, id_sections_desc_modif: id_sec, titre_sections_desc_modif: titre_ent, sections_desc_modif: z}, // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#sectionsModal').modal('hide');
				$('#section_titre' + json.id).html(json.titre_sections);
				$('#section_descriptif' + json.id).html(json.descriptif_sections);
				return false;
			}
		});
		return false;
	});

</script>


<script>
	window.onload = function () {

		// Video
		var video = document.getElementById("video");

		// Buttons
		var playButton       = document.getElementById("play-pause");
		var muteButton       = document.getElementById("mute");
		var fullScreenButton = document.getElementById("full-screen");

		// Event listener for the play/pause button
		playButton.addEventListener("click", function () {
			if (video.paused == true) {
				// Play the video
				video.play();

				// Update the button text to 'Pause'
				playButton.innerHTML = "Pause";
			} else {
				// Pause the video
				video.pause();

				// Update the button text to 'Play'
				playButton.innerHTML = "Play";
			}
		});
		// Event listener for the mute button
		muteButton.addEventListener("click", function () {
			if (video.muted == false) {
				// Mute the video
				video.muted = true;

				// Update the button text
				muteButton.innerHTML = "Unmute";
			} else {
				// Unmute the video
				video.muted = false;

				// Update the button text
				muteButton.innerHTML = "Mute";
			}
		});
		// Event listener for the full-screen button
		fullScreenButton.addEventListener("click", function () {
			if (video.requestFullscreen) {
				video.requestFullscreen();
			} else if (video.mozRequestFullScreen) {
				video.mozRequestFullScreen(); // Firefox
			} else if (video.webkitRequestFullscreen) {
				video.webkitRequestFullscreen(); // Chrome and Safari
			}
		});
	};
</script>

