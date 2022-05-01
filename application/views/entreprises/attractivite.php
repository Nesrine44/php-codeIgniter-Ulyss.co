<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 25/09/2018
 * Time: 10:31
 */ ?>

<div class="modal fade ent_mod" id="attractModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="row down">
                <div class="col-md-6 percep">
                    <h4>PERCEPTION DE L'ENTREPRISE</h4>
                    <div id="questionnary"></div>

                </div>
                <div class="col-md-6 attrac">
                    <h4>TAUX D'ATTRACTIVITE</h4>
                    <div>
                        <div id="TxAtt"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Taux de reco questionnaire -->
<script>
    <?php
    /* Open connection to "ulyss" MySQL database. */
    $mysqli = new mysqli("localhost", "root", "", "ulyss");

    /* Check the connection. */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $ent = $BusinessEntreprise->getId();
    /* Fetch result set from t_test table */
    $Taux = mysqli_query($mysqli,
        "SELECT COUNT(*) as taux FROM `questionnaire` WHERE `integrer_entreprise`= 1");
    $TauxNo = mysqli_query($mysqli,
        "SELECT COUNT(*) as Notaux FROM `questionnaire` WHERE not `integrer_entreprise`= 1")
    ?>
	// TAUX DE RECO
	var tauxAttract = [<?php
        while ($info = mysqli_fetch_array($Taux)) {
            echo $info['taux'];
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var tauxNo      = [<?php
        while ($info = mysqli_fetch_array($TauxNo)) {
            echo $info['Notaux'];
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var AttConf     = {
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
				text: "%npv %",
				rules: [
					{
						rule: "%npv < 50",
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
						text: "%npv",
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
				values: tauxAttract,
				text: "%npv",
				borderWidth: "0px",
				textAlign: "center",
				shadow: 0
			},
			{
				values: tauxNo,
				backgroundColor: "#FFFFFF",
				borderColor: "#dadada",
				shadow: 0
			}
		]
	};
	$('.attractModal').click(function () {
		zingchart.render({
			id: 'TxAtt',
			data: AttConf,
			height: 450,
			width: 500
		});
	});


</script>
<!-- QUESTIONNAIRE -->
<script>
    <?php

    /* Fetch result set from t_test table */
    $NSP = mysqli_query($mysqli,
        "SELECT COUNT(*) as NSP FROM `questionnaire` WHERE `integrer_entreprise`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `remuneration` = 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `valorise_collab`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `evolution_interne`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `ambiance`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `bonnes_conditions`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `a_lecoute`= 2 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `innovante_entreprise`= 2 and entreprise_id =1881");
    $Oui = mysqli_query($mysqli,
        "SELECT COUNT(*) as Oui FROM `questionnaire` WHERE `integrer_entreprise`= 1 and entreprise_id =1881 
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `remuneration` = 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `valorise_collab`= 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `evolution_interne`= 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `ambiance`= 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `bonnes_conditions`= 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `a_lecoute`= 1 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `innovante_entreprise`= 1 and entreprise_id =1881");
    $Non = mysqli_query($mysqli,
        "SELECT COUNT(*) as Non FROM `questionnaire` WHERE `integrer_entreprise`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `remuneration` = 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `valorise_collab`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `evolution_interne`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `ambiance`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `bonnes_conditions`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `a_lecoute`= 0 and entreprise_id =1881
UNION ALL SELECT COUNT(*) FROM `questionnaire` WHERE `innovante_entreprise`= 0 and entreprise_id =1881");
    ?>
	var NSP       = [<?php
        while ($info = mysqli_fetch_array($NSP)) {
            echo $info['NSP'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var OUI       = [<?php
        while ($info = mysqli_fetch_array($Oui)) {
            echo $info['Oui'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var NON       = [<?php
        while ($info = mysqli_fetch_array($Non)) {
            echo $info['Non'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var askConfig = {
		type: "hbar",

		title: {
			offsetY: 10,
			text: "\"Suite à votre entretien avec un mentor, estimez-vous <br> que cette entreprise...\" ",
			fontFamily: "Lato",
			fontSize: 14,
			align: 'left',
			fontColor: "#000000",
			offsetX: 10
		},
		tooltip: {
			padding: 10,
			fontSize: 14,
			text: "%v",
			backgroundColor: "#fff",
			fontColor: "#444",
			borderRadius: "5px",
			borderColor: "#333",
			borderWidth: 1
		},

		legend: {
			align: 'center',
			verticalAlign: 'top',
			offsetY: 50,
			offsetX: 0,
			padding: 0,
			backgroundColor: "transparent",
			borderWidth: "0px",
			highlightPlot: true,
			item: {
				fontSize: 12,
				fontColor: "#000000",
				fontFamily: "Lato",

			},
			marker: {
				borderRadius: 10,
				borderWidth: "0px",
			},
			cursor: "hand"
		},
		plotarea: {
			margin: "70 20 40 180"
		},
		plot: {
			borderRadius: "0 5 5 0",
			hightlightMarker: {
				backgroundColor: "#009fbf"
			},
			highlightState: {
				backgroundColor: "#009fbf"
			},
			animation: {
				delay: 90000,
				effect: 2,
				speed: "9000",
				method: "3",
				sequence: "ANIMATION_BY_PLOT"
			}
		},
		scaleX: {
			labels: ['Souhaiteriez-vous intégrer <br> cette entreprise', 'rémunère bien ses employés', 'valorise ses collaborateurs', 'favorise l\'évolution professionnelle', 'accorde de l\'importance <br> à l\'ambiance de travail', 'favorise les bonnes conditions <br> de travail', 'est à l\'écoute de ses collaborateurs', 'est innovante'],
			item: {
				fontFamily: "Lato",
				fontSize: 10,
				color: "#000",
			},
			lineColor: "#DDD",
			tick: {
				visible: false
			}
		},
		scaleY: {
			item: {
				// fontColor: "#fff",
				fontFamily: "Lato",
				fontSize: 14
			},
			lineWidth: 0,
			tick: {
				visible: false
			},
			guide: {
				lineStyle: "solid",
				lineColor: "#DDD"
			},
		},
		series: [
			{
				text: "Oui",
				values: OUI,
				backgroundColor: "#6de06e",
			},

			{
				text: "Non",
				values: NON,
				backgroundColor: "#cc1b25",
			},
			{
				text: "NSP",
				values: NSP,
				backgroundColor: "#9a9b9c",
			}
		]
	};

	zingchart.render({
		id: 'questionnary',
		data: askConfig,
		height: 450,
		width: 500
	});
</script>