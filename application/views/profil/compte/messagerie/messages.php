<?php /* @var $this CI_Loader */ ?>
<?php /* @var $BusinessConversation BusinessConversation */ ?>

<section class="top_msg_back">
    <div class="container">
        <div class="row">
            <div class="col-md-4 ">
                <div class="text-left inbox_n">
                    <i class="fa fa-chevron-left"></i> <a href="<?php echo base_url(); ?>messages">Boîte de réception</a>
                </div>
            </div>
            <div class="col-md-8">
                <h1 class="text-right title_block_exp">
                    Conversation avec <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mgt_40">
                <?php if ($BusinessConversation->getBusinessDemandeRDV()->getStatus() == BusinessTalentDemande::STATUS_ENATTENTE) { ?>
                    <?php if ($BusinessConversation->IamTalentInConversation()) { ?>
                        <form class="f_reservation" action="post">
                            <p class="title">
                                <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> a besoin de votre aide en tant qu'Insider
                            </p>
                            <p class="text">
                                Répondez en moins de 24h pour ne pas faire baisser votre taux de réponse.<br/> Pour confirmer la prise de rendez-vous, acceptez la demande. Pensez à
                                contacter <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> pour convenir d’une heure exacte de RDV ainsi que les modalités de RDV (RDV
                                téléphonique, RDV physique, Skype...)<br/><br/> Récapitulatif de la demande :<br/>
                                Date: <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateRdvInText(); ?><br/>
                                Créneau: <?php echo $BusinessConversation->getBusinessDemandeRDV()->gethoraireText(); ?><br/> Durée: 30 minutes<br/>
                            </p>
                            <a class="btn btn-sm btn_style_send" onclick="validerDemande(<?php echo $BusinessConversation->getBusinessDemandeRDV()->getId(); ?>);" href="#">Accepter</a>
                            <a class="btn btn-sm btn_style_refus" href="#" data-toggle="modal" data-target="#ModalRefuserDemande">Refuser</a>
                            <div class="loader">Loading...</div>
                        </form>
                    <?php } else { ?>
                        <form class="f_reservation" action="post">
                            <p class="title">
                                Vous avez demandé un RDV avec <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?>
                            </p>
                            <p class="text">
                                <br/> Récapitulatif de la demande :<br/> Date: <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateRdvInText(); ?><br/>
                                Créneau: <?php echo $BusinessConversation->getBusinessDemandeRDV()->gethoraireText(); ?><br/> Durée: 30 minutes<br/> Vous allez recevoir une réponse sous 24h<br/><br/>
                                Pensez à contacter <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> pour convenir d’une heure exacte de RDV ainsi que les modalités de
                                RDV (RDV téléphonique, RDV physique, Skype...) 
                            </p>
                            <a class="btn btn-sm btn_style_send" data-toggle="modal" data-target="#ModalRefuserDemande" href="#">Annuler mon RDV</a>
                            <div class="loader">Loading...</div>
                        </form>
                    <?php } ?>
                <?php } else {
                    if ($BusinessConversation->getBusinessDemandeRDV()->getStatus() == BusinessTalentDemande::STATUS_VALIDER) { ?>
                        <?php if ($BusinessConversation->getBusinessDemandeRDV()->getTimestampRDV() > $timeStampNow) { ?>
                            <form class="f_reservation" action="post">
                                <p class="title">
                                    Rendez-vous confirmé
                                </p>
                                <p class="text">
                                    <br/> Récapitulatif de la demande :<br/> Date: <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateRdvInText(); ?><br/>
                                    Créneau: <?php echo $BusinessConversation->getBusinessDemandeRDV()->gethoraireText(); ?><br/> Durée: 30 minutes<br/> Pensez à
                                    contacter <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> pour convenir d’une heure exacte de RDV ainsi que les modalités de RDV
                                    (RDV téléphonique, RDV physique, Skype...)
                                </p>
                                <?php if ($BusinessConversation->IamTalentInConversation()) { ?>
                                    <a class="btn btn-sm btn_style_send" data-toggle="modal" data-target="#ModalRefuserDemande" href="#">Annuler le RDV avec le candidat</a>
                                <?php } else { ?>
                                    <a class="btn btn-sm btn_style_send" data-toggle="modal" data-target="#ModalRefuserDemande" href="#">Annuler mon RDV</a>
                                <?php } ?>
                            </form>
                        <?php } ?>
                    <?php }
                } ?>

                <form action="/messages/conversation/<?php echo $BusinessConversation->getId(); ?>" method="post" id="form_messagerie">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="conversations" value="<?php echo $BusinessConversation->getId(); ?>">
                    <input type="hidden" name="to" value="<?php echo $BusinessConversation->getBusinessUserInterlocutor()->getId(); ?>">
                    <textarea class="form-control text-area_style required" name="message" id="messagerie" rows="10" placeholder="Rédigez votre message et pensez à définir ensemble l’heure de début du rendez-vous téléphonique"></textarea>
                    <div class="row">
                        <div class="col-md-12 text-right ">
                            <div class="btn_send_msg">
                                <button type="submit" class="btn btn-sm btn_style_send sendButtonmessage" name="envoyer" value="Envoyer">Envoyer le message</button>
                            </div>
                        </div>
                    </div>
                </form>

                <?php foreach ($BusinessConversation->getAllMessages() as $BusinessMessage) {
                    /* @var $BusinessMessage BusinessMessage */ ?>
                    <div class="item_msg_chat <?php echo $BusinessMessage->getBoxInClass(); ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="img_sender">
                                    <?php if ($BusinessMessage->isAdminMessage()) { ?>
                                        <img src="/assets/img/admin/camille-ulyss.png" alt="">
                                    <?php } else {
                                        if ($BusinessMessage->getBusinessUserSender()->getAvatar() != '') { ?>
                                            <img src="<?php echo $BusinessMessage->getBusinessUserSender()->getAvatar(); ?>" alt="">
                                        <?php } else { ?>
                                            <img alt="" src="/upload/avatar/default.jpg">
                                        <?php }
                                    } ?>

                                </div>

                                <p class="bubble_sent">
                                    <?php echo $BusinessMessage->getText(); ?>
                                </p>
                                <p class="date_msg_send"><?php echo $BusinessMessage->getDateInText(); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-4 col-md-offset-1 mgt_40 profile_card">
                <!-- Begin profile -->
                <div class="row pad_card">
                    <a href="<?php echo $BusinessConversation->IamCandidatInConversation() ? $BusinessConversation->getBusinessUserInterlocutor()->getBusinessTalent()->getUrl() . 'apropos' : '#'; ?>">
                        <div class="card hovercard">
                            <div class="cardheader" style="background: url(/upload/covertures/default.jpg);">
                                <div class="avatar">
                                    <?php if ($BusinessConversation->getBusinessUserInterlocutor()->getAvatar() != '') { ?>
                                        <img src="<?php echo $BusinessConversation->getBusinessUserInterlocutor()->getAvatar(); ?>" alt="">
                                    <?php } else { ?>
                                        <img alt="" src="/upload/avatar/default.jpg">
                                    <?php } ?>
                                </div>
                                <span class="name_avatar"><?php echo $BusinessConversation->getBusinessUserInterlocutor()->getBusinessUserLinkedin()->getActualjobTitle(); ?></span>
                            </div>

                            <div class="name_pers_chat">
                                <div class="title_avatar">
                                    <span><?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?></span>
                                </div>
                                <div class="info_avatar">
                                    <i class="fa fa-map-marker color_marker"></i><span> <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getBusinessUserLinkedin()->getCompagnyName(); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End profile -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End chat page -->

<?php if ($BusinessConversation->IamCandidatInConversation()) { ?>
    <div class="modal fade text-center modal_home modal_form" id="ModalAddAccepter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="row btn_inscription ">
                        <div class="col-md-5">
                            <button class="sendButtondemande btn_style_refus" data-toggle="modal" data-target="#ModalRefuserDemande">Refuser</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade text-center" id="ModalRefuserDemande" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="row btn_inscription">
                    <div class="col-md-12">
                        Expliquez à <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> pourquoi vous devez annuler le RDV.
                        <textarea class="form-control text-area_style required" name="refusedRDV" id="refusedRDV" rows="10" placeholder="Rédigez le message qui sera envoyé à <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?>"></textarea>
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-sm btn_style_refus" onclick="$('#ModalRefuserDemande').modal('hide');" href="#">Annuler</a>
                        <?php if ($BusinessConversation->IamTalentInConversation()) { ?>
                            <a class="btn btn-sm btn_style_send" href="#" onclick="closeDemande(<?php echo $BusinessConversation->getBusinessDemandeRDV()->getId(); ?>); return false;">Envoyer</a>
                        <?php } else { ?>
                            <a class="btn btn-sm btn_style_send" href="#" onclick="closeDemande_candidat(<?php echo $BusinessConversation->getBusinessDemandeRDV()->getId(); ?>); return false;">Envoyer</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['showpopinaccept'])) { ?>
    <div class="modal fade text-center" id="ModalPopinAccept" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-body">
                <div class="modal-content">
                    <div class="row btn_inscription">
                        <div class="col-md-10 col-md-offset-1"><br/> Votre RDV est confirmé le <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(); ?>.<br/> Pensez à
                            préciser entre vous l’heure de début ainsi que les modalités de RDV (RDV téléphonique, RDV physique, Skype…)<br/><br/>
                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-sm btn_style_send" onclick="$('#ModalPopinAccept').modal('hide');" href="#">OK</a> <br/>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">$('#ModalPopinAccept').modal('show');</script>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function () {
		$('.sendButtonmessage').attr('disabled', true);
		$('.required').keyup(function () {
			if ($("#messagerie").val().length != 0)
				$('.sendButtonmessage').attr('disabled', false);
			else
				$('.sendButtonmessage').attr('disabled', true);
		})
		$('.required').change(function () {
			if ($("#messagerie").val().length != 0)
				$('.sendButtonmessage').attr('disabled', false);
			else
				$('.sendButtonmessage').attr('disabled', true);
		})


		$("#form_messagerie").submit(function () {
			if ($("#messagerie").val() == "") {
				return false;
			}
		});


	});
</script>
<script type="text/javascript">

	function closeDemande(arg) {
		$('.error_text').remove();
		if ($('#refusedRDV').val() == '') {
			$('#refusedRDV').after('<p class="error_text">Veuillez renseigner un message</p>');
		} else {
			$.ajax({
				type: "POST",
				url: base_url + "messages/refuser_demande",
				data: {
					id: arg,
					csrf_token_name: csrf_token,
					messageperso: $('#refusedRDV').val(),
					to:<?php echo $BusinessConversation->getBusinessUserInterlocutor()->getId(); ?>,
					conversations:<?php echo $BusinessConversation->getId(); ?> }, // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
					window.location = window.location.href.split("?")[0];
					return false;
				}
			});
		}
		return true;
	}

	function closeDemande_candidat(arg) {
		$('.error_text').remove();
		if ($('#refusedRDV').val() == '') {
			$('#refusedRDV').after('<p class="error_text">Veuillez renseigner un message</p>');
		} else {
			$.ajax({
				type: "POST",
				url: base_url + "messages/refuser_demande_candidat",
				data: {
					id: arg,
					csrf_token_name: csrf_token,
					messageperso: $('#refusedRDV').val(),
					to:<?php echo $BusinessConversation->getBusinessUserInterlocutor()->getId(); ?>,
					conversations:<?php echo $BusinessConversation->getId(); ?> }, // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
					window.location = window.location.href.split("?")[0];
					return false;
				}
			});
		}
		return false;
	}

	function validerDemande(arg) {
		$('.btn_style_send, .btn_style_refus').hide();
		$('.loader').show();
		$.ajax({
			type: "POST",
			url: base_url + "messages/valider_demande",
			data: {id: arg, csrf_token_name: csrf_token, to:<?php echo $BusinessConversation->getBusinessUserInterlocutor()->getId(); ?>, conversations:<?php echo $BusinessConversation->getId(); ?> }, // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('.btn_style_send, .btn_style_refus').show();
				$('.loader').hide();
				window.location.href = "<?php echo $_SERVER['REQUEST_URI'] . '?showpopinaccept' ?>";
				return false;
			}
		});
		return false;
	}
</script>