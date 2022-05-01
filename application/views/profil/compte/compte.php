<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
			<?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
			<div class="col-md-9 block_mn_compte">
				<div class="row nav_comment">
					<ul class="mg_15">
						<li class="title_li_compte">Mes informations</li>
					</ul>
				</div>
				<div class="row mes_infos_compte">
					<div class="col-md-12 pdl_30">
						<form method="post" action="<?php echo base_url(); ?>compte">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="row">
								<div class="col-md-6">
									<div class="title_label">
										<span>Nom </span>
										<?php if($info_user->nom == ""): ?>
											<span> <i class="ion-close" style="color:red"></i></span>
										<?php endif ?>
									</div>
									<div>
										<input type="text" value="<?php echo $info_user->nom; ?>" name="nom">
									</div>
								</div>
								<div class="col-md-6  ">
									<div class="title_label">
										<span>Prénom</span>
										<?php if($info_user->prenom == ""): ?>
											<span> <i class="ion-close" style="color:red"></i></span>
										<?php endif ?>

									</div>
									<div>
										<input type="text" value="<?php echo $info_user->prenom; ?>" name="prenom">
									</div>
								</div>
								<div class="col-md-6">
									<div class="title_label">
										<span>Sexe</span>
									</div>
									<div class="row">
										<div class="col-md-6 select_field">
											<select name="sexe">
												<option value="homme" <?php if($info_user->sexe == 'homme') {
													echo "selected";
												} ?>>Homme
												</option>
												<option value="femme" <?php if($info_user->sexe == 'femme') {
													echo "selected";
												} ?>>Femme
												</option>
											</select> <span><i class="ion-ios-arrow-down"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-6  ">
									<div class="title_label">
										<span>Date de naissance</span>
										<?php if($info_user->date_naissance == "0000-00-00"): ?>
											<span> <i class="ion-close" style="color:red"></i></span>
										<?php endif ?>
									</div>
									<div class="row">
										<div class="col-md-3 select_field">
											<?php
												$option = '<option value>Jour</option>';
												for($i = 1; $i <= 31; $i++) {
													$selected = "";
													if($i == date("d", strtotime($info_user->date_naissance)) && $info_user->date_naissance != "0000-00-00") {
														$selected = "selected";
													}
													$num_jours = $i < 10 ? '0' . $i : $i;
													$option    .= '<option value="' . $num_jours . '" ' . $selected . '>' . $num_jours . '</option>';
												} ?>
											<?php
												$mois_noms   = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
												$option_mois = '<option value>Mois</option>';
												for($i = 1; $i <= 12; $i++) {
													$selected = "";
													if($i == date("m", strtotime($info_user->date_naissance))) {
														$selected = "selected";
													}
													$num_mois    = $i < 10 ? '0' . $i : $i;
													$option_mois .= '<option value="' . $num_mois . '" ' . $selected . '>' . $mois_noms[$i] . '</option>';
												} ?>
											<select name="jour">
												<?php echo $option; ?>
											</select> <span><i class="ion-ios-arrow-down"></i></span>
										</div>
										<div class="col-md-9">
											<div class="row">
												<div class="col-md-6 select_field">
													<select name="mois">
														<?php echo $option_mois; ?>
													</select> <span><i class="ion-ios-arrow-down"></i></span>
												</div>
												<div class="col-md-6 select_field">
													<?php
														$year        = date("Y");
														$year_min    = $year - 100;
														$year_max    = $year - 10;
														$option_year = '<div class="col-md-2"><option value>Année</option>'; ?>
													<?php
														for($i = $year_max; $i >= $year_min; $i--) {
															$selected = "";
															if($i == date("Y", strtotime($info_user->date_naissance))) {
																$selected = "selected";
															}
															$option_year .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
														}
													?>
													<select name="annee">
														<?php echo $option_year; ?>
													</select> <span><i class="ion-ios-arrow-down"></i></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6  ">
									<div class="title_label">
										<span>Email</span> <span>
									    <?php if($info_user->email_verified) { ?>
										    <i class="ion-checkmark-round verified" title="Votre email est verifié"></i>
									    <?php } else { ?>
										    <a href="#" data-toggle="modal" data-target="#modalSendEmailConfirmation"> <i class="ion-checkmark-round" title="‏Votre adresse email n'a pas encore été vérifiée. Cliquez ici pour recevoir un nouvel email de confirmation"></i></a>
									    <?php } ?>
	                                    </span>
									</div>
									<div>
										<input type="text" name="email" value="<?php echo $info_user->email; ?>" placeholder="Votre email">
									</div>
								</div>

								<!-- Champ Ville(autocomple+api google) Write by Raph.b -->
								<div class="col-md-6">
									<div class="title_label">
										<span>Votre ville</span>
										<?php if($info_user->ville == "" or $info_user->ville == null): ?>
											<span> <i class="ion-close" style="color:red"></i></span>
										<?php endif ?>
									</div>
									<div class="location_field_2">
										<span class="ico_map"><i class="fa fa-map-marker"></i></span>
										<input type="text" name="ville" id="autocomplete" value="<?php echo $info_user->ville; ?>" placeholder="Ex: Paris" onFocus="geolocate()">
										<span class="ico_spin"><i class="fa fa-spin fa-circle-o-notch"></i></span>
									</div>
								</div>
								<!-- Fin -->

							</div>
							<div class="col-md-6 blocktel">
								<div class="title_label">
									<span>Téléphone</span> <span>
								    	<?php if($info_user->tel == "" or $info_user->tel == "+33") { ?>
										    <span> <i class="ion-close" style="color:red"></i></span>
									    <?php } else {
										    if($info_user->tel_verified) { ?>
											    <i class="ion-checkmark-round verified" title="Votre téléphone est verifié"></i>
										    <?php } else { ?>
											    <a href="#" data-toggle="modal" data-target="#modalSendTelConfirmation"> <i class="ion-checkmark-round" title="‏Votre Téléphone n'a pas encore été vérifié. Cliquez ici pour recevoir un code de confirmation"></i></a>
										    <?php }
									    } ?>
                                    </span>
								</div>
								<?php $this->view('fragment/verif_tel/vue'); ?>
							</div>
							<div class="row btn_info ">
								<div class="col-md-6 col-md-offset-5">
									<button class="sendButton" type="submit">Sauvegarder</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade text-center modal_home modal_form" id="modalBienvenue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">

			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<div class="modal-body">
				<div class="row bienvenue">
					<p><?php echo $this->user_info->getconfig(14); ?></p>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade text-center modal_home modal_form" id="modalnochangephone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-body">
				<div class="row bienvenue">
					<p>Nous n'avons détecté aucun changement sur votre numéro de téléphone.</p>
				</div>

			</div>
		</div>
	</div>
</div>

<?php if($bienvenue and $bienvenue == "bienvenue") { ?>
	<script>
		$('#modalBienvenue').modal('show');
	</script>
<?php } ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer></script>

<script>
	var placeSearch, autocomplete;

	var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
	};

	function initAutocomplete() {
		// Create the autocomplete object, restricting the search predictions to
		// geographical location types.
		autocomplete = new google.maps.places.Autocomplete(
			document.getElementById('autocomplete'), {types: ['geocode']});

		// Avoid paying for data that you don't need by restricting the set of
		// place fields that are returned to just the address components.
		autocomplete.setFields(['address_component']);

		// When the user selects an address from the drop-down, populate the
		// address fields in the form.
		autocomplete.addListener('place_changed', fillInAddress);
	}

	function fillInAddress() {
		// Get the place details from the autocomplete object.
		var place = autocomplete.getPlace();

		for (var component in componentForm) {
			document.getElementById(component).value    = '';
			document.getElementById(component).disabled = false;
		}

		// Get each component of the address from the place details,
		// and then fill-in the corresponding field on the form.
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val                                    = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType).value = val;
			}
		}
	}

	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				var geolocation =
						{
							lat: position.coords.latitude,
							lng: position.coords.longitude
						};
				var circle      = new google.maps.Circle(
					{center: geolocation, radius: position.coords.accuracy});
				autocomplete.setBounds(circle.getBounds());
			});
		}
	}
</script>
