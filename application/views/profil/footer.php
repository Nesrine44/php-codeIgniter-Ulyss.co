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