<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 06/02/2019
 * Time: 15:32
 * /* @var $this CI_Loader
 *
 * @var array        $departements
 * @var BusinessUser $BusinessUser
 * @var array        $all_exp
 * @var int          $length_exp
 * @var array        $dep
 * @var array        $chapeauTab
 * @var string       $num_exp
 * @var stdClass     $Experience
 * @var array        $user
 */ ?>
<div class="row" style="height: 230px; width: 100%; background-image: url('/assets/img/bg_step_2.jpg'); margin: auto">
    <div class="col-xs-12 col-md-12" style="height: 100%; padding: 80px;">
        <?php if ($this->getController()->userIsAuthentificate()) { ?>
            <div class="avatarHeader" style="background-image: url('<?php echo $this->getController()->getBusinessUser()->getAvatar() != '' ? $this->getController()->getBusinessUser()->getAvatar() : '/upload/avatar/default.jpg' ?>')"></div>
        <?php } else { ?>
            <div class="avatarHeader" style="background-image: url('<?php echo isset($user['avatar']) && $user['avatar'] != $user['avatar'] ? '/upload/avatar/temp/' . $user['avatar'] : '/upload/avatar/default.jpg' ?>')"></div>
        <?php } ?>
        <div class="nameHead"><?php echo $user['nom'] . ' ' . $user['prenom'] ?></div>
    </div>
</div>
<div class="container_inscrip xp mgb_30">
    <h1>VEUILLEZ RENSEIGNER VOTRE EXPERIENCE ACTUELLE</h1>
    <?php echo form_open('register_done', 'autocomplete="off" id="first_time_step2_form"') ?>
    <div>
        <label for="noXp" style="display: inline-flex; font-weight: 500;">

            <input id="noXp" name="no_xp" type="checkbox"> Je n'ai pas d'expérience </label>
    </div>
    <div class="row blocXp mgb_15" style="background-color: #afb9bc1f; padding: 25px;box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.16);">
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <input type="text" name="entreprise" id="entreprise_insc" value="" placeholder="Nom de l'entreprise" autocomplete="off" class="inputText">
                    <input class="cach" type="hidden" id="entreprise_id" name="entreprise_id" value="">
                    <div id="drop_list_exp" class="drop_list drop_list_e" style="display:none;">
                        <ul id="entreprise_list"></ul>
                    </div>
                    <label id="error_entreprise"> </label>
                </div>
                <div class="col-xs-12 col-md-6">
                    <input class="inputText" type="text" name="titre_mission" value="" placeholder="Poste occupé"> <label id="error_titre_mission"> </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mgb_30" style="display:flex ">
                    <?php if (isset($chapeauTab) && is_array($chapeauTab)) { ?>
                        <select class="inputText" title="Secteur d'activité" id="sect_insc" name="secteur_id">
                            <option DISABLED SELECTED value="">-- Sélectionnez le secteur d'activité --</option>
                            <?php foreach ($chapeauTab as $chapeau => $secteurTab) { ?>
                                <optgroup label="<?php echo $chapeau ?>">
                                    <?php foreach ($secteurTab as $sect_id => $secteurName) { ?>
                                        <option value="<?php echo $sect_id ?>">
                                            <?php echo $secteurName ?>
                                        </option> <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <label id="error_secteur_id"> </label>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="checkbox" id="aujourdhui" style="display: initial; font-weight: 100px">J'occupe ce poste actuellement <br><br>
                    <!-- Form code begins -->Début
                    <div class="row">
                        <div class="col-md-6">
                            <label id="error_date_debut_mois" style="display: block"> </label>

                            <select id="DateDebutMois" name="date_debut_mois" size="1">
                                <option value="0" SELECTED disabled>Mois</option>
                                <option value="01">Janvier</option>
                                <option value="02">Février</option>
                                <option value="03">Mars</option>
                                <option value="04">Avril</option>
                                <option value="05">Mai</option>
                                <option value="06">Juin</option>
                                <option value="07">Juillet</option>
                                <option value="08">Août</option>
                                <option value="09">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label id="error_date_debut_annee" style="display: block"> </label>

                            <select id="DateDebutAnnee" name="date_debut_annee">
                                <option value="0" SELECTED disabled>Année</option>
                                <script>
									var myDate = new Date();
									var year   = myDate.getFullYear();
									for (var i = 1980; i < year + 1; i++) {
										document.write('<option value="' + i + '">' + i + '</option>');
									}
                                </script>
                            </select>
                        </div>

                    </div>
                    <div id="divDateFin">
                        Fin &nbsp;
                        <div class="row">
                            <div class="col-md-6">
                                <label id="error_date_fin_mois" style="display: block"> </label>

                                <select id="DateFinMois" name="date_fin_mois" size="1">
                                    <option value="0" SELECTED disabled>Mois</option>
                                    <option value="01">Janvier</option>
                                    <option value="02">Février</option>
                                    <option value="03">Mars</option>
                                    <option value="04">Avril</option>
                                    <option value="05">Mai</option>
                                    <option value="06">Juin</option>
                                    <option value="07">Juillet</option>
                                    <option value="08">Août</option>
                                    <option value="09">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                    <option value="12">Décembre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label id="error_date_fin_annee" style="display: block"> </label>

                                <select id="DateFinAnnee" name="date_fin_annee">
                                    <option value="0" SELECTED disabled>Année</option>
                                    <script>
										var myDate = new Date();
										var year   = myDate.getFullYear();
										for (var i = 1980; i < year + 1; i++) {
											document.write('<option value="' + i + '">' + i + '</option>');
										}
                                    </script>
                                    <option value="9999" hidden></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Form code ends -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    Lieu : &nbsp;
                    <input class="api_geo inputText" id="pac-input" name="lieu" type="text" placeholder="Ville">

                    <input type="hidden" id="ville" name="ville" required/>

                    <input type="hidden" id="departement_geo" name="departement_geo"/>

                    <input type="hidden" id="region" name="region"/>

                    <input type="hidden" id="pays" name="pays"/>

                    <label id="error_ville"> </label>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 mgb_30">
                    <div class="candidatDept">
                        Veuillez choisir une fonction : <br><br>
                        <?php if ($departements != null) {
                            foreach ($departements as $dept): ?>
                                <label for="<?php echo $dept['id'] ?>" id="label<?php echo $dept['id'] ?>">
                                    <input id="<?php echo $dept['id'] ?>" class="inputHide" type="radio" name="departement_id" value="<?php echo $dept['id'] ?>" required>
                                    <span class="tag blueDept"><?php echo $dept['nom'] ?></span> </label>
                            <?php endforeach;
                        } ?>
                    </div>
                    <label id="error_departement_id"> </label>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" value="Valider mes expériences" id="insc_etape2" class="nextStep">
    <?php echo form_close() ?>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer>
</script>
<!-- Erreur if checkbox not checked-->
<script>
	$("#aujourdhui").on('click', function () {
		if ($("#aujourdhui").is(":checked")) {
			$(this).parent().find('div#divDateFin').hide();
			$(this).parent().find('select[name$="[date_fin_mois]"]').val('12');
			$(this).parent().find('select[name$="[date_fin_annee]"]').val('9999');
		} else {
			$(this).parent().find('div#divDateFin').show();
			$(this).parent().find('select[name$="[date_fin_mois]"]').val('0');
			$(this).parent().find('select[name$="[date_fin_annee]"]').val('0');
		}
	});
    /*  entreprise list*/
	$("#entreprise_insc").on('click keyup', function () {
		let $depInsc = $("#sect_insc");
		$depInsc.attr("disabled", false);
		$depInsc.removeClass("readonly_cursor");
		$depInsc.val(null);

		if ($(this).val().length < 3) {
			$('.drop_list.drop_list_e').hide();
			return false;
		}

		$("#entreprise_id").val(0);
		$(".drop_list_e").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/entreprise",
			data: 'entreprise=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#entreprise_list").html("Chargement...");
			},
			success: function (data) {
				$("#entreprise_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#entreprise_list").append(text);
				}

				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_e" item="' + element.value + '" item_id="' + element.id + '" item_sect_id="' + element.secteur_id + '" item_sect_name="' + element.secteur_nom + '" name="entrepriseName"><a><img src="' + element.logo + '" style="width:25px;height:25px; margin: 5px" border="0">' + element.value + '</a></li>';
					$("#entreprise_list").append(text);
				});

				$('li.auto_cat_e').click(function (event) {
					event.preventDefault();
					$("#entreprise_insc").val($(this).text());
					$("#entreprise_id").val($(this).attr('item_id'));
					$(".drop_list_e").hide();
					let sect_id_search   = $(this).attr('item_sect_id');
					let sect_name_search = $(this).attr('item_sect_name');
					if (sect_id_search !== "undefined" && sect_name_search !== "undefined") {
						$depInsc.val(sect_id_search);
						$depInsc.attr("disabled", true);
						$depInsc.addClass('readonly_cursor');
					}
				});


			}
		})
	});

	$('#insc_etape2').on('click', function () {
		let sect     = $('#sect_insc');
		let rollback = false;

		if (sect.is(':disabled')) {
			sect.attr("disabled", false);
			rollback = true;
		}

		if ($('#noXp:checked').val() == undefined) {
			$.ajax({
				url: base_url + "inscription/InscriptionStep2Verification",
				type: "POST",
				cache: false,
				async: false,
				data: $("#first_time_step2_form").serialize(),
				dataType: 'json',
				success: function (data) {
					if (data.valid_info === false) {
						if (rollback === true) {
							sect.attr("disabled", true);
						}

						$(document).find('label[id^="error_"]').each(function () {
							$(this).empty();
						});

						$.each(data.errors, function (key, value) {
							$i = $('label[id="error_' + key + '"]');
							$i.append('<div class="error">' + value + '</div>');
						});

						var firstKey     = Object.keys(data.errors)[0];
						var el           = $('label[id="error_' + firstKey + '"]');
						var elOffset     = el.offset().top;
						var elHeight     = el.height();
						var windowHeight = $(window).height();
						var offset;

						if (elHeight < windowHeight) {
							offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
						} else {
							offset = elOffset;
						}
						var speed = 700;
						$('html, body').animate({scrollTop: offset}, speed);
						return false;
					} else if (data.valid_info === true) {
						$('#first_time_step2_form').submit();
					}
				},
				error: function () {
					if (rollback === true) {
						sect.attr("disabled", true);
					}
					alert("Une erreur s'est produite, veuillez nous avertir immédiatement");
					return false;
				}
			});
			return false;
		} else {
			$('#first_time_step2_form').submit();
		}
		return false;
	});
</script>
<script>
	$('.form-control').datepicker({});

	$('input[name$="[date_fin]"]').each(function () {
		if ($(this).val() === '9999-12-31') {
			$(this).parent().find('#date_fin').val('');
		}
	});


	$('input[id^="aujourdhui"]').on('click', function () {
		if ($('input[id^="aujourdhui"]').is(":checked")) {
			$(this).parent().find('input[name="date_fin"]').hide();
			$(this).parent().find('input[name="date_fin"]').val('9999-12-31');
		} else {
			$(this).parent().find('input[name="date_fin"]').show();
			$(this).parent().find('input[name="date_fin"]').val('');
		}
	});
</script>

<script>
	function initAutocomplete() {

		geocoder = new google.maps.Geocoder();

		var mapFields = document.getElementsByClassName('api_geo');


		for (let i = 0; i < mapFields.length; i++) {
			let input            = mapFields[i];
			autocomplete         = new google.maps.places.Autocomplete(input, {types: ['(cities)']});
			autocomplete.inputId = input.id;
			autocomplete.addListener('place_changed', fillInAddress);
			autocompletes.push(autocomplete);
		}
	}

	function fillInAddress() {

		var place = this.getPlace();

		place.address_components.forEach(function (element) {
			switch (element.types[0]) {
				case 'locality':
					document.getElementById('ville').setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_2':
					document.getElementById('departement_geo').setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_1':
					document.getElementById('region').setAttribute("value", element.long_name);
					break;
				case 'country':
					document.getElementById('pays').setAttribute("value", element.long_name);
					break;
				default:
					break;
			}
		});
	}


</script>

<script>
	// if "je n'ai pas xp" checked hide form
	$('#noXp').change(function () {
		if ($(this).prop("checked")) {
			$('.blocXp').hide();
		} else {
			$('.blocXp').show();
		}
	});
	// Ajout d'XP
	$('.addXp').on('click', function () {
		$('.blocXp').toggle('slow')
	})
</script>