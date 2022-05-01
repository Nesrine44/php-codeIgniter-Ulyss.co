<?php /* @var $this CI_Loader */ ?>
<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
			<div class="col-md-9 block_mn_compte">
				<div class="row nav_comment">
					<ul class="mg_15">
						<li class="title_li_compte">Notifications</li>
					</ul>
				</div>
				<div class="row ">
					<div class="col-md-12">
						<div class="col-md-12 pdl_30">
							<div class="title_label">
								<span>Je reçois un message d’un autre membre</span>
							</div>
							<div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_msg_membre" value="email" <?php if ($notifications->notifications_msg_membre == "email") echo "checked"; ?>> E-mail
									</label>
								</div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_msg_membre" value="rien" <?php if ($notifications->notifications_msg_membre == "rien") echo "checked"; ?>> Ne rien recevoir
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12 pdl_30">
							<div class="title_label">
								<span>Une de mes demandes de rendez-vous est acceptée ou refusée </span>
							</div>
							<div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_accepte_refuse" value="email" <?php if ($notifications->notifications_demande_accepte_refuse == "email") echo "checked"; ?>> E-mail
									</label>
								</div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_accepte_refuse" value="sms" <?php if ($notifications->notifications_demande_accepte_refuse == "sms") echo "checked"; ?>> SMS
									</label>
								</div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_accepte_refuse" value="sms_email" <?php if ($notifications->notifications_demande_accepte_refuse == "sms_email") echo "checked"; ?>> SMS et E-mail
									</label>
								</div>


								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_accepte_refuse" value="rien" <?php if ($notifications->notifications_demande_accepte_refuse == "rien") echo "checked"; ?>> Ne rien recevoir
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12 pdl_30">
							<div class="title_label">
								<span> Je reçois une demande de rendez-vous</span>
							</div>
							<div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_pour_talent" value="email" <?php if ($notifications->notifications_demande_pour_talent == "email") echo "checked"; ?>> E-mail
									</label>
								</div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_pour_talent" value="sms" <?php if ($notifications->notifications_demande_pour_talent == "sms") echo "checked"; ?>> SMS
									</label>
								</div>

								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_pour_talent" value="sms_email" <?php if ($notifications->notifications_demande_pour_talent == "sms_email") echo "checked"; ?>> SMS et E-mail
									</label>
								</div>


								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="notifications_demande_pour_talent" value="rien" <?php if ($notifications->notifications_demande_pour_talent == "rien") echo "checked"; ?>> Ne rien recevoir
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12 pdl_30">
							<div class="title_label">
								<span> Je m'inscris à la newsletter</span>
							</div>
							<div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="optin_news" value="1" <?php echo $this->getController()->getBusinessUser()->isOptinNews() ? 'checked' : ''; ?>> Oui
									</label>
								</div>
								<div class="checkbox check_notif">
									<label>
										<input type="radio" name="optin_news" value="0" <?php echo $this->getController()->getBusinessUser()->isOptinNews() == false ? 'checked' : ''; ?>> Non
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>