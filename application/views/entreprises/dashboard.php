<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 31/07/2018
 * Time: 14:12
 */
/* @var $this CI_Loader */
/* @var $BusinessEntreprise BusinessEntreprise
 * @var $BusinessStat BusinessStat
 */
?>

<div class="modal fade ent_mod" id="dashModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="row up">
                <div class="col-md-4 nbMentor" style="margin: 0 50px;"><h4>MENTORS <a class="bulleInfo">i<span>Salariés dans l'entreprise</span></a></h4>
                    <div> <?php echo $BusinessEntreprise->getNbrMentor() ?>
                        <img src="/assets/img/icons/team.png" alt="mentors"></div>
                    <p class="last">Last : 0</p>
                </div>
                <div class="col-md-4 nbMentor" style="margin: 0 50px;"><h4>RDV REALISES</h4>
                    <div><?php echo '0' ?><img src="/assets/img/icons/conversation.png" alt="rdv_mentors"></div>
                    <p class="last">Last : 0</p>
                </div>
                <div class="col-md-4 nbMentor" style="margin: 0 50px;">
                    <h4>OFFRES D'EMPLOI</h4>
                    <div><?php echo $BusinessEntreprise->getNbrOffrePublic() ?><img src="/assets/img/icons/job.png" alt="rdv_mentors"></div>
                    <p class="last">Non publiée(s) : <?php echo $BusinessEntreprise->getNbrOffreNonPublic() ?></p>
                    <p class="last">Total : <?php echo $BusinessEntreprise->getNbrTotalOffre() ?></p>

                </div>
            </div>
            <div class="row down">
                <div class="col-md-6"><h4> TAUX D'ATTRACTIVITE</h4>
                    <div id="TxAttDash"></div>
                </div>
                <div class="col-md-6"><h4 style="margin-bottom: 30px">NOMBRE DE REQUETES <a class="bulleInfo">i<span>Recherches de l'entreprise</span></a></h4>
                    <div id="NbRequete"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats Dashboard -->
<script>
	//FAKE TAUX DE RECO

	var AttConf = {
		type: "pie",
		backgroundColor: "#ffffff",
		borderRadius: 4,
		title: {
			text: "",
			textAlign: "center",
			fontFamily: "Lato",
			backgroundColor: "none",
			fontColor: "#000000",
			fontSize: "13px",
			offsetY: "10%",
			offsetX: "10%"
		},
		valueBox: {
			visible: true
		},
		plot: {
			slice: 98,
			refAngle: 270,
			detach: false,
			backgroundColor: '#3cd572',
			hoverState: {
				visible: false
			},
			valueBox: {
				visible: true,
				type: "first",
				connected: false,
				placement: "center",
				text: "%v %",
				rules: [
					{
						rule: "%v < 70",
						visible: false
					}
				],
				fontColor: "#000000",
				fontFamily: 'Lato',
				fontSize: "20px"
			},
			tooltip: {
				rules: [
					{
						rule: "%i == 0",
						text: "%v",
						shadow: false,
						borderRadius: 4,
					}
				],
			},
			animation: {
				delay: 90000,
				effect: 2,
				speed: "9000",
				method: "3",
				sequence: "ANIMATION_BY_PLOT"
			}
		},
		series: [
			{
				values: [0],
				text: "Taux de recommandation",
				borderWidth: "0px",
				textAlign: "center",
				shadow: 0
			},
			{
				values: [0],
				backgroundColor: "#FFFFFF",
				borderColor: "#dadada",
				shadow: 0
			}
		]
	};
	$('.dashModal').click(function () {
		zingchart.render({
			id: 'TxAttDash',
			data: AttConf,
			height: 450,
			width: 500
		});
	});

	//FAKE STAT REQUETES ////////////
    <?php
    /* Open connection to "ulyss" MySQL database. */
    $mysqli = new mysqli("localhost", "root", "", "ulyss");
    $mysqli->query("SET lc_time_names = 'fr_FR'");

    /* Check the connection. */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $ent = $BusinessEntreprise->getId();
    $requetes = mysqli_query($mysqli,
        "SELECT COUNT(nbr_vues) as nbr_req, monthname(date_creation) as mois FROM `entreprise_recherche` WHERE entreprise_id='$ent' GROUP BY month(date_creation)");
    $requetesMois = mysqli_query($mysqli,
        "SELECT COUNT(nbr_vues) as nbr_req, monthname(date_creation) as mois FROM `entreprise_recherche` WHERE entreprise_id='$ent' GROUP BY month(date_creation)");
    ?>
	var requetes     = [<?php
        while ($info = mysqli_fetch_array($requetes)) {
            echo $info['nbr_req'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var requetesMois = [<?php
        while ($info = mysqli_fetch_array($requetesMois)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];


	var reqConf = {
		"globals": {
			"font-family": "Roboto"
		},
		"graphset": [
			{
				"type": "area",
				"background-color": "#fff",
				"utc": true,
				"plotarea": {
					"margin-top": "10%",
					"margin-right": "dynamic",
					"margin-bottom": "dynamic",
					"margin-left": "dynamic",
					"adjust-layout": true
				},
				"labels": [
					{
						"text": "Visiteurs: %plot-0-value",
						"default-value": "",
						"color": "#8da0cb",
						"x": "20%",
						"y": 50,
						"width": 120,
						"text-align": "left",
						"bold": 0,
						"font-size": "14px",
						"font-weight": "bold"
					},
				],
				"scale-x": {
					"label": {
						"text": "Date Range",
						"font-size": "14px",
						"font-weight": "normal",
						"offset-x": "10%",
					},
					"item": {
						"text-align": "center",
						"font-color": "#05636c"
					},
					"zooming": 1,
					"max-labels": 12,
					"labels": requetesMois,
					"max-items": 12,
					"items-overlap": true,
					"guide": {
						"line-width": "0px"
					},
					"tick": {
						"line-width": "2px"
					},
				},
				"crosshair-x": {
					"line-color": "#898989",
					"line-style": "dashed",
					"line-width": 1,
					"plot-label": {
						"visible": false
					},
					"marker": {
						visible: true,
						size: 4
					}
				},
				"scale-y": {
					"values": "0:20:2",
					"item": {
						"font-color": "#05636c",
						"font-weight": "normal"
					},
					"label": {
						"text": "Nombre de requêtes",
						"font-size": "14px"
					},
					"guide": {
						"line-width": "0px",
						"alpha": 0.2,
						"line-style": "dashed"
					}
				},
				"plot": {
					"line-width": 2,
					"marker": {
						"size": 1,
						"visible": false
					},
					"animation": {
						"delay": 500,
						"speed": "9000",
						"effect": "ANIMATION_EXPAND_LEFT"
					},
					"tooltip": {
						"font-family": "Roboto",
						"font-size": "15px",
						"text": "Il y a eu %v visiteurs",
						"text-align": "left",
						"border-radius": 5,
						"padding": 10
					}
				},
				"series": [

					{
						"values": requetes,
						"data-days": requetesMois,
						"line-color": "#8da0cb",
						"background-color": "#8da0cb",
						"aspect": "spline",
						"alpha-area": "0.2",
						"text": "visitors",
						"font-family": "Roboto",
						"font-size": "14px"
					}
				]
			}
		]
	};


	$('.dashModal').click(function () {

		zingchart.render({
			id: 'NbRequete',
			data: reqConf,
			height: 430,
			width: 450
		});
	});


</script>
