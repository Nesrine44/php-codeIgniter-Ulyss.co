<?php
/* @var $this CI_Loader
 * @var stdClass     $lastExp
 * @var BusinessUser $BusinessUser
 */
?>
    <section class="hero_ccm bg_prof" style="background:url(<?php echo base_url(); ?>assets/img/bg_step_2.jpg) top center no-repeat ">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center text-hr">
                    <h1 class="prof_img">
                        <?php if ($info->avatar != '') { ?>
                            <img src="<?php echo $info->avatar; ?>" alt="" width="80" height="80" class="img-circle">
                        <?php } else { ?>
                            <img src="/upload/avatar/default.jpg" alt="">
                        <?php } ?>
                    </h1>
                    <p class="title_profl"><?php echo $info->prenom . ' ' . $info->nom; ?></p>
                    <?php if (isset($lastExp)) {
                        ?>
                        <span class="description_profil"><?php echo $lastExp->titre_mission . '<br />' . $lastExp->entName ?></span>
                    <?php } ?>
                    <?php if ($BusinessUser->getMentor()->countRecommandations() > 0) { ?>
                        <p class="stars_profl">
                            <i class="ion-thumbsup"></i> <span>(<?php echo $BusinessUser->getMentor()->countRecommandations(); ?>)</span>
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero home -->
    <section class="tab_nav_profil bar_prof_fixed">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul class="row text-left">
                        <li class="<?php if ($this->uri->segment(3) == 'apropos') {
                            echo "active";
                        } ?>"><a href="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos">A propos</a></li>
                        <?php if ($BusinessUser->getMentor()->countRecommandations() > 0) { ?>
                            <li style="color: #fff;"><i class="ion-thumbsup"></i> (<?php echo $BusinessUser->getMentor()->countRecommandations(); ?>
                                candidat<?php echo $BusinessUser->getMentor()->countRecommandations() > 1 ? 's' : ''; ?>
                                recommande<?php echo $BusinessUser->getMentor()->countRecommandations() > 1 ? 'nt' : ''; ?> ce Mentor)
                            </li>
                        <?php } ?>
                        <li class="ic_fav"><?php if ($this->session->userdata('logged_in_site_web')) { ?>
                                <?php if (!$droir_editer) {
                                    if ($this->user_info->checkFavoris($info_talent->id)) {
                                        ?>
                                        <a href="#" class="active" id="favoris_icon1" onclick="gotofavoris1(<?php echo $info_talent->id; ?>)"><i id="f_ico_co1" class="fa fa-heart"></i></a>
                                    <?php } else {
                                        ?>
                                        <a href="#" id="favoris_icon1" onclick="gotofavoris1(<?php echo $info_talent->id; ?>)"><i id="f_ico_co1" class="fa fa-heart-o"></i></a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <a href="#" data-toggle="modal" data-target="#ModalConnexion"><i class="fa fa-heart-o"></i> </a>
                            <?php } ?> | <a href="#" data-toggle="modal" data-target="#modal-partage"><i class="fa fa-share-alt"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="tab_nav_profil top_bar_prof">
        <div class="container">
            <ul class="row text-left">
                <li class="<?php if ($this->uri->segment(3) == 'apropos') {
                    echo "active";
                } ?>"><a href="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos">A propos</a></li>
                <?php if ($BusinessUser->getMentor()->countRecommandations() > 0) { ?>
                    <li style="color: #fff;"><i class="ion-thumbsup"></i> (<?php echo $BusinessUser->getMentor()->countRecommandations(); ?>
                        candidat<?php echo $BusinessUser->getMentor()->countRecommandations() > 1 ? 's' : ''; ?>
                        recommande<?php echo $BusinessUser->getMentor()->countRecommandations() > 1 ? 'nt' : ''; ?> ce Mentor)
                    </li>
                <?php } ?>
                <li class="ic_fav"><?php if ($this->session->userdata('logged_in_site_web')) { ?>
                        <?php if (!$droir_editer) {
                            if ($this->user_info->checkFavoris($info_talent->id)) {
                                ?>
                                <a href="#" class="active" id="favoris_icon" onclick="gotofavoris(<?php echo $info_talent->id; ?>)"><i id="f_ico_co" class="fa fa-heart"></i></a>
                            <?php } else {
                                ?>
                                <a href="#" id="favoris_icon" onclick="gotofavoris(<?php echo $info_talent->id; ?>)"><i id="f_ico_co" class="fa fa-heart-o"></i></a>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" data-toggle="modal" data-target="#ModalConnexion"><i class="fa fa-heart-o"></i> </a>
                    <?php } ?> | <a href="#" data-toggle="modal" data-target="#modal-partage"><i class="fa fa-share-alt"></i></a>
                </li>
            </ul>
        </div>
    </section>
<?php if ($droir_editer) { ?>
    <!-- modal editer coverture -->
    <div class="modal fade text-center modal_home modal_form" id="modalEditCoverture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <form method="post" id="changeCovertureTalent">
                        <div class="row">
                            <input type="hidden" value="<?php echo $info_talent->id; ?>" name="id_talent">
                            <?php
                            $list_coverture = $this->user_info->getListCoverture();
                            foreach ($list_coverture as $cover) {
                                $active  = "";
                                $checked = "";
                                if ($cover->image == $this->user_info->getCovertureTalent($info_talent->id)) {
                                    $active  = "active";
                                    $checked = "checked";
                                }
                                ?>
                                <a href="#">
                                    <div class="col-md-4 coverture_item <?php echo $active; ?>">
                                        <input type="radio" name="id_coverture" class="id_coverture" value="<?php echo $cover->image; ?>" <?php echo $checked; ?> >
                                        <img src="<?php echo base_url(); ?>image.php/<?php echo $cover->image; ?>?height=319&width=154&cropratio=2:1&image=<?php echo base_url($this->config->item('upload_covertures') . $cover->image); ?>" alt="">
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="row btn_inscription ">
                            <div class="col-md-10 col-md-offset-1 button_su">
                                <button class="sendButtonport" type="submit">Valider</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal editer talent-->
    <div class="modal fade text-center modal_home modal_form" id="ModalEditmonTalent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <h1>Editer discipline</h1>
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" id="formEditerTalent" enctype="multipart/form-data">
                        <div class="row  ">
                            <div class="col-md-10 col-md-offset-1 ">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>">
                                <input type="text" class="required" name="titre" value="<?php echo $info_talent->titre; ?>" placeholder="Indiquez le titre de talent">
                            </div>
                        </div>
                        <div class="row field_mail1">
                            <div class="input-group margin-bottom-sm col-md-10 col-md-offset-1 location_field">
                                <span class="input-group-addon"><i class="fa fa-home fa-fw"></i></span>
                                <input name="ville" id="ville_id_insc" value="<?php echo $info_talent->ville; ?>" type="hidden"></input>
                                <input type="text" id="ville_insc" class="form-control" value="<?php echo $this->user_info->getVilleCodePostal($info_talent->ville); ?>" placeholder="Localisation, Ville, Station">
                                <div class="drop_list">
                                    <ul id="ville_list_insc">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 ">
                                <input type="file" name="file" id="file" onchange="validate();" placeholder="image">
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
                            <div class="col-md-10 col-md-offset-1 chargement_b">
                                <span class="load_photo"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>