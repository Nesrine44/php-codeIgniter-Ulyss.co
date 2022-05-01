<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 08/08/2018
 * Time: 14:33
 */
/* @var $this CI_Loader */
/* @var $this Jobs */
/* @var $this Entreprises */
/* @var array $mentorOffre */
/* @var BusinessOffre $offre */
/* @var BusinessEntreprise $BusinessEntreprise */
?>

    <section class="container" style="width: 1170px">
        <div class="row block_offer">


            <?php echo '<h2>' . mb_strtoupper($offre->getTitre()) . '</h2>'; ?>
            <br>
            <?php echo '<p class="p_title"><img src="/assets/img/icons/agreement.png" alt="contrat">' . $offre->getTypeContrat() . ' <img src="/assets/img/icons/placeholder.png" alt="contrat"> ' . $offre->getLieu() . ' <img src="/assets/img/icons/medal.png" alt="contrat"> ' . $offre->getNiveau() . ' <img src="/assets/img/icons/time.png" alt="contrat"> ' . $this->BusinessOffre->getJourFromDate($offre->getDateCreation()) . '</p>'; ?>
            <br>
            <?php echo '<h4>Descriptif du poste</h4><br><p>' . nl2br($offre->getDescriptif()) . '</p>' ?><br>
            <?php echo '<h4>Votre profil</h4><br><p>' . nl2br($offre->getProfilDiscriptif()) . '</p>' ?>
        </div>

        <aside>
            <div><h1>Actualité</h1>
                <a class="twitter-timeline" data-height="550" data-chrome="nofooter" href="<?php echo $BusinessEntreprise->getTwitterLink(); ?>">Tweets by ulyss_co</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                <hr>
                <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $BusinessEntreprise->getFacebookLink(); ?>&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            </div>
            <div class="ico_social">
                <h1>Suivre</h1>
                <img src="/assets/img/social/fb.png" alt="facebook"> <img src="/assets/img/social/twitter.png" alt="twitter"> <img src="/assets/img/social/linkedin.png" alt="linkedIn">
            </div>
        </aside>

        <div class="mentors_choice">
            <div class="row">
                <h1>Ces mentors sont prêt à vous conseiller</h1>

                <?php if (isset($mentorOffre)) {
                ?>
                <?php foreach ($mentorOffre

                               as $key => $mentor) { ?>
                    <div class="col-md-5 bg_white_2 pad_0">
                        <a href="<?php echo $mentor->url; ?>apropos" class="mentorbox" style="display:block;">
                            <div class="row display_flex">
                                <div class="col-md-5 col-sm-5 img_membre">
                                    <?php if ($mentor->avatar != "") { ?>
                                        <img class="avatar img_linkedin" src="<?php echo $mentor->avatar; ?>" style="center center no-repeat; height: 100px; border-radius: 50px; margin: auto;" alt="avatar <?php echo $mentor->prenom; ?>">
                                    <?php } else { ?>
                                        <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;" alt="avatar <?php echo $mentor->prenom; ?>">
                                    <?php } ?>
                                </div>
                                <div class="col-md-7 col-sm-7 padl-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="nom_prenom"><?php echo $mentor->prenom ?></h5>
                                            <h5 class="titre_mission"><?php echo $mentor->titre_mission; ?></h5>
                                            <p class="pos_pers">
                                                <span><i class="fa fa-map-marker"></i> <?php echo $mentor->lieu; ?></span>
                                            </p>
                                            <span class="date">
                                                                <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_debut))); ?>
                                                <?php if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') { ?>
                                                    à Aujourd'hui
                                                <?php } else { ?>
                                                    à <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_fin))); ?>
                                                <?php } ?>
                                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <?php } else { ?>
                <div class="row pagination_result text-center">
                    <div class="col-md-12">
                        <p>Aucun mentor n'est associé à cette offre </p>
                    </div>
                </div>
            <?php } ?>
            <?php if ($this->getController()->userIsAuthentificate() == false && $this->getController()->companyIsAuthentificate() == false) { ?>
                <button class="postulerBtn" data-toggle="modal" data-target="#ModalConnexion"> Postuler sur le site de l'employeur</button>
                <button type="button" class="postulerBtn" data-toggle="modal" data-target=".iframeModal">Générez le widget de l'offre</button>

            <?php } elseif ($this->getController()->userIsAuthentificate() == true) { ?>
                <?php if (isset($isCondidat)) { ?>
                    <button class="postulerBtn" title="Vous avez déjà postulé à cette offre." DISABLED>Postuler sur le site de l'employeur
                    </button>
                <?php } else { ?>
                    <?php echo form_open('/postuler') ?>
                    <input type="hidden" name="offre_id" value="<?php echo $offre->getSecureId() ?>">
                    <button class="postulerBtn" type="submit" onclick="">
                        <a <?php echo $offre->getUrl() != '' ? 'href="http://' . $offre->getUrl() . ' "' : 'href="http://' . $BusinessEntreprise->getSite() . '"' ?> target="_blank"> Postuler sur le
                            site de l'employeur</a>
                    </button>
                    <button type="button" class="postulerBtn" data-toggle="modal" data-target=".iframeModal">Générez le widget de l'offre</button>
                    <?php echo form_close() ?>
                <?php } ?>
            <?php } else { ?>

                <button type="button" class="postulerBtn" data-toggle="modal" data-target=".iframeModal">Générez le widget de l'offre</button>
            <?php } ?>
        </div>
    </section>


<?php include('widgetPage.php') ?>