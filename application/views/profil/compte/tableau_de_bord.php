<section class="dashbord">
	<div class="container">
        <?php if ($talents): ?>
			<div class="row">
				<div class="col-md-3 col-sm-6 mgb_30">
					<div class="bg_blue">
						<div class="top_card">
							<span class="icon_card"><i class="ion-arrow-graph-up-right"></i>
							<span class="pull-right text-right stat"><em><?php echo $responses; ?> %</em><br /> de taux de réponse</span>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 mgb_30">
					<div class="bg_blue">
						<div class="top_card">
							<span class="icon_card"><i class="ion-eye"></i></span>
							<span class="pull-right text-right stat"><em><?php echo $visualisee; ?></em><br /> vue<?php echo $visualisee>1?'s':''; ?> de votre profil</span>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 mgb_30">
					<div class="bg_blue">
						<div class="top_card">
							<span class="icon_card"><i class="ion-android-calendar"></i></span>
							<span class="pull-right text-right stat"><em><?php echo $rdvRealises; ?></em><br>rendez-vous réalisé<?php echo $rdvRealises>1?'s':''; ?></span>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 mgb_30">
					<div class="bg_blue">
						<div class="top_card">
							<span class="icon_card"><i class="ion-thumbsup"></i></span>
							<span class="pull-right text-right stat"><em><?php echo $recommandations; ?></em><br>recommandation<?php echo $recommandations>1?'s':''; ?></span>
						</div>
					</div>
				</div>
			</div>
        <?php endif; ?>
	</div>
</section>