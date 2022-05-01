<section class="block_resultas wanted_block">
	<div class="container">
        <?php if (!empty($facture)) { ?>
			<div class="row">
                <?php $this->load->view('profil/compte/mes_activites_item/nav_activites'); ?>
				<div class="col-md-9 block_activ_demande">
					<div class="row nav_comment">
						<ul class="col-md-12 mg_15">
							<li class="pull-left"><a href="javascript:window.history.go(-1);"><i class="ion-chevron-left"></i> Retour</a></li>
							<li class="pull-right mgr_0"><a href="<?php echo base_url(); ?>mes_activites/telecharger_facture/<?php echo $facture->demande_id; ?>"><i class="ion-ios-download-outline"></i> Télècharger</a></li>
						</ul>
					</div>

					<div class="row">
						<div class="col-md-12 table_transactions">
							<div class="row">

								<!-- facture -->
								<!-- header facture -->
								<table align='left'>
									<tr>
										<td><img src="<?php echo base_url(); ?>/assets/img/logo_2.png" alt=""></td>
									</tr>
									<tr height="50"></tr>
								</table>
								<!-- end header facture -->
								<table style="border:1px solid #ddd">
									<tr style="border:1px solid #ddd;height:40px;    background: #f2f2f2;">
										<th style="padding-left:20px"><b>Designation</b></th>
										<th style=""></th>
										<th style=""><b>Prix</b></th>
									</tr>
									<tr style="border:1px solid #ddd">
										<td colspan="2" style="padding:10px 20px">
                                            <?php echo $facture->titre; ?>
										</td>
										<td style="">
                                            <?php echo $facture->montant - ($facture->montant * ($facture->montant / 100)); ?>
										</td>
									</tr>

									<tr style="border:1px solid #ddd;height:40px">
										<td></td>
										<td style="background: #f2f2f2;padding-left: 20px;">
											<b>TVA</b>
										</td>
										<td style="background: #f2f2f2">
											<b><?php echo $facture->montant * ($facture->montant / 100); ?></b>
										</td>
									</tr>

									<tr style="border:1px solid #ddd;height:40px">
										<td></td>
										<td style="background: #f2f2f2;padding-left: 20px;">
											<b>Total TTC</b>
										</td>
										<td style="background: #f2f2f2">
											<b><?php echo $facture->montant; ?></b>
										</td>
									</tr>
								</table>

								<!-- footer facture -->
								<table align='center'>
									<tr height="50"></tr>
									<tr>
										<td style="font-size:11px;color:#333;text-align:center !important"><?php echo $this->user_info->getconfig(9); ?></td>
									</tr>
								</table>
								<!-- end footer facture -->
								<!-- end facture -->
							</div>
						</div>
					</div>
				</div>
			</div>
        <?php } ?>
	</div>
</section>

