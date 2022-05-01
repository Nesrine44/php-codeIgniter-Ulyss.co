<?php /* @var $this CI_Loader */ ?>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<section class="hero_home hero_mentor" style="background: url('<?php echo base_url(); ?>assets/img/devenez-mentor2018.jpg') center center no-repeat;-webkit-background-size: cover;background-position:0 -100px;background-size: cover;min-height:430px; height: 100vh; background-attachment: fixed">

    <!-- and carousel -->
    <div class="container mentor_contain">
        <div class="row text-center text_hero mt80">
            <div class="col-md-12 col-xs-12">
                <p class="p_2">PARTAGEZ VOS EXPERIENCES PROFESSIONNELLES POUR AIDER LES CANDIDATS A FAIRE LE BON CHOIX D'ENTREPRISE</p>
            </div>
            <div class="" style="border: none;margin: 0;">
                <div class="row text-center">
                    <div class="col-md-12 col-sm-12">
                        <?php if ($this->session->has_userdata('logged_in_site_web')) { ?>
                            <div class="btn_tem_ment center">
                                <a href="<?= base_url() ?>mentor/etape1">Devenir Insider</a>
                            </div>
                        <?php } else { ?>
                            <div class="btn_tem_ment center">
                                <a href="#" data-toggle="modal" data-target="#modalInscriptionMentor">Devenir Insider</a>
                                <div class="loader">Loading...</div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end hero home -->
<section class="mentorStep">
    <div class="row">
        <div class="col-md-6 mentorStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6" data-aos="fade-left"><h2>Renseignez vos expériences</h2>
            <p class="mgb50">Votre expérience actuelle ou vos entreprises précédentes intéressent les candidats. Remplissez votre profil professionnel en quelques clics <br><br> <a href="/recherche">Devenir
                    Insider ></a><a href="/recherche" style="float: right">Découvrir les Insiders ></a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" data-aos="fade-right"><h2>Fixez vos disponibilités</h2>
            <p class="mgb50">Votre temps est précieux. Définissez vos disponibilités pour échanger avec les candidats intéressés. Ceux-ci peuvent vous contacter uniquement sur vos créneaux
                disponibles. Vous pouvez modifier vos disponibilités à tout moment. <br><br> <a href="/recherche">Devenir Insider ></a><a href="/recherche" style="float: right">Découvrir les Insiders
                    ></a></p>
        </div>
        <div class="col-md-6 mentorStep_bg" data-aos="fade-left"></div>
    </div>
    <div class="row">
        <div class="col-md-6 mentorStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6" data-aos="fade-left">
            <h2>Échangez avec les candidats</h2>
            <p class="mgb50">Vos expériences intéressent les candidats. Échangez par téléphone, en visioconférence ou partagez un café pour répondre à leurs questions et les aider à faire le bon choix
                d’employeur et de carrière. <br><br> <a href="/recherche">Devenir Insider ></a><a href="/recherche" style="float: right">Découvrir les Insiders ></a></p>
        </div>
    </div>
</section>
<section class="temoignagesMentors">
    <div class="row">
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>Laura T.</h4>
                    <p>Responsable marketing et communication <br><br> Je reçois souvent des demandes sur les réseaux sociaux pour des questions sur mon métier ou sur ma boîte. Difficile de répondre à
                        tout le monde et difficile de trouver le temps. Sur cette plateforme, ce qui m'a plu c'est qu'on fixe nos dispos pour échanger.

                        Cela m'a permis de rencontrer une candidate intéressée par un poste chez nous. On a partagé un café et je pense que sa vision par rapport à mon entreprise a changé.
                        Aujourd'hui, elle a intégré notre entreprise et c'est une super collègue de travail !</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>Nicolas M.</h4>
                    <p>Développeur Fullstack JS - Mobile <br><br> Quand on m'a parlé de la plateforme ULYSS j'ai tout de suite apprécié le principe. En effet, je trouve qu'il est important de pouvoir
                        échanger avec des « insiders » avant d'intégrer une entreprise. Les employeurs mettent souvent ça en place mais à la fin d'un process de recrutement. Là, ça permet de le faire
                        avant même de postuler !

                        J'ai pu échanger avec plusieurs candidats qui souhaitaient en savoir plus sur mon quotidien et mon environnement de travail. En plus, c'était des candidats avec des profils
                        tech donc on avait forcément beaucoup de choses en commun !</p></div>
            </div>
        </div>
    </div>
</section>
<section class="bementor_block mp">
    <h2>Vos expériences professionnelles intéressent les candidats</h2>
    <p class="mgb50">Les candidats souhaitent échanger avec vous pour en découvrir davantage sur vos expériences, vos missions, votre employeur. Votre avis les intéresse. Inscrivez-vous en tant
        qu'Insiders pour les aider dans leur choix de carrière.</p>
    <div class="btn_tem_ment center">
        <a href="<?= base_url() ?>/mentor">Devenir Insider</a>
    </div>
</section>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript">
	AOS.init({
		duration: 1200,
	})
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$("a.scrollLink").click(function (event) {
			event.preventDefault();
			$("html, body").animate({scrollTop: $($(this).attr("href")).offset().top}, 500);
		});
	});

</script>