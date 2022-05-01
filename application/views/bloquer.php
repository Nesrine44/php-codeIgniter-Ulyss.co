<?php /* @var $this CI_Loader */ ?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="HandheldFriendly" content="true"/>
    <title><?php echo $this->lang->line("title_site"); ?></title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animations.css" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


    <link href="<?php echo base_url(); ?>assets/css/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/owl-carousel/owl.theme.css" rel="stylesheet">


    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>    <![endif]-->
</head>
<body>

<!-- header home non logger -->
<?php if (!$this->session->userdata('logged_in_site_web')) { ?>
    <nav class="navbar  navbar-fixed-top nav-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo-beta.png" alt=""></a>
            </div>


        </div>
    </nav>
<?php } else { ?>
    <!-- end header home non logger -->
    <!-- header home logger -->

    <nav class="navbar  navbar-fixed-top nav-top header_2 bg_n">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo-beta.png" alt=""></a>
            </div>

            <div id="navbar" class="navbar-collapse collapse pull-right">
                <ul class="nav navbar-nav navigation">
                    <li class=""><a href="#"><?php echo $this->lang->line("decouvrir_cowanted"); ?></a></li>
                    <li>
                        <div class=" ">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				  <span class="avatar_header">
					<?php if ($this->getController()->getBusinessUser()->getAvatar() != '') { ?>
                        <img src="<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>" alt="">
                    <?php } else { ?>
                        <img src="/upload/avatar/default.jpg" alt="">
                    <?php } ?>

				  </span> <?php echo $this->getController()->getBusinessUser()->getFullName(); ?>

                                <span class="fa fa-chevron-down"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>">Voir mon profil</a></li>
                                <li><a href="<?php echo base_url(); ?>tableau_de_bord">Tableau de bord</a></li>
                                <li><a href="<?php echo base_url(); ?>calendrier">Calendrier</a></li>
                                <li><a href="<?php echo base_url(); ?>mes_activites">Mes activités</a></li>
                                <li><a href="<?php echo base_url(); ?>messages">Messages</a></li>
                                <li><a href="<?php echo base_url(); ?>compte">Compte</a></li>
                                <li><a href="<?php echo base_url(); ?>login/logout">Déconnexion</a></li>

                            </ul>
                        </div>
                    </li>
                    <li class="icon_badge"><a href="<?php echo base_url(); ?>messages"><span><i class="fa fa-envelope"></i><?php echo $this->user_info->getTotalNonLus(); ?></span></a></li>
                    <li class="icon_search"><a href="#"><span><i class="fa fa-search"></i></span></a></li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- end header home logger -->
<?php } ?>
<section class="hero_home bg_recherche bg_wishlist" style="background:url('<?php echo base_url(); ?>assets/img/bg_wishlist.png');">
    <div class="container">
        <div class="row text-center text_hero">
            <div class="col-md-6 col-md-offset-3">
                <p class="p_4">Accès refusé</p>
                <!-- 		<p class="p_5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, eius.</p> -->
            </div>
        </div>


    </div>
</section><!-- end hero home -->

<section class="block_resultas">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-12">
                    <h1>Rétablir accés</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><?php echo $this->lang->line("phrase_bloque"); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 btn_add_demande">
                    <a href="<?php echo base_url(); ?>bloquer/debloquer"><?php echo $this->lang->line("bloquer"); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- footer -->
<footer class="footer_top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 block_1">
                <img src="<?php echo base_url(); ?>assets/img/logo-beta.png" class="img-responsive mgb_60" alt="">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit commodi soluta dolor inventore, sequi aliquam rerum maxime provident voluptates, alias.</p>
            </div>
            <div class="col-md-3 block_2">
                <h2>Restez connéctés</h2>
                <a href="#"><span><i class="fa fa-facebook"></i></span></a> <a href="#"><span><i class="fa fa-twitter"></i></span></a> <a href="#"><span><i class="fa fa-instagram"></i></span></a>
                <a href="#"><span class="blog">Blog</span></a>
            </div>
            <div class="col-md-3 block_3">
                <h2>Informations</h2>
                <a href="#">Comment ca marche</a> <a href="#">FAQ</a> <a href="#">CGU</a> <a href="#">CGV</a>

            </div>

        </div>
    </div>
</footer>
<footer class="footer_bot">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Fait avec <i class="fa fa-heart-o"></i> par CoWanted</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="#">Mentions légales</a> <a href="#">Politique de confidentialité</a>
            </div>
        </div>
    </div>
</footer>


<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src='<?php echo base_url(); ?>assets/js/css3-animate-it.js'></script>
<script type="text/javascript">
	var base_url   = "<?php echo base_url(); ?>";
	var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>
<!-- Bootstrap JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/css/owl-carousel/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>assets/js/range.js"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>


</body>
</html>
