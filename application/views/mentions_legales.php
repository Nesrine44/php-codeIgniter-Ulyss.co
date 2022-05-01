<?php /* @var $this Mentions_legales */ ?>
<section class="pg-conditions">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1>Mentions légales</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 links_cd">
                <?php foreach ($list as $key => $para) { ?>
					<p>
						<a href="#sec<?php echo $para->id; ?>"><?php echo $para->title; ?></a>
					</p>
                <?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
                <?php foreach ($list as $key => $para) { ?>
					<section class="section" id="sec<?php echo $para->id; ?>">
						<h3><?php echo $para->title; ?></h3>
						<p>
                            <?php echo $para->description; ?>
						</p>
					</section>
                <?php } ?>
			</div>
		</div>
	</div>
</section>
