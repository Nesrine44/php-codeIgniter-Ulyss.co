<?php /* @var $this CI_Loader */
/* @var $this Jobs */
/* @var array $EntrepriseMontor */
/* @var array $offres_disponible */
/* @var BusinessEntreprise $BusinessEntreprise */
/* @var BusinessOffre $BusinessOffre */
/* @var array $images */
?>

<section class="container">
    <div class="block_offer">
        <h1>OFFRES D'EMPLOI</h1>
        <?php if (isset($msg_offre)) {
            echo '<p>' . $msg_offre . '</p>';
        } else {
            foreach ($offres_disponible as $Offre) {
                $BusinessOffre = new BusinessOffre($Offre); ?>

                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url() . "entreprise/" . $BusinessEntreprise->getAlias() . "/offresdemploi/" . $BusinessOffre->getId() ?>">
                            <?php $x = '<h3>' . mb_strtoupper($BusinessOffre->getTitre()) . '</h3>';
                            $x       .= '<p><img src="/assets/img/icons/agreement.png" alt="contrat">' . $BusinessOffre->getTypeContrat() . ' <img src="/assets/img/icons/placeholder.png" alt="contrat"> ' . $BusinessOffre->getLieu() . ' <img src="/assets/img/icons/medal.png" alt="contrat"> ' . $BusinessOffre->getNiveau() . ' <img src="/assets/img/icons/time.png" alt="contrat"> ' . $this->BusinessOffre->getJourFromDate($BusinessOffre->getDateCreation());
                            $av      = $BusinessOffre->getMentorAvatars();
                            if ($av != null && is_array($av)) {
                                if (sizeof($av) <= 5) {
                                    foreach ($av as $avatar) {
                                        $x .= '<img class="avatarOffre" src="' . $avatar . '" alt="" style="width: 50px; border-radius: 50px; margin-top: -40px;">';
                                    }
                                } else {
                                    $reste = sizeof($av) - 5;
                                    for ($i = 0; $i <= 4; $i++) {
                                        $x .= '<img class="avatarOffre" src="' . $av[$i] . '" alt="" style="width: 50px; border-radius: 50px; margin-top: -40px;">';
                                    }
                                    $x .= ' + ' . $reste;
                                }
                                $x .= '<p class="nbrMentorMobile">' . sizeof($av) . ' Mentor(s) sont prêt(s) à vous conseiller sur cette offre</p>';

                            }
                            $x .= '</p>';
                            echo $x;
                            ?></a></div>
                </div>

                <?php
            }
        } ?>


    </div>
    <aside>
        <div><h1>Actualité</h1>
            <a class="twitter-timeline" data-height="550" data-chrome="nofooter" href="<?php echo $BusinessEntreprise->getTwitterLink(); ?>">Tweets by <?php echo $BusinessEntreprise->getNom() ?></a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            <hr>
            <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $BusinessEntreprise->getFacebookLink(); ?>&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
        <div class="ico_social">
            <h1>Suivre</h1>
            <a href="<?php echo $BusinessEntreprise->getFacebookLink() ?>"> <img src="/assets/img/social/fb.png" alt="facebook"></a>
            <a href="<?php echo $BusinessEntreprise->getTwitterLink(); ?>"><img src="/assets/img/social/twitter.png" alt="twitter"></a> <a href="<?php echo $BusinessEntreprise->getLinkedinLink(); ?>"><img src="/assets/img/social/linkedin.png" alt="linkedIn"></a>
            <a href="<?php echo $BusinessEntreprise->getInstagramLink(); ?>"><img src="/assets/img/social/Instagram-logo.png" alt="instagram"></a>
        </div>
    </aside>

    <div class="mentors_choice">
        <div class="row">
            <h1>Ces mentors sont prêt à vous conseiller</h1>

            <?php if (isset($EntrepriseMontor)) {
            ?>
            <?php foreach ($EntrepriseMontor

                           as $key => $mentor) { ?>
                <div class="col-md-5 bg_white_2 pad_0">
                    <a href="<?php echo $mentor->url; ?>apropos"
                       class="mentorbox"
                       style="display:block;">


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
                                        <h4 class="nom_prenom"><?php echo $mentor->prenom ?></h4>
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
                    <p>Aucun mentor ne correspond à cette entreprise ... </p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="media_ent">
        <h1><?php echo $BusinessEntreprise->getNom() ?></h1>

        <div class="row">
            <ul class="gallery">
                <?php
                if (!empty($images)) {
                    foreach ($images as $image) { ?>
                        <div class="shadow" id="<?php echo $image['id'] ?>">
                            <button type="submit" onclick="return del_img_ent(<?php echo $image['id'] ?>)">X</button>
                            <div class="col-md-2">
                                <a href="<?php echo base_url('upload/files/' . $image['image_name']); ?>" data-lightbox="roadtrip">
                                    <li class="item" style="background-image: url('<?php echo base_url('upload/files/' . $image['image_name']); ?>');">

                                    </li>
                                </a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p>Aucune image ajoutée.....</p>
                <?php } ?>
            </ul>

        </div>
    </div>
</section>
