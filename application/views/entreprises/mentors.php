<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 26/09/2018
 * Time: 14:10
 */ ?>
<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
	ZC.LICENSE                = ["af485f0913f1881b4e691786587ad569", "323c7c56ecc88dcf2bceddeeec460766"];</script>
<div class="modal fade ent_mod" id="mentorsModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <ul class="nav nav-tabs" id="tabContent">
                <li class="active"><a href="#mentorsTab" data-toggle="tab">Mentors dont Ambassadeurs</a></li>
                <li class="mentorsAmbasTab"><a href="#mentorsAmbasTab" data-toggle="tab">Ambassadeurs</a></li>
            </ul>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="tab-content">
                <div class="tab-pane active" id="mentorsTab">
                    <div class="row up">
                        <div class="col-md-3 col-lg-3 nbMentor"><h4>MENTORS <a class="bulleInfo">i<span>Salariés dans l'entreprise</span></a></h4>
                            <div> <?php echo $BusinessEntreprise->getNbrMentor() ?>
                                <img src="/assets/img/icons/team.png" alt="mentors"></div>
                            <p class="last">Last : <?php echo $BusinessStat->getLastNbrMentorsEnt() ?> </p>
                            <p>Dont <?php echo $BusinessStat->getNbrAmbassadeurEnt() ?> Ambassadeur(s)</p>
                        </div>
                        <div class="col-md-3 nopad" id="MentDept">
                        </div>
                        <div class="col-md-3 nopad" id="myChart"></div>
                        <div class="col-md-3 nbMentor"><h4>MENTORS <span style="font-size: 12px">(Anciens salariés)</span></h4>
                            <div> <?php echo $BusinessStat->getAncienNbrMentorsEnt() ?>
                                <img src="/assets/img/icons/team.png" alt="mentors"></div>
                            <p class="last">Last : <?php echo $BusinessStat->getLastAncienNbrMentorsEnt() ?></p>
                        </div>
                    </div>
                    <div class="row down">
                        <div class="col-md-6" id="vuesMentorsAmb">
                        </div>
                        <select id="stat_rdv">
                            <option value="rdv">Générale</option>
                            <option value="realises">Réalisés</option>
                            <option value="attente">En-attente</option>
                            <option value="annules">Annulés</option>
                        </select>
                        <div class="rdv" id="rdv">
                        </div>
                        <div class="rdv" id="realises" style="display: none;">
                        </div>
                        <div class="rdv" id="attente" style="display: none;">
                        </div>
                        <div class="rdv" id="annules" style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="mentorsAmbasTab">
                    <div class="row up">
                        <div class="col-md-3 col-lg-3 nbMentor"><h4>AMBASSADEURS</h4>
                            <div> <?php echo $BusinessEntreprise->getNbrAmbassador() ?>
                                <img src="/assets/img/icons/team.png" alt="mentors"></div>
                            <p class="last">Last : <?php echo $BusinessStat->getLastNbrAmbassadeurEnt() ?></p>
                        </div>
                        <div class="col-md-3 nopad" id="AmbDept">
                        </div>
                        <div class="col-md-3 nopad" id="AncAmb"></div>
                        <div class="col-md-3 nbMentor"><h4>AMBASSADEURS</h4>
                            <div> <?php echo $BusinessStat->getNbrAmbassadeurEnt() ?>
                                <img src="/assets/img/icons/team.png" alt="mentors"></div>
                            <p class="last">Last : <?php echo $BusinessStat->getLastNbrAmbassadeurEnt() ?></p>
                        </div>
                    </div>
                    <div class="row down">
                        <div class="col-md-6" id="vuesAmbass">
                        </div>
                        <div class="col-md-6" id="rdvAvecAmbass">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(function () {
		$('#stat_rdv').change(function () {
			$('.rdv').hide();
			$('#' + $(this).val()).show();
		});
	});
</script>
<!-- STATS MENTORS/Dept + Ancienneté-->
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
    $data = mysqli_query($mysqli,
        "SELECT COUNT(*) as total, nom FROM `talent_experience` INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id WHERE `entreprise_id`= '$ent' AND date_fin = '9999-12-31' group by departement_id");
    $nomDept = mysqli_query($mysqli,
        "SELECT COUNT(*) as total, nom FROM `talent_experience` INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id WHERE `entreprise_id`= '$ent' AND date_fin = '9999-12-31' group by departement_id");

    $nbrMentor = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM `talent_experience` WHERE `entreprise_id`= '$ent' group by `date_debut`<='2018-06-01 00:00:00'");
    ?>

	var dptMentor  = [<?php
        while ($info = mysqli_fetch_array($data)) {
            echo $info['total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomDpt     = [<?php
        while ($info = mysqli_fetch_array($nomDept, MYSQLI_BOTH)) {
            echo '"' . $info['nom'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nbrmentors = [<?php
        while ($info = mysqli_fetch_array($nbrMentor)) {
            echo $info['total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var MentDept = {
		type: "ring",
		title: {
			text: "MENTORS PAR DEPT.",
			align: "center",
			fontSize: '18',
			fontFamily: "Lato",
			offsetX: 10,
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
				effect: 3,
				method: 5,
				speed: 500,
				sequence: 1
			},
		},
		series: [
			{
				values: [dptMentor[0]],
				text: [nomDpt[0]],
				backgroundColor: "#6FB07F",
			},
			{values: [dptMentor[1]], text: [nomDpt[1]], backgroundColor: "#32a0cc"},
			{values: [dptMentor[2]], text: [nomDpt[2]], backgroundColor: "#e86683"},
			{values: [dptMentor[3]], text: [nomDpt[3]], backgroundColor: "#fbd856"},

		]
	};
	$('.mentorsModal').click(function () {
		zingchart.render({
			id: "MentDept",
			width: 262,
			height: 270,
			data: MentDept,
		});
	});
    <?php
    /* Close the connection */
    $mysqli->close();
    ?>
</script>


<script>
	//MENTORS PAR ANCIENNETE
    <?php
    /* Open connection to "ulyss" MySQL database. */
    $mysqli = new mysqli("localhost", "root", "", "ulyss");
    $mysqli->query("SET lc_time_names = 'fr_FR'");

    /* Check the connection. */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $Anciennete0 = mysqli_query($mysqli,
        "SELECT COUNT(TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE)) as df, talent_id FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31' AND status=1 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) <1");
    $Anciennete1 = mysqli_query($mysqli,
        "SELECT COUNT(TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE)) as df, talent_id FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31' AND status=1 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) >=1 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) <3");
    $Anciennete2 = mysqli_query($mysqli,
        "SELECT COUNT(TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE)) as df, talent_id FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31' AND status=1 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) >=3 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) <6");
    $Anciennete3 = mysqli_query($mysqli,
        "SELECT COUNT(TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE)) as df, talent_id FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31' AND status=1 AND TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) >=6");
    ?>
	var ancien0 = [<?php
        while ($info = mysqli_fetch_array($Anciennete0)) {
            echo $info['df'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var ancien1 = [<?php
        while ($info = mysqli_fetch_array($Anciennete1)) {
            echo $info['df'] . ',';
        }?>];
	var ancien2 = [<?php
        while ($info = mysqli_fetch_array($Anciennete2)) {
            echo $info['df'] . ',';
        }?>];
	var ancien3 = [<?php
        while ($info = mysqli_fetch_array($Anciennete3)) {
            echo $info['df'] . ',';
        }?>];
	var myConf  = {
		type: "pie",
		plot: {
			slice: 60,
			valueBox: {
				text: "%t",
				fontSize: 10,
				fontFamily: "Lato",
				fontWeight: "normal",
				fontColor: '#fff',
				rules: [
					{
						rule: "%v < 1",
						placement: "center",
						fontColor: "#fff",
					},
					{
						rule: "%v > 5",
						placement: "in",
						fontColor: "#fff",
					},
					{
						rule: "%v >=1 && %v <= 5",
						placement: "in",
						fontColor: "#fff",
					}
				]
			},
			tooltip: {
				fontSize: '12',
				fontFamily: "Lato",
				text: "%v mentors"
			},
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		title: {
			text: 'MENTORS PAR ANCIENNETE',
			align: "left",
			offsetX: 10,
			fontFamily: "Lato",
			fontSize: 16
		},
		series: [
			{
				values: ancien0,
				text: "- 1 an",
				backgroundColor: '#e86683',
			},
			{
				values: ancien1,
				text: "1 - 3 ans",
				backgroundColor: '#32a0cc',
			},
			{
				values: ancien2,
				text: "3 - 6 ans",
				backgroundColor: '#6FB07F',
			},
			{
				values: ancien3,
				text: "+ 6 ans",
				backgroundColor: '#e8b64f',
			},
		]
	};
	$('.mentorsModal').click(function () {
		zingchart.render({
			id: 'myChart',
			data: myConf,
			height: 262,
			width: 270
		});
	});

	//*************** Rdv Mentors dont Ambassadeurs **************//
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
    $rejete = "rejeté";
    /* Fetch result set from t_test table */
    $rdvTotaux = mysqli_query($mysqli,
        "SELECT MONTH(date_livraison) as mois, COUNT(*) as rdv_total FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_livraison)");
    $rdvTotauxMois = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_livraison) as mois, COUNT(*) as rdv_total FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_livraison)");
    $rdvAmb = mysqli_query($mysqli,
        "SELECT MONTH(date_livraison) as mois, COUNT(*) as rdv_total FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id INNER JOIN mentor_ambassadeur ON talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_livraison)");
    $rdvAmbMois = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_livraison) as mois, COUNT(*) as rdv_total FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id INNER JOIN mentor_ambassadeur ON talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_livraison)");
    ?>
	var rdvAmbass     = [<?php
        while ($info = mysqli_fetch_array($rdvAmb)) {
            echo $info['rdv_total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvAmbMois    = [<?php
        while ($info = mysqli_fetch_array($rdvAmbMois)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvTotaux     = [<?php
        while ($info = mysqli_fetch_array($rdvTotaux)) {
            echo $info['rdv_total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvTotauxMois = [<?php
        while ($info = mysqli_fetch_array($rdvTotauxMois)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdv           = {
		type: "line",
		title: {
			text: 'RENDEZ-VOUS',
			align: "center",
			fontFamily: "Lato",
			fontSize: 16
		},
		legend: {
			align: 'center',
			verticalAlign: 'top',
			backgroundColor: 'none',
			offsetY: 30,
			borderWidth: 0,
			item: {
				fontColor: "#777",
				cursor: 'pointer',
				offsetX: 0,
				fontSize: 10,
				width: 100,
			},
			marker: {
				type: 'circle',
				offsetX: 0,
				borderWidth: 0,
				cursor: 'hand'
			}
		},
		plot: {
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		tooltip: {
			text: "%v Rendez-vous"
		},
		scaleX: {
			labels: rdvTotauxMois
		},
		series: [
			{
				values: rdvTotaux,
				text: 'Rendez-vous (tous)',
				lineColor: '#5fe86b',
				marker: {
					backgroundColor: '#5fe86b'
				}
			},
			{
				values: rdvAmbass,
				text: 'Rendez-vous Ambassadeurs',
				lineColor: '#e83827',
				marker: {
					backgroundColor: '#e83827'
				}
			},
		]
	};
	$('.mentorsModal').click(function () {
		zingchart.render({
			id: 'rdv',
			data: rdv,
			height: 450,
			width: 520,
		});
	});
	//*************** Rdv Ambassadeurs **************//
	var rdvAmb = {
		title: {
			text: 'RENDEZ-VOUS AMBASSADEURS',
			align: "center",
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
		tooltip: {
			text: "%v Rendez-vous Ambassadeurs"
		},
		type: "line",
		scaleX: {
			labels: rdvAmbMois
		},
		series: [
			{values: rdvAmbass},
		]
	};
	$('.mentorsAmbasTab').click(function () {
		zingchart.render({
			id: 'rdvAvecAmbass',
			data: rdvAmb,
			height: 450,
			width: 500,
		});
	});
	//****************** RDV REALISES **********************//
    <?php
    $rdvReal = mysqli_query($mysqli,
        "SELECT MONTH(date_livraison) as mois, COUNT(*) as rdv_valid FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.date_livraison < CURRENT_DATE() AND talent_demandes.status= 'valide' GROUP BY MONTH(date_livraison)");
    $rdvMoisReal = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_livraison) as mois, COUNT(*) as rdv_valid FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.date_livraison < CURRENT_DATE() AND talent_demandes.status= 'valide' GROUP BY MONTH(date_livraison)");
    ?>
	var rdvValid     = [<?php
        while ($info = mysqli_fetch_array($rdvReal)) {
            echo $info['rdv_valid'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvMoisValid = [<?php
        while ($info = mysqli_fetch_array($rdvMoisReal)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var rdvReal = {
		title: {
			text: 'RENDEZ-VOUS REALISES',
			align: "center",
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
		tooltip: {
			text: "%v Rendez-vous réalisés"
		},
		type: "line",
		scaleX: {
			labels: rdvMoisValid
		},
		series: [
			{values: rdvValid},
		]
	};
	$('#stat_rdv').click(function () {
		zingchart.render({
			id: 'realises',
			data: rdvReal,
			height: 450,
			width: 500,
		});
	});


	//****************** RDV EN-ATTENTE **********************//
    <?php
    $rdvAttente = mysqli_query($mysqli,
        "SELECT MONTH(date_livraison) as mois, COUNT(*) as rdv_att FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.status= 'en-attente' GROUP BY MONTH(date_livraison)");
    $rdvMoisAttente = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_livraison) as mois, COUNT(*) as rdv_att FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.status= 'en-attente' GROUP BY MONTH(date_livraison)");
    ?>
	var rdvAttent     = [<?php
        while ($info = mysqli_fetch_array($rdvAttente)) {
            echo $info['rdv_att'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvMoisAttent = [<?php
        while ($info = mysqli_fetch_array($rdvMoisAttente)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var rdvAtt = {
		title: {
			text: 'RENDEZ-VOUS EN ATTENTE',
			align: "center",
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
		tooltip: {
			text: "%v Rendez-vous en attente"
		},
		type: "line",
		scaleX: {
			labels: rdvMoisAttent
		},
		series: [
			{values: rdvAttent},
		]
	};
	$('#stat_rdv').click(function () {
		zingchart.render({
			id: 'attente',
			data: rdvAtt,
			height: 450,
			width: 500,
		});
	});

	//****************** RDV ANNULE **********************//
    <?php
    $rdvAnnule = mysqli_query($mysqli,
        "SELECT MONTH(date_livraison) as mois, COUNT(*) as rdv_annul FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.status= 'rejete' GROUP BY MONTH(date_livraison)");
    $rdvMoisAnnule = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_livraison) as mois, COUNT(*) as rdv_annul FROM `talent_experience` INNER JOIN talent_demandes ON talent_experience.talent_id = talent_demandes.talent_id WHERE entreprise_id = '$ent' AND talent_demandes.status= 'rejete' GROUP BY MONTH(date_livraison)");
    ?>
	var rdvAnnule     = [<?php
        while ($info = mysqli_fetch_array($rdvAnnule)) {
            echo $info['rdv_annul'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var rdvMoisAnnule = [<?php
        while ($info = mysqli_fetch_array($rdvMoisAnnule)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var rdvAnn = {
		title: {
			text: 'RENDEZ-VOUS ANNULES',
			align: "center",
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
		tooltip: {
			text: "%v Rendez-vous annulés"
		},
		type: "line",
		scaleX: {
			labels: rdvMoisAnnule
		},
		series: [
			{values: rdvAnnule},
		]
	};
	$('#stat_rdv').click(function () {
		zingchart.render({
			id: 'annules',
			data: rdvAnn,
			height: 450,
			width: 500,
		});
	});


	//********************** Vues mentors dont Ambass ***********//
    <?php
    /* Open connection to "ulyss" MySQL database. */
    $mysqli = new mysqli("localhost", "root", "", "ulyss");
    $mysqli->query("SET lc_time_names = 'fr_FR'");

    /* Check the connection. */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $vuesMentors = mysqli_query($mysqli,
        "SELECT MONTH(date_creation) as mois, COUNT(*) as total FROM talent_vues INNER JOIN talent_experience ON talent_vues.talent_id = talent_experience.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_creation)");
    $vuesMentorsMois = mysqli_query($mysqli,
        "SELECT MONTHNAME(date_creation) as mois, COUNT(*) as total FROM talent_vues INNER JOIN talent_experience ON talent_vues.talent_id = talent_experience.talent_id WHERE entreprise_id = '$ent' GROUP BY MONTH(date_creation)");
    $vuesAmb = mysqli_query($mysqli,
        "SELECT MONTH(talent_vues.date_creation) as mois, COUNT(*) as total FROM talent_vues INNER JOIN talent_experience ON talent_vues.talent_id = talent_experience.talent_id INNER JOIN mentor_ambassadeur ON talent_vues.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id = '$ent' AND mentor_ambassadeur.id_entreprise = '$ent' GROUP BY MONTH(date_creation) ORDER BY `mois` ASC");
    $vuesMoisAmb = mysqli_query($mysqli,
        "SELECT MONTHNAME(talent_vues.date_creation) as moisAmb, COUNT(*) as total FROM talent_vues INNER JOIN talent_experience ON talent_vues.talent_id = talent_experience.talent_id INNER JOIN mentor_ambassadeur ON talent_vues.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id = '$ent' AND mentor_ambassadeur.id_entreprise = '$ent' GROUP BY MONTH(talent_vues.date_creation)");
    ?>
	var vueMtrs     = [<?php
        while ($info = mysqli_fetch_array($vuesMentors)) {
            echo $info['total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var vueMtrsMois = [<?php
        while ($info = mysqli_fetch_array($vuesMentorsMois)) {
            echo '"' . $info['mois'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var vuesAmb     = [<?php
        while ($info = mysqli_fetch_array($vuesAmb)) {
            echo $info['total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var mySet       = {
		type: "line",
		legend: {
			align: 'center',
			verticalAlign: 'top',
			offsetY: 30,
			backgroundColor: 'none',
			borderWidth: 0,
			item: {
				fontColor: '#777',
				cursor: 'hand'
			},
			marker: {
				type: 'circle',
				borderWidth: 0,
				cursor: 'hand'
			}
		},
		title: {
			text: 'VUES MENTORS DONT AMBASSADEURS',
			align: "center",
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
		tooltip: {
			text: "%v profils vus"
		},
		scaleX: {
			labels: vueMtrsMois
		},
		series: [
			{
				values: vueMtrs,
				text: 'Mentors',
			},
			{
				values: vuesAmb,
				text: 'Ambassadeurs',
			},
		]
	};
	$('.mentorsModal').click(function () {
		zingchart.render({
			id: 'vuesMentorsAmb',
			data: mySet,
			height: 450,
			width: 500,
		});
	});
	//********************** Vues Ambassadeurs **************//
	var vuesMoisAmb = [<?php
        while ($info = mysqli_fetch_array($vuesMoisAmb)) {
            echo '"' . $info['moisAmb'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var vueAmb      = {
		type: "line",
		title: {
			text: 'VUES AMBASSADEURS',
			align: "center",
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
			labels: vuesMoisAmb
		},
		series: [
			{values: vuesAmb},
		]
	};
	$('.mentorsAmbasTab').click(function () {
		zingchart.render({
			id: 'vuesAmbass',
			data: vueAmb,
			height: 450,
			width: 500,
		});
	});


</script>
<!-- ************* AMBASSADEURS / dept *******************/// -->
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
    $nbrAmbDpt = mysqli_query($mysqli,
        "SELECT COUNT(*) as totalMent, nom FROM `talent_experience` INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id INNER JOIN mentor_ambassadeur ON talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id= '$ent' AND date_fin = '9999-12-31' group by departement_id");
    $nomDept = mysqli_query($mysqli,
        "SELECT COUNT(departement_id) as totalMent, departement_id, categorie_groupe.nom as nomDept FROM talent_experience INNER JOIN categorie_groupe ON talent_experience.departement_id = categorie_groupe.id INNER JOIN talent ON talent_experience.talent_id = talent.id INNER JOIN mentor_ambassadeur ON talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id = '$ent' GROUP BY departement_id");
    ?>
	var AmbDpt  = [<?php
        while ($info = mysqli_fetch_array($nbrAmbDpt)) {
            echo $info['totalMent'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var nomDept = [<?php
        while ($info = mysqli_fetch_array($nomDept)) {
            echo '"' . $info['nomDept'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var ambdptConfig = {
		type: "ring",
		title: {
			text: "AMBASSADEURS PAR DEPT.",
			align: "left",
			fontSize: '15',
			fontFamily: "Lato",
			offsetX: 10,
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
				effect: 3,
				method: 5,
				speed: 500,
				sequence: 1
			},
		},
		series: [
			{values: [AmbDpt[0]], text: [nomDept[0]], backgroundColor: "#32a0cc"},
			{values: [AmbDpt[1]], text: [nomDept[1]], backgroundColor: "#e86683"},
			{values: [AmbDpt[2]], text: [nomDept[2]], backgroundColor: "#5fe86b"},
			{values: [AmbDpt[3]], text: [nomDept[3]], backgroundColor: "#e753e8"},
		]
	};
	$('.mentorsAmbasTab').click(function () {
		zingchart.render({
			id: "AmbDept",
			width: 262,
			height: 270,
			data: ambdptConfig,
		});
	})
</script>
<!-- ******************* AMB par ancien ************* -->
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
    $AncienAmb = mysqli_query($mysqli,
        "SELECT TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) as df, prenom FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id INNER JOIN user ON talent.user_id = user.id INNER JOIN mentor_ambassadeur on talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31'");
    $prenomAmb = mysqli_query($mysqli,
        "SELECT TIMESTAMPDIFF(YEAR, date_debut, CURRENT_DATE) as df, prenom FROM `talent_experience` INNER JOIN talent ON talent_experience.talent_id = talent.id INNER JOIN user ON talent.user_id = user.id INNER JOIN mentor_ambassadeur on talent_experience.talent_id = mentor_ambassadeur.talent_id WHERE entreprise_id='$ent' AND `date_fin` = '9999-12-31'");
    ?>
	var AncienAmb = [<?php
        while ($info = mysqli_fetch_array($AncienAmb)) {
            echo $info['df'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var prenomAmb = [<?php
        while ($info = mysqli_fetch_array($prenomAmb)) {
            echo '"' . $info['prenom'] . '",';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];
	var AncAmb    = {
		type: "bar",
		title: {
			text: "ANCIENNETE DES AMBASSADEURS",
			fontSize: '13',
			fontFamily: "Lato",
		},
		scaleX: {
			values: prenomAmb,
			item: {
				fontSize: 10,
				fontAngle: -45
			}
		},
		series: [
			{
				values: AncienAmb,
				backgroundColor: "#5fe86b"
			},
		]
	};

	$('.mentorsAmbasTab').click(function () {
		zingchart.render({
			id: 'AncAmb',
			data: AncAmb,
			height: 269,
			width: 262,
		});
	});
</script>
