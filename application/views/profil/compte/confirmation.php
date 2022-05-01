<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="row">
					<div class="col-md-12">
						<div class="steps_pmt active">
	            			<span class="step_number">
	            				<em>1</em>
	            			</span>
							<span>
	            				Confirmation
	            			</span>
						</div>
						<div class="steps_pmt next_stp">
	            			<span class="step_number">
	            				<em>2</em>
	            			</span>
							<span>
	            				Paiement
	            			</span>
						</div>
						<div class="steps_pmt next_stp">
	            			<span class="step_number">
	            				<em>3</em>
	            			</span>
							<span>
	            				Validation
	            			</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 block_mn_compte">
				<div class="row nav_comment">
					<ul class="mg_15">
						<li class="title_li_compte">Confirmation paiement</li>
					</ul>
				</div>
				<div class="row mes_infos_compte">
					<div class="col-md-6 confirm_pmt">
						<div class="row title_label">
							<div class="col-md-6">
								<span>Paiement pour <em class="pull-right">: </em></span>
							</div>
							<div class="col-md-6 cnt_pmt">
                                <?php echo $utilisateur_pour; ?>
							</div>
						</div>
						<div class="row title_label">
							<div class="col-md-6">
								<span>Total <em class="pull-right">: </em></span>
							</div>
							<div class="col-md-6 cnt_pmt">
                                <?php echo number_format($this->session->userdata("amount"), 2, '.', ' '); ?>€
							</div>

						</div>
                        <?php if ($user_quipay->date_naissance != "0000-00-00" and $user_quipay->adresse != "" and $user_quipay->ville_id != "") { ?>
							<div class="row btn_add mgt_10">
								<button href="<?php echo base_url(); ?>paiement/card" class="sendButton">payer</button>
							</div>
                        <?php } else { ?>
							<div class="row  mgt_10">
								<br><br>
								<p>Avant de régler,veuillez complétervotre date de naissance et/ou adresse,ville dans l'espace <a href="<?php echo base_url(); ?>compte">mon compte</a></p>
							</div>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
