<?php /* @var $this CI_Loader */ ?>
<?php /* @var $BusinessUser BusinessUser */ ?>
<?php /* @var $BusinessEntreprise BusinessEntreprise */ ?>
<?php $version = '2.0.0'; ?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="HandheldFriendly" content="true"/>
    <title><?php echo $SEO_title_page; ?></title>
    <meta name="title" content="<?php echo $SEO_title_page; ?>"/>
    <meta name="description" content="<?php echo $SEO_desc_page; ?>"/>
    <meta name="google-site-verification" content="b7y1tQsyWXNFLNyctMGhEp4mfvSusB994ujo7qnaL7o"/>
    <link rel="alternate" href="https://www.ulyss.co" hreflang="fr-fr"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/animations.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/trumbowyg.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/animate.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/owl-carousel/owl.carousel.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/owl-carousel/owl.theme.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/calendar.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/date-picker.min.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/lightbox.css?v=<?php echo $version; ?>"/>
    <link rel="stylesheet" href="/assets/css/hovercss/hover-min.css"/>
    <link rel="icon" href="/assets/img/Y.png"/>
    <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css"/>
    <!-- Bootstrap Date-Picker Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

    <?php if (ENVIRONMENT == 'production') { ?>
        <link rel="stylesheet" href="/assets/css/style.min.css?v=<?php echo $version; ?>"/>

    <?php } else { ?>
        <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo $version; ?>"/>
    <?php } ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->        <!--[if lt IE 9]>
    <script defer src="/assets/js/html5shiv.min.js"></script>
    <script defer src="/assets/js/respond.min.js"></script>        <![endif]-->
    <!-- Bootstrap JavaScript -->
    <script src="/assets/js/jquery.min.js?v=<?php echo $version; ?>"></script>
    <script defer src='/assets/js/css3-animate-it.min.js'></script>
    <script defer src="/assets/js/bootstrap.min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/range.min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/date-picker.min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/trumbowyg.min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/underscore-min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/calendar.min.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/js/lightbox.js?v=<?php echo $version; ?>"></script>
    <script defer src="/assets/css/owl-carousel/owl.carousel.min.js?v=<?php echo $version; ?>"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>


    <?php if (ENVIRONMENT == 'development') { ?>
        <script defer src="/assets/js/app.js?v=<?php echo $version; ?>"></script>
    <?php } else { ?>
        <script defer src="/assets/js/app.min.js?v=<?php echo $version; ?>"></script>
    <?php } ?>
    <script defer type="text/javascript">
		var base_url   = "<?php echo base_url(); ?>";
		var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <?php if (isset($sharing)) { ?>
        <?php if (isset($sharing['facebook']) && is_array($sharing['facebook'])) { ?>
            <?php foreach ($sharing['facebook'] as $property => $content) { ?>
                <meta property="<?php echo $property; ?>" content="<?php echo $content; ?>"/>
            <?php } ?>
        <?php } ?>
        <?php if (isset($sharing['twitter']) && is_array($sharing['twitter'])) { ?>
            <?php foreach ($sharing['twitter'] as $name => $content) { ?>
                <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>"/>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <meta property="og:title" content="ULYSS"/>
        <meta property="og:type" content="article"/>
        <meta property="og:url" content="/"/>
        <meta property="og:image" content="<?= base_url() ?>/assets/img/banniere/b543ec8e-2c01-449a-bc3d-09f93f37a2cb.jpg"/>
        <meta property="og:description" content="ulyss..."/>
        <meta property="og:site_name" content="ulyss"/>
    <?php } ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118771546-1"></script>
    <script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}

		gtag('js', new Date());

		gtag('config', 'UA-118771546-1');

    </script>
</head>
<body>
<!-- ORGANISATION -->
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "Ulyss.co",
        "url": "https://www.ulyss.co",
        "logo": "https://www.ulyss.co/assets/img/logo-beta.png",
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "telephone": "+336 60 06 48 04",
                "contactType": "customer service",
                "contactOption": "TollFree",
                "areaServed": "FR",
                "availableLanguage": "French"
            }
        ]
    }


</script>
<!-- WEBSITE -->
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "Ulyss.co",
        "url": "https://www.ulyss.co"
    }


</script>

<?php
$this->getController()->session->set_userdata('last_page_visited', $_SERVER['REQUEST_URI']);
// si il se n'est pas encore inscri dans la table mentor => donc c'est la premier fois qu'il se connecte
// alor on le redirige vers la page inscription

if ($this->getController()->userIsAuthentificate()
    && $_SERVER['REQUEST_URI'] != '/inscription/etape1'
    && $_SERVER['REQUEST_URI'] != '/inscription/etape2'
    && $_SERVER['REQUEST_URI'] != '/register_done'
    && $_SERVER['REQUEST_URI'] != '/inscription/insider'
    && $_SERVER['REQUEST_URI'] != '/inscription/insider-etape2'
    && $_SERVER['REQUEST_URI'] != '/inscription/insider-etape3'
    && $_SERVER['REQUEST_URI'] != '/inscription/insider-etape4'
    && $_SERVER['REQUEST_URI'] != '/inscription/insider-validation'
) {

    // seperation des redirect des deux tunel
    // verification si l'url redirect envoier  pour l'api linkdin Est bien pris en compte
    // creation de firstTimeConnectMentor (optionelle)

    $this->getController()->firstTimeConnect();
}
?>
<!-- header home non logger -->

<nav class="navbar navbar-fixed-top nav-top <?php echo $this->getController()->userIsAuthentificate() == false && $this->getController()->companyIsAuthentificate() == false ? '' : 'header_2'; ?> <?php echo $header_class; ?>">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" onclick="ga('send', 'event', 'CTA', 'logo');"><img src="/assets/img/<?php echo $header_logo; ?>.png" alt=""></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse pull-right">
            <ul class="nav navbar-nav navigation">
                <li class="link_talent">
                    <a href="<?= base_url() ?>mentor">DEVENIR INSIDER</a>
                </li>
                <!-- nav de trouver mon mentor -->
                <?php if ($this->getController()->companyIsAuthentificate() == false) { ?>
                    <li class="<?php echo uri_string() === '' ? 'active' : ''; ?>"><a href="<?= base_url() ?>recherche">Trouver mon Insider</a></li>
                <?php } ?>
                <?php if ($this->getController()->companyIsAuthentificate() == false) { ?>
                    <li class=""><a href="/employeur">Vous êtes employeur</a>
                    </li>
                <?php } ?>

                <!-- nav de connection/deconnection (user) -->

                <?php if ($this->getController()->userIsAuthentificate() == false && $this->getController()->companyIsAuthentificate() == false) { ?>
                    <li class="link_employeur"><a href="">Se connecter</a>
                        <ul class="submenu">
                            <li><a href="#" data-toggle="modal" data-target="#ModalConnexion">Candidat</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#ModalConnexion">Insider</a></li>
                            <li><a data-toggle="modal" data-target="#connectModal">Employeur</a></li>
                        </ul>
                    </li>
                    <li class="link_employeur"><a href="">S'inscrire</a>
                        <ul class="submenu">
                            <li><a href="#" data-toggle="modal" data-target="#modalInscription">Candidat</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#modalInscriptionMentor">Insider</a></li>
                            <li><a href="/employeur/#inscription">Employeur</a></li>
                        </ul>
                    </li>
                <?php } else { ?><?php if ($this->getController()->userIsAuthentificate() == true) { ?>
                    <!-- nav pour le user  -->
                    <li>
                        <div class="">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<span class="avatar_header">

                                        <?php if ($this->getController()->getBusinessUser()->getAvatar() != '') { ?>
                                            <img src="<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>" alt="">
                                        <?php } else { ?>
                                            <img src="<?= base_url() ?>/upload/avatar/default.jpg" alt="">
                                        <?php } ?>
									</span> <?php echo $this->getController()->getBusinessUser()->getFullName(); ?>
                                <span class="fa fa-chevron-down"></span> </a>
                            <ul class="dropdown-menu">
                                <?php if ($BusinessUser->isMentor()) { ?>
                                    <li><a href="/<?php echo $BusinessUser->getMentor()->getUrlProfile(); ?>">Voir mon profil</a></li>
                                    <li><a href="/tableau_de_bord">Tableau de bord</a></li>
                                    <li><a href="/calendrier">Calendrier</a></li>
                                <?php } ?>
                                <li><a href="/mes_activites">Mes activités</a></li>
                                <li><a href="/messages">Messages</a></li>
                                <li><a href="/compte">Compte</a></li>
                                <li><a href="/login/logout">Déconnexion</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="icon_badge">
                        <a class="envelop" href="/messages"><span><i class="fa fa-envelope"></i><?php echo $BusinessUser->getTotalMessagesNonLus() > 0 ? '<em>' . $BusinessUser->getTotalMessagesNonLus() . '</em>' : ''; ?></span>
                            <strong class="showm">Mes messages</strong></a></li>

                <?php } elseif ($this->getController()->companyIsAuthentificate() == true) { ?>
                    <li>
                        <div class="">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<span class="avatar_header">

                                        <?php if ($this->getController()->getBusinessEntreprise()->getLogo() != '') { ?>
                                            <img src="<?php echo base_url('upload/logos/' . $BusinessEntreprise->getLogo()) ?>" alt="">
                                        <?php } else { ?>
                                            <img src="<?= base_url() ?>/upload/avatar/default.jpg" alt="">
                                        <?php } ?>
									</span> <?php echo $this->getController()->getBusinessEntreprise()->getNom(); ?>
                                <span class="fa fa-chevron-down"></span> </a>
                            <ul class="dropdown-menu">
                                <li><a href="/entreprise/<?php echo $BusinessEntreprise->getAlias(); ?>">Mon profil entreprise</a></li>
                                <li><a href= <?php echo base_url() . "entreprise/" . $BusinessEntreprise->getAlias() . "/messages"; ?>>Messages</a></li>
                                <li><a href="/login/logout">Déconnexion</a></li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="connectModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="connectInput">
                <img src="/assets/img/logo_2.png" alt="logo ulyss">

                <div class="row">
                    <div class="col-md-12 text-center block_pass" style="display:none;" id="erreur-connect-ent">
                    </div>
                </div>

                <?php echo form_open('welcome_employeur') ?>

                <label for="login">Identifiant</label>
                <?php echo form_error('login') ?>
                <input type="text" name="login" placeholder="Identifiant">

                <label for="password">Mot de passe</label>
                <?php echo form_error('password') ?>
                <input type="password" name="password" placeholder="Mot de passe">

                <input class="connect_btn" type="submit" value="Connexion">
                <?php echo form_close() ?>
                <p><a data-toggle="modal" data-target="#forgetModal">Mot de passe oublié ?</a></p>
                <p><a href="/employeur#inscription">Pas encore inscrit ?</a></p>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="forgetModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <?php echo form_open() ?>
                <p>Veuillez saisir votre adresse email pour récupérer votre mot de passe :</p>
                <input id="email_oublier" type="email" name="email_oublier" placeholder="Adresse mail de connexion">

                <input onclick="return ForgetMypassword()" class="forgot_btn" type="submit" value="ENVOYER">
                <div class="row">
                    <div class="col-md-12 text-center block_pass" style="display:none;" id="erreur-mdp-oublier">
                        <p class="error">Merci de renseigner votre adresse mail</p>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<?php if ($this->session->userdata('logged_in_site_web') == false) { ?>
    <?php $this->load->view('inscrip_modal'); ?>
    <?php $this->load->view('inscrip_modal_mentor'); ?>
<?php } ?>

<!-- DEBUT verif des Questionaires-->

<?php // affichage des questionnaire et de l'ajout des department et de la formation lors de la premiere connexion
if ($this->getController()->userIsAuthentificate()) {
    if ($this->getController()->hasQuestionnairesUser() || $this->getController()->hasQuestionnairesMentor()) {
        $this->view('profil/compte/mes_activites_item/questionnaires'); ?>

        <script>$(document).ready(function () {
				$('#questionModal').modal('show');
			});
        </script>
    <?php }
} ?>


<!-- FIN verif des Questionaires-->

<script>


	function ForgetMypassword() {
		if ($("#email_oublier").val() == "") {
			$("#erreur-mdp-oublier").html('<p class="erreur_p">Veuillez renseigner une adresse mail</p>');
			$("#erreur-mdp-oublier").show();
			setTimeout(function () {
				$("#erreur-mdp-oublier").hide();
			}, 6000);
			return false;
		}

		email_oublier = $("#email_oublier").val();
		$.ajax({
			type: "POST",
			url: base_url + "entreprise/login_ent/mdp_oublier",
			data: {email_oublier: email_oublier, csrf_token_name: csrf_token},
			dataType: 'json',
			success: function (json) {
				if (json.operation === false) {

					$("#erreur-mdp-oublier").html('<p class="erreur_p">' + json.msg + '</p>');
					$("#erreur-mdp-oublier").show();
					setTimeout(function () {
						$("#erreur-mdp-oublier").hide();
					}, 6000);

				} else if (json.operation === true) {
					$("#forgetModal").hide();
					$(".modal-backdrop").hide(); // supprime le fond !!!!!!!!!!!!!!!!!!!!!!!! :D :D :D
					$("#erreur-connect-ent").html('<p class="succed_p">' + json.msg + '</p>');
					$("#erreur-connect-ent").show();
					setTimeout(function () {
						$("#erreur-connect-ent").hide();
					}, 7000);

				}


			}
		});
		return false;
	}
</script>

