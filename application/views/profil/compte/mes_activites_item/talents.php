<section class="block_resultas wanted_block">
    <div class="container">
        <div class="row">
            <?php $this->load->view('profil/compte/mes_activites_item/nav_activites'); ?>
            <div class="col-md-9">
                <?php if (!$talents) { ?>
                    <div class="row empty-talents">
                        <div class="col-md-7 col-md-offset-2 text-left">
                            <p>Crée un profil Insider et propose le instantanément à toute la communauté.</p>
                            <div class="text-right btn-add-talent">
                                <a href="<?php echo base_url(); ?>mentor">Créer un profil Insider </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="row block_favoris talent_profil">
                    <?php foreach ($talents as $talent) { ?>
                        <div class="col-md-6">
                            <div class="col-md-12 item_fav bg_grey">
                                <div class="">
                                    <div class="row mh_bl mgb_0 ">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="img_article">
                                                <span class="avatar"><img src="<?php echo base_url(); ?>upload/talents/<?php echo $talent->cover; ?>" alt=""></span>

                                            </div>
                                        </div>

                                        <div class="col-md-8 col-sm-8 text-left">
                                            <h3><?php echo $talent->titre; ?></h3>
                                            <p><?php echo character_limiter($talent->description, 100); ?></p>
                                        </div>

                                    </div>

                                    <div class="border_b"></div>
                                    <div class="row mgb_0 ">
                                        <div class="col-md-6 col-sm-6 text-left status">
                                            <?php if ($talent->status) { ?>
                                                <a href="<?php echo base_url(); ?>mes_activites/desactiver/<?php echo $talent->id; ?>"> <span class="active">activé</span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url(); ?>mes_activites/activer/<?php echo $talent->id; ?>"><span class="desactive">Désactivé</span></a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6 col-sm-6 text-right share_fav">
                                            <!-- <a href="#"><i class="ion-eye"></i></a> -->
                                            <?php if ($talent->etanche) { ?>
                                                <a href="<?php echo base_url(); ?>mes_activites/etanche_on/<?php echo $talent->id; ?>"><i class="ion-eye-disabled"></i></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url(); ?>mes_activites/etanche_off/<?php echo $talent->id; ?>"><i class="ion-eye"></i></a>
                                            <?php } ?>
                                            <!--  <a href="#"><i class="fa fa-share-alt"></i></a> -->
                                        </div>


                                    </div>
                                </div>


                                <!-- on hover  -->
                                <a href="<?php echo base_url() . $this->user_info->getAliasUser(1) . '/' . $talent->alias; ?>/apropos">

                                    <div class="col-md-12 item_fav_text  text-left">
                                        <p><?php echo $talent->description; ?></p>
                                    </div>
                                </a>
                                <!-- end on hover -->
                            </div>
                        </div><!-- end item fav -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- footer -->
<?php $this->load->view('container_footer'); ?>

<!-- end footer -->
<!-- Modal creation talent-->
<div class="modal fade text-center modal_home modal_form" id="ModalAddEquipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>mes_activites/talents" enctype="multipart/form-data">
                    <input type="hidden" value="" id="id_wish" name="id_wish">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="row">
                        <h1>Creation une annonce</h1>
                    </div>


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

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <input type="text" name="prix" id="prix" class="numericOnly" placeholder="Indiquez le prix de talent">
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

                    <div class="row  ">
                        <div class="col-md-8 col-md-offset-2 ">
                            <div class="sub_cat">
                                <label class="list_selected"> </label> <input type="text" id="sous_cat" class="min_210" placeholder="rechercher une catégorie">

                                <div class="drop-list">
                                    <ul id="cat_list">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <input type="file" name="file" id="file" onchange="validate();" placeholder="image">
                        </div>
                    </div>

                    <div class="row demoInputBox" id="file_error">

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

<div class="modal fade text-center modal_home modal_form" id="modalchangeAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <div class="modal-body">

                <div class="row">
                    <h1>Image profile</h1>
                </div>
                <div class="row  ">
                    <div class="col-md-8 col-md-offset-2 ">
                        <div class="image-editor">
                            <input type="file" class="cropit-image-input">
                            <div class="cropit-image-preview"></div>
                            <div class="image-size-label">
                                Redimensionner image
                            </div>
                            <input type="range" class="cropit-image-zoom-input">
                        </div>
                    </div>
                </div>
                <div class="row btn_inscription ">
                    <div class="col-md-10 col-md-offset-1">
                        <button class="export" type="submit">valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var keys = [];
	$(document).ready(function () {

		$('.sendButton').attr('disabled', true);
		$('.required').keyup(function () {
			if ($("#name").val().length != 0 && $("#desc").val().length != 0)
				$('.sendButton').attr('disabled', false);
			else
				$('.sendButton').attr('disabled', true);
		})

		$("#sous_cat").keyup(function () {
			if ($(this).val().length < 2) return;
			$.ajax({
				type: "GET",
				url: "<?php echo base_url(); ?>autocomplete",
				data: 'categorie=' + $(this).val(),
				dataType: 'json',
				beforeSend: function () {
					$("#cat_list").html("Chargement...");
				},
				success: function (data) {
					$("#cat_list").html("");
					if (data.length == 0) {
						var text = '<li>Aucun résultat trouvé</li>';
						$("#cat_list").append(text);
					}
					$.each(data, function (index, element) {
						var text = '<li class="auto_cat" style="height:40px;" item="' + element.value + '" item_id="' + element.id + '"><a href="#" style="height:40px;">' + element.value + '</a></li>';
						$("#cat_list").append(text);
					});

					$('li.auto_cat').click(function (event) {
						event.preventDefault();
						var found = jQuery.inArray($(this).attr('item_id'), keys);
						if (found >= 0) {
							alert("Vous avez déja ajouter cette catégorie.");
						} else {
							keys.push($(this).attr('item_id'));
							$(".list_selected").append("<span class='item_of_sous_" + $(this).attr('item_id') + "'>" + $(this).attr('item') + "<a href='#' onclick='delete_me(" + $(this).attr('item_id') + ")'><i class='ion-close-circled'></i></a><input type='hidden' value='" + $(this).attr('item_id') + "' name='list_cat[]'></span>");
							$("#sous_cat").removeClass("min_210").addClass("m_ini");
							$(".drop_list").hide();
						}
					});


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

	function delete_me(argument) {
		$(".item_of_sous_" + argument).remove();
		var found = jQuery.inArray(argument, keys);
		keys.splice(found, 1);
	}

	$(function () {
		$('.image-editor').cropit({
			imageState: {
				src: '',
			},
		});

		$('.export').click(function () {
			var imageData = $('.image-editor').cropit('export');
			$('.export').attr('disabled', true);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>compte/upload_avatar",
				data: {avatar: imageData, csrf_token_name: csrf_token}, // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
					location.reload();
				}
			});
		});
	});

</script>