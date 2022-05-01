<?php /* @var $this CI_Loader */ ?>
<section class="block_confirmation">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Compte crée</h2>
				<a class="btn btn-sm btn_style_send" href="/<?php echo $this->getController()->getBusinessUser()->getMentor()->getUrlProfile(); ?>">Voir mon profil</a>
				<div class="row text-center">
					<div class="col-md-12 title_decouvert">
						<h2>Partagez notre page pour que chacun puisse trouver un mentor dans son domaine</h2>
					</div>
				</div>
				<div class="row text-center btn_tem_ment mgt00 ">
					<div class="col-md-12 btn_share_social">
						<a href="http://www.facebook.com/sharer.php?u=<?php echo base_url(); ?>" target="_BLANK"><i class="fa fa-facebook"></i>Partager sur Facebook</a>
						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>&source=Ulyss" target="_BLANK"><i class="fa fa-linkedin"></i>Partager sur Linkedin</a>
						<a href="https://twitter.com/intent/tweet/?url=<?php echo base_url(); ?>&text=ulyss&via=ulyss" target="_BLANK"><i class="fa fa-twitter"></i>Partager sur Twitter</a>
					</div>
				</div>


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
    });

    $(document).ready(function () {
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