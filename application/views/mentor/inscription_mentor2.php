<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 27/11/2018
 * Time: 17:06
 */
/* @var $this CI_Loader
 * @var array        $departements
 * @var BusinessUser $BusinessUser
 * @var array        $all_exp
 * @var int          $length_exp
 * @var array        $dep
 * @var array        $chapeauTab
 * @var string       $num_exp
 * @var stdClass     $Experience
 * @var stdClass     $lastExp
 */
?>
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
<section class="block_experience_mentor">
    <?php echo form_open_multipart('inscription/insider-etape3', ['id' => 'expform']) ?>
    <div class="mgb_30">
        <h1>RENSEIGNEZ VOS EXPERIENCES PROFESSIONNELLES :</h1> <br>

        <div id="exp_1">
            <!--<p id="num_exp_<?php /*echo $length_exp */ ?>" style="color: #3abee8; font-weight: bold"># <?php /*echo $num_exp */ ?></p>-->
            <div class="row" style="width: 10px; float: right; margin-right: -10px">
                <button type="button" class="close" aria-label="Close" style="margin-right: 15px ">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row" style="background-color: #afb9bc1f; padding: 25px;">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mgb_30">Entreprise :&nbsp;
                            <label id="entreprise[1]"> </label>

                            <input type="text" name="entreprise[1]" id="entreprise_label_1" value="" placeholder="Nom de l'entreprise" autocomplete="off">
                            <input class="cach" type="hidden" id="entreprise_id_1" name="experience[1][entreprise_id]" value="">
                            <div id="drop_list_exp" class="drop_list drop_list_e_1" style="display:none; margin-left: 75px">
                                <ul id="entreprise_list_1" class="te"></ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 mgb_30">
                            Poste:&nbsp;
                            <label id="experience[1][titre_mission]"> </label>

                            <input class="poste" type="text" name="experience[1][titre_mission]" value="" placeholder="Poste occupé" style="width: 170px;">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mgb_30" style="display:flex">
                            Secteur d'activité :&nbsp;

                            <label id="experience[1][secteur_id]" style="display: block"> </label>
                            <?php if (isset($chapeauTab) && is_array($chapeauTab)) { ?>
                                <select title="Secteur d'activité" id="dropdown_menu_1" style="width: 285px" name="experience[1][secteur_id]">
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
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Form code begins -->
                            <input type="checkbox" id="aujourdhui_1" style="display: initial; font-weight: 100px">J'occupe ce poste actuellement <br><br>
                            <div class="form-group"> <!-- Date input -->Début &nbsp;
                                <div class="row">
                                    <div class="col-md-6">
                                        <label id="experience[1][date_debut_mois]" style="display: block"> </label>

                                        <select id="DateDebutMois_1" name="experience[1][date_debut_mois]" size="1">
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
                                        <label id="experience[1][date_debut_annee]" style="display: block"> </label>

                                        <select id="DateDebutAnnee_1" name="experience[1][date_debut_annee]">
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
                                <div id="divDateFin_1">
                                    Fin &nbsp;
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label id="experience[1][date_fin_mois]" style="display: block"> </label>

                                            <select id="DateFinMois_1" name="experience[1][date_fin_mois]" size="1">
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
                                            <label id="experience[1][date_fin_annee]" style="display: block"> </label>

                                            <select id="DateFinAnnee_1" name="experience[1][date_fin_annee]">
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
                            </div>
                            <!-- Form code ends -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Lieu : &nbsp;<br> <label id="experience[1][ville]"> </label>

                            <input class="api_geo" id="pac-input1" name="experience[1][lieu]" type="text" placeholder="Ville"> <input type="hidden" id="ville_1" name="experience[1][ville]" required/>

                            <input type="hidden" id="departement_geo_1" name="experience[1][departement_geo]"/>

                            <input type="hidden" id="region_1" name="experience[1][region]"/>

                            <input type="hidden" id="pays_1" name="experience[1][pays]"/>


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 mgb_30">

                            Département professionnel :<br><br> <label id="experience[1][departement_id]"> </label>

                            <?php if ($departements != null) { ?>
                                <input type="button" class="voirplus" value="Voir plus">
                                <?php foreach ($departements as $dept): ?>
                                    <label for="dep<?php echo $dept['id'] ?>_1" id="label<?php echo $dept['id'] ?>">
                                        <input id="dep<?php echo $dept['id'] ?>_1" type="radio" name="experience[1][departement_id]" value="<?php echo $dept['id'] ?>">
                                        <span class="tag blueDept"><?php echo $dept['nom'] ?></span> </label>
                                <?php endforeach;
                            } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label id="experience[1][description]"> </label>
                            <textarea id="desc_1" name="experience[1][description]" cols="30" rows="50" placeholder="Racontez votre expérience en quelques mots"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>

    </div>
</section>
<input type="button" class="addXp" value="+ Ajouter une expérience">
<div class="row">
    <div class="col-md-12 mgb_30">
        <input type="submit" id="conf_info" value="Étape 2/3" class="nextStep">
    </div>
</div>
<?php echo form_close() ?>
<script>
	$('input[name$="[date_fin]"]').each(function () {
		if ($(this).val() === '9999-12-31') {
			$(this).parent().find('#date_fin').val('');
		}
	});

	$("#aujourdhui_1").on('click', function () {
		if ($("#aujourdhui_1").is(":checked")) {
			$(this).parent().find('div#divDateFin_1').hide();
			$(this).parent().find('select[name$="[date_fin_mois]"]').val('12');
			$(this).parent().find('select[name$="[date_fin_annee]"]').val('9999');
		} else {
			$(this).parent().find('div#divDateFin_1').show();
			$(this).parent().find('select[name$="[date_fin_mois]"]').val('0');
			$(this).parent().find('select[name$="[date_fin_annee]"]').val('0');
		}
	});


	$firstLabel = $('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').addClass("hideDept");
	$('.voirplus').on('click', function () {
		$(this.parentNode).find('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').toggleClass('hideDept');
	});

	let input_recherche = $(document).find('input[id^="entreprise_label_"]');
	let autocomplete, geocoder;
	let autocompletes   = [];


	input_recherche.each(function () {
		this.addEventListener("keyup", list_ent);
		$(window).on('click', function () {
			$('#drop_list_exp').hide();

		})
	});


	$('.addXp').click(function () {

		// get the last DIV which ID starts with ^= "exp_"
		let divenum = $('div[id^="exp_"]:last');
		// Read the Number from that DIV's ID (i.e: 3 from "exp_3")
		// And increment that number by 1
		let num = parseInt(divenum.prop("id").match(/\d+/g), 10);

		let newnum = num + 1;

		// get the last DIV which ID starts with ^= "exp_"
		let divexp = $('div[id="exp_1"]');


		// Clone it and assign the new ID (i.e: from num 4 to ID "exp_4")
		let koln = divexp.clone().prop('id', 'exp_' + newnum);
		koln.find('input[type="text"]').val("");
		koln.find('input[type="hidden"]').val("");
		koln.find('input[type="radio"]').prop("checked", false);
		koln.find("textarea").val("").end().appendTo('.block_experience_mentor');
		koln.find('#dropdownMenuButton').html('Sélectionnez le secteur d\'activité');
		koln.find('input[id^="aujourdhui_"]').prop("checked", false);
		koln.find('input[name$="[date_fin]"]').css({'display': 'inline-block'});
		koln.find('.voirplus').on('click', function () {
			$(this.parentNode).find('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').toggleClass('hideDept');
		});

		koln.find('label[for^="dep"]').each(function () {
			this.htmlFor = this.htmlFor.replace(/.$/, newnum);
		});

		//get nom du secteur et le remplace dans le btn
		$(function () {
			koln.find('input[id^="sect_"]').click(function () {
				if ($(this).is(':checked')) {
					$(koln.find('#dropdownMenuButton')).html(koln.find('input[id^="sect_"]:checked').attr("class"));
				}
			});
		});

		$(document).ready(function () {
			let date_input = $('input[class="form-control"]'); //our date input has the name "date"
			let container  = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
			let options    = {
				format: 'yyyy-mm-dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
				endDate: new Date(new Date().setDate(new Date().getDate())),
				language: 'fr',
			};
			date_input.datepicker(options);
		});

		// a regler
		//koln.find('#num_exp_' + num)[0].id   = 'num_exp_' + newnum;
		//koln.find('#num_exp_' + num)[0].text = '# ' + newnum++;

		koln.find('label[id^="experience[1]"]').each(function () {
			this.id = this.id.replace('[1]', '[' + newnum + ']');
			$(this).empty();
		});


		koln.find('label[id^="entreprise["]').each(function () {
			this.id = this.id.replace('[1]', '[' + newnum + ']');
			$(this).empty();
		});

        /*		koln.find('select[id="dropdown_menu_1"]').each(function () {
         this.id   = "dropdown_menu_" + newnum;
         this.name = "experience[" + newnum + "][secteur_id]";
         });*/

		koln.find('input').each(function () {
			this.name = this.name.replace('[1]', '[' + newnum + ']');

			if (this.id == "entreprise_label_1") {
				this.id   = "entreprise_label_" + newnum;
				this.name = "entreprise[" + newnum + "]";
				this.addEventListener("keyup", list_ent);
				$('.poste').on('click', function () {
					$('#drop_list_exp').hide();
				})
			}


			if (this.id == "entreprise_id_1") {
				this.id = "entreprise_id_" + newnum;
			}
			if (this.id == "aujourdhui_1") {
				this.id = "aujourdhui_" + newnum;
			}
			if (this.id == "pac-input1") {
				this.id      = "pac-input" + newnum;
				autocomplete = new google.maps.places.Autocomplete(this, {types: ['(cities)']});
				autocomplete.addListener('place_changed', fillInAddress);
				autocomplete.inputId = this.id;
				autocompletes.push(autocomplete);
			}
			if (this.id == "ville_1") {
				this.id = "ville_" + newnum;
			}

			if (this.id == "departement_geo_1") {
				this.id = "departement_geo_" + newnum;
			}

			if (this.id == "region_1") {
				this.id = "region_" + newnum;
			}

			if (this.id == "pays_1") {
				this.id = "pays_" + newnum;
			}

			if (this.id.startsWith("dep")) {
				this.id = this.id.replace(/.$/, newnum);
			}
		});

		koln.find('#drop_list_exp')[0].className = 'drop_list drop_list_e_' + newnum;
		koln.find('#entreprise_list_1')[0].id    = 'entreprise_list_' + newnum;


		$DivDateFin       = koln.find('div#divDateFin_1');
		$DivDateFin[0].id = 'divDateFin_' + newnum;
		$DivDateFin.show();

		$MenuL          = koln.find('#dropdown_menu_1')[0];
		$MenuL.id       = "dropdown_menu_" + newnum;
		$MenuL.name     = "experience[" + newnum + "][secteur_id]";
		$MenuL.disabled = false;
		$MenuL.classList.remove("readonly_cursor");
		$MenuL.val = null;

		$DateDebutMois      = koln.find('#DateDebutMois_1')[0];
		$DateDebutMois.id   = "DateDebutMois_" + newnum;
		$DateDebutMois.name = "experience[" + newnum + "][date_debut_mois]";
		$DateDebutMois.val  = 0;

		$DateDebutAnnee      = koln.find('#DateDebutAnnee_1')[0];
		$DateDebutAnnee.id   = "DateDebutAnnee_" + newnum;
		$DateDebutAnnee.name = "experience[" + newnum + "][date_debut_annee]";
		$DateDebutAnnee.val  = 0;

		$DateFinMois      = koln.find('#DateFinMois_1')[0];
		$DateFinMois.id   = "DateFinMois_" + newnum;
		$DateFinMois.name = "experience[" + newnum + "][date_fin_mois]";
		$DateFinMois.val  = 0;

		$DateFinAnnee      = koln.find('#DateFinAnnee_1')[0];
		$DateFinAnnee.id   = "DateFinAnnee_" + newnum;
		$DateFinAnnee.name = "experience[" + newnum + "][date_fin_annee]";
		$DateFinAnnee.val  = 0;

		$TextareaDescription      = koln.find('#desc_1')[0];
		$TextareaDescription.id   = "desc_" + newnum;
		$TextareaDescription.name = "experience[" + newnum + "][description]";
		$TextareaDescription.val  = '';


		// Finally insert koln
		divenum.after(koln);

		$("#aujourdhui_" + newnum).on('click', function () {
			if ($("#aujourdhui_" + newnum).is(":checked")) {
				$(this).parent().find('div#divDateFin_' + newnum).hide();
				$(this).parent().find('select[name$="[date_fin_mois]"]').val('12');
				$(this).parent().find('select[name$="[date_fin_annee]"]').val('9999');
			} else {
				$(this).parent().find('div#divDateFin_' + newnum).show();
				$(this).parent().find('select[name$="[date_fin_mois]"]').val('0');
				$(this).parent().find('select[name$="[date_fin_annee]"]').val('0');
			}
		});
	});


	//Fermeture des EXP
	$(document).on('click', ".close", function (e) {
		e.preventDefault();
		$(this).closest('[id^="exp_"]').remove();
	});
	//FIN Fermeture des EXP
	//Get secteur on mobile
	if (jQuery.browser.mobile) {
		$('.dropdown-item').on('click', function (e) {
			e.preventDefault();
			$('.dropdown-item').children().toggleClass("showSect")
		});
	}

	function initAutocomplete() {

		geocoder = new google.maps.Geocoder();

		let mapFields = document.getElementsByClassName('api_geo');


		for (let i = 0; i < mapFields.length; i++) {
			let input            = mapFields[i];
			autocomplete         = new google.maps.places.Autocomplete(input, {types: ['(cities)']});
			autocomplete.inputId = input.id;
			autocomplete.addListener('place_changed', fillInAddress);
			autocompletes.push(autocomplete);
		}
	}

	function fillInAddress() {
		let numinp = parseInt(this.inputId.match(/\d+/g), 10);
		let place  = this.getPlace();

		place.address_components.forEach(function (element) {
			switch (element.types[0]) {
				case 'locality':
					document.getElementById('ville_' + numinp).setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_2':
					document.getElementById('departement_geo_' + numinp).setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_1':
					document.getElementById('region_' + numinp).setAttribute("value", element.long_name);
					break;
				case 'country':
					document.getElementById('pays_' + numinp).setAttribute("value", element.long_name);
					break;
				default:
					break;
			}
		});
	}


    /*entreprise liste employeur*/
	function list_ent() {

		let numexp = parseInt(this.id.match(/\d+/g), 10);

		let $menutext = $("#dropdown_menu_" + numexp);

		$menutext.attr("disabled", false);
		$menutext.removeClass("readonly_cursor");
		$menutext.val(null);


		if ($(this).val().length < 3) {
			$('.drop_list.drop_list_e_' + numexp).hide();
			return false;
		}
		$('').click(function () {
			$('#drop_list_exp').clone();
		});
		$("#entreprise_id_" + numexp).val(null);
		$(".drop_list_e_" + numexp).show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/entrepriseAvanced",
			data: 'entreprise=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#entreprise_list_" + numexp).html("Chargement...");
			},
			success: function (data) {

				$("#entreprise_list_" + numexp).html("");

				if (data.length == 0) {
					$('.drop_list.drop_list_e_' + numexp).hide();
				}

				$.each(data, function (index, element) {
					let text = '<li class="auto_cat_e_' + numexp + '" item="' + element.value + '" item_id="' + element.id + '" item_sect_id="' + element.secteur_id + '" item_sect_name="' + element.secteur_nom + '" name="entrepriseName"><a><img src="' + element.logo + '" style="width:25px;height:25px; margin: 5px" border="0">' + element.value + '</a></li>';
					$("#entreprise_list_" + numexp).append(text);
				});

				$('li.auto_cat_e_' + numexp).click(function (event) {
					event.preventDefault();
					$("#entreprise_label_" + numexp).val($(this).attr('item'));
					$("#entreprise_id_" + numexp).val($(this).attr('item_id'));
					$(".drop_list_e_" + numexp).hide();
					let sect_id   = $(this).attr('item_sect_id');
					let sect_name = $(this).attr('item_sect_name');
					if (sect_id !== "undefined" && sect_name !== "undefined") {
						$menutext.val(sect_id);
						$menutext.attr("disabled", true);
						$menutext.addClass('readonly_cursor');
					}
				});
			}
		});
	}
</script>

<script>
	//get nom du secteur et le remplace dans le btn
	$(function () {
		$('input[id^="sect_"]').click(function () {
			if ($(this).is(':checked')) {
				$('button[id^="dropdownMenuButton"]').html($('input[id^="sect_"]:checked').attr("class"));
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {
		let date_input = $('input[class="form-control"]'); //our date input has the name "date"
		let container  = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
		let options    = {
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
			endDate: new Date(new Date().setDate(new Date().getDate())),
			language: 'fr',
		};
		date_input.datepicker(options);

		$("#expform").submit(function (event) {

			$allListSelectDisabled = $(document).find('select[id^="dropdown_menu_"]:disabled');
			$allListSelectDisabled.each(function () {
				this.disabled = false;
			});

			let tab    = $("#expform").serializeJSON().experience;
			let tabent = $("#expform").serializeJSON().entreprise;


			$.ajax({
				url: base_url + "Mentor/etape2VerificationForm",
				type: "POST",
				cache: false,
				async: false,
				data: {experience: tab, entreprise: tabent, csrf_token_name: csrf_token},
				dataType: 'json',
				success: function (data) {
					if (data.valid_exp === false) {

						$(document).find('label[id^="experience["]').each(function () {
							$(this).empty();
						});

						$(document).find('label[id^="entreprise["]').each(function () {
							$(this).empty();
						});

						$.each(data.errors, function (key, value) {
							$i = $('label[id="' + key + '"]');
							$i.append('<div class="error">' + value + '</div>');
						});

						$allListSelectDisabled.each(function () {
							this.disabled = true;
						});

						let firstKey     = Object.keys(data.errors)[0];
						let el           = $('label[id="' + firstKey + '"]');
						let elOffset     = el.offset().top;
						let elHeight     = el.height();
						let windowHeight = $(window).height();
						let offset;

						if (elHeight < windowHeight) {
							offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
						} else {
							offset = elOffset;
						}
						let speed = 700;
						$('html, body').animate({scrollTop: offset}, speed);
						event.preventDefault();
					}
				},
				error: function () {
					alert("Une erreur s'est produite, veuillez réessayer");
					event.preventDefault();
				}
			});
		});
	})
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer>
</script>