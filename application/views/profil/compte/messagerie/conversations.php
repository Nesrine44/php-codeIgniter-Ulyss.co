<?php /* @var $this CI_Loader */ ?>
<?php /* @var $BusinessConversations BusinessConversations */ ?>

<!-- Messages list -->
<section class="top_space bottom_space">

	<div class="container brd_bot">
        <?php if (count($BusinessConversations) < 1) { ?>
			<p><?php echo $this->lang->line("conversation_vide"); ?></p>
        <?php } else { ?>
			<?php foreach ($BusinessConversations as $BusinessConversation){ /* @var $BusinessConversation BusinessConversation */ ?>
				<a href="/messages/conversation/<?php echo $BusinessConversation->getId(); ?>">
					<div class="<?php echo $BusinessConversation->getBusinessDemandeRDV()->getStatusClassCSS(); ?>">
						<div class="row inline <?php echo $BusinessConversation->getLastBusinessMessage()->getStatusInClass().'_bleu'; ?>">
							<div class="col-md-3">
								<div class="pos_block">
									<div class="row">
										<div class="col-xs-3">
											<div class="img_r">
												<?php if ($BusinessConversation->getLastBusinessMessage()->getBusinessUserInterlocutor()->getAvatar() != '') { ?>
													<img src="<?php echo $BusinessConversation->getLastBusinessMessage()->getBusinessUserInterlocutor()->getAvatar(); ?>" alt="">
												<?php } else { ?>
													<img src="/upload/avatar/default.jpg" alt="">
												<?php } ?>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="text-left">
												<span class="txt_profile <?php echo $BusinessConversation->getLastBusinessMessage()->getStatusInClass(); ?>">
													<?php echo $BusinessConversation->getLastBusinessMessage()->getBusinessUserInterlocutor()->getFullName(); ?>
												</span>
												<span class="txt_time <?php echo $BusinessConversation->getLastBusinessMessage()->getStatusInClass(); ?>">
													<?php echo $BusinessConversation->getLastBusinessMessage()->getDateInText(); ?>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-7">
								<div class="text_msg">
									<p class="<?php echo $BusinessConversation->getLastBusinessMessage()->getStatusInClass(); ?>">  <?php echo character_limiter($BusinessConversation->getLastBusinessMessage()->getText(), 30); ?></p>
									<p class="date_heure_call"><?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(); ?></p>
								</div>
							</div>
							<div class="col-md-2">
								<div class="msg_left_wanted text-left">
									<span class="txt_status"><?php echo $BusinessConversation->getBusinessDemandeRDV()->getStatusInText(); ?></span>
								</div>
							</div>
						</div>
					</div>
				</a>
			<?php } ?>
		<?php } ?>
	</div>
</section>