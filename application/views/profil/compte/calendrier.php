<?php /* @var $this CI_Loader */ ?>
<style>#cal-slide-box, .icon-chevron-down {
        display: none !important;
    }</style>
<section class="calendar">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ico_etat">
                <span class="pr_valide"><i class="ion-record"></i>  Rendez-vous confirmé</span> <span class="pr_nego"><i class="ion-record"></i> Rendez-vous en attente </span>
                <a href="#" data-toggle="modal" data-target="#ModalEditmonTalent"> <span class="pr_indis"><i class="ion-ios-close-empty"></i> Indisponible</span></a>
            </div>
            <div class="col-md-4">
                <div class="page-header pull-left">
                    <div class="pull-right form-inline">
                        <div class="btn-group btn_calendar">
                            <button class=" active" data-calendar-view="month">Mois</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="page-header">
                    <div class="form-inline">
                        <div class="btn-group top_calendar">
                            <button class="prev" data-calendar-nav="prev"><i class="ion-chevron-left"></i></button>
                            <h3></h3>
                            <button class="next" data-calendar-nav="next"><i class="ion-chevron-right"></i></button>
                        </div>

                    </div>
                </div>
                <div id="calendar">
                    <?php $this->view('fragment/calendar/calendar_view.php'); ?>
                </div>
                <div id="calendar"></div>

            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 title_mission">
                        <div class="bg_grey_3 text-center">
                            <h1> Rendez-vous du jour</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 date_mission">
                        <div class="bg_grey_dark text-center">
                            <span><?php echo strftime("%d  %B %Y", strtotime(date("Y-m-d"))); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 list_missions"></div>
                </div>

            </div>
        </div>

        <div id="calendar"></div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12 title_mission">
                <div class="bg_grey_3 text-center">
                    <h1> Rendez-vous du jour</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 date_mission">
                <div class="bg_grey_dark text-center">
                    <span><?php echo strftime("%d  %B %Y", strtotime(date("Y-m-d"))); ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 list_missions"></div>
        </div>

    </div>
    </div>
    <?php if ($this->getController()->getBusinessUser()->isMentor()) { ?>
        <div class="row">
            <div class="col-md-8">
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
            </div>
        </div>
    <?php } ?>
    </div>
</section>
<div class="modal fade text-center modal_home modal_form" id="ModalEditmonTalent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <h1>Indisponible</h1>
        <div class="modal-content">


            <div class="modal-body">
                <form method="post" id="formAddIndisponible">


                    <div class="row  ">
                        <div class="col-md-10 col-md-offset-1 ">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" class="required" id="titre_indi" name="titre" value="indisponible" placeholder="Indiquez le titre Indisponible">
                        </div>
                    </div>

                    <div class="row  ">
                        <div class="col-md-10 col-md-offset-1 ">
                            <input type="text" name="date" id="date" placeholder="Indiquez la date" class="date-picker">
                        </div>
                    </div>


                    <div class="row mgb0">
                        <p class="error editer_t_error" style="display:none;">
                            Merci de remplir tous les champs
                        </p>
                    </div>
                    <div class="row demoInputBox" id="file_error">

                    </div>
                    <div class="row btn_inscription  ">
                        <div class="col-md-10 col-md-offset-1 button_su">
                            <button class="sendButton" type="submit">valider</button>
                        </div>
                        <div class="col-md-10 col-md-offset-1 chargement_b" style="display:none;">

                            <span class="load_photo"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade text-center modal_home modal_form" id="ModalRemoveRDV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h1 style="color: #000;">Annuler le rendez-vous ?</h1>
                Souhaitez-vous réellement annuler le rendez-vous ?<br/> <span class="prenom"></span> recevra un email afin d'être informé. <br/><br/>
                <a class="btn btn-sm btn_style_send" onclick="" href="#">Annuler le RDV</a> <a class="btn btn-sm btn_style_refus" href="#" data-dismiss="modal">Fermer</a> <br/>&nbsp;
            </div>

        </div>
    </div>
</div>
<!-- end footer -->

<script type="text/javascript">
	var events_calendar;
	var options  = {
		events_source: '<?php echo base_url(); ?>calendrier/events',
		view: 'month',
		tmpl_path: '<?php echo base_url(); ?>assets/js/tmpls/',
		tmpl_cache: false,
		day: '<?php echo date("Y-m-d");?>',
		onAfterEventsLoad: function (events) {
			if (!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');
			events_calendar = events;
			$.each(events, function (key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function (view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};
	var calendar = $('#calendar').calendar(options);

	$('.date-picker').datepicker({
		format: "dd/mm/yyyy",
		autoclose: "true",
		startDate: '2d',
		language: 'fr'
	});


	$('.horaire_td').click(function () {
		if ($(this).find('.check_disp').is(":checked")) {
			$(this).find('.check_disp').attr("checked", false);
		}
		else {
			$(this).find('.check_disp').prop("checked", true);
		}
		$(this).toggleClass('active');
		var nombre = 0;
		$("input[name='crenaux[]']:checked").each(function () {
			nombre = nombre + 2;
		});

		$.ajax({
			type: "POST",
			url: base_url + "profil/editer_horaire_talent",
			data: $("#editerHoraire").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
			}
		});
		return true;
	});
	$('.btn_show_desc').click(function () {
		$(this).find('.disc_exper').toggleClass('show');
	});

	$('#calendar').on('click', '.cal-month-day', function () {
		var date      = $(this).find('span.pull-right').attr('data-cal-date');
		var arrayDate = date.split('-');
		var event     = new Date(arrayDate[0], arrayDate[1] - 1, arrayDate[2]);
		var options   = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
		$('.date_mission span').text(event.toLocaleDateString('fr-FR', options));

		var $boxAllRDV = $(this).find('.events-list');
		if ($boxAllRDV !== undefined) {
			var datechoose = $boxAllRDV.attr('data-cal-start');
			$('.list_missions').html('');
			$.each(events_calendar, function (i, v) {
				if (v.start == datechoose) {
					var idRDV             = v.id;
					var idConv            = v.id_conv;
					var fullname          = v.fullname;
					var horaire           = v.horaire;
					var societe           = v.societe;
					var state             = v.state;
					//var textPushcancelRDV		= '<a class="cancelRDV" href="#" onclick="alertRemoveRDV('+idRDV+',\''+fullname+'\');return false;">Annuler le rendez-vous</a>';
					var textPushcancelRDV = '<a class="cancelRDV" href="/messages/conversation/' + idConv + '">Annuler le rendez-vous</a>';

					if (idConv > 0 && state == 'event-warning') {
						var textPushcancelRDV = '<a class="cancelRDV" href="/messages/conversation/' + idConv + '">Voir la demande de RDV</a>'
					}

					$('.list_missions').append('<div class="item_miss clearfix">\n' +
						'<i class="event ' + state + '"></i>' +
						'\t<span class="pull-left time_miss"><i class="ion-android-time"></i> ' + horaire + '</span>\n' +
						'\t<p class="titl_miss pull-left">' + fullname + '</p>\n' +
						'\t<p class="titl_miss pull-left">' + societe + '</p>\n' +
						'\t' + textPushcancelRDV + '\n' +
						'</div>');
				}

			});
		}
	});
	$('#calendar .cal-month-day .pull-right[data-cal-date="<?php echo date('Y-m-d'); ?>"]').closest('.cal-month-day').click();

	function alertRemoveRDV(idRDV, prenom) {
		$('#ModalRemoveRDV span.prenom').text(prenom);
		$('#ModalRemoveRDV .btn_style_send').attr('onclick', 'removeRDV(' + idRDV + '); return false;');

		$('#ModalRemoveRDV').modal();
	}

	function removeRDV(idRDV) {
		$.ajax({
			type: "post",
			url: "/calendrier/supprimerredezvous",
			data: {id: idRDV, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
			success: function (data) {
				window.location.replace("/calendrier");
			}
		});
	}
</script>