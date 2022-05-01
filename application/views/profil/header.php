<section class="hero_home bg_recherche bg_profil" style="background:url('<?php echo base_url(); ?>assets/img/cover_profil.png') ">
	<div class="spec-profil">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-2">
					<div class="row">
						<div class="col-md-6">
							<span class="name-spec"><?php echo $info_talent->titre; ?></span>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
						</div>
						<div class="col-md-6 side_right text-right">
                           <span class="price">
                           <i><?php echo $info_talent->prix; ?></i> € / H
                           </span>
							<a href="#"><i class="ion-person"></i> Wanted</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ban_info_profil">
		<div class="container">
			<div class="row">
				<div class="col-md-2 photo_profil">
					<img src="<?php echo base_url(); ?>assets/img/pers_2.png" alt="">
				</div>
				<div class="col-md-8 name_pers_profil">
					<p class="nom_pers"><?php echo $info->prenom . " " . $info->nom; ?></p>
					<p class="profil_location">
						<span><i class="ion-ios-location"></i><?php echo $info->adresse; ?></span>
						<span><i class="fa fa-clock-o"></i><?php echo $info_talent->horaire; ?></span>
					</p>
				</div>
				<div class="col-md-2 text-right btn_share_profil">
					<a href="#"><i class="fa fa-heart-o"></i></a>
					<a href="#"><i class="ion-person-add"></i></a>
					<a href="#"><i class="fa fa-share-alt"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end hero home -->
<section class="tab_nav_profil">
	<div class="container">
		<ul class="row text-center">
			<li class="active"><a href="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/apropos">Apropos</a></li>
			<li><a href="<?php echo base_url() . $alias . '/' . $alias_talent; ?>/commentaires">Commentaires <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i> (4)</a></li>
			<li><a href="profil_service.html">Autres talents</a></li>
		</ul>
	</div>
</section>
     