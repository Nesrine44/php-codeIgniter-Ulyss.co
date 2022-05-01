<section class="block_resultas wanted_block">
	<div class="container">
		<div class="row">
            <?php $this->load->view('profil/compte/compte_item/nav_compte'); ?>
			<div class="col-md-9 block_mn_compte">
				<div class="row nav_comment">
					<ul class="mg_15">
						<li class="title_li_compte">Fermeture du compte</li>
					</ul>
				</div>
				<div class="row ">
					<div class="col-md-12">
						<p>Si vous souhaitez vraiment fermer votre compte, nous en sommes désolés. Afin que nous puissions continuer d'améliorer notre service, nous vous demandons simplement de nous donner la raison de votre décision.</p>
					</div>
				</div>
				<div class="row ">
					<div class="col-md-12 pdl_30">
						<div class="title_label">
							<span>Les raisons</span>
						</div>
						<div>
							<textarea rows="10" name="raisons" id="raison_f" placeholder="Les raisons" maxlength="300"></textarea>
						</div>
					</div>
				</div>
				<div class="row ">
					<div class="col-md-12 pdl_30">
						<div class="title_label">
							<span>Recommanderiez-vous notre service ? </span>
						</div>
						<div>
							<div class="checkbox">
								<label>
									<input type="radio" name="cowd" class="recomandation_cowanted" value="oui" checked="checked"> Oui
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="radio" name="cowd" class="recomandation_cowanted" value="non"> Non
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row ">
					<div class="col-md-12 pdl_30">
						<div class="title_label">
							<span>Que pourrions-nous améliorer ?</span>
						</div>
						<div>
							<textarea rows="10" name="ameliorer" id="ameliorer_f" placeholder="Que pourrions-nous améliorer ?" maxlength="355"></textarea>
						</div>
					</div>
				</div>
				<div class="row  delete_compte">
					<div class="col-md-12 pdl_30">
						<a href="#" onclick="bolckerMonCompte()"><i class="ion-close"></i> Supprimer le compte</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Modal change fermeture compte-->
<div class="modal fade text-center modal_home modal_form" id="modalFermetureCompte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-body">
				<div class="row">
					<h1>Confirmation de fermeture votre compte</h1>
				</div>

				<div class="col-md-10 col-md-offset-1">
					<p class="msg error"></p>
				</div>

				<div class="row">
					<div class="col-md-8 col-md-offset-2 ">
						<p>Voulez-vous vraiment fermer votre compte ?</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-2 button_su btn_inscription">
						<button type="submit" onclick="dofermetureMonCompte();">Oui</button>
					</div>
					<div class="col-md-4  ">
						<button class="close color_fermeture" data-dismiss="modal" aria-hidden="true">Non</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end modal change picture-->