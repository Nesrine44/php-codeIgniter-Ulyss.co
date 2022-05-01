<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 21/09/2018
 * Time: 13:47
 */
/* @var $BusinessUser BusinessUser */ ?>
<div class="modal fade ent_mod" id="usersModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <ul class="nav nav-tabs" id="tabContent">
                <li class="active"><a href="#visitTab" data-toggle="tab">Visiteurs</a></li>
                <li><a class="candidatTab" href="#candidatTab" data-toggle="tab">Candidats</a></li>
            </ul>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="tab-content">
                <div class="tab-pane active" id="visitTab">
                    <div class="row up">
                        <div class="col-md-4 nopad" id="visitDpt"></div>
                        <div class="col-md-4 nopad" id="visitAge"></div>
                        <div class="col-md-4 nopad" id="visitEtud"></div>
                    </div>
                    <div class="row down">
                        <div class="col-md-6" id="visitUniq"></div>
                        <div class="col-md-6" id="visitGeo"></div>
                    </div>
                </div>
                <div class="tab-pane " id="candidatTab">
                    <div class="row up">
                        <div class="col-md-4 nopad" id="candGeo"></div>
                        <div class="col-md-4 nopad" id="candidDpt"></div>
                        <div class="col-md-4 nopad" id="candEtud"></div>
                    </div>
                    <div class="row down">
                        <div class="col-md-6" id="originCand"></div>
                        <div class="col-md-6" id="otherCompanies"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- STATS VISIT -->
<script>
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
    /* Fetch result set from t_test table */
    $visitXp = mysqli_query($mysqli,
        "SELECT IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) as totalMois FROM `talent_experience` INNER JOIN entreprise_vues ON talent_experience.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id = 3 GROUP by entreprise_vues.talent_id HAVING IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) < 1");
    $visitXp1 = mysqli_query($mysqli,
        "SELECT IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) as totalMois FROM `talent_experience` INNER JOIN entreprise_vues ON talent_experience.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id = 3 GROUP by entreprise_vues.talent_id HAVING IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) >= 1 AND IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) <3");
    $visitXp2 = mysqli_query($mysqli,
        "SELECT IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) as totalMois FROM `talent_experience` INNER JOIN entreprise_vues ON talent_experience.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id = 3 GROUP by entreprise_vues.talent_id HAVING IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) >= 3 AND IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) <=6");
    $visitXp3 = mysqli_query($mysqli,
        "SELECT IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) as totalMois FROM `talent_experience` INNER JOIN entreprise_vues ON talent_experience.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id = 3 GROUP by entreprise_vues.talent_id HAVING IF(MAX(date_fin='9999-12-31'), TIMESTAMPDIFF(year, MIN(date_debut), CURRENT_DATE), TIMESTAMPDIFF(year, MIN(date_debut), MAX(date_fin))) >6");

    $visitDept = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM `talent_experience` WHERE `entreprise_id`= '$ent' group by `date_debut`<='2018-06-01 00:00:00'");
    ?>

	var myVisitXp  = [<?php
        $info = mysqli_num_rows($visitXp);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var myVisitXp1 = [<?php
        $info = mysqli_num_rows($visitXp1);
        echo $info;/* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var myVisitXp2 = [<?php
        $info = mysqli_num_rows($visitXp2);
        echo $info;/* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var myVisitXp3 = [<?php
        $info = mysqli_num_rows($visitXp3);
        echo $info;/* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];


	var visitXP = {
		type: "ring",
		legend: {
			verticalAlign: 'middle',
			toggleAction: 'remove',
			marginRight: 0,
			width: 90,
			alpha: 0.1,
			borderWidth: 0,
			highlightPlot: true,
			marker: {
				type: 'circle',
				cursor: 'pointer',
				borderWidth: 0,
				size: 5
			},
			item: {
				fontColor: "#373a3c",
				fontSize: 10
			}
		},
		title: {
			text: "REPARTITION VISITEURS PAR ANNEES D'EXP.",
			fontSize: '11',
			fontFamily: "Lato",
		},
		plot: {
			slice: '65%',
			borderColor: "#00b3ee36",
			tooltip: {
				fontFamily: "Lato",
				text: "%v"
			},
			valueBox: {
				fontSize: '10',
				fontFamily: "Lato",
				rules: [
					{
						rule: "%npv < 1",
						visible: false,
					}
				]
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		series: [
			{
				values: myVisitXp,
				text: "-1",
				backgroundColor: "#6FB07F",
				marker: {
					backgroundColor: '#6FB07F'
				}
			},
			{values: myVisitXp1, text: "1 de 3 ans", backgroundColor: "#32a0cc", fontSize: 12,},
			{values: myVisitXp2, text: "3 à 6 ans", backgroundColor: "#e86683"},
			{values: myVisitXp3, text: "+ 6 ans", backgroundColor: "#e0c843"},

		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: "visitXp",
			width: 262,
			height: 269,
			data: visitXP,
		});
	})

</script>

<script>
	// Visiteurs par départements
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
    $deptVisit = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrVisiteur, categorie_groupe.nom FROM entreprise_vues INNER JOIN talent ON entreprise_vues.talent_id=talent.id INNER JOIN user_linkedin ON talent.user_id=user_linkedin.id_user INNER JOIN categorie_groupe ON user_linkedin.departement_id=categorie_groupe.id WHERE entreprise_vues.entreprise_id=1881  GROUP BY categorie_groupe.nom");
    $nomDeptVisit = mysqli_query($mysqli,
        "SELECT COUNT(*), categorie_groupe.nom as dept FROM entreprise_vues INNER JOIN talent ON entreprise_vues.talent_id=talent.id INNER JOIN user_linkedin ON talent.user_id=user_linkedin.id_user INNER JOIN categorie_groupe ON user_linkedin.departement_id=categorie_groupe.id WHERE entreprise_vues.entreprise_id=1881  GROUP BY categorie_groupe.nom");
    ?>
	var nbrDeptVisit = [<?php
        $info = mysqli_num_rows($deptVisit);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var deptVisit    = [<?php
        while ($info = mysqli_fetch_array($nomDeptVisit)) {
            echo '"' . $info['dept'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var visiteurDept = {
		type: "ring",
		title: {
			text: "REPARTITION VISITEURS PAR DEPT.",
			fontSize: '13',
			fontFamily: "Lato",
		},
		plot: {
			slice: '60%',
			borderColor: "#00b3ee36",
			tooltip: {
				fontFamily: "Lato",
				text: "%v %t"
			},
			valueBox: {
				fontSize: '10',
				fontFamily: "Lato",
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		series: [
			{
				values: [nbrDeptVisit[0]],
				text: [deptVisit[0]],
				backgroundColor: "#6FB07F",
			},
			{values: [nbrDeptVisit[1]], text: [deptVisit[1]], backgroundColor: "#32a0cc"},
			{values: [nbrDeptVisit[2]], text: [deptVisit[2]], backgroundColor: "#e86683"},
			{values: [nbrDeptVisit[3]], text: [deptVisit[3]], backgroundColor: "#e0c843"},

		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: "visitDpt",
			width: 350,
			height: 269,
			data: visiteurDept,
		});
	});

	// ***************** Candidats par dept.
    <?php
    $deptCand = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrVisit, nom FROM talent_experience INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id INNER JOIN offre_candidat ON talent_experience.talent_id = offre_candidat.talent_id WHERE date_fin= '9999-12-31' AND talent_experience.entreprise_id=3 group by departement_id");
    $nomDeptCand = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrVisit, nom FROM talent_experience INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id INNER JOIN offre_candidat ON talent_experience.talent_id = offre_candidat.talent_id WHERE date_fin= '9999-12-31' AND talent_experience.entreprise_id=3 group by departement_id");

    ?>
	var nbrDeptCand = [<?php
        while ($info = mysqli_fetch_array($deptCand)) {
            echo $info['nbrVisit'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomDeptCand = [<?php
        while ($info = mysqli_fetch_array($nomDeptCand)) {
            echo '"' . $info['nom'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var candidDept  = {
		type: "ring",
		title: {
			text: "REPARTITION CANDIDATS PAR DEPT.",
			align: "center",
			offsetX: 3,
			fontFamily: "Lato",
			fontSize: 13
		},
		plot: {
			slice: '60%',
			tooltip: {
				fontSize: '10',
				fontFamily: "Lato",
				padding: "5 10",
				text: "%v %t"
			},
			valueBox: {
				placement: 'in',
				text: '%npv%',
				fontSize: '10',
				fontFamily: "Lato"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		series: [
			{
				values: [nbrDeptCand[0]],
				text: [nomDeptCand[0]],
				backgroundColor: "#6FB07F",
				marker: {
					backgroundColor: '#6FB07F'
				}
			},
			{values: [nbrDeptCand[1]], text: [nomDeptCand[1]], backgroundColor: "#32a0cc", fontSize: 12,},
			{values: [nbrDeptCand[2]], text: [nomDeptCand[2]], backgroundColor: "#e86683"},
			{values: [nbrDeptCand[3]], text: [nomDeptCand[3]], backgroundColor: "#e0c843"},

		]
	};
	$('.candidatTab').click(function () {
		zingchart.render({
			id: "candidDpt",
			width: 350,
			height: 269,
			data: candidDept,
		});
	});


	///////////// Entreprise des candidats \\\\\\\\\\\\\\
    <?php
    $entCandidat = mysqli_query($mysqli,
        "SELECT COUNT(*)as totalent, entreprise.nom as nomEnt FROM `talent_experience` INNER JOIN entreprise ON talent_experience.entreprise_id= entreprise.id INNER JOIN (SELECT * FROM offre_candidat GROUP BY talent_id) offre_candidat on talent_experience.talent_id = offre_candidat.talent_id INNER JOIN offre_emplois ON offre_candidat.offre_id = offre_emplois.id WHERE date_fin = '9999-12-31' AND offre_emplois.entreprise_id = 3 GROUP by talent_experience.entreprise_id");
    $nomEntCandidat = mysqli_query($mysqli,
        "SELECT COUNT(*)as totalent, entreprise.nom as nomEnt FROM `talent_experience` INNER JOIN entreprise ON talent_experience.entreprise_id= entreprise.id INNER JOIN (SELECT * FROM offre_candidat GROUP BY talent_id) offre_candidat on talent_experience.talent_id = offre_candidat.talent_id INNER JOIN offre_emplois ON offre_candidat.offre_id = offre_emplois.id WHERE date_fin = '9999-12-31' AND offre_emplois.entreprise_id = 3 GROUP by talent_experience.entreprise_id");
    ?>
	var entNbrCand = [<?php
        while ($info = mysqli_fetch_array($entCandidat)) {
            echo $info['totalent'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomEntCand = [<?php
        while ($info = mysqli_fetch_array($nomEntCandidat)) {
            echo '"' . $info['nomEnt'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var candEnt    = {
		type: "bar",
		title: {
			text: "ENTREPRISE DES CANDIDATS",
			align: "left",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 16
		},
		scaleX: {
			values: nomEntCand,
			item: {
				fontSize: 10,
				fontAngle: -45
			}
		},
		plot: {
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		series: [
			{
				values: entNbrCand
			},
		]
	};
	$('.candidatTab').click(function () {
		zingchart.render({
			id: 'originCand',
			data: candEnt,
			height: 462,
			width: 550,
		});
	});

	// Entreprises qui intérèsse les candidats
    <?php
    $entIntCandidat = mysqli_query($mysqli,
        "SELECT COUNT(entreprise.nom) as nomEnt, nom FROM `entreprise_vues` INNER JOIN (SELECT * FROM offre_candidat GROUP BY talent_id) offre_candidat ON entreprise_vues.talent_id = offre_candidat.talent_id INNER JOIN entreprise ON entreprise_vues.entreprise_id = entreprise.id GROUP BY entreprise.nom");
    $entIntNom = mysqli_query($mysqli,
        "SELECT COUNT(entreprise.nom) as nomEnt, nom FROM `entreprise_vues` INNER JOIN (SELECT * FROM offre_candidat GROUP BY talent_id) offre_candidat ON entreprise_vues.talent_id = offre_candidat.talent_id INNER JOIN entreprise ON entreprise_vues.entreprise_id = entreprise.id GROUP BY entreprise.nom");
    ?>
	var nbrIntCand   = [<?php
        while ($info = mysqli_fetch_array($entIntCandidat)) {
            echo $info['nomEnt'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomEntInt    = [<?php
        while ($info = mysqli_fetch_array($entIntNom)) {
            echo '"' . $info['nom'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var candInterest = {
		type: "bar",
		title: {
			text: 'LES CANDIDATS S\'INTERESSENT AUSSI A CES ENTREPRISES',
			align: "left",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 16
		},
		plot: {
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		scaleX: {
			values: nomEntInt,
			item: {
				fontAngle: -45,
				fontSize: 10,
			},

		},
		series: [
			{
				values: nbrIntCand,
				rules: [
					{
						rule: "%v >= 30",
						backgroundColor: '#6de06e'
					},
					{
						rule: "%v >= 10 && %v < 30",
						backgroundColor: '#dde050'
					},
					{
						rule: "%v >= 5 && < 10",
						backgroundColor: '#92d6ff'
					},
					{
						rule: "%v < 5",
						backgroundColor: '#e83827'
					}
				]
			},
		]
	};
	$('.candidatTab').click(function () {
		zingchart.render({
			id: 'otherCompanies',
			data: candInterest,
			height: 462,
			width: 550,
		});
	});
</script>
<!-- 	//STAT Ent/Vis //////////// -->
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
    $entIntVisit = mysqli_query($mysqli,
        "SELECT COUNT(nom) as nbr, nom FROM entreprise INNER JOIN entreprise_recherche on entreprise.id = entreprise_recherche.entreprise_id UNION SELECT COUNT(nom) as nbr, nom from entreprise INNER JOIN entreprise_vues on entreprise.id = entreprise_vues.entreprise_id UNION SELECT COUNT(entreprise.nom) as nbr, nom FROM `talent_vues` INNER JOIN talent_experience on talent_vues.talent_id = talent_experience.talent_id INNER JOIN entreprise ON talent_experience.entreprise_id = entreprise.id WHERE talent_experience.date_fin = '9999-12-31' GROUP BY entreprise.nom ORDER BY nbr DESC LIMIT 5");
    $nbrIntVisit = mysqli_query($mysqli,
        "SELECT COUNT(nom) as nbr, nom FROM entreprise INNER JOIN entreprise_recherche on entreprise.id = entreprise_recherche.entreprise_id UNION SELECT COUNT(nom) as nbr, nom from entreprise INNER JOIN entreprise_vues on entreprise.id = entreprise_vues.entreprise_id UNION SELECT COUNT(entreprise.nom) as nbr, nom FROM `talent_vues` INNER JOIN talent_experience on talent_vues.talent_id = talent_experience.talent_id INNER JOIN entreprise ON talent_experience.entreprise_id = entreprise.id WHERE talent_experience.date_fin = '9999-12-31' GROUP BY entreprise.nom ORDER BY nbr DESC LIMIT 5");
    ?>
	var EntIntVisit = [ <?php
        while ($info = mysqli_fetch_array($entIntVisit)) {
            echo '"' . $info['nom'] . '",';
            /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        }
        ?>];
	var nbrIntVisit = [ <?php
        while ($info = mysqli_fetch_array($nbrIntVisit)) {
            echo $info['nbr'] . ',';
            /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        }
        ?>];
	var visitEntInt = {
		type: "bar",
		title: {
			text: 'LES VISITEURS S\'INTERESSENT AUSSI A CES ENTREPRISES',
			align: "left",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 16
		},
		plot: {
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		scaleX: {
			values: EntIntVisit,
			item: {
				fontAngle: -45,
				fontSize: 10,
			},

		},
		series: [
			{
				values: nbrIntVisit,
				rules: [
					{
						rule: "%v >= 30",
						backgroundColor: '#6de06e'
					},
					{
						rule: "%v >= 10 && %v < 30",
						backgroundColor: '#dde050'
					},
					{
						rule: "%v >= 5 && < 10",
						backgroundColor: '#92d6ff'
					},
					{
						rule: "%v < 5",
						backgroundColor: '#e83827'
					}
				]
			},
		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: 'visitUniq',
			data: visitEntInt,
			height: 462,
			width: 550,
		});
	});
	//**************** MOYENNE D'AGE ************//
	var ageVisit = {
		type: "pie",
		scale: {
			sizeFactor: '0.9'
		},
		legend: {
			shared: true,
			toggleAction: 'remove',
			backgroundColor: '#FBFCFE',
			borderWidth: 0,
			align: 'right',
			verticalAlign: 'middle',
			marker: {
				type: 'circle',
				cursor: 'pointer',
				borderWidth: 0,
				size: 5
			},
			item: {
				fontColor: "#777",
				cursor: 'pointer',
				offsetX: -6,
				fontSize: 10,
				marginLeft: 0
			},
			mediaRules: [
				{
					maxWidth: 100,
					visible: true
				}
			]
		},
		plot: {
			borderWidth: 1,
			// slice: 90,
			valueBox: {
				placement: 'in',
				text: '%npv%',
				fontSize: '10',
				fontFamily: "Lato"
			},
			tooltip: {
				fontSize: '10',
				fontFamily: "Lato",
				padding: "5 10",
				text: "%npv%"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		title: {
			text: 'VISITEURS PAR TRANCHE D\'AGE',
			fontFamily: "Lato",
			fontSize: 13
		},
		series: [
			{
				values: [],
				text: "18 - 25",
				backgroundColor: '#50ADF5',
			},
			{
				values: [1],
				text: "25 - 30",
				backgroundColor: '#FF7965'
			},
			{
				values: [],
				text: '30 - 35',
				backgroundColor: '#FFCB45'
			},
			{
				text: '35 - 40',
				values: [],
				backgroundColor: '#6877e5'
			},
			{
				text: '40 - 50',
				values: [],
				backgroundColor: '#6FB07F'
			},
			{
				text: '+ 50',
				values: [],
				backgroundColor: '#b250d5'
			}
		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: 'visitAge',
			data: ageVisit,
			height: 269,
			width: 350
		});
	});

</script>
<!-- CANDIDATS GEO -->
<script>
    <?php
    $mysqli = new mysqli("localhost", "root", "", "ulyss");
    $mysqli->query("SET lc_time_names = 'fr_FR'");
    $CandGeo = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrCand, region FROM offre_candidat INNER JOIN offre_emplois ON offre_candidat.offre_id = offre_emplois.id WHERE offre_emplois.entreprise_id= $ent AND region is not null GROUP BY region");
    $nomCandReg = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrCand, region FROM offre_candidat INNER JOIN offre_emplois ON offre_candidat.offre_id = offre_emplois.id WHERE offre_emplois.entreprise_id= $ent AND region is not null GROUP BY region");
    ?>
	var candNbrRegion = [<?php
        while ($info = mysqli_fetch_array($CandGeo)) {
            echo $info['nbrCand'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomCandRegion = [<?php
        while ($info = mysqli_fetch_array($nomCandReg)) {
            echo '"' . $info['region'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var candGeo       = {
		type: "hbar",
		title: {
			fontColor: "#000000",
			text: 'CANDIDATS PAR REGIONS',
			align: "center",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 13
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

		plotarea: {
			margin: "50 40 60 80"
		},
		plot: {
			borderRadius: "0 0 0 0",
			hightlightMarker: {
				backgroundColor: "red"
			},
			highlightState: {
				backgroundColor: "red"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		scaleX: {
			labels: nomCandRegion,
			item: {
				fontFamily: "Lato",
				fontSize: 12
			},
			lineColor: "#DDD",
			tick: {
				visible: false
			}
		},
		scaleY: {
			label: {
				offsetY: 5,
				text: "Nombre de candidats",
				fontColor: "#777",
				fontSize: 12,
				fontFamily: "Lato",
			},
			item: {
				// fontColor: "#fff",
				fontFamily: "Lato",
				fontSize: 10
			},
			lineWidth: 0,
			tick: {
				visible: false
			},
			guide: {
				lineStyle: "solid",
				lineColor: "#DDD"
			},
			values: "0:10:1"
		},
		series: [
			{
				values: candNbrRegion,
				backgroundColor: "#d6d6d6",
				rules: [
					{rule: '%i==0', backgroundColor: '#f98377'},
					{rule: '%i==1', backgroundColor: '#fbd972'},
					{rule: '%i==2', backgroundColor: '#78e5d2'},
					{rule: '%i==3', backgroundColor: '#7ad8e5'},
					{rule: '%i==4', backgroundColor: '#d2f27c'},
					{rule: '%i==5', backgroundColor: '#e572ec'},
				]
			},
		]
	};
	$('.candidatTab').click(function () {
		zingchart.render({
			id: 'candGeo',
			width: 350,
			height: 269,
			data: candGeo,
		});
	});
</script>


<!-- Visiteurs Regions & Etudes -->
<script>
    <?php
    $mysqli = new mysqli("localhost", "root", "", "ulyss");
    $mysqli->query("SET lc_time_names = 'fr_FR'");
    $visitGeo = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrVisi, region FROM `entreprise_vues` WHERE entreprise_id= '$ent' AND region is not null GROUP BY region");
    $nomReg = mysqli_query($mysqli,
        "SELECT COUNT(*) as nbrVisi, region FROM `entreprise_vues` WHERE entreprise_id= '$ent' AND region is not null GROUP BY region");

    ?>
	var visiNbrRegion = [<?php
        while ($info = mysqli_fetch_array($visitGeo)) {
            echo $info['nbrVisi'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomRegion     = [<?php
        while ($info = mysqli_fetch_array($nomReg)) {
            echo '"' . $info['region'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var visitGeo      = {
		type: "hbar",
		title: {
			fontColor: "#000000",
			text: 'VISITEURS PAR REGIONS',
			align: "center",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 15
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

		plotarea: {
			margin: "50 10 60 100"
		},
		plot: {
			borderRadius: "0 0 0 0",
			hightlightMarker: {
				backgroundColor: "red"
			},
			highlightState: {
				backgroundColor: "red"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			}
		},
		scaleX: {
			labels: nomRegion,
			item: {
				fontFamily: "Lato",
				fontSize: 10
			},
			lineColor: "#DDD",
			tick: {
				visible: false
			}
		},
		scaleY: {
			label: {
				offsetY: 5,
				text: "Nombre de candidats",
				fontColor: "#777",
				fontSize: 12,
				fontFamily: "Lato",
			},
			item: {
				// fontColor: "#fff",
				fontFamily: "Lato",
				fontSize: 10
			},
			lineWidth: 0,
			tick: {
				visible: false
			},
			guide: {
				lineStyle: "solid",
				lineColor: "#DDD"
			},
			//values: "0:100:5"
		},
		series: [
			{
				values: visiNbrRegion,
				backgroundColor: "#d6d6d6",
				rules: [
					{rule: '%i==0', backgroundColor: '#f98377'},
					{rule: '%i==1', backgroundColor: '#fbd972'},
					{rule: '%i==2', backgroundColor: '#cc1b25'},
					{rule: '%i==3', backgroundColor: '#7ad8e5'},
					{rule: '%i==4', backgroundColor: '#d2f27c'},
					{rule: '%i==5', backgroundColor: '#e572ec'},
				]
			},
		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: 'visitGeo',
			width: 460,
			height: 450,
			data: visitGeo,
		});
	});
</script>
<!-- ETUDES -->
<script>
	//**************** Visiteurs ANNEES D'ETUDES ************//
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
    $nbrAnneesEtud = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `entreprise_vues` GROUP BY `talent_id`) entreprise_vues ON talent_formation.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id='3' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) <=2 ");
    $nbrAnneesEtud1 = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `entreprise_vues` GROUP BY `talent_id`) entreprise_vues ON talent_formation.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id='3' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) > 2 AND SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) <= 5");
    $nbrAnneesEtud2 = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `entreprise_vues` GROUP BY `talent_id`) entreprise_vues ON talent_formation.talent_id = entreprise_vues.talent_id WHERE entreprise_vues.entreprise_id='$ent' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) > 5");
    ?>
	var etudVisit  = [<?php
        $info = mysqli_num_rows($nbrAnneesEtud);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var etudVisit1 = [<?php
        $info = mysqli_num_rows($nbrAnneesEtud1);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var etudVisit2 = [<?php
        $info = mysqli_num_rows($nbrAnneesEtud2);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var visitEtude = {
		type: "ring",
		scale: {
			sizeFactor: '0.9'
		},
		legend: {
			shared: true,
			toggleAction: 'remove',
			backgroundColor: '#FBFCFE',
			borderWidth: 0,
			align: 'right',
			verticalAlign: 'middle',
			marker: {
				type: 'circle',
				cursor: 'pointer',
				borderWidth: 0,
				size: 5
			},
			item: {
				fontColor: "#777",
				cursor: 'pointer',
				offsetX: -6,
				fontSize: 10,
				marginLeft: 0
			},
			mediaRules: [
				{
					maxWidth: 100,
					visible: true
				}
			]
		},
		plot: {
			slice: '60%',
			valueBox: {
				placement: 'in',
				text: '%npv%',
				fontSize: '10',
				fontFamily: "Lato",
				rules: [
					{
						rule: "%npv < 1",
						visible: false,
					}
				]
			},
			tooltip: {
				fontSize: '10',
				fontFamily: "Lato",
				padding: "5 10",
				text: "%v visiteurs"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		title: {
			text: 'VISITEURS PAR NIVEAU D\'ETUDES',
			fontFamily: "Lato",
			fontSize: 13
		},
		series: [
			{
				values: etudVisit,
				text: "0 - 2",
				backgroundColor: '#FF7965',
			},
			{
				values: etudVisit1,
				text: "3 - 5",
				backgroundColor: '#8cd5d5'
			},
			{
				values: etudVisit2,
				text: '+ 5',
				backgroundColor: '#3cd572'
			},
		]
	};
	$('.usersModal').click(function () {
		zingchart.render({
			id: 'visitEtud',
			data: visitEtude,
			height: 260,
			width: 350
		});
	});


	//**************** CANDIDATS ANNEES D'ETUDES ************//
    <?php
    /* Fetch result set from t_test table */
    $candAnneesEtud = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `offre_candidat` GROUP by talent_id) offre_candidat ON talent_formation.talent_id = offre_candidat.talent_id INNER JOIN offre_emplois ON offre_candidat.offre_id=offre_emplois.id WHERE offre_emplois.entreprise_id='$ent' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) <= 2");
    $candAnneesEtud1 = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `offre_candidat` GROUP by talent_id) offre_candidat ON talent_formation.talent_id = offre_candidat.talent_id INNER JOIN offre_emplois ON offre_candidat.offre_id=offre_emplois.id WHERE offre_emplois.entreprise_id='$ent' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) > 2 AND SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) <=5");
    $candAnneesEtud2 = mysqli_query($mysqli,
        "SELECT SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) as anneesTotal, talent_formation.talent_id FROM `talent_formation` INNER JOIN (SELECT * FROM `offre_candidat` GROUP by talent_id) offre_candidat ON talent_formation.talent_id = offre_candidat.talent_id INNER JOIN offre_emplois ON offre_candidat.offre_id=offre_emplois.id WHERE offre_emplois.entreprise_id='$ent' GROUP BY talent_formation.talent_id HAVING SUM(TIMESTAMPDIFF(year, date_debut, date_fin)) > 5");
    ?>
	var etudCand  = [<?php
        $info = mysqli_num_rows($candAnneesEtud);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var etudCand1 = [<?php
        $info = mysqli_num_rows($candAnneesEtud1);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var etudCand2 = [<?php
        $info = mysqli_num_rows($candAnneesEtud2);
        echo $info;
        /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var candEtude = {
		type: "ring",
		scale: {
			sizeFactor: '0.9'
		},
		legend: {
			shared: true,
			toggleAction: 'remove',
			backgroundColor: '#FBFCFE',
			borderWidth: 0,
			align: 'right',
			verticalAlign: 'middle',
			marker: {
				type: 'circle',
				cursor: 'pointer',
				borderWidth: 0,
				size: 5
			},
			item: {
				fontColor: "#777",
				cursor: 'pointer',
				offsetX: -6,
				fontSize: 10,
				marginLeft: 0
			},
			mediaRules: [
				{
					maxWidth: 100,
					visible: true
				}
			]
		},
		plot: {
			borderWidth: 1,
			slice: '60%',
			valueBox: {
				placement: 'in',
				text: '%npv%',
				fontSize: '10',
				fontFamily: "Lato",
				rules: [
					{
						rule: "%npv < 1",
						visible: false,
					}
				]
			},
			tooltip: {
				fontSize: '10',
				fontFamily: "Lato",
				padding: "5 10",
				text: "%v candidat(s)"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		title: {
			text: 'CANDIDATS PAR NIVEAU D\'ETUDES',
			align: "center",
			fontFamily: "Lato",
			fontSize: 13
		},
		series: [
			{
				values: 0,
				text: "0 - 2 ans",
				backgroundColor: '#FF7965',
			},
			{
				values: 0,
				text: "3 - 5 ans",
				backgroundColor: '#8cd5d5'
			},
			{
				values: 0,
				text: '+5',
				backgroundColor: '#3cd572'
			}
		]
	};
	$('.candidatTab').click(function () {
		zingchart.render({
			id: 'candEtud',
			data: candEtude,
			height: 269,
			width: 350
		});
	});
</script>