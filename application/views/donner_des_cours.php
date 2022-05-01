<section class="hero_ccm hero_dcc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center text-hr">
				<h1>Donner des cours</h1>
				<p>Easylearn vous permet de trouver des élèves rapidement près de chez vous !</p>
			</div>
		</div>
	</div>
</section>
<section class="pg-ccm pg-dcc">
	<div class="container">
		<form id="formAddCours" action="<?php echo base_url(); ?>mentor/add" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="row">
				<div class="col-md-12">
					<h1>Etape 1 : Votre cours</h1>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-sm-12">
							<label>Ajoutez un titre à votre annonce : </label>
							<input type="text" name="titre" class="required" placeholder="taper votre titre ici.">
						</div>
					</div>
				</div>
			</div>


			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-md-2 col-sm-4">
							<label>Catégorie : </label>
						</div>
						<div class="col-md-10 col-sm-8 select_field">
							<select name="list_cat[]" id="cat_cours" class="required">
								<option value="">Toutes les catégories</option>
                                <?php foreach ($list_categories as $categorie):
                                    ?>
									<option value="<?php echo $categorie->id; ?>"><?php echo $categorie->nom; ?></option>
                                <?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-sm-12">
							<label>Lieu où se déroule le cours : </label>
							<!-- 		<input type="text"  placeholder="renseignez la ville "> -->
							<div class="location_field_2">
								<span class="ico_map"><i class="fa fa-map-marker"></i></span>
								<input name="ville" id="ville_id_r" value="" type="hidden">
								<input type="text" id="ville_r" value="" class="required" placeholder="Ex. Paris">
								<span class="ico_spin"><i class="fa fa-spin fa-circle-o-notch"></i></span>

								<div class="drop_list">
									<ul id="ville_list_r">

									</ul>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-sm-12">
							<label>Code postal : </label>
							<input type="text" name="cp" placeholder="Renseignez le code postal">
						</div>
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="checkbox">
						<label>
							<input type="checkbox" value="1" name="pro">Cochez si vous exercez une activité professionnelle
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h1>Etape 2 : Indiquez vos tarifs </h1>
				</div>
			</div>
			<div class="row text-field">
				<div class="col-md-12">
					<p class="text-left">
						A noter : Vos tarifs sont soumis à une commission. Consultez nos <a href="<?php echo base_url(); ?>cgu_cgv">CGV</a>.
					</p>

				</div>
			</div>


			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-sm-12">
							<label>Tarif horaire : </label>
							<input type="text" name="prix" class="required" placeholder="0 / heure ">
						</div>
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-sm-12">
							<label>Tarif journalier : </label>
							<input type="text" name="prix_journee" class="required" placeholder="0 / jour">
						</div>
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-2 col-sm-4">
					<input type="text" name="reduction" placeholder="0 pourcent" class="cl-grey brdrs text-center">
				</div>
				<div class="col-md-3 col-sm-4">
					<label class="lh36">de réduction à partir de</label>
				</div>
				<div class="col-md-2 col-sm-4 ">
					<input type="text" name="reduction_heure" placeholder="0 heure" class="cl-grey brdrs text-center">
				</div>
			</div>

			<div class="row mgb30">
				<div class="col-md-2 col-sm-4">
					<input type="text" name="reduction_personne" placeholder="0 euros" class="cl-grey brdrs text-center">
				</div>
				<div class="col-md-4 col-sm-6">
					<label class="lh36">par personne supplémentaire</label>
				</div>

			</div>

			<div class="row">
				<div class="col-md-12">
					<h1>Etape 3 : Détaillez votre service</h1>
				</div>
			</div>

			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey textarea_field">
						<div class="col-sm-12">
							<label>CV sportifs & Expériences :</label>
							<textarea name="description" id="" rows="6" placeholder="Renseignez toutes les informations relatives à votre talent"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row text-field">
				<div class="col-md-12">
					<p><b>Vérification</b> (photos / photocopies de vos éventuels diplômes, classement qui permettent de justifier de vos compétences)</p>
					<p>Uploadez vos documents ou envoyez-nous par mail à <a href="mailto:verif@easylearn.io">verif@easylearn.io</a></p>
				
				</div>
			</div>

			<div class="row mgb30 btn_add_files">
				<div class="col-md-12">
					<h4>Ajouter les documents de vérification</h4>
				</div>
				<div class="col-md-3 col-sm-4" id="html_add_doc">
					<input type="file" name="files[]" id="fileinput" class="hidden last add_files add_document">
					<a href="#" class="add_file_link">Ajouter des documents</a>
				</div>
				<div class="col-md-4 col-sm-6">
					<label class="lh36">4 Documents</label>
				</div>
			</div>

			<div class="row mgb30 file_icon">
				<div class="col-md-2 col-sm-4" id="doc_preview_0" style="display:none;">
					<div id="loading_0"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
					<a href="#" target="_BLANK" id="lien_0" style="display:none;">
						<img src="<?php echo base_url(); ?>assets/img/ico_file.png" alt="">
					</a>
				</div>
				<div class="col-md-2 col-sm-4" id="doc_preview_1" style="display:none;">
					<div id="loading_1"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>

					<a href="#" target="_BLANK" id="lien_1" style="display:none;">
						<img src="<?php echo base_url(); ?>assets/img/ico_file.png" alt="">
					</a>
				</div>
				<div class="col-md-2 col-sm-4" id="doc_preview_2" style="display:none;">
					<div id="loading_2"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>

					<a href="#" target="_BLANK" id="lien_2" style="display:none;">
						<img src="<?php echo base_url(); ?>assets/img/ico_file.png" alt="">
					</a>
				</div>
				<div class="col-md-2 col-sm-4" id="doc_preview_3" style="display:none;">
					<div id="loading_3"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>

					<a href="#" target="_BLANK" id="lien_3" style="display:none;">
						<img src="<?php echo base_url(); ?>assets/img/ico_file.png" alt="">
					</a>
				</div>

			</div>

			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey textarea_field">
						<div class="col-sm-12">
							<label>Centres d’intérêt :</label>
							<textarea name="centre_interet" rows="6" placeholder="Vos hobbies et vos sujets de discussion peuvent séduire votre élève potentiel"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="sp_langues sp_langues1">
					</div>
				</div>
			</div>
			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-md-2 col-sm-4">
							<label>Langue parlée : </label>
						</div>
						<div class="col-md-10 col-sm-8 select_field">
							<select name="langue[]" id="select_lang_r" id="">
								<option value="">Ajouter vos langues</option>
                                <?php foreach ($list_language as $item):
                                    ?>
									<option value="<?php echo $item->id; ?>"><?php echo $item->nom; ?></option>
                                <?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row mgb30">
				<div class="col-md-12">
					<div class="sp_langues sp_tag">
					</div>
				</div>
			</div>


			<div class="row mgb30">
				<div class="col-md-12">
					<div class="cl-grey brdrs">
						<div class="col-md-2 col-sm-4">
							<label>Tags (optionnel) : </label>
						</div>
						<div class="col-md-10 col-sm-8 select_field">
							<select name="tag[]" id="select_tag">
								<option value="">Ajoutez des tags</option>
                                <?php foreach ($list_tags as $item):
                                    ?>
									<option value="<?php echo $item->id; ?>"><?php echo $item->nom; ?></option>
                                <?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row text-field">
				<div class="col-md-12">
					<p class="text-center">
						Les visiteurs pourront faire des filtres dans leurs recherches
					</p>

				</div>
			</div>


			<div class="row mgb30 btn_add_files">
				<div class="col-md-3 col-sm-4" id="html_files_img">
					<input type="file" name="image[]" class="hidden add_files_2">
					<a href="#" class="add_file2">AJOUTER DES PHOTOS</a>
				</div>
				<div class="col-md-4 col-sm-6">
					<label class="lh36">4 Photos ( 570px x400px )</label>
				</div>
			</div>


			<div class="row mgb30 file_icon">
				<div class="col-md-2 col-sm-4" id="image_preview_0">
					<img src="<?php echo base_url(); ?>assets/img/ico_pic.png" alt="">
				</div>
				<div class="col-md-2 col-sm-4" id="image_preview_1">
					<img src="<?php echo base_url(); ?>assets/img/ico_pic.png" alt="">
				</div>
				<div class="col-md-2 col-sm-4" id="image_preview_2">
					<img src="<?php echo base_url(); ?>assets/img/ico_pic.png" alt="">
				</div>
				<div class="col-md-2 col-sm-4" id="image_preview_3">
					<img src="<?php echo base_url(); ?>assets/img/ico_pic.png" alt="">
				</div>

			</div>

			<div class="row mgt30 text-field">
				<div class="col-md-12">
					<p class="">
						<b>Choisissez vos disponibilités hebdomadaires (cliquez sur les cases qui correspondent à un créneau horaire pour ajuster vos disponibilités) </b>
					</p>
					<p class="link_horaires"><a href="#" id="disp_week_and_soir">Je suis disponible le soir et weekend</a> <a href="#" id="disp_horaire_tavail">Je suis disponible sur les heures de travail</a></p>

				</div>
			</div>
			<div class="row  ">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table text-center table_diponibilite">
							<tr>
								<th></th>
								<th>Lundi</th>
								<th>Mardi</th>
								<th>Mercredi</th>
								<th>Jeudi</th>
								<th>Vendredi</th>
								<th>Samedi</th>
								<th>Dimanche</th>
							</tr>
							<tr>
								<td>8h-10h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_8_10" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_8_10" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>10h-12h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_10_12" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_10_12" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>12h-14h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_12_14" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_12_14" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>14h-16h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_14_16" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_14_16" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>16h-18h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_16_18" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_16_18" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>18h-20h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="samedi_18_20" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="dimanche_18_20" class="check_disp" checked></td>
							</tr>
							<tr>
								<td>20h-22h</td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="lundi_20_22" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mardi_20_22" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="mercredi_20_22" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="jeudi_20_22" class="check_disp" checked></td>
								<td class="horaire_td active"><input type="checkbox" value="1" name="vendredi_20_22" class="check_disp" checked></td>
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

			<div class="row mgt30 btn_add_cours">
				<div class="col-md-12">
					<p class="etap1_error" style="display:none;"></p>
				</div>
				<div class="col-md-12">
					<input type="submit" value="AJOUTER CE COURS">
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

</script>