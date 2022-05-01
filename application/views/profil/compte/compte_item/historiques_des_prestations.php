<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
			<div class="col-md-9 block_activ_demande">
				<div class="row nav_comment">
					<ul class="col-md-12 mg_15">
						<li><a href="<?php echo base_url(); ?>compte/historiques_des_transactions">En cours</a></li>
						<li class="active"><a href="<?php echo base_url(); ?>compte/historiques_des_prestations">Historique des prestations</a></li>
					</ul>
				</div>
                <?php if (!empty($mes_demandes)) { ?>
					<div class="row">
						<div class="col-md-12 table_transactions">
							<div class="panel panel-default">
								<!-- Default panel contents -->
								<div class="panel-heading">Prestations passées</div>
								<!-- Table -->
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
										<tr>
											<th>Statut</th>
											<th></th>
											<th>Nom</th>
											<th>Date</th>
											<th></th>
											<th>Option</th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach ($transaction_passes as $row):
                                            if( $row->statut == 'undefined' ) continue;
											?>
											<tr class="accepter">
												<td class="state"><?php echo $row->statut; ?></td>
												<td class="cl_blue"></td>
												<td class="cl_blue"><?php echo $this->user_info->getNameUser($row->user_achteur); ?></td>
												<td><?php echo strftime("%d  %B %Y", strtotime($row->date_livraison)).' - '.$row->horaire; ?></td>
												<td class="cl_blue"></td>
												<td>
													<p><a href="<?php echo base_url(); ?>messages/conversation/<?php echo $row->conversations; ?>">Historique des messages</a></p>
												</td>
											</tr>
                                        <?php endforeach ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>


					<div class="row">
						<div class="col-md-12 table_transactions">
							<div class="panel panel-default">
								<!-- Default panel contents -->
								<div class="panel-heading">Prestations refusées</div>
								<!-- Table -->
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
										<tr>
											<th>Statut</th>
											<th></th>
											<th>Nom</th>
											<th>Date</th>
											<th></th>
											<th>Option</th>
										</tr>
										</thead>
										<tbody>
                                        <?php foreach ($transaction_rejete as $row): ?>
											<tr class="annuler">
												<td class="state"><?php echo $row->statut; ?></td>
												<td class="cl_blue"></td>
												<td class="cl_blue"><?php echo $this->user_info->getNameUser($row->user_achteur); ?></td>
												<td><?php echo strftime("%d  %B %Y", strtotime($row->date_creation)); ?></td>
												<td></td>
												<td>
													<p><a href="<?php echo base_url(); ?>messages/conversation/<?php echo $row->conversations; ?>">Historique des messages</a></p>
												</td>
											</tr>
                                        <?php endforeach ?>

										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
                <?php } else { ?>
					<div class="row mgb_0">
						<div class="col-md-11 col-md-offset-1">
							<p>Vous n’avez pas de nouvelles demandes. </p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-9  field_search">
							<input type="text" placeholder="Souhaitez-vous faire une demande ?">
						</div>
						<div class="col-md-2 col-xs-3 btn_search">
							<a href="#"><i class="ion-android-search"></i></a>
						</div>
					</div>


                <?php } ?>


			</div>
		</div>
	</div>
</section>