<!-- Modal demande -->
<?php if ($this->session->userdata('logged_in_site_web')) { ?>
	<!-- Modal change talent-->
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
									Resize image
								</div>
								<input type="range" class="cropit-image-zoom-input">
								<!--   <button class="export">Export</button> -->
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
<?php } ?>
<!-- end modal creation talent-->
<div class="modal fade text-center modal_home" id="modalADDdemandeConfirmationajoutDEmande" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-body">

				<div class="row">
					<h2>Votre demande a bien été prise en compte</h2>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal_share" id="modal-partage">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4 btn_connection ">
						<a href="http://www.facebook.com/sharer.php?u=<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos" target="_blank" class="share_fb">
							<i class="fa fa-facebook"></i> Partager sur Facebook
						</a>
					</div>
					<div class="col-md-4 btn_connection ">
						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos&source=Easylearn" target="_blank" class="share_lkd">
							<i class="fa fa-linkedin"></i> Partager sur linkedin
						</a>
					</div>
					<div class="col-md-4 btn_connection ">
						<button class="btn btn-blue btn-block btn-share-with-freind"><i class="fa fa-envelope"></i>Partager à un ami</button>
					</div>
				</div>
			</div>
			<div class="outer-footer text-center">
				<button class="btn btn-blue btn-clos" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade tfa-modal modal-comment-tags modal_share" id="modal-add-share-with-freind" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<h1 class="outer-title text-center">Partager à un ami</h1>
		<div class="modal-content text-center">
			<div class="modal-body">
				<div class="row">
					<p class="msg_error"></p>
				</div>
				<form id="form-share-it">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <?php if ($this->session->userdata('logged_in_site_web')) { ?>
						<input type="text" name="name_user" class="form-control" value="<?php echo $this->session->userdata('logged_in_site_web')['name']; ?>" placeholder="Votre nom">
                    <?php } else { ?>
						<input type="text" name="name_user" class="form-control" value="" placeholder="Votre nom">
                    <?php } ?>
					<input type="text" name="from" class="form-control" value="<?php echo $this->session->userdata('logged_in_site_web')['email']; ?>" placeholder="Votre email">
					<input type="text" name="to" class="form-control" placeholder="Email de destinataire">
					<input type="hidden" name="symbol" value="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos">
					<input type="hidden" name="name" value="<?php echo $info_talent->titre; ?>">
					<input type="hidden" name="overview" value="<?php echo $info_talent->description; ?>">
					<div class="action">
						<button type="button" class="btn btn-blue-o" data-dismiss="modal">Annuler</button>
						<button class="btn btn-blue btn-pdn-md bt-submit-share-with-freind">Envoyer</button>
					</div>
				</form>
				<div class="action close_after" style="display:none;">
					<button type="button" class="btn btn-blue-o" data-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    var prix_par_heure = "<?php echo $info_talent->prix; ?>";
    var prix_supp_personne = "<?php echo $info_talent->reduction_personne; ?>";
    var frais_de_service = 8;
    var reduction_heure = "<?php echo $info_talent->reduction_heure; ?>";
    var pourcentage = "<?php echo $info_talent->reduction; ?>";
    $(document).ready(function () {
        $("#carousel_coup , #carousel_savoir").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });
        $('.date-picker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: "true",
            language: 'fr'
        });
    });
</script>

<script type="text/javascript">
    // When the document is ready
    $(document).ready(function () {
        <?php
        $php_array = $get_disponibilite_in_week;
        $js_array = json_encode($php_array);
        echo "var active_dates = " . $js_array . ";\n";
        $js_array1 = json_encode($all_holidays);
        echo "var active_dates1 = " . $js_array1 . ";\n";
        ?>

        $('.date-picker-i').datepicker({
            format: "dd/mm/yyyy",
            autoclose: "true",
            startDate: '1d',
            language: 'fr',
            todayHighlight: true,
            beforeShowDay: function (date) {
                var d = date;
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();

                var formattedDate = d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);

                //  console.log("yes",formattedDate);
                var n = d.getDay();

                if ($.inArray(n, active_dates) != -1 || $.inArray(formattedDate, active_dates1) != -1) {
                    return {
                        classes: 'no_diponible'
                    };
                }
                return;
            }
        });
        $('.date-picker-i').on("changeDate", function () {
            $.ajax({
                type: "POST",
                url: base_url + "profil/get_html_dispo",
                dataType: 'json',
                data: {date: $('.date-picker-i').datepicker('getFormattedDate'), talent_id:<?php echo $info_talent->id; ?>, csrf_token_name: csrf_token},
                success: function (json) {
                    $(".html_dispo").html(json.html);
                    $("#js_nbr_heure").html(json.html_heure);
                    if (json.html_heure == "") {
                        $("#button_reservation").addClass("me_reserv");
                        $("#button_reservation").prop("disabled", true);
                    } else {
                        $("#button_reservation").removeClass("me_reserv");
                        $("#button_reservation").prop("disabled", false);
                    }
                    $('.horaire_td').click(function () {

                        if ($(this).find('.check_disp').is(":checked")) {

                            $(this).find('.check_disp').attr("checked", false);
                        }
                        else {
                            $(this).find('.check_disp').prop("checked", true);
                        }
                        $(this).toggleClass('active');
                    });
                }
            });
            $('#my_hidden_input').val(
                $('.date-picker-i').datepicker('getFormattedDate')
            );
        });

    });
</script>
<?php if ($this->session->userdata('logged_in_site_web')) { ?>
	<script>
        $(function () {
            $('.image-editor').cropit({
                imageState: {
                    src: '<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>',

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
<?php } ?>