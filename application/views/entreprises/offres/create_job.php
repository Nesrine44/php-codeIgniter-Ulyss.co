<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 31/07/2018
 * Time: 14:15
 */
/* @var array $categories */
/* @var array $offres_all */
/* @var BusinessEntreprise $BusinessEntreprise */
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/job/createJob-style.css"/>
<div class="modal fade" id="jobsModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <section class="section-job1">
                <h1>CR&EacuteEZ VOTRE OFFRE D'EMPLOI</h1>
                <div class="row">
                    <img src="<?php echo base_url('upload/logos/' . $BusinessEntreprise->getLogo()) ?>" alt="logo-entreprise" class="logo_ent_job">
                </div>

                <div class="row">
                    <form action="/create_offre" name="offre_emploie" method="post" class="f_el offre_emploie">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="ent_id" value="<?php echo $BusinessEntreprise->getId(); ?>">
                        <input type="hidden" name="ent_alias" value="<?php echo $BusinessEntreprise->getAlias(); ?>">

                        <input type="hidden" id="offre_id_modif" name="offre_id_modif">


                        <div class="col-md-3 col-xs-12 header_job">
                            <input id="offre_Titre" required type="text" name="Titre" title="Titre de l'offre" placeholder="Intitulé du poste">
                        </div>

                        <div class="col-md-3 col-xs-12 header_job">
                            <select id="offre_departement" title="Departement de l'offre" name="departement" class="required secteur" id="<?php echo $key; ?>">
                                <option value="">Département</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat->id; ?>"><?php echo $cat->nom; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-3 col-xs-12 header_job">
                            <input id="offre_Lieu" title="Lieu de l'offre" type="text" name="Lieu" placeholder="Lieu" class="required">
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-3 header_job">
                        <select id="offre_type_contrat" title="Type de contrat de l'offre" name="type_contrat">
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Interim">Intérim</option>
                            <option value="Alternance">Alternance</option>
                            <option value="Alternance">Stage</option>
                        </select>
                    </div>
                    <div class="col-md-3 header_job">
                        <select id="offre_salaire" title="salaire proposé pour l'offre" name="salaire">
                            <option value="20k">20 k - 30 k</option>
                            <option value="30k">30 k - 40 k</option>
                            <option value="40k">40 k - 50 k</option>
                            <option value="50K">50 k - 60 k</option>
                            <option value="plus60K">+ 60 k</option>
                            <option value="nc">Non mentionné</option>
                        </select>
                    </div>
                    <div class="col-md-3 header_job">
                        <select id="offre_niveau" title="Le niveau demandé pour l'offre" name="niveau">
                            <option value="Debut">Débutant</option>
                            <option value="Confirmé">Confirmé</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="ent_postuler_url" name="ent_postuler_url" title="URL de votre Job Board" placeholder="Le lien vers votre job board" required="required">
                    </div>

                </div>
                <div class="row descrip">
                    <div class="col-md-12 mission">
                        <p>Descriptif du poste</p>
                        <textarea id="offre_poste" title="Descriptif du poste" placeholder="Descriptif du poste" name="poste" class="required"></textarea>
                    </div>
                    <div class="col-md-12 mission">
                        <p>Profil recherché</p>
                        <textarea id="offre_profil" title="Descriptif du profil" placeholder="Descriptif du profil" name="profil" rows="10" class="required"></textarea>
                    </div>
                </div>

                <div class="row">
                    <h1>SELECTIONNEZ LES INSIDERS RATTACH&EacuteS &Agrave CETTE OFFRE</h1>

                    <?php if (isset($EntrepriseMontor)) {
                    ?>
                    <?php foreach ($EntrepriseMontor

                                   as $key => $mentor) { ?>

                        <div class="col-md-6 bg_white_2 pad_0 mentorCard">

                            <div class="row mentors">
                                <label for="<?php echo $mentor->user_id ?> check_mentor" class="label_mentor"><input type="checkbox" name="mentor[]" value="<?php echo $mentor->user_id ?>" id="<?php echo $mentor->user_id ?> check_mentor"/>
                                    <span class="checkmark"></span>
                                    <div class="col-md-5 col-sm-5 img_membre">

                                        <?php if ($mentor->avatar != "") { ?>
                                            <img class="avatar img_linkedin" src="<?php echo $mentor->avatar; ?>" style="center center no-repeat; height: 100px; border-radius: 50px; margin: auto;"  <?php echo $mentor->prenom; ?>">
                                        <?php } else { ?>
                                            <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;"  <?php echo $mentor->prenom; ?>">
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-7 col-sm-7 padl-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="name_entreprise"><?php echo $mentor->nom_entreprise; ?></h4>
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
                                </label> <!--</label> -->
                            </div>
                        </div>

                    <?php } ?>
                </div>

                <?php } else { ?>
                    <div class="row pagination_result text-center">
                        <div class="col-md-12">
                            <p>Aucun insider ne correspond à cette entreprise ... </p>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-3 col-md-offset-4">
                        <button class="seemoreM">Voir + d'Insiders</button>
                        <button class="seelesM">Voir - d'Insiders</button>
                    </div>
                </div>
                <div class="publier_btn">
                    <button class="btn_srch"><a id="publier_modif_btn" href="ulyssco" onclick="postForm('offre_emploie');return false;">Publier !</a></button>
                </div>
                </form>


            </section>
            <section class="section-job1">
                <h1 id="titjob">VOS OFFRES EN COURS</h1>

                <?php if (isset($msg_offre_ent) || !isset($offres_all)) {
                    echo '<p>' . $msg_offre_ent . '</p>';
                } else {
                    foreach ($offres_all as $BusinessOffre) { ?>
                        <div class="row ">
                            <form method="POST" class="current_offers" enctype="multipart/form-data">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="hidden" name="offre_id" value="' . $BusinessOffre->id . '"> <input type="hidden" name="alias_ent" value="<?php echo $BusinessEntreprise->getAlias(); ?>">
                                <div class="col-md-7 single_offer">
                                    <a href="<?php echo base_url() . "entreprise/" . $BusinessEntreprise->getAlias() . "/offresdemploi/" . $BusinessOffre->id ?>">
                                        <?php echo '<h3>' . $BusinessOffre->titre_offre . '</h3>';
                                        echo '<p><img src="/assets/img/icons/agreement.png" alt="contrat">' . $BusinessOffre->type_offre . ' <img src="/assets/img/icons/placeholder.png" alt="contrat"> ' . $BusinessOffre->lieu_offre . ' <img src="/assets/img/icons/medal.png" alt="contrat"> ' . $BusinessOffre->niveau . ' <img src="/assets/img/icons/time.png" alt="contrat"> ' . $this->BusinessOffre->getJourFromDate($BusinessOffre->creation_date) . '</p>';
                                        ?></a>
                                </div>

                                <div class="col-md-2">
                                    <button onclick="return modif_offre(<?php echo $BusinessOffre->id ?>);" name="modifier_offre" class="btn_modif">Modifier</button>
                                </div>

                                <div class="col-md-2">
                                    <input <?php echo 'id="public_offre' . $BusinessOffre->id . '"' ?> onChange='submit_public(<?php echo $BusinessOffre->id ?>);' type="checkbox" name="public_offre" data-toggle="toggle" data-on="Publiée" data-off="Non publiée" data-onstyle="success" data-offstyle="danger"
                                        <?php if ($BusinessOffre->public_offre == 1) {
                                            echo 'value="true" checked ';
                                        } else {
                                            echo 'value="false"';
                                        } ?>
                                    >
                                </div>

                                <div class="col-md-1 col-lg-1">
                                    <a data-toggle="modal" data-target="#deleteOffreModal"> <input type="submit" name="supprimer_offre" class="btn_supp" value="Supprimer"></a>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } ?>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteOffreModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content deleteOffre">
            <form method="POST" class="" enctype="multipart/form-data">
                <div class="row ask1">
                    <p>Avez-vous trouvé votre recrue sur Ulyss.co ?</p>
                    <div class="col-md-12">
                        <input type="radio" name="reponseOffre" value="oui" checked>Oui <input type="radio" name="reponseOffre" value="non">Non <br>
                    </div>
                </div>
                <div class="row ask2">
                    <p>Êtes-vous sûr de vouloir supprimer cette offre ?</p>
                    <div class="col-md-12">
                        <input type="submit" onclick="del(<?php echo $BusinessOffre->id ?>);" data-dismiss="modal" name="supprimer_offre" class="btn_supp" value="Oui">
                        <input type="submit" data-dismiss="modal" name="supprimer_offre" class="btn_supp" value="Non">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

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

</script>
<script type="text/javascript">

	//function modif offre public ou non
	function submit_public(id) {

		checkedValue = $('#public_offre' + id).val();

		// Let's edit the description!
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/jobs/offrePublic",
			data: {id: id, value: checkedValue, csrf_token_name: csrf_token},
			dataType: 'json',
			success: function (json) {

				document.getElementById('public_offre' + id).value = json.value;
				return false;

			}
		});
		return false;
	}

	//function edition de l'offre ( renvoi seulment les info de l'offre a la vue )
	function modif_offre(id) {

		$.ajax({
			type: "POST",
			url: base_url + "entreprise/jobs/editOffre",
			data: {id: id, csrf_token_name: csrf_token},
			dataType: 'json',
			success: function (json) {

				document.getElementById('publier_modif_btn').innerHTML = 'Modifier !';

				document.getElementById('offre_id_modif').value     = json.offre_id_modif;
				document.getElementById('offre_Titre').value        = json.Titre;
				document.getElementById('offre_departement').value  = json.departement;
				document.getElementById('offre_type_contrat').value = json.type_contrat;
				document.getElementById('offre_Lieu').value         = json.Lieu;
				document.getElementById('offre_salaire').value      = json.salaire;
				document.getElementById('offre_niveau').value       = json.niveau;
				document.getElementById('offre_profil').value       = json.profil;
				document.getElementById('offre_poste').value        = json.poste;
				document.getElementById('ent_postuler_url').value   = json.url_candidature;


				// en recupere les checkbox sur la page , on les decoche tous
				var checkboxes = document.getElementsByName('mentor[]');
				for (var i = 0, n = checkboxes.length; i < n; i++) {
					if (checkboxes[i].checked === true) {
						document.getElementById(checkboxes[i].id).checked = false;
					}
				}


				// en coche les nouveaux montor de l'offre
				var array = json.tab_id_montor_affiliated;
				array.forEach(function (element) {

					//Check
					document.getElementById(element.id_mentor + 'check_mentor').checked = true;
				});

				return false;


			}
		});
		return false;
	}


	//function suppression de l'offre
	function del(id) {


		$.ajax({
			type: "POST",
			url: base_url + "entreprise/jobs/deleteOffre",
			data: {id: id, csrf_token_name: csrf_token},
			success: function () {

				return false;

			}
		});
		location.reload();
		return false;

	}

	$('.btn_modif').click(function (e) {
		var $target = $('#jobsModal');
		$target.animate({scrollTop: $(this).offset().top}, 500);
	})

</script>
