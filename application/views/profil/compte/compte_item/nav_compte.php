<div class="col-md-3">
	<div class="row">
		<div class="col-md-12">
			<div class="img_membre">
				<a href="#" data-toggle="modal" data-target="#modalchangeAvatar">
					<span class="avatar">
						<?php if( $this->getController()->getBusinessUser()->getAvatar() != '' ){ ?>
							<img src="<?php echo $this->getController()->getBusinessUser()->getAvatar(); ?>" alt="">
                        <?php }else{ ?>
							<img src="/upload/avatar/default.jpg" alt="">
                        <?php } ?>
					</span>
				</a>
				<p class="name_wanted"><?php echo $this->getController()->getBusinessUser()->getFullName(); ?></p>
				<p class="title_wanted">Mon compte</p>
			</div>
			<div class="menu_left_wanted">
				<ul class="col-md-12 text-left">
					<li class="<?php if ($this->uri->segment(1) == 'compte' && $this->uri->segment(2) == '') echo "active"; ?>">
						<a href="<?php echo base_url(); ?>compte">
							<span><i class="entypo-vcard fs_n"></i></span>
							Mes Informations <i class="ion-chevron-right"></i>
						</a>
					</li>
					<li class="<?php if ($this->uri->segment(2) == 'monprofil') echo "active"; ?>">
						<a href="<?php echo base_url(); ?>compte/monprofil">
							<span><i class="ion-person" style="font-size: 22px;"></i></span>
							Mon Profil Linkedin<i class="ion-chevron-right"></i>
						</a>
					</li>
					<li class="<?php if ($this->uri->segment(2) == 'notifications') echo "active"; ?>">
						<a href="<?php echo base_url(); ?>compte/notifications">
							<span><i class="ion-email-unread"></i></span>
							Notifications <i class="ion-chevron-right"></i>
						</a>
					</li>
					<li class="<?php if ($this->uri->segment(2) == 'mes_activites') echo "active"; ?>">
						<a href="<?php echo base_url(); ?>mes_activites/talents">
							<span><i class="ion-android-close"></i></span>
							Désactiver mon profil <i class="ion-chevron-right"></i>
						</a>
					</li>
					<li class="<?php if ($this->uri->segment(2) == 'fermeture_du_compte') echo "active"; ?>">
						<a href="<?php echo base_url(); ?>compte/fermeture_du_compte">
							<span><i class="ion-android-close"></i></span>
							Fermeture du compte <i class="ion-chevron-right"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>