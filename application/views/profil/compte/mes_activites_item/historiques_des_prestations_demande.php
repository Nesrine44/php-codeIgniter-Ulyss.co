<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/mes_activites_item/nav_activites'); ?>
			<div class="col-md-9 block_activ_demande">
				<div class="row nav_comment">
					<ul class="col-md-12 mg_15">
						<li><a href="<?php echo base_url(); ?>mes_activites/demandes">En cours</a></li>
						<li class="active"><a href="<?php echo base_url(); ?>mes_activites/historiques_des_prestations_demande">Historique des prestations</a></li>
					</ul>
				</div>
                <?php if ( is_array($ModelDemandes) && count($ModelDemandes) > 0 ) { ?>
					<div class="row">
						<div class="col-md-12 table_transactions">
							<div class="panel panel-default">
								<!-- Default panel contents -->
								<div class="panel-heading">Prestations en cours</div>
								<!-- Table -->
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
										<tr>
											<th>Statut</th>
											<th>Nom</th>
											<th>Date</th>
											<th>Option</th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach ($ModelDemandes as $BusinessTalentDemande){ /* @var $BusinessTalentDemande BusinessTalentDemande */ ?>
											<tr class="<?php echo $BusinessTalentDemande->getStatusClassCSS(); ?>">
												<td class="state"><?php echo $BusinessTalentDemande->getStatusInText(); ?></td>
												<td class="cl_blue"><a href="<?php echo $BusinessTalentDemande->getBusinessUserInterlocutor()->getBusinessTalent()->getUrl(); ?>apropos"><?php echo $BusinessTalentDemande->getBusinessUserInterlocutor()->getFullName(); ?></a></td>
												<td><?php echo $BusinessTalentDemande->getDateHourRdvInText(); ?></td>
												<td>
													<p><a href="<?php echo base_url(); ?>messages/conversation/<?php echo $BusinessTalentDemande->getBusinessConversation()->getId(); ?>">Historique des messages</a></p>
												</td>
											</tr>
                                        <?php } ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                <?php } else { ?>
					<div class="row mgb_0">
						<div class="col-md-11 col-md-offset-1">
							<p>Vous n’avez pas de nouvelles demandes en cours. </p>
						</div>
					</div>
                <?php } ?>
			</div>
		</div>
	</div>
</section>

