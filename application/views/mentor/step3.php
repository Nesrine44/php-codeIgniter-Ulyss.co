<section class="hero_ccm hero_dcc bg_prof">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-hr">
                <h1 class="prof_img">
                    <?php if ($this->getController()->getBusinessUser()->getAvatar() != '') { ?>
                        <img src="<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>" alt="">
                    <?php } else { ?>
                        <img src="/upload/avatar/default.jpg" alt="">
                    <?php } ?>
                </h1>
                <p class="title_profl"><?php echo $this->getController()->getBusinessUser()->getFullName(); ?></p>
            </div>
        </div>
    </div>
</section>
<section class="pg-ccm pg-dcc">
    <div class="container">
        <form id="formAddCours" action="<?php echo base_url(); ?>mentor/step4" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row text-center ">
                <div class="col-md-12">
                    <p class="nb_step">Etape 2 sur 3 </p>
                    <h1 class="title_st">Vos disponibilités</h1>
                </div>
            </div>

            <div class="row mgt30 text-field">
                <div class="col-md-12">
                    <p class="mgb_30" style="text-align: center">
                        Choisissez vos disponibilités hebdomadaires pour échanger avec les candidats interessés par vos expériences professionnelles
                    </p>

                    <p class="link_horaires"><a href="#" id="disp_week_and_soir">Je suis disponible le soir et weekend</a> <a href="#" id="disp_horaire_tavail">Je suis disponible sur les heures de
                            travail</a></p>

                </div>
            </div>
            <div class="row  ">
                <div class="col-md-12">
                    <div class="">
                        <table class="table text-center table_diponibilite">
                            <tr class="hidden-xs">
                                <th></th>
                                <th>Lundi</th>
                                <th>Mardi</th>
                                <th>Mercredi</th>
                                <th>Jeudi</th>
                                <th>Vendredi</th>
                                <th>Samedi</th>
                                <th>Dimanche</th>
                            </tr>
                            <tr class="visible-xs">
                                <th></th>
                                <th>Lun</th>
                                <th>Mar</th>
                                <th>Mer</th>
                                <th>Jeu</th>
                                <th>Ven</th>
                                <th>Sam</th>
                                <th>Dim</th>
                            </tr>
                            <tr>
                                <td class="pad_m0">8h-10h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_8_10" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_8_10" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_8_10" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_8_10" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_8_10" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_8_10" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_8_10" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">10h-12h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_10_12" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_10_12" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_10_12" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_10_12" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_10_12" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_10_12" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_10_12" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">12h-14h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_12_14" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_12_14" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_12_14" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_12_14" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_12_14" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_12_14" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_12_14" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">14h-16h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_14_16" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_14_16" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_14_16" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_14_16" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_14_16" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_14_16" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_14_16" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">16h-18h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_16_18" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_16_18" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_16_18" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_16_18" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_16_18" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_16_18" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_16_18" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">18h-20h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_18_20" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_18_20" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_18_20" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_18_20" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_18_20" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_18_20" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_18_20" class="check_disp" checked></td>
                            </tr>
                            <tr>
                                <td class="pad_m0">20h-22h</td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="lundi_20_22" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mardi_20_22" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="mercredi_20_22" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="jeudi_20_22" class="check_disp"></td>
                                <td class="horaire_td "><input type="checkbox" value="1" name="vendredi_20_22" class="check_disp"></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="samedi_20_22" class="check_disp" checked></td>
                                <td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_20_22" class="check_disp" checked></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row text-field">
                <div class="col-md-12">

                    <p class="link_horaires"><span class="active">Tranche horaire disponible</span> <span>non disponible</span></p>

                </div>
            </div>
            <hr>
            <div class="row mgb_30 btn_add_cours text-right">
                <div class="col-md-12">
                    <p class="etap1_error" style="display:none;"></p>
                </div>
                <div class="col-md-12 mgb_30">
                    <button type="submit">Étape 3/3 <i class="fa fa-angle-right"></i></button>
                </div>
            </div>


        </form>
    </div>
</section>


<section class="block_confirmation" style="display:none">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Annonce envoyée</h2>
                <p class="ico_chk"><i class="ion-ios-checkmark-outline"></i></p>
                <p class="text-chk">Votre annonce a bien été prise en compte. L’équipe EasyLearn va étudier<br> et valider votre annonce dans les plus brefs délais. </p>
            </div>
        </div>
        <div class="row mgt30 btn_add_cours">
            <div class="col-md-12">
                <a href="#">Retour à la page d'accueil</a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	function gotoSearch() {
		$('#Formsearch').submit();
	}

	$(document).ready(function () {
		$('.date-picker-n').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			language: 'fr'
		});
		$(".chargement_b").hide();
		$("#formADDtalent").submit(function () {
			if ($("#name").val() == "" || $("#desc").val() == "") {
				$(".erreur_talent").show();
				setTimeout(function () {
					$(".erreur_talent").hide();
				}, 6000);
				return false;
			} else {
				$("#formADDtalent").submit();
			}
		});
		$("#formADDWishlist").submit(function () {
			if ($("#option_scat").val() == 0 || $("#descw").val() == "" || $("#namew").val() == "" || $("#ville_id").val() == 0) {
				$(".erreur_wishlist").show();
				setTimeout(function () {
					$(".erreur_wishlist").hide();
				}, 6000);
				return false;
			} else {
				$("#formADDWishlist").submit();
			}
		});
		$("#gcat").change(function () {
			$("#option_scat").html('');
			$.ajax({
				type: "GET",
				url: base_url + "recherche/get_sous_categorie",
				dataType: 'html',
				data: {id: $(this).val()},
				success: function (list) {
					$("#option_scat").html(list);
				}
			});
		});

		$(".proposeceservice").click(function () {
			$.ajax({
				type: "GET",
				url: base_url + "wishlist/get_info",
				data: {id: $(this).attr("lvalue")}, // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
					if (json.msg == 'yes') {
						$("#name").val(json.info.titre);
						$("#desc").val(json.info.description);
						$("#id_wish").val(json.info.id);
						$("#id_ville").val(json.info.ville_id);
						$("#id_cat").val(json.info.categorie_id);
					}
				}
			});
		});

		$("#carousel_coup").owlCarousel({

			autoPlay: 3000, //Set AutoPlay to 3 seconds

			items: 3,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [979, 3]
		});
	});

	$(document).ready(function () {
		$('.horaire_td').click(function () {

			if ($(this).find('.check_disp').is(":checked")) {

				$(this).find('.check_disp').attr("checked", false);
			}
			else {
				$(this).find('.check_disp').prop("checked", true);
			}
			$(this).toggleClass('active');
		});

	});

	$("#formAddCours").submit(function () {


		if (!verification_step_2()) {

			$(".etap1_error").html("Merci de remplir tous les champs");
			$("html, body").animate({scrollTop: 0}, "slow");
			$(".etap1_error").show();
			setTimeout(function () {
				$(".etap1_error").show();
			}, 6000);
			return false;
		} else {
			return true;
		}
	});

	function verification_step_2() {
		var error = false;
		$(".required").each(function () {
			if ($.trim($(this).val()) == "") {
				$(this).removeClass("valid").addClass("invalid");
				$(this).parent().parent().addClass('invalid');
				error = true;
			}
		});
		if (error) {
			return false;
		}
		else {
			return true;
		}
	}
</script>