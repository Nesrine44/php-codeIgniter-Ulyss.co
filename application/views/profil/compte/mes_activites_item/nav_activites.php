<?php /* @var $this CI_Loader */ ?>
<div class="col-md-3">
    <div class="row">
        <div class="col-md-12">
            <div class="img_membre">
                <a href="#" data-toggle="modal" data-target="#modalchangeAvatar">
                <span class="avatar">
					<?php if ($this->getController()->getBusinessUser()->getAvatar() != '') { ?>
                        <img src="<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>" alt="">
                    <?php } else { ?>
                        <img src="/upload/avatar/default.jpg" alt="">
                    <?php } ?>
                </span> </a>
                <p class="name_wanted"><?php echo $this->getController()->getBusinessUser()->getFullName(); ?></p>


                <p class="title_wanted">
                    <!-- Mes activités -->
                </p>
            </div>
            <div class="menu_left_wanted">


                <ul class="col-md-12 text-left">
                    <?php if ($this->getController()->getBusinessUser()->isMentor()) { ?>
                        <p class="title_wanted1">
                            Espace mentor
                        </p>
                        <li class="<?php if ($this->uri->segment(2) == 'talents_encours' || $this->uri->segment(2) == '') {
                            echo "active";
                        } ?>">
                            <a href="<?php echo base_url(); ?>mes_activites/talents_encours "> <span><i class="fa fa-history"></i></span> Prestations en cours<i class="ion-chevron-right"></i> </a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == 'historiques_des_prestations') {
                            echo "active";
                        } ?>">
                            <a href="<?php echo base_url(); ?>mes_activites/historiques_des_prestations "> <span><i class="fa fa-history"></i></span> Historique des
                                prestations<i class="ion-chevron-right"></i> </a>
                        </li>

                        <hr>
                    <?php } ?>
                    <p class="title_wanted1">
                        Espace Candidat
                    </p>
                    <li class="<?php if ($this->uri->segment(2) == 'favoris') {
                        echo "active";
                    } ?>">
                        <a href="<?php echo base_url(); ?>mes_activites/favoris"> <span><i class="fa fa-heart-o"></i></span> Mes favoris <i class="ion-chevron-right"></i> </a>
                    </li>
                    <li class="<?php if ($this->uri->segment(2) == 'demandes' || $this->uri->segment(2) == 'historiques_des_prestations_demande') {
                        echo "active";
                    } ?>">
                        <a href="<?php echo base_url(); ?>mes_activites/demandes"> <span><i class="ion-briefcase"></i></span> Mes demandes <i class="ion-chevron-right"></i> </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
      