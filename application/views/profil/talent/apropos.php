<?php
/* @var CI_Loader $this
 * @var BusinessUser $BusinessUser
 * @var  array       $suggestMentor
 * @var  array       $tabEntRdv
 */
$date = new DateTime('+1 day');
?>
<section class="block_profil">
    <div class="container mgb_30">
        <div class="row">
            <div class="col-md-8">
                <div class=" brbt pad_15">
                    <h1>

                        Présentation
                        <?php if ($droir_editer) { ?><a href="#" data-toggle="modal" data-target="#ModalEditerDetail" class="btn_edit_inf"><span>Éditer</span></a><?php } ?>
                        <?php if ($droir_editer) { ?><a href="<?= base_url() ?>mentor/etape1" style="margin-right: 10px;color:#fff;background-color:#26a6e1" class="pull-right link_prof_linked">Mettre
                            à jour mes expériences</a><?php } ?>
                    </h1>
                    <p id="detail_talent"><?php echo $info_talent->description; ?></p>
                </div>

                <div class=" profil_experience brbt pad_15">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Expérience</h1>
                        </div>
                    </div>
                    <div class="list_expr">
                        <?php foreach ($experiences as $exp) { ?>
                            <div class="list_exp list_formation row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <h4><?php echo $exp->titre_mission; ?></h4>
                                            <p class="cl_grey_p"><?php echo $this->user_info->getNameEntreprise($exp->entreprise_id); ?></p>
                                            <?php if ($exp->date_fin == '9999-12-31' || $exp->date_fin == '0000-00-00') { ?>
                                                <p><?php echo Business::getDateFormatted($exp->date_debut); ?> - Aujourd'hui <br/><?php echo $exp->lieu; ?></p>
                                            <?php } else { ?>
                                                <p><?php echo Business::getDateFormatted($exp->date_debut); ?> - <?php echo Business::getDateFormatted($exp->date_fin); ?>
                                                    (<?php echo $this->user_info->getDiffDate($exp->date_debut, $exp->date_fin); ?>
                                                    )<br/><?php echo $exp->lieu; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-4 text-right">
                                            <img width="70" src="<?php echo $this->user_info->getLogoEntreprise($exp->entreprise_id); ?>" alt="" class="mgt_15" width="145">
                                        </div>
                                    </div>
                                    <?php if (isset($exp->description) && $exp->description != "") { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn_show_desc"><span class="d_plus "><i>+</i> Détail</span>
                                                    <div class="disc_exper">
                                                        <p>
                                                            <?php echo $exp->description; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="profil_operatoire brbt pad_15">
                    <h1>Compétences</h1>
                    <div class="liste_oper tag">
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($tags as $key => $tag): ?>
                                    <span><?php echo $tag->nom; ?></span>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" profil_experience brbt pad_15">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Formation</h1>
                        </div>
                    </div>
                    <div class="list_formations_html">
                        <?php foreach ($formations as $key => $forma): ?>
                            <div class="row list_exp list_formation ">
                                <div class="col-md-12">
                                    <h4><?php echo $forma->university; ?></h4></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <!-- Display Suggestions of Mentors & Entreprise if is client write by Raphael Beneluz -->
                <div class="profil_operatoire brbt pad_15">
                    <?php if ($entreprise_client == true) { ?>
                        <!-- if Entreprise is client display ent -->
                        <div class="entreprise-client">
                            <div class="row">
                                <h1>Entreprise Cliente</h1>
                                <a href="<?php echo $ent->site; ?>" class="mentorbox" style="display:block;">
                                    <div class="banniere-ent">
                                        <div class="banniere-bg">
                                            <img class="bg-ent" src="<?php echo $ent->background; ?>" style="display:block;" alt="background">
                                            <div class="logo-ent">
                                                <img src="<?php echo $ent->logo; ?>" style="display:block;" alt="logo-ent">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- else display Mentors -->
                        <?php if (isset($mentors) && !empty($mentors)) { ?>
                            <div class="mentors_choice">
                            <div class="row">
                            <h1>Mentors</h1>
                            <p>Voici quelques suggestions de nos mentors</p>
                            <?php foreach ($mentors as $mentor) { ?>
                                <div class="col-md-5 bg_white_2 pad_0 mentorCard">
                                    <a href="<?php // URL du Mentor ?>apropos" class="mentorbox" style="display:block;">
                                        <div class="row display_flex">
                                            <div class="col-md-5 col-sm-5 img_membre">
                                                <?php if ($mentor->avatar != "") { ?>
                                                    <img class="avatar img_linkedin" src="<?php echo $mentor->avatar; ?>" style="center center no-repeat; height: 100px; border-radius: 50px; margin: auto;"
                                                         alt="avatar <?php echo $mentor->prenom; ?>">
                                                <?php } else { ?>
                                                    <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;"
                                                         alt="avatar <?php echo $mentor->prenom; ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-7 col-sm-7 padl-0">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h4 class="nom_prenom"><?php echo $mentor->prenom; ?></h4>
                                                        <p class="titre_mission"><?php echo $mentor->titre_mission; ?></p>
                                                        <p class="pos_pers">
                                                            <span><i class="fa fa-map-marker"></i> <?php echo $mentor->lieu; ?></span>
                                                        </p>
                                                        <span class="date">
                                                                    <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_debut))); ?>
                                                            <?php if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') { ?>
                                                                <p>à Aujourd'hui</p>
                                                            <?php } else { ?>
                                                                <p>à</p>
                                                                <?php echo ucfirst(strftime('%B %Y', strtotime($mentor->date_fin))); ?>
                                                            <?php } ?>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="row pagination_result text-center">
                                <div class="col-md-12">
                                    <h1>Mentors</h1>
                                    <p>Désolé aucun mentor ne correspond à ce profil ... </p>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- End -->

                <?php if ($droir_editer) { ?>
                    <div class="table-responsive profil_experience pg-dcc">
                        <h1>Vos disponibilités hebdomadaires </h1>
                        <form id="editerHoraire">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>">
                            <table class="table text-center table_diponibilite">
                                <tr>
                                    <th></th>
                                    <th>Lundi</th>
                                    <th>Mardi</th>
                                    <th>Mercredi</th>
                                    <th>Jeudi</th>
                                    <th>Vendredi</th>
                                    <th>Samedi</th>
                                    <th>Dimanche</th>
                                </tr>
                                <tr>
                                    <td>8h-10h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->lundi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->mardi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->mercredi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->jeudi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->vendredi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->samedi_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_8_10 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_8_10" class="check_disp save_horaire_ch" <?php if ($disponibilites_of_talent->dimanche_8_10 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>10h-12h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->lundi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->mardi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_10_12" class="check_disp" <?php if ($disponibilites_of_talent->samedi_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_10_12 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_10_12" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_10_12 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>12h-14h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->lundi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->mardi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_12_14" class="check_disp" <?php if ($disponibilites_of_talent->samedi_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_12_14 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_12_14" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_12_14 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>14h-16h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->lundi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->mardi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_14_16" class="check_disp" <?php if ($disponibilites_of_talent->samedi_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_14_16 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_14_16" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_14_16 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>16h-18h</td>
                                    <td class="horaire_td  <?php if ($disponibilites_of_talent->lundi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->lundi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->mardi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_16_18" class="check_disp" <?php if ($disponibilites_of_talent->samedi_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_16_18 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_16_18" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_16_18 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>18h-20h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->lundi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->mardi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_18_20" class="check_disp" <?php if ($disponibilites_of_talent->samedi_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_18_20 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_18_20" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_18_20 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                                <tr>
                                    <td>20h-22h</td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->lundi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="lundi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->lundi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mardi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mardi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->mardi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->mercredi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="mercredi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->mercredi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->jeudi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="jeudi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->jeudi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->vendredi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="vendredi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->vendredi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->samedi_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="samedi_20_22" class="check_disp" <?php if ($disponibilites_of_talent->samedi_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                    <td class="horaire_td <?php if ($disponibilites_of_talent->dimanche_20_22 == "1") {
                                        echo "active";
                                    } ?>"><input type="checkbox" value="1" name="dimanche_20_22" class="check_disp" <?php if ($disponibilites_of_talent->dimanche_20_22 == "1") {
                                            echo "checked";
                                        } ?>></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                <?php } ?>
            </div>
            <!-- end block -->

            <div class="col-md-4 ">
                <div class="profil_reservation">
                    <form id="formReservation">
                        <input type="hidden" value="h" name="prix_offre">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>"> <input type="hidden" name="date_offre" value="<?php echo date('d/m/Y',
                            strtotime("+1 day")); ?>" id="my_hidden_input">
                        <?php if (!$droir_editer) { ?>
                            <div class="row text-right">
                                <div class="col-md-12 text-right">
                                    <p class="phr_contact" style="padding-top: 88px">
                                        <?php if ($this->session->userdata('logged_in_site_web')) { ?>
                                            <a href="#" data-toggle="modal" data-target="#ContacterTalent">Contacter</a>
                                        <?php } else { ?>
                                            <a href="#" data-toggle="modal" data-target="#ModalConnexion"> Contacter</a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="calendar">
                            <h3>Sélectionnez une date</h3>
                            <div class="rdrd">
                                <div class="date-picker-i datepicker-inline"></div>
                                <div class="hours_span text-center html_dispo">
                                    <?php if ($disponible['8_10'] != 1 && $disponible['10_12'] != 1 && $disponible['12_14'] != 1 && $disponible['14_16'] != 1 && $disponible['16_18'] != 1 && $disponible['18_20'] != 1 && $disponible['20_22'] != 1) { ?>
                                        <p style="color:red;">Ce mentor n'est plus disponible sur ce jour.</p>
                                    <?php } else { ?>
                                        <?php if (empty($holidays)) { ?>
                                            <span class="horaire_td  <?php if ($disponible['8_10'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="8h-10h" name="crenaux[]" class="<?php if ($disponible['8_10'] == 1) {
                                                    echo 'check_disp';
                                                } ?>" <?php if ($disponible['8_10'] != 1) {
                                                    echo 'disabled';
                                                } ?>>8h-10h</span> <span class="horaire_td  <?php if ($disponible['10_12'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="10h-12h" name="crenaux[]" class="<?php if ($disponible['10_12'] == 1) {
                                                    echo 'check_disp';
                                                } ?>" <?php if ($disponible['10_12'] != 1) {
                                                    echo 'disabled';
                                                } ?>>10h-12h</span> <span class="horaire_td  <?php if ($disponible['12_14'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="12h-14h" name="crenaux[]" class="check_disp" <?php if ($disponible['12_14'] != 1) {
                                                    echo 'disabled';
                                                } ?>>12h-14h</span> <span class="horaire_td  <?php if ($disponible['14_16'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="14h-16h" name="crenaux[]" class="check_disp" <?php if ($disponible['14_16'] != 1) {
                                                    echo 'disabled';
                                                } ?>>14h-16h</span> <span class="horaire_td  <?php if ($disponible['16_18'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="16h-18h" name="crenaux[]" class="check_disp" <?php if ($disponible['16_18'] != 1) {
                                                    echo 'disabled';
                                                } ?>>16h-18h</span> <span class="horaire_td  <?php if ($disponible['18_20'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="18h-20h" name="crenaux[]" class="check_disp" <?php if ($disponible['18_20'] != 1) {
                                                    echo 'disabled';
                                                } ?>>18h-20h</span> <span class="horaire_td  <?php if ($disponible['20_22'] != 1) {
                                                echo 'disabled';
                                            } ?>"><input type="checkbox" value="20h-22h" name="crenaux[]" class="check_disp" <?php if ($disponible['20_22'] != 1) {
                                                    echo 'disabled';
                                                } ?>>20h-22h</span>
                                        <?php } else { ?>
                                            <p style="color:red;">Ce mentor n'est plus disponible sur ce jour.</p>

                                        <?php }
                                    } ?>
                                </div>

                                <!-- Display entreprise choice via 'radio button' of experiences profilTalent Write by Raphael.b -->
                                <div class="text-left select">
                                    <?php foreach ($tabEntRdv as $idEnt) { ?>
                                        <input type="radio" id="<?php echo $idEnt; ?>" class="ent_choice" name="rdv_ent"><?php echo $this->user_info->getNameEntreprise($idEnt); ?>
                                    <?php } ?>
                                </div>
                                <!-- End -->

                                <div class="text-left select">
                                    <input type="hidden" name="" value="30min"/> Les échanges se font par téléphone sur une durée de 30 mn​
                                </div>
                                <div class="btn-sresa">
                                    <?php if ($this->session->userdata('logged_in_site_web')) { ?>
                                        <?php if ($droir_editer) { ?>
                                            <div class="btn-resa">
                                                <input type="submit" class="me_reserv" disabled="disabled" value="Envoyer une demande de RDV">
                                            </div>
                                        <?php } else { ?>
                                            <?php if ($this->getController()->getBusinessUser()->getTelephone() == '' || $this->getController()->getBusinessUser()->isVerifiedTelephone() == false) { ?>
                                                <div class="btn-resa">
                                                    <input type="submit" class="me_reserv" disabled="disabled" value="Envoyer une demande de RDV">
                                                </div>
                                                <div class="block_mn_compte">
                                                    <div class="mes_infos_compte" style="margin-top: 10px;">
                                                        <p>Pour prendre rendez-vous avec un mentor veuillez renseigner votre numéro de téléphone :</p>
                                                        <div class="row">
                                                            <?php $this->view('fragment/verif_tel/vue'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="btn-resa">
                                                    <input type="submit" id="button_reservation" class="me_reserv" disabled="disabled" value="Envoyer une demande de RDV" data-toggle="modal" data-target="#ModalConfirmRDV" onclick="return false;">
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a href="#" data-toggle="modal" data-target="#ModalConnexion"> Envoyer une demande</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($droir_editer): ?>
    <div class="modal fade text-center modal_home modal_form" id="ModalEditerDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <h1>Présentation</h1>
            <div class="modal-content">
                <div class="modal-body">
                    <form id="formEditerDetail" method="post" action="/" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>">
                        <div class="row  ">
                            <div class="col-md-10 col-md-offset-1 ">
                                <textarea name="description" class="required" id="detailtalent" rows="5" placeholder="Présentez-vous en quelques lignes"><?php echo $info_talent->description; ?></textarea>
                            </div>
                        </div>
                        <div class="row btn_inscription ">
                            <div class="col-md-10 col-md-offset-1">
                                <button class="sendButtondetail" type="submit">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<!-- Modal demande -->
<?php if ($this->session->userdata('logged_in_site_web')) { ?>
    <div class="modal fade text-center modal_home modal__offre" id="ContacterTalent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <h1 class="text-center">Votre message </h1>
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="row msg_envois" style="display:none;">
                        <h2 style="font-size: 22px">votre message a bien été envoyé. merci</h2><br/>
                        <a class="btn btn-sm btn_style_send" href="#" onclick="$('#ContacterTalent .close').click();return false;">Fermer</a>
                    </div>
                    <div class="row msg_err" style="display:none;">
                        <h2>Merci de remplir tous les champs.</h2>
                    </div>
                    <form id="contacteTalent" method="post" action="/" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>"> <input type="hidden" name="titre" value="<?php echo $info_talent->titre; ?>">
                        <div class="row field_mail">
                            <div class="input-group margin-bottom-sm col-md-8 col-md-offset-2 brrds-20">
                                <textarea name="message_detail" id="msg_to_user" class="form-control" rows="5" cols="70" placeholder="Entrez votre message ici..."></textarea>
                            </div>
                        </div>
                        <div class="row btn_inscription text-center">
                            <div class="col-md-10 col-md-offset-1">
                                <button class="sendButtondemande" type="submit">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-center modal_home" id="modalADDdemandeConfirmationajoutDEmande" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="row">
                        <h2 style="font-size: 15px;width: 90%;margin: 0 auto;">Votre demande de rendez-vous a bien été envoyée à votre Mentor. Vous recevrez une réponse dans un délai de 24h
                            maximum.</h2>
                        <br/> <a href="#" class="btn_style_send inlineblock" onclick="$('#modalADDdemandeConfirmationajoutDEmande .close').click();return false;">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-center modal_home modal__offre" id="ModalConfirmRDV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <h1 class="text-center">Récapitulatif de votre demande</h1>
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    Mentor : <?php echo $BusinessUser->getPrenom() . ' ' . $BusinessUser->getNom() ?><br/> Date choisie : <span class="datechoisie"></span><br/> Créneau choisi :
                    <span class="heurechoisie"></span> <br/><br/>
                    <div class="row btn_inscription">
                        <div class="col-md-5 col-md-offset-1">
                            <button type="reset" data-dismiss="modal" aria-label="Close">Annuler</button>
                        </div>
                        <div class="col-md-5">
                            <button type="reset" id="f_reservation_apropos" onclick="SendPostRDV();return false;">Valider</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal fade modal_share" id="modal-partage">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 btn_connection">
                        <a class="sharefacebook share_fb" href="#" data-rel="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?php echo base_url(); ?>&display=popup&ref=plugin&src=share_button">
                            <i class="fa fa-facebook"></i> Partager sur Facebook </a>
                    </div>
                    <div class="col-md-4 btn_connection">
                        <a class="sharelinkedin share_lkd" href="#" data-rel="http://www.linkedin.com/shareArticle?mini=false&source=Ulyss&url=<?php echo base_url(); ?>">
                            <i class="fa fa-linkedin"></i> Partager sur linkedin </a>
                    </div>
                    <div class="col-md-4 btn_connection">
                        <a class="sharetwitter" href="#" data-rel="https://twitter.com/intent/tweet/?url=<?php echo base_url(); ?>&via=ulyss"><i class="fa fa-twitter"></i>Partager sur Twitter</a>
                    </div>
                </div>
            </div>
            <div class="outer-footer text-center">
                <button class="btn btn-blue btn-clos" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade tfa-modal modal-comment-tags modal_share" id="modal-add-share-with-freind" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <h1 class="outer-title text-center">Partager à un ami</h1>
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="row">
                    <p class="msg_error"></p>
                </div>
                <form id="form-share-it">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <?php if ($this->session->userdata('logged_in_site_web')) { ?>
                        <input type="text" name="name_user" class="form-control" value="<?php echo $this->session->userdata('logged_in_site_web')['name']; ?>" placeholder="Votre nom">
                    <?php } else { ?>
                        <input type="text" name="name_user" class="form-control" value="" placeholder="Votre nom">
                    <?php } ?>
                    <input type="text" name="from" class="form-control" value="<?php echo $this->session->userdata('logged_in_site_web')['email']; ?>" placeholder="Votre email">
                    <input type="text" name="to" class="form-control" placeholder="Email de destinataire">
                    <input type="hidden" name="symbol" value="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos">
                    <input type="hidden" name="name" value="<?php echo $info_talent->titre; ?>"> <input type="hidden" name="overview" value="<?php echo $info_talent->description; ?>">
                    <div class="action">
                        <button type="button" class="btn btn-blue-o" data-dismiss="modal">Annuler</button>
                        <button class="btn btn-blue btn-pdn-md bt-submit-share-with-freind">Envoyer</button>
                    </div>
                </form>
                <div class="action close_after" style="display:none;">
                    <button type="button" class="btn btn-blue-o" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal creation talent-->
<script type="text/javascript">
	var base_url   = "<?php echo base_url(); ?>";
	var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

</script>

<style>
    .trumbowyg-button-pane {
        display: none;
    }

    .trumbowyg-box {
        border-style: solid;
        border-width: 2px;
        border-color: rgb(231, 231, 231);
        background-color: rgb(255, 255, 255);
        border-radius: 20px;
        text-align: left;
    }
</style>

<script src="<?php echo base_url(); ?>assets/js/trumbowyg.min.js"></script>
<script defer type="text/javascript">
	$('#detailtalent,#detailformat').trumbowyg();
	$(".chargement_b").hide();
	$(document).ready(function () {
		$('#ModalConfirmRDV .datechoisie').html('<?php echo $date->format('d/m/Y'); ?>');
		$("#carousel_coup , #carousel_savoir").owlCarousel({
			autoPlay: 3000, //Set AutoPlay to 3 seconds
			items: 3,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [979, 3]
		});
		$('.date-picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			language: 'fr'
		}).attr('readonly', 'readonly');

		$('.date-picker-offer').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			language: 'fr',
			startDate: '+1d'
		});

        <?php
        $php_array = $get_disponibilite_in_week;
        $js_array = json_encode($php_array);
        echo "var active_dates = " . $js_array . ";\n";
        $js_array1 = json_encode($all_holidays);
        echo "var active_dates1 = " . $js_array1 . ";\n";
        ?>

		$('.date-picker-i').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			startDate: '+1d',
			language: 'fr',
			todayHighlight: false,
			beforeShowDay: function (date) {
				var d             = date;
				var curr_date     = d.getDate();
				var curr_month    = d.getMonth() + 1; //Months are zero based
				var curr_year     = d.getFullYear();
				var formattedDate = d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);

				var n = d.getDay();

				if ($.inArray(n, active_dates) != -1 || $.inArray(formattedDate, active_dates1) != -1) {
					return {
						classes: 'no_diponible'
					};
				}
				return;
			}
		});


		$('.date-picker-i').on("changeDate", function () {
			$("#button_reservation").addClass("me_reserv").prop("disabled", true);
			$.ajax({
				type: "POST",
				url: base_url + "profil/get_html_dispo",
				dataType: 'json',
				data: {date: $('.date-picker-i').datepicker('getFormattedDate'), talent_id:<?php echo $info_talent->id; ?>, csrf_token_name: csrf_token},
				success: function (json) {
					$(".html_dispo").html(json.html);
					$("#js_nbr_heure").html(json.html_heure);
					$('#ModalConfirmRDV .datechoisie').html($('.date-picker-i').datepicker('getFormattedDate'));
				}
			});
			$('#my_hidden_input').val(
				$('.date-picker-i').datepicker('getFormattedDate')
			);
		});

		$('.type_offre_dem').click(function () {
			$('.type_offre_dem').removeClass('active');
			$(this).addClass('active');
			$(this).find('input[type=radio]').prop('checked', true);
		});

		$('.info_forfait_ico').hover(function () {
			$('.tootip_info_forfait').addClass('active')
		}, function () {
			$('.tootip_info_forfait').removeClass('active')

		});

		function gosubmitHoraire() {
			$.ajax({
				type: "POST",
				url: base_url + "profil/editer_horaire_talent",
				data: $("#editerHoraire").serialize(), // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
				}
			});
			return true;
		}

		$('.table_diponibilite td').click(function () {
			setTimeout(function () {
				gosubmitHoraire();
			}, 800);
			return false;
		});

		function creation_html(nombre) {
			html = "";
			for (var i = 1; i <= nombre; i++) {
				html += "<option value=" + i + ">" + i + "</option>";

			}
			;
			$("#js_nbr_heure").html(html);

		}

		$('.calendar').on('click', '.horaire_td', function () {
            /* On desactive toutes les cases */
			$('.calendar .horaire_td').removeClass('active');
			$('.calendar .horaire_td').find('.check_disp').attr("checked", false);
            /* On active la case selectionnée */
			$(this).find('.check_disp').prop("checked", true);
			$('.ent_choice').prop("checked", true);
			$(this).addClass('active');
			$("#button_reservation").removeClass("me_reserv").prop("disabled", false);
			$('#ModalConfirmRDV .heurechoisie').html($(this).find('input').val());
		});

		$('.profil_experience .horaire_td').click(function () {

			if ($(this).find('.check_disp').is(":checked")) {
				$(this).find('.check_disp').attr("checked", false);
			} else {
				$(this).find('.check_disp').prop("checked", true);
			}
			$(this).toggleClass('active');
			var nombre = 0;
			$("input[name='crenaux[]']:checked").each(function () {
				nombre = nombre + 2;
			});
			creation_html(nombre);
		});
		$('.btn_show_desc').click(function () {
			$(this).find('.disc_exper').toggleClass('show');
		});
	});
</script>
