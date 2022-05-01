<?php /* @var $this Comment_ca_marche */ ?>
<section class="hero_home hero_mentor" style="background: url('<?php echo base_url(); ?>assets/img/bg_mentor.jpg') center center no-repeat;-webkit-background-size: cover;
		background-size: cover;min-height:430px">
	<!-- and carousel -->
	<div class="container">
		<div class="row text-center text_hero">
			<div class="col-md-8 col-md-offset-2">
                <?php $titre_decouvrir = $this->user_info->getBlock(6); ?>
				<h1 class="title_mentor"><?php echo $titre_decouvrir->titre; ?></h1>
				<p class="p_44"><?php echo $titre_decouvrir->description; ?></p>
			</div>
		</div>
	</div>
</section>
<!-- end hero home -->
<section class="block_decouvert bg_grey">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12 title_decouvert">
                <?php $decrochez_job = $this->user_info->getBlock(1); ?>
				<h2>Décrochez le job</h2>
				<p><?php echo $decrochez_job->titre; ?></p>
			</div>
		</div>
		<div class="row content_decouvert">
			<div class="col-md-5 col-sm-6">
				<img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $decrochez_job->image; ?>" alt="">
			</div>
			<div class="col-md-7 col-sm-6">
				<p><?php echo $decrochez_job->description; ?></p>
			</div>
		</div>
	</div>
</section>
<section class="block_decouvert ">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12 title_decouvert">
                <?php $decrochez_com = $this->user_info->getBlock(2); ?>
				<h2>Montez en compétence</h2>
				<p><?php echo $decrochez_com->titre; ?></p>
			</div>
		</div>
		<div class="row content_decouvert">
			<div class="col-md-5 col-sm-6">
				<img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $decrochez_com->image; ?>" alt="">
			</div>
			<div class="col-md-7 col-sm-6">
				<p><?php echo $decrochez_com->description; ?></p>
			</div>
		</div>
	</div>
</section>
<section class="block_decouvert bg_grey">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12 title_decouvert">
                <?php $savoir = $this->user_info->getBlock(3); ?>
				<h2>Partagez votre savoir</h2>
				<p><?php echo $savoir->titre; ?></p>
			</div>
		</div>
		<div class="row content_decouvert">
			<div class="col-md-5 col-sm-6">
				<img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $savoir->image; ?>" alt="">
			</div>
			<div class="col-md-7 col-sm-6">
				<p><?php echo $savoir->description; ?></p>
			</div>
		</div>
	</div>
</section>
<section class="block_decouvert ">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12 title_decouvert">
                <?php $engage = $this->user_info->getBlock(4); ?>
				<h2>Tous engagés</h2>
				<p><?php echo $engage->titre; ?></p>
			</div>
		</div>
		<div class="row content_decouvert">
			<div class="col-md-5 col-sm-6">
				<img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $engage->image; ?>" alt="">
			</div>
			<div class="col-md-7 col-sm-6">
				<p><?php echo $engage->description; ?></p>
			</div>
		</div>
	</div>
</section>

<section class="savoir_faire_temoin bg_grey">
	<div class="container">
		<div class="row">
			<div class=" title_savoir text-center">
				<h1>Ils témoignent</h1>
			</div>
		</div>
		<div class="row block_temoins text-center">
            <?php foreach ($temoignages as $key => $item): ?>
				<div class="col-sm-4 temoin_decouvert">
					<p><img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $item->image; ?>" alt=""></p>
					<h3><?php echo $item->user; ?></h3>
					<h4><?php echo $item->titre; ?></h4>
					<p><?php echo $item->description; ?></p>
				</div>
            <?php endforeach ?>
		</div>
	</div>
</section>
<section class="savoir_faire_temoin">
	<div class="container">
		<div class="row">
			<div class="col-md-12 title_savoir text-center mgb_15">
                <?php $rejoin = $this->user_info->getBlock(5); ?>

				<h1><?php echo $rejoin->titre ?></h1>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-md-12">
				<p><?php echo $rejoin->description; ?></p>
			</div>
		</div>
		<div class="row text-center btn_tem_ment mgt00">
			<div class="col-md-12">
                <?php if (!$this->session->userdata('logged_in_site_web')) { ?>
					<a href="#" data-toggle="modal" data-target="#ModalConnexion"><?php echo $this->lang->line("revelez_vos_talent"); ?></a>
                <?php } else { ?>
					<a href="<?php echo base_url(); ?>mentor"><?php echo $this->lang->line("revelez_vos_talent"); ?></a>
                <?php } ?>
			</div>
		</div>
	</div>
</section>
<section class="savoir_faire_temoin bg_grey">
	<div class="container">
		<div class="row">
			<div class=" title_savoir text-center">
				<h1>Ils en parlent</h1>
			</div>
		</div>
		<div class="row logos_partenaire">
			<div class="col-md-12" id="carousel_partenaire">
                <?php foreach ($parlents as $key => $item): ?>
					<div class="item">
						<a href="<?php echo $item->link; ?>">
							<img src="<?php echo base_url(); ?>upload/temoignages/<?php echo $item->image; ?>" alt="">
						</a>
					</div>
                <?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $(".chargement_b").hide();
        $("#carousel_coup ").owlCarousel({

            autoPlay: 3000, //Set AutoPlay to 3 seconds

            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]

        });
        $(" #carousel_savoir").owlCarousel({

            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items: 1


        });

        $(".next").click(function () {
            $(" #carousel_savoir").trigger('owl.next');
        });
        $(".prev").click(function () {
            $(" #carousel_savoir").trigger('owl.prev');
        });

        $('.date-picker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: "true",
            startDate: '1d',
            language: 'fr'
        });
        $('.date-picker-n').datepicker({
            format: "dd/mm/yyyy",
            autoclose: "true",
            language: 'fr'
        });

    });

    $(" #carousel_partenaire").owlCarousel({

        autoPlay: 3000, //Set AutoPlay to 3 seconds
        items: 6,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [979, 2]

    });


</script>