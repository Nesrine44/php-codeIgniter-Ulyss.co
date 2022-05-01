<?php /* @var $this CI_Loader
 * @var array              $chapeauTab
 * @var BusinessEntreprise $BusinessEntreprise
 * @var BusinessUser       $BusinessUser
 */

?>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<section class="hero_home">
    <!-- carousel -->
    <div id="carousel-slider-home" class="carousel slide carousel-fade" data-ride="carousel" data-interval="500000">
        <div class="carousel-inner">
            <div class="item active" style="background: url('<?= base_url() ?>/assets/img/homepage/HOMENEW.jpg') center center no-repeat;-webkit-background-size: cover;background-size: 100% auto;background-position: center; background-attachment: fixed">
            </div>
        </div>
    </div>
    <!-- and carousel -->
    <div class="container">
        <div class="row text_hero">
            <div class="col-md-12">
                <h1 class="p_2"></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="searchAccess">
                    <div class="container">
                        <!-- on desktop  -->
                        <div class="row hidden-xs">
                            <button type="button" id="btn_srch" class="btn_srch mgb50"><a href="<?= base_url() ?>recherche" style="color: #fff;">Trouver un Insider</a></button>
                        </div>
                        <!-- end desktop  -->
                        <!-- on mobile -->
                        <div class="row visible-xs">
                            <button type="button" id="btn_srch" class="btn_srch mgb50"><a href="<?= base_url() ?>recherche" style="color: #fff;">Trouver un Insider</a></button>
                        </div>
                        <!-- end mobile -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row comptes">
            <div class="col-md-4">+ <span class="counter"> 3500</span> <br>Insiders</div>
            <div class="col-md-4">+ <span class="counter"> 20000</span> <br>Expériences à partager</div>
            <div class="col-md-4">+ <span class="counter"> 10000</span><br>Entreprises représentées</div>
        </div>
    </div>
</section>
<!-- end hero home -->

<section class="second_block" id="ensavoirplus">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2>Qui mieux que le collaborateur en poste peut témoigner de son métier, de ses missions et de son employeur ?</h2>
                <p class="mgb50">Des milliers d'Insiders sont disponibles pour échanger avec vous et vous aider dans votre orientation professionnelle en partageant leur expérience. N'hésitez pas à
                    les contacter.</p>
                <a href="/recherche">Découvrir les Insiders ></a> <a href="/mentor" style="float: right">Devenir Insider ></a>
            </div>
            <div class="col-md-6 col-xs-12">
                <video controls width="100%" poster="/assets/videos/Capture.PNG">
                    <source src="/assets/videos/Ulyss_trailer.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>
<section class="userStep">
    <div class="row">
        <div class="col-md-6 userStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6" data-aos="fade-left"><h2>Choisissez un Insider</h2>
            <p class="mgb50">Découvrez une sélection d'Insiders qui travaillent ou qui ont travavaillé dans l'entreprise que vous convoitez. <br> Ils sont prêts à partager leur expérience
                professionnelle. <br><br> <a href="/recherche">Découvrir les Insiders ></a><a href="/mentor" style="margin-left: 30px;">Devenir Insider ></a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" data-aos="fade-right"><h2>Prenez RDV en ligne</h2>
            <p class="mgb50">Les Insiders fixent leurs disponibilités pour échanger avec vous et partager leur vision de leurs missions et de leur employeur. <br> Prenez RDV pour échanger, en toute
                transparence. <br><br>

                <a href="/recherche">Découvrir les Insiders ></a><a href="/mentor" style="margin-left: 30px;">Devenir Insider ></a></p>
        </div>
        <div class="col-md-6 userStep_bg" data-aos="fade-left"></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12 col-xs-push-12 userStep_bg" data-aos="fade-right"></div>
        <div class="col-md-6 col-xs-12 col-xs-pull-12 " data-aos="fade-left">
            <h2>Discutez avec votre Insider</h2>
            <p class="mgb50">Vous souhaitez en savoir plus sur le poste, les missions, l'environnement de travail. Ils sont là pour vous aider. <br>Echangez par téléphone, visioconférence ou autour
                d'un café, pour faire le bon choix. <br><br> <a href="/recherche">Découvrir les Insiders ></a><a href="/mentor" style="margin-left: 30px;">Devenir Insider ></a></p>
        </div>
    </div>
</section>
<section class="bementor_block">
    <h2>Vos expériences professionnelles intéressent les candidats</h2>
    <p class="mgb50">Les candidats souhaitent échanger avec vous pour en découvrir davantage sur vos expériences, vos missions, votre employeur. Votre avis les intéresse. Inscrivez-vous en tant
        qu'Insiders pour les aider dans leur choix de carrière.</p>
    <div class="btn_tem_ment center">
        <a href="/mentor">Devenir Insider</a>
    </div>
</section>
<section class="temoignages">
    <div class="row">
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>Christel DE FOUCAULT</h4>
                    <p>Conférencière, formatrice et auteure sur les techniques de recherche d'emploi et la marque employeur <br><br> Je recommande personnellement la plateforme Ulyss.co car elle va
                        dans le sens de la Marque Employeur. Qui mieux qu'une personne ayant travaillé ou travaillant dans une entreprise pour en parler à un candidat intéressé ? C'est un excellent
                        moyen pour les chercheurs d'emploi d'avoir une vraie vision d'une entreprise, de son fonctionnement et de ses valeurs afin de postuler en connaissance de cause. C'est une belle
                        opportunité pour les entreprises de faire de leurs collaborateurs des ambassadeurs investis.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>Jules BERTELLI</h4>
                    <p>Développeur Fullstack sénior <br> <br>Pour les profils IT/Tech, échanger avec un RH ne sert pas à grand-chose car il ne connaît pas tout de notre métier. Échanger avec un
                        manager est souvent compliqué car il a tendance à survendre le poste en raison de l'urgence de recrutement au sein de son équipe... Le mieux reste donc de discuter avec un
                        profil semblable car il partage la même vision et les même motivations dans le travail. C'est ce que j'ai pu faire grâce à Ulyss.co ! J'ai apprécié cet échange avec ce
                        développeur car c'était « vrai » et cela m'a permis de découvrir l'entreprise et les missions proposées. Top !</p></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>Mylène RICO</h4>
                    <p>Sportive du recrutement chez EVER'H <br><br> Ulyss.co est la première plateforme permettant au candidat d'échanger avec ses futurs collègues ou avec d'anciens salariés de
                        l'entreprise dans laquelle il postule. Un échange sans filtre, transparent, authentique et honnête. Très belle initiative !</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portrait">
                <div><h4>François VIRE</h4>
                    <p>Agent général AXA <br> <br>Lorsque j'ai créé mon cabinet d'assurance et de gestion de patrimoine il y a 10 ans, je ne connaissais personne qui travaillait dans ce secteur
                        d'activité. J'avais donc décidé de rencontrer des agents généraux AXA (ce qui n'avait pas été simple) afin de découvrir ce métier et ses enjeux. Rien ne vaut le témoignage de
                        professionnels pour avoir des informations précises et personnalisées. Si ULYSS.CO avait proposé ce service de mise en relation, je n'aurais pas hésité à l'utiliser !
                        Aujourd'hui, je suis ravi d'être de l'autre côté et de pouvoir conseiller les personnes intéressées par mon métier ou mon entreprise.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="home_employeur">
    <div class="row">
        <h2>Vos collaborateurs sont les meilleurs ambassadeurs de votre marque employeur.</h2>
        <p>Vous êtes employeur ? Vous prônez la transparence et êtes conscients que cela est bénéfique pour vos candidats et vos collaborateurs ? Découvrez notre solution employeur pour améliorer
            votre attractivité talents.</p>
        <div class="btn_tem_ment center">
            <a href="<?= base_url() ?>/employeur">Découvrir la solution employeur</a>
        </div>
    </div>
</section>
<section class="text_general">
    <h3>91% des recruteurs contactent les anciens employeurs des candidats. Et si on inversait les rôles ?</h3><br>
    <p>Aujourd'hui plus qu'hier, ce sont les candidats qui choisissent leur employeur. Notre plateforme web vise à faciliter les échanges entre insiders et candidats. Pour faire le bon choix.</p>
    <br>
    <p>Vous appréciez notre service ? Vous souhaitez le partager à votre réseau ? Aidez-nous à faire d'ULYSS.CO le plus grand réseau d'entraide professionnel.</p>
</section>

<section class="block_decouvert">
    <div class="container">
        <div class="row text-center btn_tem_ment mgt00">
            <div class="col-md-12 btn_share_social">
                <a class="sharefacebook" href="#" data-rel="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?php echo base_url(); ?>&display=popup&ref=plugin&src=share_button"><i class="fa fa-facebook"></i>Partager
                    sur Facebook</a>
                <a class="sharelinkedin" href="#" data-rel="http://www.linkedin.com/shareArticle?mini=false&source=Ulyss&url=<?php echo base_url(); ?>"><i class="fa fa-linkedin"></i>Partager sur
                    Linkedin</a> <a class="sharetwitter" href="#" data-rel="https://twitter.com/intent/tweet/?url=<?php echo base_url(); ?>&via=ulyss"><i class="fa fa-twitter"></i>Partager sur Twitter</a>
            </div>
        </div>
    </div>
</section>

<section class="block_decouvert ilsnoussoutiennent">
    <div class="cf text-center">
        <div class="col-md-12 title_decouvert">
            <h2 style="color: #FFFFFF">Nos partenaires</h2>
        </div>
    </div>
    <div class="cf text-center mgt00">
        <div class="col-md-12">
            <a href="#"><img src="<?= base_url() ?>/assets/img/homepage/ilsnoussoutiennent/amft.png" alt="WE ARE #AIX-MARSEILLE - FRENCH LAB"></a>
            <a href="#"><img src="<?= base_url() ?>/assets/img/homepage/ilsnoussoutiennent/lelab.png" alt="Le Lab"></a>
            <a href="#"><img src="<?= base_url() ?>/assets/img/homepage/ilsnoussoutiennent/kedge.png" alt="KEDGE - Business School"></a>
            <a href="#"><img src="<?= base_url() ?>/assets/img/homepage/ilsnoussoutiennent/Logo_Pôle_Emploi.png" alt="Initiative - Marseille Métropole"></a>
        </div>
    </div>
</section>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript">
	AOS.init({
		duration: 1200,
		disable: mobile,
	})
</script>
<script>
	var content = 'CONTACTEZ LES COLLABORATEURS DE VOTRE FUTUR EMPLOYEUR';

	var ele = '<p>' + content.split('').join('</p><p>') + '</p>';


	$(ele).hide().appendTo('.p_2').each(function (i) {
		$(this).delay(80 * i).css({
			display: 'inline',
			opacity: 0
		}).animate({
			opacity: 1
		}, 90);
	});
</script>
<script>
	$('.counter').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: $(this).text()
		}, {
			duration: 4000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
</script>