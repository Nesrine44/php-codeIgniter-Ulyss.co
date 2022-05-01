<section class="block_profil block_avis_profil">
	<div class="container mgb_30">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1>Evaluez & Laisser un avis </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="row pad_card">

					<div class="card hovercard">


						<div class="cardheader" style="background: url('<?php echo base_url($this->config->item('upload_covertures') . $this->user_info->getCovertureTalent($info_talent->id)); ?>');">
							<div class="avatar">
                                <?php if (strpos($info->avatar, "https://") !== false) { ?>
									<img src="<?php echo $info->avatar; ?>" alt="" width="80" height="80" class="img-circle">
                                <?php } else { ?>
									<img class="img-circle" src="<?php echo base_url(); ?>image.php/<?php echo $info->avatar; ?>?height=80&width=80&cropratio=1:1&image=<?php echo base_url($this->config->item('upload_avatar') . $info->avatar); ?>" alt="">
                                <?php } ?>
							</div>
							<span class="name_avatar"><?php echo $info_talent->titre; ?>  </span>
						</div>

						<div class="name_pers_chat">
							<div class="title_avatar">
								<a target="_blank" href="#"><?php echo $info->prenom . ' ' . $info->nom; ?>  </a>
							</div>
							<div class="info_avatar">
								<i class="fa fa-map-marker color_marker"></i><span><?php echo $this->user_info->getVilleCodePostal($info_talent->ville); ?>, France</span>
							</div>
						</div>
					</div>
					<!-- End profile -->
				</div>

			</div>
			<div class="col-md-7 col-md-offset-1  content_comment">
				<div class="item_avis mgb_15">
					<div class="row  ">
						<div class="col-md-12">
							<div class="row mgb_15">
								<div class="col-md-6 date_comment text-left">
									<span>Professionalisme</span>
								</div>
								<div class="col-md-6 etoiles text-right">
									<i class="fa fa-star revieww1 addnot1" lid="1"></i><i class="fa fa-star revieww2 addnot1" lid="2"></i><i class="fa fa-star revieww3 addnot1" lid="3"></i><i class="fa fa-star revieww4 addnot1" lid="4"></i> <i class="fa fa-star revieww5 addnot1" lid="5"></i>
								</div>

							</div>
							<div class="row  mgb_15">
								<div class="col-md-12  text-left cnt_comment">

									<p>Evaluez le professionnalisme du professeur. A-t-il été ponctuel et précis sur le lieu du rendez-vous ?</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item_avis mgb_15">
					<div class="row  ">
						<div class="col-md-12">
							<div class="row mgb_15">
								<div class="col-md-6 date_comment text-left">
									<span>Communication</span>
								</div>
								<div class="col-md-6 etoiles text-right">
									<i class="fa fa-star review1 addnot" lid="1"></i><i class="fa fa-star review2 addnot" lid="2"></i><i class="fa fa-star review3 addnot" lid="3"></i><i class="fa fa-star review4 addnot" lid="4"></i> <i class="fa fa-star review5 addnot" lid="5"></i>

								</div>

							</div>
							<div class="row  mgb_15">
								<div class="col-md-12  text-left cnt_comment">

									<p>Evaluez la qualité de communication et de conseils du professeur. Vous a-t-il donné des conseils pertinents selon votre niveau ? Avez-vous pu échanger avec lui comme vous le souhaitiez ?</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item_avis mgb_15">
					<div class="row  ">
						<div class="col-md-12">
							<div class="row mgb_15">
								<div class="col-md-6 date_comment text-left">
									<span>Qualité du cours</span>
								</div>
								<div class="col-md-6 etoiles text-right">
									<i class="fa fa-star reviewww1 addnot2" lid="1"></i><i class="fa fa-star reviewww2 addnot2" lid="2"></i><i class="fa fa-star reviewww3 addnot2" lid="3"></i><i class="fa fa-star reviewww4 addnot2" lid="4"></i> <i class="fa fa-star reviewww5 addnot2" lid="5"></i>

								</div>

							</div>
							<div class="row  mgb_15">
								<div class="col-md-12  text-left cnt_comment">

									<p>Evaluez les compétences sportives du professeur. Une évaluation de 1 (très mauvais) à 5 (excellent) du niveau sportif du professeur et compétences à encadrer un cours. Le cours a-t-il répondu à vos exigences ?</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--                   <div class="item_avis mgb_15">
                                     <div class="row  ">
                                        <div class="col-md-12">
                                           <div class="row mgb_15">
                                              <div class="col-md-6 date_comment text-left">
                                                 <span>Note</span>
                                              </div>
                                              <div class="col-md-6 etoiles text-right">
                                                <i class="fa fa-star-o review1 addnot" lid="1"></i><i class="fa fa-star-o review2 addnot" lid="2"></i><i class="fa fa-star-o review3 addnot" lid="3"></i><i class="fa fa-star-o review4 addnot" lid="4"></i> <i class="fa fa-star-o review5 addnot" lid="5"></i>
                                              </div>

                                           </div>
                                           <div class="row  mgb_15">
                                              <div class="col-md-12  text-left cnt_comment">

                                                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat commodi iure in error illum dolores quisquam laborum vero, nihil obcaecati debitis eveniet officiis. Saepe eum quod ullam enim recusandae non.</p>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                  </div> -->


				<!-- add avis -->
				<div class="item_avis mgb_15">
					<form id="form-add-avis" action="" method="post">
						<div class="row  ">
							<div class="col-md-12">
								<div class="row mgb_15">
									<div class="col-md-6 date_comment text-left">
										<span>Votre avis</span>
									</div>

								</div>
								<div class="row  mgb_15">
									<div class="col-md-12  text-left cnt_comment">

										<p>Déposez un commentaire afin de partager votre expérience avec avec la communauté Weesports. N’hésitez pas à recommander ce professeur. Restez objectif <i class="fa fa-smile-o"></i></p>
									</div>
								</div>
								<div class="row  mgb_15">
									<div class="col-md-12  text-left cnt_comment">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										<input type="hidden" name="note" id="note_rev" value="5">
										<input type="hidden" name="note1" id="note_rev1" value="5">
										<input type="hidden" name="note2" id="note_rev2" value="5">
										<textarea name="commentaire" class="textarea_count" id="cmt" maxlength="400" rows="8"></textarea>
										<p class="text-right" id="nbr_caracter">400 caractères restants</p>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="text-center mgb_15 add_avis">
					<a href="#" id="submitFormAvis">Ajouter</a>
				</div>
				<!-- end add avis   -->
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('.textarea_count').keyup(function () {
            var text_max = $(this).attr('maxlength');
            var text_length = $(this).val().length;
            var text_remaining = text_max - text_length;

            $('#nbr_caracter').html(text_remaining + " caractères restants");
        });
        $('.addnot2').click(function () {
            var note = $(this).attr("lid");
            $("#note_rev2").val(note);
            $('.addnot2').removeClass("fa-star-o");
            $('.addnot2').removeClass("fa-star");
            for (var i = 1; i <= 5; i++) {
                if (i <= note) {
                    $(".reviewww" + i).addClass("fa-star");
                } else {
                    $(".reviewww" + i).addClass("fa-star-o");
                }

            }
            ;
        });
        $('.addnot1').click(function () {
            var note = $(this).attr("lid");
            $("#note_rev1").val(note);
            $('.addnot1').removeClass("fa-star-o");
            $('.addnot1').removeClass("fa-star");
            for (var i = 1; i <= 5; i++) {
                if (i <= note) {
                    $(".revieww" + i).addClass("fa-star");
                } else {
                    $(".revieww" + i).addClass("fa-star-o");
                }

            }
            ;
        });
        $('.addnot').click(function () {
            var note = $(this).attr("lid");
            $("#note_rev").val(note);
            $('.addnot').removeClass("fa-star-o");
            $('.addnot').removeClass("fa-star");
            for (var i = 1; i <= 5; i++) {
                if (i <= note) {
                    $(".review" + i).addClass("fa-star");
                } else {
                    $(".review" + i).addClass("fa-star-o");
                }

            }
            ;
        });
        $('#submitFormAvis').click(function () {
            if ($("#note_rev").val() < 1) {
                alert('Merci de donner une note pour la comminication.');
            } else if ($("#note_rev1").val() < 1) {
                alert('Merci de donner une note pour la Professionalisme.');
            } else if ($(".textarea_count").val() == "") {
                alert('Merci de donner une commentaire  pour ce service.');
            } else {
                $("#form-add-avis").submit();
            }
        });

    });
</script>