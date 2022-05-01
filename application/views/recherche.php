<?php
/* @var array $mentors
 * @var StdClass     $mentor
 * @var int          $mentors_count
 * @var BusinessUser $BusinessUser
 * @var array        $randomMentors
 */
$count = 0;
?>
<section class="hero_home bg_recherche pagesearch">
    <div class="search_container">
        <div class="container ">
            <!-- on desktop -->
            <div class="row">
                <div class="col-md-12">
                    <div class="search_container">
                        <div class="container">
                            <!-- on desktop  -->
                            <div class="row hidden-xs">
                                <div class="col-md-12 search_row">
                                    <?php echo form_open('', 'class="row dfd" autocomplete="off" id="formHomesearch" ') ?>
                                    <div class="col-md-2 col-sm-12">
                                        <input type="text" id="entreprise" name="entrepriselabel" placeholder="Nom de l'entreprise">
                                    </div>
                                    <div class="col-md-2">
                                        <?php if (isset($chapeauTab) && is_array($chapeauTab)) { ?>
                                            <select title="Secteur d'activité" id="search_secteur" name="secteur">
                                                <option SELECTED value="">-- Secteur d'activité --</option>
                                                <?php foreach ($chapeauTab as $Chapeau) { ?>
                                                    <option value="<?php echo $Chapeau['id'] ?>"><?php echo $Chapeau['nom_chapeau'] ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                    <?php if ($this->getController()->userIsAuthentificate()) {
                                        $depUser = $BusinessUser->getProfileTalent()->getDepartementId();
                                    } ?>
                                    <div class="col-md-2">
                                        <select id="search_departement" name="departement" class="required secteur">
                                            <option SELECTED value=""> -- Métier --</option>
                                            <?php if ($this->getController()->userIsAuthentificate()) {
                                                foreach ($categories as $cat): ?>
                                                    <option value="<?php echo $cat->id ?>" <?php echo isset($depUser) && $cat->id == $depUser ? ' SELECTED ' : '' ?> ><?php echo $cat->nom; ?></option>
                                                <?php endforeach;
                                            } else {
                                                foreach ($categories as $cat): ?>
                                                    <option value="<?php echo $cat->id ?>"><?php echo $cat->nom; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select> <i class="fa fa-chevron-down"></i>
                                    </div>
                                    <div class=" col-md-2">
                                        <input class="api_geo" name="region" id="search_Region" type="text" placeholder="Ville / Région / Pays">
                                    </div>
                                    <?php echo form_close() ?>
                                    <div class="col-md-2 col-md-offset-8" style="position: absolute; margin-top: -50px">
                                        <button class="filters_btn"><i class="ion-android-options"></i>&nbsp; &nbsp;Filtres</button>
                                        <div class="filters">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end desktop  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section><!-- end hero home -->
<section class="mostSearch">
    <div class="row">
        <h2>Recherches fréquentes</h2>
        <div class="col-md-4">
            <h3>Secteurs</h3>
            <ul>
                <li class="sectClick" value="1">Banques / Assurances></li>
                <li class="sectClick" value="3">Distribution &nbsp;></li>
                <li class="sectClick" value="7">Services &nbsp;></li>
                <li class="sectClick" value="6">Informatique / Télécom &nbsp;></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Métiers</h3>
            <ul>
                <li class="depClick" value="10">IT - Tech &nbsp;></li>
                <li class="depClick" value="3">Commercial &nbsp;></li>
                <li class="depClick" value="5">Conseil &nbsp;></li>
                <li class="depClick" value="13">Marketing &nbsp;></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Localisation</h3>
            <ul>
                <li class="geoClick" id="Paris">Paris &nbsp;></li>
                <li class="geoClick" id="Marseille">Marseille &nbsp;></li>
                <li class="geoClick" id="Lyon">Lyon &nbsp;></li>
                <li class="geoClick" id="Bordeaux">Bordeaux &nbsp;></li>
            </ul>
        </div>
    </div>
</section>

<section class="block_result_search">
    <div class="container">
        <div class="row">
            <div class="col-md-12 block_right">

                <!--  carte mentor -->

                <div class="row pagination_result text-center">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal no mentor -->
<div class="modal fade text-center modal_home" id="ModalNoFindMentor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <h1>Je n'ai pas trouvé mon mentor idéal</h1>
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <h3>Dites nous en plus sur le mentor que vous recherchez, notre équipe va mettre tout en oeuvre pour vous le trouver !</h3>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row mgb_0">
                            <div class="col-md-12 conex_fb">
                                <form action="/recherche/nomentor" method="post" name="f_nomentor" id="f_nomentor" onsubmit="SendPostNoMentor();return false;">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="form-group text-left" style="margin-top: 25px">
                                        <label for="entreprise">Entreprise :</label> <input type="text" name="entreprise" class="form-control" id="entreprise">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="entreprise">Poste :</label> <input type="text" name="poste" class="form-control" id="poste">
                                    </div>
                                    <div class="col-md-12 btn_blue">
                                        <button type="submit" onclick="SendPostNoMentor();return false;">Envoyer ma demande</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal no mentor -->

<!-- Display Suggestions of Mentors if is not logged in site web write by Raphael Beneluz -->
<?php if (!$this->getController()->userIsAuthentificate()) { ?>
    <section class="container">
        <h3>Voici un aperçu de notre communauté d'Insiders. <br> Recherchez-les et prenez rendez-vous !</h3>
        <div class="profil_operatoire">
            <?php if (isset($randomTalents) && !empty($randomTalents)) { ?>
                <div class="random-mentors">
                    <div class="row">
                        <?php foreach ($randomTalents as $talent) { ?>
                            <div class="col-md-4 result_pers">
                                <a href="<?php echo $talent->url ?>apropos" class="mentorbox" style="display:block">
                                    <div class="col-md-4 result_pers">
                                        <div class="bg_white_2 pad_0 display_flex">
                                            <div class="row" style="margin: auto;">
                                                <div class="col-md-5 col-sm-5 img_membre">
                                                    <span class="avatar img_linkedin" style="background: url('<?php echo $talent->avatar; ?>') center center no-repeat;    display: inline-block;
                                                            width: 100px;
                                                            height: 100px;
                                                            border-radius: 50%;
                                                            position: relative;
                                                            top: 30px;
                                                            background-size: cover!important;
                                                            min-height: inherit;"></span>
                                                </div>
                                                <div class="col-md-7 col-sm-7 padl-0">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4 class="name_entreprise"><?php echo $talent->nom_entreprise ?></h4>
                                                            <div class="inf_pr_ava">
                                                                <div class="rate">
                                                                    <p class="name_pers"><?php echo $talent->prenom; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="name_entreprise" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap"><?php echo $talent->titre_mission; ?></div>

                                                            <p class="pos_pers">
                                                                <span><i class="fa fa-map-marker"></i>&nbsp;<?php echo $talent->lieu; ?></span>
                                                            </p>
                                                            <span class="date"> <?php echo ucfirst(strftime('%B %Y', strtotime($talent->date_fin))); ?>
                                                                <?php if ($talent->date_fin == '9999-12-31' || $talent->date_debut == '0000-00-00') { ?>
                                                                    à Aujourd'hui
                                                                <?php } else { ?>
                                                                    à
                                                                    <?php echo ucfirst(strftime('%B %Y', strtotime($talent->date_debut))); ?>
                                                                <?php } ?>
							                                               </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

<!-- Fin -->
<!-- Display Suggestions of Mentors if is logged in site web (by Departement) write by Raphael Beneluz -->
<?php if ($this->getController()->userIsAuthentificate()) { ?>
    <div class="container block_right">
        <div class="profil_operatoire brbt pad_15">
            <?php if (isset($SuggestMentors) && !empty($SuggestMentors)) { ?>
                <div class="random-mentors">
                    <div class="row">
                        <?php foreach ($SuggestMentors as $mentor) { ?>
                            <div class="col-md-4 result_pers">
                                <a href="<?php echo $mentor->url ?>/apropos" class="mentorbox" style="display:block">
                                    <div class="col-md-4 result_pers">
                                        <div class="bg_white_2 pad_0 display_flex">
                                            <div class="row" style="margin: auto;">
                                                <div class="col-md-5 col-sm-5 img_membre">

                                                        <span class="avatar img_linkedin" style="background: url('<?php echo $mentor->avatar; ?>') center center no-repeat;    display: inline-block;
                                                                width: 100px;
                                                                height: 100px;
                                                                border-radius: 50%;
                                                                position: relative;
                                                                top: 30px;
                                                                background-size: cover!important;
                                                                min-height: inherit;"></span>
                                                </div>
                                                <div class="col-md-7 col-sm-7 padl-0">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4 class="name_entreprise"><?php echo $mentor->nom_entreprise ?></h4>
                                                            <div class="inf_pr_ava">
                                                                <div class="rate">
                                                                    <p class="name_pers"><?php echo $mentor->prenom; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="name_entreprise" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap"><?php echo $mentor->titre_mission; ?></div>

                                                            <p class="pos_pers">
                                                                <span><i class="fa fa-map-marker"></i>&nbsp;<?php echo $mentor->lieu; ?></span>
                                                            </p>
                                                            <span class="date"> <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_fin))); ?>
                                                                <?php if ($mentor->date_fin == '9999-12-31' || $mentor->date_debut == '0000-00-00') { ?>
                                                                    à Aujourd'hui
                                                                <?php } else { ?>
                                                                    à
                                                                    <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_debut))); ?>
                                                                <?php } ?>
							                                               </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<!-- Fin -->
<script>
	$('.filters').addClass('hideDept');
	$('.filters_btn').on('click', function () {
		$('.filters').toggleClass('hideDept');
	})
</script>
<script>
	function initAutocomplete() {

		geocoder = new google.maps.Geocoder();

		var mapFields = document.getElementsByClassName('api_geo');


		for (let i = 0; i < mapFields.length; i++) {
			let input            = mapFields[i];
			autocomplete         = new google.maps.places.Autocomplete(input, {types: ['(regions)']});
			autocomplete.inputId = input.id;
			autocomplete.addListener('place_changed', fillInAddress);
		}
	}
</script>
<script>
	$('#formHomesearch').on('keyup change paste', 'input, select, textarea', function () {
		recherche();

	});
	$('.sectClick').on('click', function () {
		$('#search_departement').prop('selected', true).val('');
		$('#search_Region').val('');
		$('#search_secteur').prop('selected', true).val(this.value);
		recherche();
	});

	$('.geoClick').on('click', function () {
		$('#search_departement').prop('selected', true).val('');
		$('#search_secteur').prop('selected', true).val('');
		$('#search_Region').val($(this).attr('id'));
		recherche();
	});
	$('.depClick').on('click', function () {
		$('#search_Region').val('');
		$('#search_secteur').prop('selected', true).val('');
		$('#search_departement').prop('selected', true).val(this.value);
		recherche();
	});

	function recherche() {
		$.ajax({
			type: "POST",
			url: base_url + "Recherche/search",
			data: $('#formHomesearch').serialize(),
			dataType: 'json',
			success: function (result) {
				$(".filters").html("");
				$('.profil_operatoire').hide();


				$.each(result.filters, function (filtre, elements) {

					// filtre : nom des filtre entreprise/dep/sect
					// elements : elements dans les filtre

					let bloc_filtre = '<h4 class="mgt30" style="display: inline-block">' + filtre.toUpperCase() + '</h4><button class="see_' + filtre + '"> +</button><br> ';

					$.each(elements, function (id, name) {
						switch (filtre) {
							case 'entreprise':
								bloc_filtre += '<div class="filterEnt"><input class="filtre_checkbox_ent" type="checkbox" id="' + id + '"/>' + name.name + ' (' + name.count + ') </div>';
								break;
							case 'departement':
								bloc_filtre += '<div class="filterDep"><input class="filtre_checkbox_dep" type="checkbox" id="' + id + '"/>' + name.name + ' (' + name.count + ') </div>';
								break;
							case 'secteur' :
								bloc_filtre += '<div class="filterSec"><input class="filtre_checkbox_sec" type="checkbox" id="' + id + '"/>' + name.name + ' (' + name.count + ')</div>';
								break;
							default:
								break;
						}
					});
					$(".filters").append(bloc_filtre);
				});

				$(".block_right").html("");

				$.each(result.entreprises, function (k, entreprises) {

					let card = entreprises.card;
					if (card !== null) {
						let entrepriseCard = '<div class="col-md-4 cardEnt">' +
							'<a href="' + base_url + 'entreprise/' + card.aliasEnt + '" style="display: inline-block;     padding: 0; min-height: 190px; max-height: 250px;"><li class="auto_cat_e" item="' + card.value + '" item_id="' + card.id + '">' +
							'<div class="bg_white_2 pad_0" style="background-image: url(upload/background/' + card.backgroundEnt + ')">\n' +
							'        <div class="layerBlack">\n' +
							'            <div class="bandeau">\n' +
							'                <img class="logo_card_ent" src="' + card.logoEnt + '" alt="">\n' +
							'                <ul>\n';
						$.each(card.avatarsEnt, function (key, value) {
							entrepriseCard += '<li>\n' +
								'<span style="background-image: url(' + value + '); border-radius: 30px; display: inline-block; width: 35px; height: 35px; background-size: cover !important; margin-top: 10px;"></span>\n' +
								'</li>\n';
						});
						entrepriseCard += '  </ul>\n' +
							'                    <div class="infoCard">' + card.nomEnt + '<br><span style="color: #6f6f6ffa; font-weight: lighter; font-size: 12px">' + card.secteurEnt + '</span></div>' +
							'                    <div class="nbrMent" style="color: #6f6f6ffa; font-weight: lighter; font-size: 12px; margin-top: 20px; text-align: center;">' + card.nbrMentorEnt + ' Mentors - ' + card.nbrOffreEnt + ' Job(s)</div>\n' +
							'            </div>\n' +
							'        </div>\n' +
							'    </div>\n' +
							'</li> </a></div>\n';
						$(".block_right").append(entrepriseCard);

					}


					$.each(entreprises.mentors, function (key, element) {
						let mentorCard = '<div class="mBlock" rel-fil-ent="' + element.filter_entreprise_id + '" rel-fil-dep="' + element.filter_departement_id + '"  rel-fil-sec="' + element.filter_secteur_id + '">' +
							'<a href="' + base_url + element.url + 'apropos"  class="mentorbox" style="display:block"><div class="col-md-4 result_pers">\n' +
							'                            <div class="bg_white_2 pad_0 display_flex">\n' +
							'                                <div class="row" style="margin: auto;">\n' +
							'                                    <div class="col-md-5 col-sm-5 img_membre">\n' +
							'                                        <span class="avatar img_linkedin" style="background: url(' + element.avatar + ') center center no-repeat;"></span>\n' +
							'                                    </div>\n' +
							'                                    <div class="col-md-7 col-sm-7 padl-0">\n' +
							'                                        <div class="row">\n' +
							'                                            <div class="col-sm-12">\n' +
							'                                                <h4 class="name_entreprise">' + element.nom_entreprise + '</h4>\n' +
							'                                                <div class="inf_pr_ava">\n' +
							'                                                    <div class="rate">\n' +
							'                                                        <p class="name_pers">\n' + element.prenom + '</p>\n' +
							'                                                    </div>\n' +
							'                                                </div>\n' +
							'                                                <div class="name_entreprise" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap">' + element.titre_mission + '</div>\n' +
							'                                                <p class="pos_pers">\n' +
							'                                                    <span><i class="fa fa-map-marker"></i>' + element.lieu + '</span>\n' +
							'                                                </p>\n' +
							'                                                <span class="date">\n' + element.date_debut + ' à ' + element.date_fin +
							'                                               </span>\n' +
							'                                            </div>\n' +
							'                                        </div>\n' +
							'                                    </div>\n' +
							'                                </div>\n' +
							'                            </div>\n' +
							'                        </div>' +
							'</a></div> ';
						$('.block_right').append(mentorCard);
					});
				});
				$('.mBlock').show();
				$('.filters').find('input[type=checkbox]').on('click', function () {
					if ($('.filters').find('input:checkbox:checked').length > 0) {
						$('.mBlock').hide();
						$('.filtre_checkbox_ent:checked').each(function () {
							$('.mBlock[rel-fil-ent="' + this.id + '"]').show();
						});
						$('.filtre_checkbox_dep:checked').each(function () {
							$('.mBlock[rel-fil-dep="' + this.id + '"]').show();
						});
						$('.filtre_checkbox_sec:checked').each(function () {
							$('.mBlock[rel-fil-sec="' + this.id + '"]').show();
						});
					} else {
						$('.mBlock').show();
					}
				});
				$lengthEnt = $('.filtre_checkbox_ent').length;
				$lengthDep = $('.filtre_checkbox_dep').length;
				$lengthSec = $('.filtre_checkbox_sec').length;
				$('.filterEnt').slice(5).hide();
				$('.filterDep').slice(5).hide();
				$('.filterSec').slice(5).hide();
				$('.see_entreprise').on('click', function () {
					if ($lengthEnt > 5) {
						$('.filterEnt').slice(5).toggle('slow');
					}
				});
				$('.see_departement').on('click', function () {
					if ($lengthDep > 5) {
						$('.filterDep').slice(5).toggle('slow');
					}
				});
				$('.see_secteur').on('click', function () {
					if ($lengthSec > 5) {
						$('.filterSec').slice(5).toggle('slow');
					}
				});
			}
		});
	}
</script>
