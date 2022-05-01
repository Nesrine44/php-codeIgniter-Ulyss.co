<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 14/08/2018
 * Time: 12:41
 */
/* @var $this CI_Loader */
/* @var $BusinessEntreprise BusinessEntreprise */
/* @var $BusinessUser BusinessUser */ ?>

<div class="modal fade ent_mod" id="ambassModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="row up">
                <div class="col-md-3 col-lg-3 nbMentor"><h4>MENTORS <a class="bulleInfo">i<span>Salariés dans l'entreprise</span></a></h4>
                    <div> <?php echo $BusinessEntreprise->getNbrMentor() ?>
                        <img src="/assets/img/icons/team.png" alt="mentors"></div>
                    <p class="last">Last : 0</p>
                    <p id="dontnbr_amb">Dont <?php echo $BusinessEntreprise->getNbrAmbassador() ?> Ambassadeur(s)</p>
                </div>
                <div class="col-md-3 col-lg-3 nbMentor"><h4>RDV REALISES <a class="bulleInfo">i<span>Nombre total</span></a></h4>
                    <div><?php echo $BusinessEntreprise->getNbrRdv(); ?>
                        <img src="/assets/img/icons/conversation.png" alt="rdv_mentors"></div>
                    <p class="last">Last : 0</p>
                    <p>Dont <?php echo $BusinessEntreprise->getNbrAmbassador(); ?> Ambassadeurs</p>
                </div>
                <div class="col-md-3 col-lg-3" id="rdvRealmenu">
                </div>
                <div class="col-md-3 col-lg-3" id="MentDp"></div>
            </div>
            <div class="row">
                <div class="col-md-6 searchMentor">
                    <h4>Vos Mentors</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" placeholder="Par nom" id="searchNom" onkeyup="SearchName()">
                        </div>

                        <div class="col-md-4">
                            <div id="container_dep_list">
                            </div>
                        </div>

                    </div><!-- FIN INPUT RECHERCHE MENTORS -->
                    <p>Derniers inscrits</p>
                    <div class="row labelList"><!-- LISTE MENTORS FOR EACH-->
                        <div class="col-md-1"></div>
                        <div class="col-md-3 col-md-offset-1">Nom / Poste</div>
                        <div class="col-md-3">Département</div>
                        <div class="col-md-3">Ancienneté</div>
                        <div class="col-md-2">Localisation</div>
                    </div><!-- FIN LISTE MENTORS -->
                    <hr>
                    <ul id="mentor_dd" class="dropper">
                        <?php if ($BusinessEntreprise->getMentorProfilWithoutAmbassador() !== null) {
                            ?>
                            <?php foreach ($BusinessEntreprise->getMentorProfilWithoutAmbassador() as $key => $mentor) { ?>
                                <li class="draggable">
                                    <div class="row rowMentor" id="<?php echo $mentor->id ?>">
                                        <?php if ($mentor->avatar != "") { ?>
                                            <img class="avatar img_linkedin" src="<?php echo $mentor->avatar; ?>" style="center center no-repeat; height: 50px; border-radius: 50px; margin: auto;" alt="avatar <?php echo $mentor->prenom; ?>" ondragstart="return false;">
                                        <?php } else { ?>
                                            <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;" alt="avatar <?php echo $mentor->prenom; ?>" ondragstart="return false;">
                                        <?php } ?>
                                        <div class="col-md-3"><a href="#" class="aNom"><?php echo $mentor->prenom ?></a><br><a href="#" class="aFct"><?php echo $mentor->titre_mission; ?></a></div>
                                        <div class="col-md-3"><a href="#" class="aDpt"><?php echo $mentor->nom_departement ?></a></div>
                                        <div class="col-md-3"><?php echo $this->getController()->ModelGeneral->getJourFromTwoDate($mentor->date_debut, $mentor->date_fin); ?></div>
                                        <div class="col-md-2"><?php echo $mentor->lieu; ?>
                                        </div>
                                    </div>

                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>

                <div class="col-md-6 searchMentor">
                    <h4>Votre sélection d'Ambassadeurs</h4>
                    <div class="row nbAmbass">
                        <div class="col-md-4">
                            <p id="nbr_amb"><?php echo $BusinessEntreprise->getNbrAmbassador() ?></p>
                        </div>
                        <div class="col-md-4">
                            <img src="/assets/img/icons/computer-stat.png" alt="statistiques_ambassadeurs">
                        </div>
                    </div>
                    <p>Ambassadeurs </p>
                    <div class="row labelList"><!-- LISTE Ambassadeurs FOR EACH-->
                        <div class="col-md-1"></div>
                        <div class="col-md-3 col-md-offset-1">Nom / Poste</div>
                        <div class="col-md-3">Département</div>
                        <div class="col-md-3">Ancienneté</div>
                        <div class="col-md-2">Localisation</div>
                    </div>
                    <hr><!-- FIN LISTE Ambassadeurs -->
                    <div class="dropper" id="ambassadeur_dd">
                        <?php if ($BusinessEntreprise->getAllAmbassadorProfil() !== null) {
                            ?>
                            <?php foreach ($BusinessEntreprise->getAllAmbassadorProfil() as $key => $ambassador) { ?>
                                <li class="draggable">
                                    <div class="row rowMentor " id="<?php echo $ambassador->talent_id ?>">
                                        <div class="col-md-1"><?php if ($ambassador->avatar != "") { ?>
                                                <img class="avatar img_linkedin" src="<?php echo $ambassador->avatar; ?>" style="center center no-repeat; height: 50px; border-radius: 50px; margin: auto;" alt="avatar <?php echo $ambassador->prenom; ?>" ondragstart="return false;">
                                            <?php } else { ?>
                                                <img class="avatar img_linkedin" src="/upload/avatar/default.jpg" style="center center no-repeat;" alt="avatar <?php echo $ambassador->prenom; ?>" ondragstart="return false;">
                                            <?php } ?></div>
                                        <div class="col-md-3"><a href="#" class="aNom"><?php echo $ambassador->prenom ?></a><br><a href="#" class="aFct"><?php echo $ambassador->titre_mission; ?></a>
                                        </div>
                                        <div class="col-md-3"><a href="#" class="aDpt"><?php echo $ambassador->nom_departement ?></a></div>
                                        <div class="col-md-3"><?php echo $this->getController()->ModelGeneral->getJourFromTwoDate($ambassador->date_debut, $ambassador->date_fin); ?></div>
                                        <div class="col-md-2"><?php echo $ambassador->lieu; ?>
                                        </div>
                                    </div>
                                </li>

                            <?php }
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if ($this->getController()->companyIsAuthentificate() == true) { ?>
    <!-- DRAG and DROP -->
    <script>
		(function () {


			var dndHandler = {

				draggedElement: null, // Propriété pointant vers l'élément en cours de déplacement

				applyDragEvents: function (element) {

					element.draggable = true;

					var dndHandler = this; // Cette variable est nécessaire pour que l'événement « dragstart » ci-dessous accède facilement au namespace « dndHandler »

					element.addEventListener('dragstart', function (e) {
						dndHandler.draggedElement = e.target; // On sauvegarde l'élément en cours de déplacement
						e.dataTransfer.setData('text/plain', ''); // Nécessaire pour Firefox
					});

				},

				applyDropEvents: function (dropper) {

					dropper.addEventListener('dragover', function (e) {
						e.preventDefault(); // On autorise le drop d'éléments
						this.className = 'dropper drop_hover'; // Et on applique le style adéquat à notre zone de drop quand un élément la survole
					});

					dropper.addEventListener('dragleave', function () {
						this.className = 'dropper'; // On revient au style de base lorsque l'élément quitte la zone de drop
					});

					var dndHandler = this; // Cette variable est nécessaire pour que l'événement « drop » ci-dessous accède facilement au namespace « dndHandler »

					dropper.addEventListener('drop', function (e) {

						var target         = e.target,
							draggedElement = dndHandler.draggedElement, // Récupération de l'élément concerné
							clonedElement  = draggedElement.cloneNode(true); // On créé immédiatement le clone de cet élément

						while (target.className.indexOf('dropper') == -1) { // Cette boucle permet de remonter jusqu'à la zone de drop parente
							target = target.parentNode;
						}

						target.className = 'dropper'; // Application du style par défaut

						clonedElement = target.appendChild(clonedElement); // Ajout de l'élément cloné à la zone de drop actuelle
						dndHandler.applyDragEvents(clonedElement); // Nouvelle application des événements qui ont été perdus lors du cloneNode()

						var id_ment = draggedElement.childNodes[1].id; // on recupere l'id du mentor

						var $draggedParentName = draggedElement.parentNode.id;
						var $dropperParentName = clonedElement.parentNode.id;

						draggedElement.parentNode.removeChild(draggedElement); // Suppression de l'élément d'origine

						if ($draggedParentName !== $dropperParentName) {
							$.ajax({
								type: "POST",
								url: base_url + "entreprise/entreprises/selectOrDeselectAmbassador",
								data: {id: id_ment, csrf_token_name: csrf_token},
								dataType: 'json',
								success: function (json) {
									// si tu veut mettre des animation apres le transfert de mentor a embassadeur ou l'inverce
									document.getElementById("dontnbr_amb").innerHTML = 'Dont ' + json.emb + ' Ambassadeur(s)';
									document.getElementById("nbr_amb").innerHTML     = json.emb;
								},
								error: function () {
									// en cas ou l'entreprise est deconecter et que ile st rester sur la meme page
									// on lui recharge la page comme ca il saura qu'il doit se reconnecté
									location.reload();
								}
							});
						}

					});

				}

			};

			var elements    = document.querySelectorAll('.draggable'),
				elementsLen = elements.length;

			for (var i = 0; i < elementsLen; i++) {
				dndHandler.applyDragEvents(elements[i]); // Application des paramètres nécessaires aux éléments déplaçables
			}

			var droppers    = document.querySelectorAll('.dropper'),
				droppersLen = droppers.length;

			for (var i = 0; i < droppersLen; i++) {
				dndHandler.applyDropEvents(droppers[i]); // Application des événements nécessaires aux zones de drop
			}
		})();

    </script>
    <!-- FIN DRAG and DROP -->
<?php } ?>
<script>


</script>
<script>
	var re = /, France/gi;

	$('div').contents().each(function () {
		if (this.nodeType === 3 && this.nodeValue.match(re)) {
			this.nodeValue = this.nodeValue.replace(re, '');
		}
	});
</script>

<!-- RECHERCHE MENTORS -->
<script>
	// terminer la recheche , ajoute la liste deroulante depuit le code

	$(document).ready(function () {

		var arr_dep = [];
		ul          = document.getElementById("mentor_dd");
		li          = ul.getElementsByTagName("li");

		for (i = 0; i < li.length; i++) {
			dep = li[i].getElementsByClassName("aDpt")[0];
			arr_dep.push(dep.text);
		}

		arr_dep = cleanArray(arr_dep);

		var select_dep = $("<select style=' border: #000000 1px solid; margin: 30px auto; border-radius: 15px; padding: 1px 10px; width: 200px; line-height: inherit;'></select>").attr("id", "dep_list").attr("onChange", "SearchDept(this.value)");
		select_dep.append('<option value=""> -- Par Department : tout -- </option>');
		$.each(arr_dep, function (index, arr_dep) {
			select_dep.append($("<option></option>").text(arr_dep));
		});
		$("#container_dep_list").html(select_dep);

	});

	//cleanArray removes all duplicated elements
	function cleanArray(array) {
		var i, j, len = array.length, out = [], obj = {};
		for (i = 0; i < len; i++) {
			obj[array[i]] = 0;
		}
		for (j in obj) {
			out.push(j);
		}
		return out;
	}


	function SearchName() {
		var input, filter, ul, li, a, i;
		input  = document.getElementById("searchNom");
		filter = input.value.toUpperCase();
		ul     = document.getElementById("mentor_dd");
		li     = ul.getElementsByTagName("li");
		for (i = 0; i < li.length; i++) {
			a = li[i].getElementsByClassName("aNom")[0];
			if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";
			}
		}
	}

	function SearchDept(value) {

		var filter, ul, li, a, i;
		filter = value.toUpperCase();
		ul     = document.getElementById("mentor_dd");
		li     = ul.getElementsByTagName("li");
		for (i = 0; i < li.length; i++) {
			a = li[i].getElementsByClassName("aDpt")[0];

			if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";
			}
		}
	}
</script>
<!-- FIN RECHERCHE MENTORS -->

<!-- STATS MENTORS/Dept -->
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
    $data = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM `talent_experience` WHERE `entreprise_id`= '$ent' group by departement_id");

    $nbrMentor = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM `talent_experience` WHERE `entreprise_id`= '$ent' group by `date_debut`<='2018-01-01 00:00:00'");
    ?>

	var myData = [<?php
        while ($info = mysqli_fetch_array($data)) {
            echo $info['total'] . ',';
        } /* We use the concatenation operator '.' to add comma delimiters after each data value. */
        ?>];

	var config = {
		type: "ring",
		legend: {
			shared: true,
			toggleAction: 'remove',
			backgroundColor: '#FBFCFE',
			borderWidth: 0,
			adjustLayout: true,
			align: 'center',
			verticalAlign: 'bottom',
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
				marginLeft: 0,
			},
			mediaRules: [
				{
					maxWidth: 400,
					visible: true
				}
			]
		},
		title: {
			text: "MENTORS PAR DEPT.",
			fontSize: '15',
			fontFamily: "Lato",
		},
		plot: {
			slice: '65%',
			borderColor: "#00b3ee36",
			tooltip: {
				fontFamily: "Lato",
				text: "%npv%"
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
				values: [0],
				text: "",
				backgroundColor: "#6FB07F",
				marker: {
					backgroundColor: '#6FB07F'
				}
			},
			{values: [0], text: "", backgroundColor: "#32a0cc", fontSize: 12,},
			{values: [0], text: "", backgroundColor: "#e86683"},

		]
	};
	$('.ambassModal').click(function () {
		zingchart.render({
			id: "MentDp",
			width: 262,
			height: 270,
			data: config,
		});
	});
</script>
<script>
	// RDV realises
	var rdvRealMenu = {
		type: "bar",
		title: {
			text: "RDV REALISES",
			fontSize: '15',
			fontFamily: "Lato",
		},
		plot: {
			animation: {
				delay: 500,
				speed: "9000",
				effect: "ANIMATION_EXPAND_LEFT"
			},
		},
		scaleX: {
			values: ["Mentors", "Ambassadeurs"],
			item: {
				fontSize: 10,
				fontAngle: -45
			}
		},
		series: [
			{
				values: [0, 0]
			},
		]
	};
	$('.ambassModal').click(function () {
		zingchart.render({
			id: 'rdvRealmenu',
			data: rdvRealMenu,
			height: 269,
			width: 262,
		});
	});
</script>


<!-- STATS Ambass/Dept -->
<script>


</script>