<section class="hero_home bg_recherche bg_wishlist" style="background:url('<?php echo base_url(); ?>assets/img/bg_wishlist.png');">
	<div class="container">
		<div class="row text-center text_hero">
			<div class="col-md-6 col-md-offset-3">
				<p class="p_4">Reinitialiser le mot de passe</p>
				<p class="p_5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, eius.</p>
			</div>
		</div>


	</div>
</section><!-- end hero home -->

<section class="block_result_search">
	<div class="container">
		<div class="row block_mn_compte">
			<div class="col-md-4 col-md-offset-4 mes_infos_compte">
				<form id="reinitialiserPassword" method="POST" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="title_label">
							<span>Nouveau mot de passe </span>
						</div>
						<div>
							<input type="hidden" value="<?php echo $code; ?>" name="code">
							<input type="password" value="" name="nouveau_p">
						</div>
					</div>
					<div class="row">
						<div class="title_label">
							<span>Confirmation mot de passe </span>
						</div>
						<div>
							<input type="password" value="" name="confirmation_p">
						</div>
					</div>

					<div class="row">
						<p class="error erreur_reinitialiser" style="display:none;">
							Les identifiants sont incorrects
						</p>
					</div>
					<div class="row">

						<div class="btn_info btn-center">
							<button class="sendButton" type="submit">Sauvegarder</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
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
    });
    function gotoSearch() {
        $('#Formsearch').submit();
    }
</script>