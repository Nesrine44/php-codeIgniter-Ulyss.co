<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 29/10/2018
 * Time: 15:26
 */

/* @var BusinessOffre $offre */
/* @var BusinessEntreprise $BusinessEntreprise */

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/assets/css/widget.css">
</head>

<div class="modal fade iframeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Générez l'Iframe de cette offre</h3>
            </div>
            <div class="modal-body">
                <div class="row mgb_15">
                    <div class="col-md-12">
                        <h4>Configuration</h4>
                        <div class="row mgb_15">
                            <div class="col-md-6">
                                <p>Hauteur</p>
                                <input class="heightFrame inputText" type="number" value="500">
                            </div>
                            <div class="col-md-6">
                                <p>Largeur</p>
                                <input class="widthFrame inputText" type="number" value="600">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nombre de ligne</p>
                                <input class="rowFrame inputText" type="number" name="l">
                            </div>
                            <div class="col-md-6">
                                <p>Nombre de colonnes</p>
                                <input class="colFrame inputText" type="number" name="c">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mgb_15">
                    <div class="col-md-12">
                        <input type="button" class="changeFrame btnDefault" value="VALIDER">
                    </div>
                </div>
                <div class="row mgb_15">
                    <div class="col-md-12">
                        <h4>Lien à copier/coller sur votre site</h4>
                        <textarea class="inputText" name="iframeLink" id="iframeLink" rows="0"></textarea>
                    </div>
                </div>
                <section>
                    <h4>Prévisualisation</h4>
                    <div class="newIframe">
                        <iframe name='jobFrame' id='jobFrame' height="500" width="750" src="<?php echo base_url() . 'entreprise/' . $BusinessEntreprise->getAlias() . '/widget-job/' . $offre->getId() . '?c=2&l=3' ?>"></iframe>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
	$aliasEnt = '<?php echo $BusinessEntreprise->getAlias()?>';
	$idOffre  = <?php echo $offre->getId()?>;
	$('.changeFrame').each(function (index) {
		$('.changeFrame').on('click', function () {
			$balise    = document.getElementById('jobFrame');
			$h         = $('.heightFrame').val();
			$w         = $('.widthFrame').val();
			$line      = $('.rowFrame').val();
			$col       = $('.colFrame').val();
			$setIframe = $($balise).attr({height: $h, width: $w});
			$x         = $($balise).attr('src', 'http://www.ulyss.local/entreprise/' + $aliasEnt + '/widget-job/' + $idOffre + '?l=' + $col + '&c=' + $line);
			$iframe    = $('.newIframe').html();
			$iframe    = $.trim($iframe);
			$('#iframeLink').text($iframe);
		})
	});
</script>