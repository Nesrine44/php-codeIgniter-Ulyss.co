<section class="hero_home bg_recherche bg_wishlist" style="background:url('<?php echo base_url(); ?>assets/img/bg_wishlist.png');">
	<div class="container">
		<div class="row text-center text_hero">
			<div class="col-md-6 col-md-offset-3">
				<p class="p_4">Suggestions</p>
				<p class="p_5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, eius.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 search_row">
				<form action="<?php echo base_url(); ?>wishlist" method="post" class="row">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

					<div class="col-md-8  location_field">

						<input type="text" name="quoi" value="<?php echo $quoi; ?>" placeholder="Que voulez-vous demander au wanted?">
					</div>
					<div class="col-md-4">
						<input type="submit" name="rechercher" value="Rechercher">
					</div>
				</form>
			</div>
		</div>


	</div>
</section><!-- end hero home -->
<section class="block_sort box_shad">
	<div class="container">
		<div class="row">
			<div class="col-md-1 col-sm-2 col-xs-3">
				<span class="title_sort">Trier</span>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-9">
				<div class=" row sort_drop">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					  		<span class="field_sort">
					  			Date
					  			<i class="fa fa-chevron-down"></i>
					  		</span>

					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Nom</a></li>
						<li><a href="#">Date</a></li>
						<li><a href="#">Profession</a></li>

					</ul>
				</div>
			</div>
			<div class="col-md-6 text-right pull-right pag_num">
                <?php if ($links) { ?>
					<label class="title_sort">Page:</label>
                <?php } ?>
                <?php echo $links; ?>
			</div>
		</div>
	</div>
	</div>
</section>
<section class="block_result_search">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<h1 class="col-md-12">Filtrer</h1>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12 bg_grey block_left">
							<form method="POST" action="<?php echo base_url(); ?>wishlist" id="Formsearch" autocomplete="off">
								<input type="hidden" name="filter" value="oo">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

								<div class="row">
									<div class="col-md-12">
										<h2>Localisation</h2>

									</div>
								</div>
								<div class="row">
									<div class="col-md-10 col-xs-9">
										<div class="location_field_2">
											<span class="ico_map"><i class="fa fa-map-marker"></i></span>
											<input name="ville" id="ville_id_r" value="<?php echo $ville; ?>" type="hidden"></input>
											<input type="text" id="ville_r" value="<?php if ($ville != 0) echo $this->user_info->getVilleName($ville); ?>" placeholder="Ex. Paris">
											<span class="ico_spin"><i class="fa fa-spin fa-circle-o-notch"></i></span>

											<div class="drop_list">
												<ul id="ville_list_r">

												</ul>
											</div>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
											<div class="panel  panel_cat">
												<div class="" role="tab" id="headingOne">
													<h4 class="panel-title">
														<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
															<h2>Catégories <span class="pull-right"><i class="fa fa-angle-down"></i></span></h2>
														</a>
													</h4>
												</div>
												<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
													<div class="row">
                                                        <?php
                                                        foreach ($list_groupe as $groupe):
                                                            $checked = "";
                                                            if (!empty($categorie)) {
                                                                if (in_array($groupe->id, $categorie)) {
                                                                    $checked = "checked";
                                                                }
                                                            } ?>
															<div class="col-md-12 checkbox reste_con">
																<label>
																	<input type="checkbox" class="groupe_cat_" name="groupe_cat[]" value="<?php echo $groupe->id ?>" <?php echo $checked; ?>><?php echo $groupe->nom ?>
																</label>
															</div>
                                                        <?php endforeach ?>
													</div>
												</div>
											</div>

											<div class="panel panel_cat ">
												<div class="" role="tab" id="headingThree">
													<h4 class="panel-title">
														<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
															<h2>Sous-Catégories <span class="pull-right"><i class="fa fa-angle-down"></i></span></h2>
														</a>
													</h4>
												</div>
												<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
													<div class="row" id="scat">
                                                        <?php echo $list_selectionne; ?>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12 text-center ">
													<div class="col-md-12 btn_alert">

														<a href="#" onclick="gotoSearch();"><i class="fa fa-search"></i> Chercher</a>

													</div>
												</div>
											</div>
							</form>

						</div>
					</div>
				</div>


			</div>

		</div>
	</div>
	</div>

	<div class="col-md-8 block_right">

		<div class="row">
			<h1 class="col-md-12">Resultats(<?php echo count($result_count); ?>)</h1>
		</div>
        <?php if (count($result_count) == 0): ?>
			<div class="col-md-12 ">
				<div class="row">
					<div class="col-md-12">
						<h1>Aucun résultat</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed iusto eaque perspiciatis molestias accusantium consectetur libero deleniti a illum, quibusdam.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 btn_add_demande mgt30">

                        <?php if (!$this->session->userdata('logged_in_site_web')) { ?>
							<a href="#" data-toggle="modal" data-target="#ModalConnexion">Ajouter une demande</a>
                        <?php } else { ?>
							<a href="#" data-toggle="modal" data-target="#ModalAddWishlist">Ajouter une demande</a>
                        <?php } ?>
					</div>
				</div>
			</div>
        <?php endif ?>
        <?php foreach ($result as $wishlist): ?>
			<div class="row result_wishlist">
				<div class="col-md-12 ">
					<div class="col-md-12 bg_grey ">
						<div class="col-md-3 numbre_list">
									<span>
									<em><?php echo $this->user_info->getNombreVote($wishlist->id); ?></em>
                                        <?php if (!$this->session->userdata('logged_in_site_web')) { ?>
											<a href="#" data-toggle="modal" data-target="#ModalConnexion"><em>1+</em></a>
                                        <?php } else {
                                            if ($this->user_info->checkVote($wishlist->id)) { ?>
												<a href="<?php echo base_url(); ?>wishlist/dislike/<?php echo $wishlist->id; ?>"><em>1- </em></a>
                                            <?php } else { ?>
												<a href="<?php echo base_url(); ?>wishlist/like/<?php echo $wishlist->id; ?>"><em>1+ </em></a>
                                            <?php }
                                        } ?>
									</span>
						</div>
						<div class="col-md-5 text_list">
							<h4><?php echo $wishlist->titre; ?></h4>
							<p><?php echo $wishlist->description; ?></p>
						</div>
						<div class="col-md-4 text-right link_list">
                            <?php if (!$this->session->userdata('logged_in_site_web')) { ?>
								<a href="#" data-toggle="modal" data-target="#ModalConnexion">Proposez ce service</a>
                            <?php } else { ?>
								<a href="#" data-toggle="modal" data-target="#ModalAddTalent" class="proposeceservice" lvalue="<?php echo $wishlist->id; ?>">Proposez ce service</a>
                            <?php } ?>
						</div>
					</div>
				</div>
			</div>
        <?php endforeach ?>
	</div>
	</div>
	</div>
</section>

<section class="block_sort box_shad">
	<div class="container">
		<div class="row">
			<div class="col-md-1 col-sm-2 col-xs-3">
				<span class="title_sort">Trier</span>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-9">
				<div class=" row sort_drop">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					  		<span class="field_sort">
					  			Date
					  			<i class="fa fa-chevron-down"></i>
					  		</span>

					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Nom</a></li>
						<li><a href="#">Date</a></li>
						<li><a href="#">Profession</a></li>

					</ul>
				</div>
			</div>
			<div class="col-md-6 text-right pull-right pag_num">
                <?php if ($links) { ?>
					<label class="title_sort">Page:</label>
                <?php } ?>
                <?php echo $links; ?>

			</div>
		</div>
	</div>
	</div>
</section>

<?php if ($this->session->userdata('logged_in_site_web')) { ?>
	<!-- Modal creation talent-->
	<div class="modal fade text-center modal_home modal_form" id="ModalAddTalent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog " role="document">
			<div class="modal-content">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<div class="modal-body">
					<form method="post" action="<?php echo base_url(); ?>mes_activites/talents" id="formADDtalent" enctype="multipart/form-data">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<h1>Proposez ce service</h1>
						</div>
						<div class="row">
							<p class="error erreur_talent" style="display:none;">
								Merci de remplir tous les champs
							</p>
						</div>
						<input type="hidden" value="" id="id_wish" name="id_wish">
						<input type="hidden" value="" id="id_ville-w" name="id_ville">
						<input type="hidden" value="" id="id_cat" name="list_cat[]">

						<div class="row  ">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="text" class="required" name="titre" id="name" placeholder="Indiquez le titre de talent">
							</div>
						</div>

						<div class="row  ">

							<div class="col-md-4 col-md-offset-2 ">
								<select name="horaire_de">
									<option value="09:00">De</option>
									<option value="09:00">08:00</option>
									<option value="09:00">09:00</option>
									<option value="10:00">10:00</option>
									<option value="11:00">11:00</option>
									<option value="12:00">12:00</option>

									<option value="13:00">13:00</option>
									<option value="14:00">14:00</option>
									<option value="15:00">15:00</option>
									<option value="16:00">16:00</option>
									<option value="17:00">17:00</option>
									<option value="18:00">18:00</option>
									<option value="19:00">19:00</option>
									<option value="20:00">20:00</option>
									<option value="21:00">21:00</option>
									<option value="22:00">22:00</option>
									<option value="23:00">23:00</option>
									<option value="00:00">00:00</option>
								</select>
							</div>
							<div class="col-md-4  ">

								<select name="horaire_a">
									<option value="17:00">à</option>
									<option value="09:00">08:00</option>
									<option value="09:00">09:00</option>
									<option value="10:00">10:00</option>
									<option value="11:00">11:00</option>
									<option value="12:00">12:00</option>

									<option value="13:00">13:00</option>
									<option value="14:00">14:00</option>
									<option value="15:00">15:00</option>
									<option value="16:00">16:00</option>
									<option value="17:00">17:00</option>
									<option value="18:00">18:00</option>
									<option value="19:00">19:00</option>
									<option value="20:00">20:00</option>
									<option value="21:00">21:00</option>
									<option value="22:00">22:00</option>
									<option value="23:00">23:00</option>
									<option value="00:00">00:00</option>
								</select>

							</div>
							<!--             <div class="col-md-8 col-md-offset-2 ">
                                           <input type="text" class="required" name="horaire"  value="9h-17h" placeholder="Indiquez horaire de talent">
                                        </div> -->
						</div>


						<!--          <div class="row  ">
                                    <div class="col-md-8 col-md-offset-2 ">
                                       <input type="text" class="required" name="horaire"  placeholder="Indiquez horaire de talent">
                                    </div>
                                 </div> -->
						<div class="row">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="number" name="prix" id="prix" placeholder="Indiquez le prix de talent">
							</div>
						</div>
						<div class="row">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="text" name="prix_journee" id="prix_journee" class="numericOnly" placeholder="Indiquez le prix journee de talent">
							</div>
						</div>


						<div class="row  ">
							<div class="col-md-8 col-md-offset-2 ">
								<textarea name="description" class="required" id="desc" rows="5" placeholder="Indiquez le description de talent"></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="text" name="prix_forfait" id="prix_forfait" class="numericOnly" placeholder="Indiquez le prix forfait ">
							</div>
						</div>

						<div class="row  ">
							<div class="col-md-8 col-md-offset-2 ">
								<textarea name="description_forfait" class="required" id="description_forfait" rows="5" placeholder="Indiquez le description  forfait"></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="file" name="file" id="file" placeholder="image">
							</div>
						</div>
						<div class="row btn_inscription ">
							<div class="col-md-10 col-md-offset-1">
								<button class="sendButton" type="submit">valider</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal creation talent-->


	<!-- Modal creation wishlist-->
	<div class="modal fade text-center modal_home modal_form" id="ModalAddWishlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog " role="document">
			<div class="modal-content">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<div class="modal-body">
					<form method="post" action="<?php echo base_url(); ?>wishlist/ajouter" id="formADDWishlist" enctype="multipart/form-data" autocomplete="off">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

						<div class="row">
							<h1>Ajouter une demande</h1>
						</div>
						<div class="row">
							<p class="error erreur_wishlist" style="display:none;">
								Merci de remplir tous les champs
							</p>
						</div>
						<div class="row ">
							<div class="col-md-8 col-md-offset-2 select_field">
								<select name="categorie" id="gcat">
									<option value="">Choisir une categorie</option>
                                    <?php foreach ($list_groupe as $groupe) { ?>
										<option value="<?php echo $groupe->id; ?>"><?php echo $groupe->nom; ?></option>
                                    <?php } ?>
								</select>
								<span class="arrow_bottom"><i class="ion-arrow-down-b"></i></span>
							</div>
						</div>
						<div class="row ">
							<div class="col-md-8 col-md-offset-2 select_field">
								<select name="scat" id="option_scat">
									<option value="0">Choisir sous catégorie</option>

								</select>
								<span class="arrow_bottom"><i class="ion-arrow-down-b"></i></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<div class="location_field_2">
									<span class="ico_map"><i class="fa fa-map-marker"></i></span>
									<input name="ville" id="ville_id" value="<?php echo $ville; ?>" type="hidden"></input>
									<input type="text" id="ville_wish" value="<?php if ($ville != 0) echo $this->user_info->getVilleName($ville); ?>" placeholder="Ex. Paris">
									<span class="ico_spin"><i class="fa fa-spin fa-circle-o-notch"></i></span>

									<div class="drop_list">
										<ul id="ville_list">

										</ul>
									</div>
								</div>
							</div>

						</div>


						<div class="row  ">
							<div class="col-md-8 col-md-offset-2 ">
								<input type="text" class="required" name="titre" value="<?php echo $quoi; ?>" id="namew" placeholder="Indiquez le titre de wishlist">
							</div>
						</div>


						<div class="row  ">
							<div class="col-md-8 col-md-offset-2 ">
								<textarea name="description" class="required" id="descw" rows="5" placeholder="Indiquez le description de wishlist"></textarea>
							</div>
						</div>

						<div class="row btn_inscription ">
							<div class="col-md-10 col-md-offset-1">
								<button class="sendButton" type="submit">valider</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal creation wishlist-->
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
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

        $('.date-picker-n').datepicker({
            format: "dd/mm/yyyy",
            autoclose: "true",
            language: 'fr'
        });


    });


    function gotoSearch() {
        $('#Formsearch').submit();
    }
</script>