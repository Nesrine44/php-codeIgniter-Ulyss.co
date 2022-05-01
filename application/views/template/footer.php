<?php /* @var $this CI_Loader */ ?>


<footer class="footer_top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 block_1">
                <img src="/assets/img/logo_footer.png" class="img-responsive mgb_60" alt="">
                <p class="text-justify">
                    C'est en échangeant avec de nombreux demandeurs d'emploi que nous avons constaté que la meilleure façon de découvrir une entreprise et de faire le bon choix de carrière était
                    d'échanger directement avec un employé ou ex-employé. <br/>ULYSS.CO est la première plateforme qui met en relation les candidats qui postulent avec les salariés qui travaillent ou
                    qui ont travaillé dans l'entreprise convoitée. <br/>L'objectif de cet échange est double : découvrir l'entreprise et faire le bon choix de carrière. <br/>Notre communauté
                    d'Insiders est prête à vous conseiller. N'hésitez pas à les solliciter.
                </p>
            </div>
            <div class="col-md-3 block_3">
                <h2>Informations</h2>
                <a href="/">Trouver un Insider</a> <a href="<?= base_url() ?>/mentor">Devenir Insider</a> <a href="<?= base_url() ?>/employeur">Vous êtes employeur</a>
                <a href="<?= base_url() ?>/contact">Contact</a>

            </div>
            <div class="col-md-3 block_2">
                <h2>Restons connectés</h2>
                <a href="https://www.linkedin.com/company/11253777/" target="_blank"><span><i class="fa fa-linkedin"></i></span></a> <a href="https://www.facebook.com/ulyss.co/" target="_blank"><span><i class="fa fa-facebook"></i></span></a>
                <a href="https://twitter.com/ulyss_co" target="_blank"><span><i class="fa fa-twitter"></i></span></a>
            </div>


        </div>
    </div>
</footer>
<footer class="footer_bot">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Fait avec <i class="fa fa-heart-o"></i>par Ulyss <span style="margin-left: 80px; font-size: 13px"> Copyright 2019 MyM SAS. Tous droits réservés</span></p>
            </div>
            <div class="col-md-6 text-right">
                <a href="/conditions-generales-d-utilisation">CGU & Mentions légales</a> <a href="/charte-ethique">Charte ethique</a> <a href="/politique-de-confidentialite">Politique de
                    confidentialité & Données personnelles</a>

            </div>
        </div>
    </div>
</footer>

<div class="hamon" style="display:none;">
    <input type="button" onclick="closeHamon();return false;" class="fa fa-close" value="J'accepte"> En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous
    proposer des offres et services adaptés à vos centres d'intérêts. <br/>Pour en savoir plus et paramétrer les cookies, <a href="/conditions-generales-d-utilisation">cliquez-ici</a>.
</div>

<?php if ($this->session->userdata('logged_in_site_web') == false) { ?>
    <?php $this->load->view('auth_modal'); ?>
<?php } ?>


<div class="messenger">
    <div class="content cf"><a class="close" onclick="closeMessenger(); return false;">&times;</a>
        <div class="container"></div>
    </div>
</div>

<div class="modal fade text-center modal_home modal_form" id="modalText" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="row textinside">

                </div>
            </div>
        </div>
    </div>
</div>



<?php if ($this->getController()->getBusinessUser() != null && $this->getController()->getBusinessUser()->checkIfQuestionnaireIsWaiting() && uri_string() != 'mes_activites/questionnaires') { ?>
    <div class="modal fade text-center modal_home modal_form" id="modalQuestionnaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="width: 80%;margin: 0 auto 20px;">ULYSS.CO est un service totalement gratuit.<br/> Pour continuer d’en bénéficier, pouvez-vous s’il vous plait répondre à ces quelques
                        questions.</p>
                    <div class="btn_inscription cf">
                        <div class="col-md-10 col-md-offset-1 row ">
                            <a href="/mes_activites/questionnaires">Répondre au questionnaire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>$("#modalQuestionnaire").modal();</script>
<?php } else {
    if ($this->getController()->getBusinessUser() != null && $this->getController()->getBusinessUser()->getBusinessTalent() != null && $this->getController()->getBusinessUser()->getBusinessTalent()->checkIfQuestionnaireIsWaiting() && uri_string() != 'mes_activites/questionnaires_mentor') { ?>
        <div class="modal fade text-center modal_home modal_form" id="modalQuestionnaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p style="width: 80%;margin: 0 auto 20px;">Suite à votre dernier entretien avec un candidat, nous vous remercions de répondre à ces quelques questions<br/><br/> Merci,<br/>L’équipe
                            ULYSS.CO</p>
                        <div class="btn_inscription cf">
                            <div class="col-md-10 col-md-offset-1 row ">
                                <a href="/mes_activites/questionnaires_mentor">Répondre au questionnaire</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>$("#modalQuestionnaire").modal();</script>
    <?php } elseif (isset($_SESSION['changeactivity'])) { ?>
        <?php unset($_SESSION['changeactivity']); ?>
        <div class="modal fade text-center modal_home modal_form" id="modalScrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p style="width: 80%;margin: 0 auto 20px;">Vos expériences professionnelles ont évoluées, veuillez cliquer sur le bouton ci-dessous pour mettre à jour votre profil Insider sur
                            Ulyss.co</p>
                        <div class="btn_inscription cf">
                            <div class="col-md-10 col-md-offset-1 row ">
                                <a href="/auth/getLinkedinInfos/">Mettre à jour mon profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>$("#modalScrap").modal();</script>
    <?php }
} ?>

<?php if (false) { ?>
    <div class="modal fade text-center modal_home modal_form" id="modalLogLinkedin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/assets/images/logo_linkedin.png" alt="LinkedIn" width="130px">
                    <p>Afin d'alimenter votre profil Ulyss.co veuillez renseigner vos identifiants LinkedIn.</p>
                    <form method="post" action="/auth/getLinkedinInfos/" autocomplete="off">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                        <input type="text" value="" placeholder="Votre adresse email LinkedIn" name="emaillinkedin"/>
                        <input type="password" value="" placeholder="Votre mot de passe LinkedIn" name="passwordlinkedin"/>
                        <div class="cf conex_fb">
                            <a href="#" onclick="$(this).closest('form').submit();return false;" class="connect_with_linkedin"><span><i class="fa fa-linkedin"></i></span>Renseigner mon profil</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</body>
</html>


<script type="text/javascript">
	//l'entete pour les message de validation (vert)
    <?php if( $this->session->flashdata('message_valid') !== null ){ ?>

	var message = <?php echo json_encode($this->session->flashdata('message_valid')); ?>;

	$(document).ready(function () {
		bandeau(message, false);
	});
    <?php } ?>

	//l'entete pour les message d'erreur (rouge)
    <?php if( $this->session->flashdata('message_error') !== null ){ ?>

	var message = <?php echo json_encode($this->session->flashdata('message_error')); ?>;

	$(document).ready(function () {
		bandeauError(message, false);
	});
    <?php } ?>

	$("a.scrollLink").click(function (event) {
		event.preventDefault();
		$("html, body").animate({scrollTop: $($(this).attr("href")).offset().top}, 500);
	});
</script>



