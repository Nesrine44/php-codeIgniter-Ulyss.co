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
							<div class="btn-upld">Charger une image<input type="file" class="cropit-image-input"></div>
							<div class="cropit-image-preview"></div>
							<div class="image-size-label">
								Redimensionner image
							</div>
							<input type="range" class="cropit-image-zoom-input">
							<!--   <button class="export">Export</button> -->
						</div>
					</div>
				</div>
				<div class="row btn_inscription ">
					<div class="col-md-10 col-md-offset-1 button_su">
						<button class="export" type="submit">valider</button>
					</div>
					<div class="col-md-10 col-md-offset-1 chargement_b">
						<span class="load_photo"><i class="fa fa-circle-o-notch fa-spin"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end modal change picture-->

<script type="text/javascript">
    $(document).ready(function () {
        $(".chargement_b").hide();
        $("#carousel_coup").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });
    });

    $(function () {
        $('.image-editor').cropit({
            imageState: {
                src: '<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>',
            },
        });

        $('.export').click(function () {
            var imageData = $('.image-editor').cropit('export');
            $('.export').attr('disabled', true);
            $(".chargement_b").show();
            $(".button_su").hide();

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