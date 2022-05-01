<?php
	/* @var $this CI_Loader */
	/* @var array $EntrepriseMontor */
	/* @var $this Entreprises */
	/* @var BusinessEntreprise $BusinessEntreprise */
	/* @var string $secteur_name */
?>
<!-- Selection des destinataires -->
<?php if(isset($EntrepriseMontor) && !empty($EntrepriseMontor)) { ?>
	<aside>
		<div class="row mgb_30">
			<div class="col-xs-12">
				<div class="destinataire-choice">
					<p>Veuillez choisir un Destinataire : </p>
					<div id="selection-all-menu">
						<label for="all" id="check-all"> <input type="checkbox" id="select-all">Tous </label>
					</div>
					<?php foreach($EntrepriseMontor as $Montor): ?>
						<div id="departement-menu">
							<label for="<?php echo $Montor->nom_departement ?>" id="<?php echo $Montor->id_departement ?>">
								<input type="checkbox" id="departement-choice" value="<?php echo $Montor->id_departement ?>"> <span><?php echo $Montor->nom_departement ?></span> </label>
						</div>
						<div id="talent-submenu" style="display: none;">
							<label for="<?php echo $Montor->user_id ?>" id="<?php echo $Montor->id ?>"> <input type="checkbox" id="talent-choice" class="elmt" value="<?php echo $Montor->id ?>">
								<span><?php echo $Montor->prenom ?></span> <span><?php echo $Montor->nom ?></span> </label>
						</div>
					<?php endforeach; ?>
					<!-- Ulyssco mail Contact -->
					<div class="row mgb_30">
						<div class="col-xs-12">
							<label for="ulyssco"> <input type="checkbox" name="Ulyssco" id="ulyss" value="hello@ulyss.co">Ulyssco </label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
<?php } ?>
<!-- End Selections des destinataires -->

<!-- Send Message -->
<div class="row mgb_30">
	<div class="col-xs-12">
		<div class="form-msg">
			<!-- Form Send Message -->
			<?php echo form_open('', 'id="formSendMsg"') ?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<label for="destinataire" id="destinataire"> <input type="text" id="input-destinataire" name="destinataire" placeholder="Destinataire" readonly required> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<label for="object" id="object"> <input type="text" id="object-msg" name="objet" placeholder="Objet" required> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<label for="content-msg" id="content"> <textarea id="content-msg" name="contenu" placeholder="Message" required></textarea> </label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<input type="submit" id="send-ok" value="Envoyer">
				</div>
			</div>
			<?php echo form_close() ?>
			<!-- End Form Send Message -->
		</div>
	</div>
</div>
<!-- End Send Message -->

<!-- Script -->
<script>
	$(function () {
		/* Disparition du menu déroulant au clic hors de la zone (sauf sur le champ input #departement-menu) */
		$(document).on("click", function (e) {
			if ($(e.target).closest("#talent-submenu")[0] === undefined) {
				if ((e.target.id != "talent-submenu") && (e.target.id != "departement-choice")) {
					$("#talent-submenu").hide();
				}
			}
		});

		/*Affichage/Non affichage du menu déroulant au click sur le bouton departement-choice*/
		$("#departement-choice").on("click", function () {
			$("#talent-submenu").toggle();
			$("#talent-submenu").css('width', $("#departement-choice").width());
		});

		/*Coloration de la ligne courante au survol en bleu comme sur un vrai SELECT*/
		$(".elmt").mouseover(function () {
			$(this).css('background-color', '#1E90FF');
		});

		/*Décoloration de la ligne quand on la quitte*/
		$(".elmt").mouseleave(function () {
			$(this).css('background-color', '');
		});

		/*On coche la case quand on clique sur la ligne*/
		$('.elmt').on('click', function (e) {
			var target   = e.target;
			var checkbox = $('.check', this);

			if (!checkbox.is(target)) {
				console.log('ok');
				if (checkbox.attr('checked'))
					checkbox.prop('checked', false);
				else
					checkbox.prop('checked', true);
			}
		});

		/*Cache du menu quand on quitte la zone des checkbox*/
		//$('#talent-submenu').mouseleave(function () {
		//	$('#talent-submenu').hide();
		//});
	});
</script>