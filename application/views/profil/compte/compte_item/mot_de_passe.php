<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
			<div class="col-md-9 block_mn_compte">
				<form id="change-password-profil" method="post">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

					<div class="row nav_comment">
						<ul class="mg_15">
							<li class="title_li_compte">Mot de passe</li>
						</ul>
					</div>

					<div class="row mes_infos_compte">
						<div class="col-md-12 pdl_30">
							<div class="row">
								<div class="col-md-5">
									<div class="title_label">
										<span>Nouveau mot de passe </span>
									</div>
									<div>
										<input type="password" id="nouveau" name="nouveau">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<div class="title_label">
										<span>Confirmez le nouveau</span>
									</div>
									<div>
										<input type="password" id="confirmation" name="confirmation">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center block_pass" style="display:none;" id="erreur-change-password-profil">
									<p class="error">Vous ne pouvez pas utiliser un mot de passe vide.</p>
								</div>
							</div>
							<div class="row btn_add">
								<a href="#change-password-profil" onclick="changeMypassword()">Enregister</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>