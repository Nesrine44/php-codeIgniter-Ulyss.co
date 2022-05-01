<?php /* @var $this CI_Loader */ ?>
<section class="hero_home bg_recherche h150" style="background: #333">
	<!-- <a href="#" class="btn_change_cover" data-toggle="modal" data-target="#modalEditCoverture">Changer la couverture</a> -->
	<div class="menu_wanted">
		<ul>
			<?php if($this->getController()->getBusinessUser()->isMentor()) { ?>
				<li class="<?php if($this->uri->segment(3) == 'apropos') {
					echo "active";
				} ?>">
					<a href="<?php echo base_url() . $BusinessUser->getMentor()->getUrlProfile(); ?>"><span class="ico"><i class="ion-eye"></i></span><span class="title_men">Voir mon profil</span></a>
				</li>
				<li class="<?php if($this->uri->segment(1) == 'tableau_de_bord') {
					echo "active";
				} ?>"><a href="<?php echo base_url(); ?>tableau_de_bord"><span class="ico"><i class="ion-speedometer"></i></span><span class="title_men">Tableau de bord</span></a></li>
				<li class="<?php if($this->uri->segment(1) == 'calendrier') {
					echo "active";
				} ?>"><a href="<?php echo base_url(); ?>calendrier"><span class="ico"><i class="ion-calendar"></i></span><span class="title_men">Calendrier</span></a></li>
			<?php } ?>
			<li class="<?php if($this->uri->segment(1) == 'mes_activites') {
				echo "active";
			} ?>"><a href="<?php echo base_url(); ?>mes_activites"><span class="ico"><i class="ion-person"></i></span><span class="title_men">Mes activités</span></a></li>
			<li class="<?php if($this->uri->segment(1) == 'messages') {
				echo "active";
			} ?>"><a href="<?php echo base_url(); ?>messages"><span class="ico"><i class="ion-email"></i></span><span class="title_men">Messages</span></a></li>
			<li class="<?php if($this->uri->segment(1) == 'compte') {
				echo "active";
			} ?>"><a href="<?php echo base_url(); ?>compte"><span class="ico"><i class="ion-ios-gear"></i></span><span class="title_men">Compte</span></a></li>
			<li><a href="<?php echo base_url(); ?>login/logout"><span class="ico"><i class="ion-android-exit"></i></span><span class="title_men">Déconnexion</span></a></li>
		</ul>
	</div>
</section><!-- end hero home -->


<!-- modal editer coverture -->
<div class="modal fade text-center modal_home modal_form" id="modalEditCoverture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">

			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<div class="modal-body">
				<form method="post" id="changeCovertureProfile">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<?php
							$list_coverture = $this->user_info->getListCoverture();
							foreach($list_coverture as $cover) {
								$active  = "";
								$checked = "";
								if($cover->image == $this->user_info->getCovertureUser()) {
									$active  = "active";
									$checked = "checked";
								}
								?>
								<a href="#">
									<div class="col-md-4 coverture_item <?php echo $active; ?>">
										<input type="radio" name="id_coverture" class="id_coverture" value="<?php echo $cover->image; ?>" <?php echo $checked; ?> >
										<img src="<?php echo base_url(); ?>image.php/<?php echo $cover->image; ?>?height=319&width=154&cropratio=2:1&image=<?php echo base_url(); ?>upload/covertures/<?php echo $cover->image; ?>" alt="">
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