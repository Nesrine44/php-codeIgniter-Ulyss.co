<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/mes_activites_item/nav_activites'); ?>
			<div class="col-md-9 block_result_search">
				<div class="row empty-favoris">
					<div class="col-md-6 col-md-offset-5 text-right">
						<p> Ajoutez un profil à vos favoris en cliquant <br> sur le bouton <i class="fa fa-heart-o"></i></p>
					</div>
				</div>
				<div class="row block_favoris block_right">

                    <?php foreach ($favoris as $BusinessTalent) { /* @var $BusinessTalent BusinessTalent */ ?>
						<a href="<?php echo $BusinessTalent->getUrl(); ?>apropos">
							<div class="col-md-6 result_pers">
								<div class="bg_white_2 pad_0" style="min-height: 190px;">
									<div class="row display_flex">
										<div class="col-md-5 col-sm-5 img_membre">
                                            <?php if ($BusinessTalent->getBusinessUser()->getAvatar() != "") { ?>
												<span class="avatar img_linkedin" style="background: url('<?php echo $BusinessTalent->getBusinessUser()->getAvatar(); ?>') center center no-repeat;"></span>
                                            <?php } else { ?>
												<span class="avatar img_linkedin" style="background: url('/upload/avatar/default.jpg') center center no-repeat;"></span>
                                            <?php } ?>
										</div>
										<div class="col-md-7 col-sm-7 padl-0">
											<div class="row" style="text-align: left !important;">
												<div class="col-sm-12">
													<h4 class="name_entreprise"><?php echo $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyName(); ?></h4>
													<div class="inf_pr_ava">
														<div class="rate">
															<p class="name_pers">
                                                                <?php echo $BusinessTalent->getBusinessUser()->getPrenom(); ?>
															</p>
                                                            <?php if ((int)$BusinessTalent->countRecommandations() > 0) { ?>
																<i class="ion-thumbsup"></i>
																<span>(<?php echo (int)$BusinessTalent->countRecommandations(); ?>)</span>
                                                            <?php } ?>
														</div>
													</div>
													<span class="name_entreprise mt20"><?php echo $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getActualjobTitle(); ?></span>
													<p class="pos_pers">
														<span><i class="fa fa-map-marker"></i><?php echo $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyLocation(); ?></span>
													</p>
													<span class="date">
																<?php echo ucfirst(strftime('%B %Y', strtotime($BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getActualjobStartDate()->format('Y-m-d')))); ?>
                                                        	à Aujourd'hui
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
                    <?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade text-center modal_home modal_form" id="modalConfirmationDisliketalent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-body">
				<div class="row bienvenue">
					<p>Êtes-vous sûr de vouloir supprimer ce profil de vos favoris ?</p>
				</div>

				<div class="row">
					<div class="col-md-5 col-md-offset-1 row btn_add">
						<a href="#" id="id_dislike_favoris">Valider</a>
					</div>
					<div class="col-md-5 col-md-offset-1 row btn_add">
						<a href="#" data-dismiss="modal" aria-label="Close">Annuler</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- footer -->
