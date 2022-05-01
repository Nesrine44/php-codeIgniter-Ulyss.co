<div class="row" style="height: 230px; width: 100%; background-image: url('/assets/img/bg_step_2.jpg'); margin: auto">
    <div class="col-xs-12 col-md-12" style="height: 100%; padding: 80px;">
        <?php if ($this->getController()->userIsAuthentificate()) { ?>
            <div class="avatarHeader" style="background-image: url('<?php echo $this->getController()->getBusinessUser()->getAvatar() != '' ? $this->getController()->getBusinessUser()->getAvatar() : '/upload/avatar/default.jpg' ?>')"></div>
        <?php } else { ?>
            <div class="avatarHeader" style="background-image: url('<?php echo isset($user['avatar']) && $user['avatar'] != '/upload/avatar/default.jpg' ? '/upload/avatar/temp/' . $user['avatar'] : '/upload/avatar/default.jpg' ?>')"></div>
        <?php } ?>
        <div class="nameHead"><?php echo $user['nom'] . ' ' . $user['prenom'] ?></div>
    </div>
</div>
<section class="pg-ccm pg-dcc">
    <div class="container">
        <form action="<?php echo base_url(); ?>inscription/insider-validation" method="POST" enctype="multipart/form-data" name="f_postmentor4">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row text-center mgb_30">
                <div class="col-md-12">
                    <p class="nb_step">Etape 3 sur 3 </p>
                    <h1 class="title_st">Informations complémentaires</h1>
                </div>
            </div>
            <div class="row mgb30">
                <div class="block_mn_compte">
                    <div class="mes_infos_compte">
                        <div class="blocktel">
                            <div class="title_label_ w90pc_mb">
                                <h4>Téléphone</h4>
                                <span class="info">Votre numéro de téléphone sera uniquement utilisé pour vous prévenir en cas de demande de rendez-vous. Il ne sera pas communiqué aux autres utilisateurs et ne sera en aucun cas utilisé dans une démarche commerciale.</span>
                                <div class="w410" style="margin-top: 15px;">
                                    <?php $this->view('fragment/verif_tel/vue_mentor'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: none;margin:60px 0">

                <div class="block_mn_compte">
                    <div class="mes_infos_compte">
                        <div class="blocktel">
                            <div class="title_label_ w90pc_mb langueparlee">
                                <h4>Renseignez vos langues</h4>
                                <span class="info">Indiquez dans quelle(s) langue(s) vous souhaitez correspondre</span>
                                <div class="cf">
                                    <span class="label_">Langue maternelle</span>
                                    <div class="selectbox" name="countrylangue1">
                                        <span class="selectchoice"></span>
                                        <ul>
                                            <li value="1">
                                                <img src="/assets/img/icons/drapeaux/france.png" alt="Français">Français
                                            </li>
                                            <li value="2">
                                                <img src="/assets/img/icons/drapeaux/royaume-uni.png" alt="Anglais">Anglais
                                            </li>
                                            <li value="5">
                                                <img src="/assets/img/icons/drapeaux/espagne.png" alt="Espagnol">Espagnol
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cf">
                                    <span class="label_">Deuxième langue</span>
                                    <div class="selectbox" name="countrylangue2">
                                        <span class="selectchoice"></span>
                                        <ul>
                                            <li value="">Choisir une langue</li>
                                            <li value="1">
                                                <img src="/assets/img/icons/drapeaux/france.png" alt="Français">Français
                                            </li>
                                            <li value="2">
                                                <img src="/assets/img/icons/drapeaux/royaume-uni.png" alt="Anglais">Anglais
                                            </li>
                                            <li value="5">
                                                <img src="/assets/img/icons/drapeaux/espagne.png" alt="Espagnol">Espagnol
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cf">
                                    <span class="label_">Troisième langue</span>
                                    <div class="selectbox" name="countrylangue3">
                                        <span class="selectchoice"></span>
                                        <ul>
                                            <li value="">Choisir une langue</li>
                                            <li value="1">
                                                <img src="/assets/img/icons/drapeaux/france.png" alt="Français">Français
                                            </li>
                                            <li value="2">
                                                <img src="/assets/img/icons/drapeaux/royaume-uni.png" alt="Anglais">Anglais
                                            </li>
                                            <li value="5">
                                                <img src="/assets/img/icons/drapeaux/espagne.png" alt="Espagnol">Espagnol
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: none;margin:60px 0">

                <div class="col-md-12 textarea_field">
                    <h4>Présentez vous en quelques lignes (optionnel)</h4>
                    <textarea name="description" id="" rows="14" placeholder="Présentez votre parcours et vos expertises professionnelles. Cela apparaîtra en tête de votre profil mentor."></textarea>
                </div>
            </div>


            <div class="row mgb_30 btn_add_cours text-right">
                <div class="col-md-12">
                    <p class="etap1_error" style="display:none;"></p>
                </div>
                <div class="col-md-12 mgb_30">
                    <button type="submit" onclick="submitForm('f_postmentor4'); return false;">Valider votre profil <i class="fa fa-angle-right"></i></button>
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
                <p class="text-chk"> Partagez notre page pour que chacun puisse trouver un Mentor dans son domaine! </p>
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

	function submitForm(f_name) {
		if ($('.btninprocess').hasClass('numvalid') == false) {
			$('.selectinputphone').addClass('errorvalue');
			bandeauError('Veuillez vérifier votre numéro de téléphone', false);
		} else {
			$('form[name="' + f_name + '"]').submit();
		}
	}

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
			} else {
				$(this).find('.check_disp').prop("checked", true);
			}
			$(this).toggleClass('active');
		});

	});

</script>