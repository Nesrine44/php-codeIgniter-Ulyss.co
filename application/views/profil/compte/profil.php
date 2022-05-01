<?php
/* @var BusinessUser $BusinessUser */
/* @var BusinessUserLinkedin $BusinessUserLinkedin */
?>

<section class="block_resultas wanted_block">
    <div class="container">
        <div class="row">
            <?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
            <div class="col-md-9 block_mn_compte">
                <div class="row nav_comment">
                    <ul class="mg_15">
                        <li class="title_li_compte">Mon profil LinkedIn</li>
                        <a href="<?php echo $BusinessUserLinkedin->getPublicProfileUrl(); ?>" target="_blank" class="custombutton" style="float: right">Voir mon profil LinkedIn</a>
                    </ul>
                </div>
                <div class="row mes_infos_compte">
                    <div class="col-md-12 pdl_30">
                        <form method="post" action="<?php echo base_url(); ?>monprofil">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="title_label">
                                        <span>Titre du poste actuel</span>
                                        <?php if ($BusinessUserLinkedin->getActualjobTitle() == ""): ?><span> <i class="ion-close" style="color:red"></i></span><?php endif ?>
                                    </div>
                                    <div><input disabled type="text" value="<?php echo $BusinessUserLinkedin->getActualjobTitle(); ?>" name="actualjob-title"></div>
                                </div>
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="title_label">
                                        <span>Date d'entrée</span>
                                        <?php if ($BusinessUserLinkedin->getActualjobStartDate() === null): ?><span> <i class="ion-close" style="color:red"></i></span><?php endif ?>
                                    </div>
                                    <div>
                                        <input disabled type="text" value="<?php echo $BusinessUserLinkedin->getActualjobStartDate() !== null ? $BusinessUserLinkedin->getActualjobStartDate()->format('d/m/Y') : ''; ?>" name="actualjob-startdate">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="title_label">
                                        <span>Société</span>
                                        <?php if ($BusinessUserLinkedin->getCompagnyName() == ""): ?><span> <i class="ion-close" style="color:red"></i></span><?php endif ?>
                                    </div>
                                    <div><input disabled type="text" value="<?php echo $BusinessUserLinkedin->getCompagnyName(); ?>" name="company-name"></div>
                                </div>
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="title_label">
                                        <span>Localisation</span>
                                        <?php if ($BusinessUserLinkedin->getCompagnyLocation() === null): ?><span> <i class="ion-close" style="color:red"></i></span><?php endif ?>
                                    </div>
                                    <div><input disabled type="text" value="<?php echo $BusinessUserLinkedin->getCompagnyLocation(); ?>" name="company-location"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
