<?php /* @var $this CI_Loader */
/* @var array $name */ ?>

<section class="hero_home hero_mentor" style="background: url('/assets/img/employeur/Background-Employeur.jpg') center center no-repeat;-webkit-background-size: cover;background-position:0px -100px;background-size: cover;min-height:430px; height: 100vh">

    <!-- and carousel -->
    <div class="container employeur_contain">
        <div class="row text-center text_hero">
            <div class="col-md-12">
                <p class="p_2 mgb50">VOS COLLABORATEURS SONT VOS MEILLEURS AMBASSADEURS</p>
                <button type="button" id="btn_srch" class="btn_srch "><a href="#inscription" style="color: #fff;">Débloquer ma page employeur</a></button>
            </div>
        </div>
    </div>
</section>
<!-- end hero home -->
<section class="second_block" id="ensavoirplus">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>76% des candidats souhaitent contacter des collaborateurs de l'entreprise qu'ils convoitent avant de postuler. Améliorez l'expérience de vos candidats et engagez vos collaborateurs
                    grâce à notre solution employeur.</h2>

                <a href="/recherche">Découvrir les Insiders ></a> <a href="#inscription" style="float: right">Débloquer ma page employeur ></a>
            </div>
            <div class="col-md-6">
                <video controls width="100%">
                    <source src="/assets/videos/ulyss_employeur.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>
<section class="employeurStep mgb50">
    <div class="row">
        <div class="col-md-6 emplStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6" data-aos="fade-left"><h2>Présentez votre entreprise et vos ambassadeurs</h2>
            <p class="mgb50">Bénéficiez d'une page employeur entièrement éditable qui met en valeur votre entreprise, vos Insiders, votre actualité et vos offres d'emploi et améliorez l'expérience de
                vos candidats. Ciblez les candidats que vous recrutez et augmentez la visibilité de vos ambassadeurs et de vos offres d'emploi. <br><br> <a href="/recherche">Découvrir les Insiders
                    ></a><a href="#inscription" style="margin-left: 20px;">Débloquer ma page employeur ></a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" data-aos="fade-right"><h2>Créez du lien avec vos ambassadeurs</h2>
            <p class="mgb50">Confiez votre marque employeur à vos collaborateurs. Dialoguez et partagez votre actualité avec vos ambassadeurs. Identifiez les profils les plus recommandés et
                associez-les à vos offres d'emploi. <br><br> <a href="/recherche">Découvrir les Insiders ></a><a href="#inscription" style="margin-left: 20px;">Débloquer ma page employeur ></a></p>
        </div>
        <div class="col-md-6 emplStep_bg" data-aos="fade-left"></div>
    </div>
    <div class="row">
        <div class="col-md-6 emplStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6" data-aos="fade-left">
            <h2>Visualisez, mesurez, progressez</h2>
            <p class="mgb50">Le dashboard d'analyse vous permet de mieux connaître le profil des candidats intéressés par votre entreprise et de vous jauger par rapport à la concurrence. Mesurez votre
                attractivité talents et recueillez des données précieuses sur la perception qu'ont les candidats de votre entreprise. <br><br> <a href="/recherche">Découvrir les Insiders
                    ></a><a href="#inscription" style="margin-left: 20px;">Débloquer ma page employeur ></a></p>
        </div>
    </div>
</section>

<section class="block-inscript bg_grey" id="inscription">
    <div class="container">
        <div class="row inscrip_ent">
            <h2>Inscrivez-vous pour débloquer votre page employeur</h2>
            <div name="inscri_Ent">
                <?php echo form_open('register_employeur') ?>
                <div class="col-md-6">
                    <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Nom" minlength="3" maxlength="15" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" placeholder="Prénom" minlength="3" maxlength="15" required>
                    <?php echo form_error('first_name') ?>
                </div>
                <div class="col-md-6">
                    <input type="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Adresse mail professionnelle"> <?php echo form_error('email') ?>
                </div><!------------------------------------------------------->
                <!----------Module de recherche entreprise--------------->
                <div class="col-md-6">
                    <?php echo form_error('entrepriselabel') ?>
                    <?php echo form_error('entreprise') ?>
                    <input type="text" id="entreprise_emp" name="entrepriselabel" value="<?php echo set_value('entrepriselabel'); ?>" placeholder="Nom de l'entreprise" autocomplete="off">

                    <input name="entreprise" id="entreprise_id" value="<?php echo set_value('entreprise'); ?>" type="hidden">

                    <div class="drop_list drop_list_e" style="display:none;">
                        <ul id="entreprise_list"></ul>
                    </div>
                </div>

                <!------------------------------------------------------->
                <div class="col-md-6">
                    <input type="text" name="function" value="<?php echo set_value('function'); ?>" placeholder="Fonction">
                    <?php echo form_error('function') ?>
                </div>
                <div class="col-md-6">
                    <input type="number" name="nbr_employes" value="<?php echo set_value('nbr_employes'); ?>" placeholder="Nombre d'employés">
                    <?php echo form_error('nbr_employes') ?>
                </div>
                <div class="col-md-6">
                    <input type="tel" name="tel" value="<?php echo set_value('tel'); ?>" placeholder="Numéro de téléphone" minlength="10" required>
                    <?php echo form_error('tel') ?>
                </div>
                <div class="col-md-6">
                    <input type="password" name="mdp" placeholder="Mot de passe">
                    <?php echo form_error('mdp') ?>
                </div>
                <div class="col-md-6">
                    <input type="password" name="mdp_confirm" placeholder="Confirmation Mot de passe">
                    <?php echo form_error('mdp_confirm') ?>
                </div>
                <div class="col-md-6">
                    <input type="submit" value="M'inscrire" class="btn_minscrire">
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bementor_block ep">
    <h2>Vous désirez en savoir plus ? Vous souhaitez une démonstration personnalisée de notre solution employeur ? <br><br> Contactez-nous</h2>
    <div class="btn_tem_ment center">
        <a href="mailto:hello@ulyss.co?subject=Je suis intéressé(e) et je souhaite bénéficier d'une démonstration d'ULYSS.CO">Bénéficier d'une démonstration personnalisée</a>
    </div>
</section>

<script type="text/javascript" src="/assets/js/BtoC/employeur.js"></script>
<script type="text/javascript">
    <?php if( $messagesend !== null ){ ?>
	$(document).ready(function () {
		bandeau('Votre message a été envoyé aux équipes Ulyss.co');
	});
    <?php } ?>
</script>
<script>
	$("#entreprise_emp").on('click keyup', function () {
		if ($(this).val().length < 3) {
			$('.drop_list .drop_list_e').hide();
			return false;
		}
		$("#entreprise_id").val(0);
		$(".drop_list_e").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/entrepriseAvanced",
			data: 'entreprise=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#entreprise_list").html("Chargement...");
			},
			success: function (data) {
				$("#entreprise_list").html("");
				if (data.length === 0) {
					let text = '<li>Aucun résultat trouvé</li>';
					$("#entreprise_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_e" item="' + element.value + '" item_id="' + element.id + '"  name="entrepriseName" ><a><img src="' + element.logo + '" style="width:25px;height:25px; margin: 5px" border="0">' + element.value + '</a></li>';
					$("#entreprise_list").append(text);
				});


				$('li.auto_cat_e').click(function (event) {
					event.preventDefault();
					$("#entreprise").val($(this).text());
					$("#entreprise_id").val($(this).attr('item_id'));
					$(".drop_list_e").hide();
				});


			}
		});
	});
</script>
