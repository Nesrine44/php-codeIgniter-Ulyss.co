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
<section class="hero_ccm bg_prof" style="background:url(<?php echo base_url(); ?>assets/img/bg_step_2.jpg) top center no-repeat ">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-hr">
                <h1 class="prof_img">
                    <img src="<?php echo $BusinessUser->getAvatar(); ?>" alt="">
                </h1>

                <p class="title_profl"><?php echo $BusinessUser->getFullName(); ?></p>
                <?php if (isset($lastExp)) { ?>
                    <span class="description_profil"><?php echo $lastExp->titre_mission . '<br />' . $lastExp->ent ?></span>
                <?php } ?>

                <?php if ($BusinessUser->getMentor()->countRecommandations() > 0) { ?>
                    <p class="stars_profl">
                        <i class="ion-thumbsup"></i> <span>(<?php echo $BusinessUser->getMentor()->countRecommandations(); ?>)</span>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="block_experience_mentor">
    <?php echo form_open('mentor/etape2Validation', ['id' => 'expform']) ?>
    <div class="mgb_30">
        <h1>RENSEIGNEZ VOS EXPERIENCES PROFESSIONNELLES :</h1><br> <input type="hidden" value="<?php echo $BusinessUser->getId(); ?>">
        <?php if (isset($all_exp) && is_array($all_exp) && $all_exp != 0) { ?>
        <?php foreach ($all_exp

        as $key => $Experience) { ?>
        <div id="exp_<?php echo $key ?>"><!--<p style="color: #3abee8; font-weight: bold"># </p>-->
            <input type="hidden" name="experience[<?php echo $key; ?>][id]" value="<?php echo $Experience->id ?>"/>
            <div class="row" style="width: 10px; float: right; margin-right: -10px">
                <button type="button" class="close" aria-label="Close" style="margin-right: 15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row" style="background-color: #afb9bc1f; padding: 25px;">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 mgb_30">Entreprise :&nbsp;
                            <input class="readonly_cursor" readonly name="entreprise[<?php echo $key ?>]" type="text" value="<?php echo $Experience->entreprise_nom ?>" placeholder="Nom de l'entreprise">
                            <input type="hidden" name="experience[<?php echo $key; ?>][entreprise_id]" value="<?php echo $Experience->entreprise_id ?>">
                            <label id="entreprise[<?php echo $key ?>]"> </label>
                        </div>
                        <div class="col-xs-12 col-md-6 mgb_30">
                            Poste: &nbsp;<?php if (isset($Experience->titre_mission) && $Experience->titre_mission != "") { ?>
                                <input class="readonly_cursor" readonly type="text" name="experience[<?php echo $key; ?>][titre_mission]" value="<?php echo $Experience->titre_mission ?>" style="width: 190px;">
                            <?php } else { ?>
                                <input type="text" name="experience[<?php echo $key; ?>][titre_mission]" value="" placeholder="Poste occupé" style="width: 190px;">
                            <?php } ?>
                            <label id="experience[<?php echo $key ?>][titre_mission]"> </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mgb_30" style="display: flex;">
                            <p>Secteur d'activité :</p>
                            <?php if (isset($chapeauTab) && is_array($chapeauTab)) { ?>
                                <select <?php echo $Experience->secteur_id != '' && $Experience->secteur_id != null ? 'disabled' : ''; ?> title="Secteur d'activité" id="dropdown_menu_<?php echo $key ?>" style="width: 285px" name="experience[<?php echo $key; ?>][secteur_id]">
                                    <option DISABLED <?php echo $Experience->secteur_id != '' && $Experience->secteur_id != null ? '' : 'SELECTED'; ?> value="">-- Sélectionnez le secteur d'activité --
                                    </option>
                                    <?php foreach ($chapeauTab as $chapeau => $secteurTab) { ?>
                                        <optgroup label="<?php echo $chapeau ?>">
                                            <?php foreach ($secteurTab as $sect_id => $secteurName) { ?>
                                                <option value="<?php echo $sect_id ?>" <?php echo $Experience->secteur_id == $sect_id ? 'SELECTED' : '' ?>>
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
                            <input class="styled" type="checkbox" id="aujourdhui_<?php echo $key ?>"/>J'occupe ce poste actuellement <br><br>
                            <div class="form-group"> <!-- Date input -->Début &nbsp;
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="ETAMonth" name="experience[<?php echo $key; ?>][date_debut_mois]" size="1">
                                            <option disabled>Mois</option>
                                            <?php
                                            foreach ($mois as $numMois => $nomMois) {
                                                $exist = isset($Experience->date_debut_mois) && $Experience->date_debut_mois != null && $Experience->date_debut_mois == $numMois ? "selected" : "";
                                                echo '<option ' . $exist . ' value="' . $numMois . '">' . $nomMois . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="year<?php echo $key; ?>" name="experience[1][date_debut_annee]">
                                            <option value="année" SELECTED disabled>Année</option>
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
                                    Fin
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select id="ETAMonth" name="experience[<?php echo $key; ?>][date_fin_mois]" size="1">
                                                <option SELECTED disabled>Mois</option>
                                                <?php
                                                foreach ($mois as $numMois => $nomMois) {
                                                    $exist = isset($Experience->date_fin_mois) && $Experience->date_fin_mois != null ? "selected" : "";
                                                    echo '<option ' . $exist . ' value="' . $numMois . '">' . $nomMois . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="year<?php echo $key; ?>" name="experience[1][date_fin_annee]">
                                                <option value="année" SELECTED disabled>Année</option>
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


                                    <label id="experience[<?php echo $key ?>][date_debut]" style="width: 50%;"> </label> <label id="experience[<?php echo $key ?>][date_fin]"> </label>
                                </div>
                                <!-- Form code ends -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Lieu :
                                &nbsp;<input class="api_geo" id="pac-input<?php echo $key; ?>" name="experience[<?php echo $key ?>][lieu]" type="text" placeholder="Ville"
                                    <?php echo $Experience->ville != null && $Experience->ville != "" ? 'value="' . $Experience->lieu . '"' : '' ?>
                                />

                                <input type="hidden" id="ville_<?php echo $key ?>" name="experience[<?php echo $key; ?>][ville]" required
                                    <?php echo $Experience->ville != null && $Experience->ville != "" ? 'value="' . $Experience->ville . '"' : '' ?>
                                />

                                <input type="hidden" id="departement_geo_<?php echo $key ?>" name="experience[<?php echo $key; ?>][departement_geo]"
                                    <?php echo $Experience->ville != null && $Experience->ville != "" ? 'value="' . $Experience->departement_geo . '"' : '' ?>
                                />

                                <input type="hidden" id="region_<?php echo $key ?>" name="experience[<?php echo $key; ?>][region]"
                                    <?php echo $Experience->ville != null && $Experience->ville != "" ? 'value="' . $Experience->region . '"' : '' ?>
                                />

                                <input type="hidden" id="pays_<?php echo $key ?>" name="experience[<?php echo $key; ?>][pays]"
                                    <?php echo $Experience->ville != null && $Experience->ville != "" ? 'value="' . $Experience->pays . '"' : '' ?>
                                />

                                <label id="experience[<?php echo $key ?>][ville]"> </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mgb_30">
                                Département professionnel :<br><br>
                                <?php if ($departements != null) {
                                    if (isset($Experience->departement_id)) { ?>
                                        <input type="radio" name="experience[<?php echo $key; ?>][departement_id]" value="<?php echo $Experience->departement_id ?>" required checked="checked">
                                        <span class="tag readonly_cursor blueDept"><?php echo $Experience->departement_nom ?></span>
                                    <?php } else { ?>
                                        <input type="button" class="voirplus" value="Voir plus">
                                        <?php foreach ($departements as $dept): ?>
                                            <label for="<?php echo $dept['id'] ?>" id="label<?php echo $dept['id'] ?>">
                                                <input id="<?php echo $dept['id'] ?>" type="radio" name="experience[<?php echo $key; ?>][departement_id]" value="<?php echo $dept['id'] ?>">
                                                <span class="tag  blueDept"><?php echo $dept['nom'] ?></span> </label>
                                        <?php endforeach;
                                    }
                                } ?>
                                <label id="experience[<?php echo $key ?>][departement_id]"> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><label id="experience[<?php echo $key ?>][description]"> </label>
                                <textarea name="experience[<?php echo $key ?>][description]" cols="30" rows="50" placeholder="Racontez nous votre expérience chez <?php echo $Experience->entreprise_nom ?> en tant que <?php echo $Experience->titre_mission ?> en quelques mots"><?php
                                    if (strlen($Experience->description) != 0 || $Experience->description != null) {
                                        echo $Experience->description;
                                    } ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php }
            } ?>

            <div id="exp_<?php echo $length_exp ?>">
                <!--<p id="num_exp_<?php /*echo $length_exp */ ?>" style="color: #3abee8; font-weight: bold"># <?php /*echo $num_exp */ ?></p>-->
                <div class="row" style="width: 10px; float: right; margin-right: -10px">
                    <button type="button" class="close" aria-label="Close" style="margin-right: 15px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row" style="background-color: #afb9bc1f; padding: 25px;">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-md-6 mgb_30">Entreprise :&nbsp;
                                <input type="text" name="entreprise[<?php echo $length_exp ?>]" id="entreprise_label_<?php echo $length_exp ?>" value="" placeholder="Nom de l'entreprise" autocomplete="off" class="TESSST">
                                <input class="cach" type="hidden" id="entreprise_id_<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][entreprise_id]" value="">
                                <div id="drop_list_exp" class="drop_list drop_list_e_<?php echo $length_exp ?>" style="display:none; margin-left: 75px">
                                    <ul id="entreprise_list_<?php echo $length_exp ?>" class="te"></ul>
                                </div>
                                <label id="entreprise[<?php echo $length_exp ?>]"> </label>
                            </div>
                            <div class="col-xs-12 col-md-6 mgb_30">
                                Poste:&nbsp;<input class="poste" type="text" name="experience[<?php echo $length_exp; ?>][titre_mission]" value="" placeholder="Poste occupé" style="width: 190px;">
                                <label id="experience[<?php echo $length_exp ?>][titre_mission]"> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mgb_30" style="display:flex ">
                                <p>Secteur d'activité :</p>
                                <?php if (isset($chapeauTab) && is_array($chapeauTab)) { ?>
                                    <select title="Secteur d'activité" id="dropdown_menu_<?php echo $length_exp ?>" style="width: 285px" name="experience[<?php echo $length_exp; ?>][secteur_id]">
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
                                <input type="checkbox" id="aujourdhui_<?php echo $length_exp ?>" style="display: initial; font-weight: 100px">J'occupe ce poste actuellement
                                <div class="form-group"> <!-- Date input -->Début
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select id="ETAMonth" name="experience[<?php echo $key; ?>][date_debut_mois]" size="1" value="<?php echo $Experience->date_debut ?>">
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
                                            <select id="year" name="experience[1][date_debut_annee]">
                                                <option value="année" SELECTED disabled>Année</option>
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
                                    <div id="divDateFin_">
                                        Fin
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select id="ETAMonth" name="experience[<?php echo $key; ?>][date_fin_mois]" size="1" value="<?php echo $Experience->date_debut ?>">
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
                                                <select id="year" name="experience[1][date_fin_annee]">
                                                    <option value="année" SELECTED disabled>Année</option>
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
                                    </div>
                                </div>
                                <!-- Form code ends -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Lieu : &nbsp;
                                <input class="api_geo" id="pac-input<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][lieu]" type="text" placeholder="Ville">
                                <input type="hidden" id="ville_<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][ville]" required/>

                                <input type="hidden" id="departement_geo_<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][departement_geo]"/>

                                <input type="hidden" id="region_<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][region]"/>

                                <input type="hidden" id="pays_<?php echo $length_exp ?>" name="experience[<?php echo $length_exp ?>][pays]"/>
                                <label id="experience[<?php echo $length_exp ?>][ville]"> </label>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mgb_30">
                                Département professionnel :<br><br>
                                <?php if ($departements != null) { ?>
                                    <input type="button" class="voirplus" value="Voir plus">
                                    <?php foreach ($departements as $dept): ?>
                                        <label for="dep<?php echo $dept['id'] ?>_<?php echo $length_exp ?>" id="label<?php echo $dept['id'] ?>">
                                            <input id="dep<?php echo $dept['id'] ?>_<?php echo $length_exp ?>" type="radio" name="experience[<?php echo $length_exp ?>][departement_id]" value="<?php echo $dept['id'] ?>">
                                            <span class="tag blueDept"><?php echo $dept['nom'] ?></span> </label>
                                    <?php endforeach;
                                } ?>
                                <label id="experience[<?php echo $length_exp ?>][departement_id]"> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label id="experience[<?php echo $length_exp ?>][description]"> </label>
                                <textarea name="experience[<?php echo $length_exp ?>][description]" cols="30" rows="50" placeholder="Racontez votre expérience en quelques mots"></textarea>

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
        <button type="submit" id="conf_info" class="nextStep">Étape 2/3 <i class="fa fa-angle-right"></i></button>
    </div>
</div>
</div>
<?php echo form_close() ?>
<script>

	$('input[name$="[date_fin]"]').each(function () {
		if ($(this).val() === '9999-12-31') {
			$(this).parent().find('#date_fin').val('');
		}
	});


	$("input[id^=aujourdhui_]").on('click', function () {
		if ($(this).is(":checked")) {
			$(this).parent().find('div[id^=divDateFin]').hide();
			$(this).parent().find('select[name$="[date_fin_mois]"]').val('12');
			$(this).parent().find('select[name$="[date_fin_annee]"]').val('9999');
		} else {
			$(this).parent().find('div[id^=divDateFin]').show();
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
		var $div = $('div[id^="exp_"]:last');
		// Read the Number from that DIV's ID (i.e: 3 from "exp_3")
		// And increment that number by 1
		var num = parseInt($div.prop("id").match(/\d+/g), 10);

		var newnum = num + 1;

		// Clone it and assign the new ID (i.e: from num 4 to ID "exp_4")
		var $klon = $div.clone().prop('id', 'exp_' + newnum);
		$klon.find('input[type="text"]').val("");
		$klon.find('input[type="hidden"]').val("");
		$klon.find('input[type="radio"]').prop("checked", false);
		$klon.find("textarea").val("").end().appendTo('.block_experience_mentor');
		$klon.find('#dropdownMenuButton').html('Sélectionnez le secteur d\'activité');
		$klon.find('input[id^="aujourdhui_"]').prop("checked", false);
		$klon.find('input[name$="[date_fin]"]').css({'display': 'inline-block'});
		$klon.find('.voirplus').on('click', function () {
			$(this.parentNode).find('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').toggleClass('hideDept');
		});

		$klon.find('label[for^="dep"]').each(function () {
			this.htmlFor = this.htmlFor.replace(/.$/, newnum);
		});


		//get nom du secteur et le remplace dans le btn
		$(function () {
			$klon.find('input[id^="sect_"]').click(function () {
				if ($(this).is(':checked')) {
					$($klon.find('#dropdownMenuButton')).html($klon.find('input[id^="sect_"]:checked').attr("class"));
				}
			});
		});

		$(document).ready(function () {
			var date_input = $('input[class="form-control"]'); //our date input has the name "date"
			var container  = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
			var options    = {
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
		//$klon.find('#num_exp_' + num)[0].id   = 'num_exp_' + newnum;
		//$klon.find('#num_exp_' + num)[0].text = '# ' + newnum++;

		$klon.find('label[id^="experience["]').each(function () {
			this.id = this.id.replace('[' + num + ']', '[' + newnum + ']');
			$(this).empty();
		});


		$klon.find('label[id^="entreprise["]').each(function () {
			this.id = this.id.replace('[' + num + ']', '[' + newnum + ']');
			$(this).empty();
		});

		$klon.find('input').each(function () {
			this.name = this.name.replace('[' + num + ']', '[' + newnum + ']');

			if (this.id == "entreprise_label_" + num) {
				this.id   = "entreprise_label_" + newnum;
				this.name = "entreprise[" + newnum + "]";
				this.addEventListener("keyup", list_ent);
				$(window).on('click', function () {
					$('#drop_list_exp').hide();
				})
			}


			if (this.id == "entreprise_id_" + num) {
				this.id = "entreprise_id_" + newnum;
			}
			if (this.id == "aujourdhui_" + num) {
				this.id = "aujourdhui_" + newnum;
			}
			if (this.id == "pac-input" + num) {
				this.id      = "pac-input" + newnum;
				autocomplete = new google.maps.places.Autocomplete(this, {types: ['(cities)']});
				autocomplete.addListener('place_changed', fillInAddress);
				autocomplete.inputId = this.id;
				autocompletes.push(autocomplete);
			}
			if (this.id == "ville_" + num) {
				this.id = "ville_" + newnum;
			}

			if (this.id == "departement_geo_" + num) {
				this.id = "departement_geo_" + newnum;
			}

			if (this.id == "region_" + num) {
				this.id = "region_" + newnum;
			}

			if (this.id == "pays_" + num) {
				this.id = "pays_" + newnum;
			}

			if (this.id.startsWith("dep")) {
				this.id = this.id.replace(/.$/, newnum);
			}

		});

		$klon.find('#drop_list_exp')[0].className = 'drop_list drop_list_e_' + newnum;

		$klon.find('#entreprise_list_' + num)[0].id = 'entreprise_list_' + newnum;


		$MenuL          = $klon.find('#dropdown_menu_' + num)[0];
		$MenuL.attr     = 'dropdown_menu_' + newnum;
		$MenuL.disabled = false;
		$MenuL.classList.remove("readonly_cursor");
		$MenuL.val = null;


		// Finally insert $klon
		$div.after($klon);
		$("#aujourdhui_" + newnum).on('click', function () {
			if ($(this).is(":checked")) {
				$(this).parent().find('div#divDateFin_').hide();
				$(this).parent().find('select[name$="[date_fin_mois]"]').val('12');
				$(this).parent().find('select[name$="[date_fin_annee]"]').val('9999');
			} else {
				$(this).parent().find('div#divDateFin_').show();
				$(this).parent().find('select[name$="[date_fin_mois]"]').val('');
				$(this).parent().find('select[name$="[date_fin_annee]"]').val('');
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
		var numinp = parseInt(this.inputId.match(/\d+/g), 10);
		var place  = this.getPlace();

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

		var numexp = parseInt(this.id.match(/\d+/g), 10);

		var $menutext = $("#dropdown_menu_" + numexp);

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
					var text = '<li class="auto_cat_e_' + numexp + '" item="' + element.value + '" item_id="' + element.id + '" item_sect_id="' + element.secteur_id + '" item_sect_name="' + element.secteur_nom + '" name="entrepriseName"><a><img src="' + element.logo + '" style="width:25px;height:25px; margin: 5px" border="0">' + element.value + '</a></li>';
					$("#entreprise_list_" + numexp).append(text);
				});

				$('li.auto_cat_e_' + numexp).click(function (event) {
					event.preventDefault();
					$("#entreprise_label_" + numexp).val($(this).attr('item'));
					$("#entreprise_id_" + numexp).val($(this).attr('item_id'));
					$(".drop_list_e_" + numexp).hide();
					var sect_id   = $(this).attr('item_sect_id');
					var sect_name = $(this).attr('item_sect_name');
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
		var date_input = $('input[class="form-control"]'); //our date input has the name "date"
		var container  = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
		var options    = {
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
			endDate: new Date(new Date().setDate(new Date().getDate())),
			language: 'fr',
		};
		date_input.datepicker(options);

		$("#conf_info").on('click', function () {
			var tab    = $("#expform").serializeJSON().experience;
			var tabent = $("#expform").serializeJSON().entreprise;
			$.ajax({
				url: base_url + "Mentor/etape2VerificationForm",
				type: "POST",
				cache: false,
				async: false,
				data: {experience: tab, entreprise: tabent, csrf_token_name: csrf_token},
				dataType: 'json',
				success: function (data) {
					if (data.valid_exp === false) {

						$.find('label[id^="experience["]').each(function () {
							$(this).empty();
						});

						$.each(data.errors, function (key, value) {
							$i = $('label[id="' + key + '"]');
							$i.append('<div class="error">' + value + '</div>');
						});

						var firstKey     = Object.keys(data.errors)[0];
						var el           = $('label[id="' + firstKey + '"]');
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
					} else if (data.valid_exp === true) {
						$('#expform').submit();
					}
				},
				error: function () {
					alert("Une erreur s'est produite, veuillez réessayer");
					return false;
				}
			});
			return false;
		});
	})
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer>
</script>