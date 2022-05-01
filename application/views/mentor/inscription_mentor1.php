<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 26/03/2019
 * Time: 11:08
 */
/* @var array $User
 * @var BusinessUser $BusinessUser
 * @var CI_Loader    $this
 * @var array        $departements
 * @var string       $Logged
 */ ?>
<?php echo form_open_multipart('inscription/insider-etape2', 'autocomplete="off" id="first_time_form"') ?>
<div class="row" style="height: 230px; width: 100%; background: url('/assets/img/bg_step_2.jpg') center center; background-size: cover; margin: auto">
    <div class="col-xs-12 col-md-12" style="height: 100%; padding: 80px;">
        <div class="avatarHeader" <?php echo $Logged == true && $BusinessUser->getAvatar() != '' && $BusinessUser->getAvatar() != null ? 'style="background: url(' . $BusinessUser->getAvatar() . ')"' : '' ?> >
            <?php if (!$this->getController()->userIsAuthentificate()) { ?>
                <label> <img src="/assets/img/icons/changelogo2.png" alt="" style="margin-top: 65px; margin-left: 65px;">
                    <input type="file" id="file_name" name="avatar" multiple onchange="rodURL(this);" style="display: none;" required/> <span style="color: #FFFFFF; font-weight: 400;"></span> </label>
            <?php } ?>
        </div>
        <div class="nameHead"><?php echo $Logged == true && $BusinessUser->getFullName() != '' && $BusinessUser->getFullName() != null ? $BusinessUser->getFullName() : ''; ?></div>
    </div>
</div>

<div class="container_inscrip">
    <div class="row">
        <div class="col-xs-12">
            <h1>BIENVENUE <?php echo $Logged == true && $BusinessUser->getPrenom() != '' && $BusinessUser->getPrenom() != null ? $BusinessUser->getPrenom() : ''; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <input name="nom" <?php echo $Logged == true && $BusinessUser->getNom() != '' && $BusinessUser->getNom() != null ? 'value="' . $BusinessUser->getNom() . '" readonly="readonly" class="inputText readonly_cursor" ' : ' class="inputText" '; ?> type="text" placeholder="Nom">
            <label id="error_nom"> </label>
        </div>
        <div class="col-xs-12 col-md-4">
            <input name="prenom" <?php echo $Logged == true && $BusinessUser->getPrenom() != '' && $BusinessUser->getPrenom() != null ? 'value="' . $BusinessUser->getPrenom() . '" readonly="readonly" class="inputText readonly_cursor" ' : ' class="inputText" '; ?> type="text" placeholder="Prénom">
            <label id="error_prenom"> </label>
        </div>
        <div class="col-xs-12 col-md-4">
            <input <?php echo $Logged == true && $BusinessUser->getEmail() != '' && $BusinessUser->getEmail() != null ? 'value="' . $BusinessUser->getEmail() . '" readonly="readonly" class="inputText readonly_cursor" ' : ' class="inputText" '; ?> name="email" type="email" placeholder="E-mail">
            <label id="error_email"> </label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6"><input class="api_geo inputText" id="pac-input" name="lieu" type="text" placeholder="Ville"/>

            <input type="hidden" id="ville" name="ville" required/>

            <input type="hidden" id="departement_geo" name="departement_geo"/>

            <input type="hidden" id="region" name="region"/>

            <input type="hidden" id="pays" name="pays"/>

            <label id="error_ville"> </label>
        </div>
        <div class="col-xs-12 col-md-6">
            <select class="inputText" name="levelSchool" id="levelSchool" required>
                <option value="" selected="selected">Niveau d'étude</option>
                <option value="99">Aucun diplôme</option>
                <option value="0">Bac</option>
                <option value="1">Bac +1</option>
                <option value="2">Bac +2</option>
                <option value="3">Bac +3</option>
                <option value="4">Bac +4</option>
                <option value="5">Bac +5</option>
                <option value="6">Au delà de Bac +5</option>
            </select> <label id="error_levelSchool"> </label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 school">
            <div>
                <p>Nom de l'école</p>
                <input class="inputText" type="text" id="school" name="schoollabel" value="" placeholder="Nom de l'école">

                <input type="hidden" id="school_id" name="school_id" value="0">

                <div class="drop_list drop_list_e" style="display:none;">
                    <ul id="school_list"></ul>
                </div>
            </div>
            <label id="error_school_id"> </label>
        </div>
        <div class="col-xs-12">
            <div class="autre_checkbox_div">
                <input type="checkbox" id="autre_checkbox" name="autre_checkbox"> <label for="autre_checkbox">Mon école n'est pas dans la liste</label>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="autre_school">
                <p>Renseignez le nom de l'école</p>
                <input class="inputText" type="text" id="autre" name="autre" value="<?php echo set_value('autre'); ?>" placeholder="Nom autre école"> <label id="error_autre"> </label>
            </div>
        </div>
    </div>
    <div class="row mgb_30">
        <div class="col-xs-12">
            <div class="candidatDept">
                Veuillez choisir une fonction : <br><br>
                <?php if ($departements != null) {
                    foreach ($departements as $dept): ?>
                        <label for="<?php echo $dept['id'] ?>" id="label<?php echo $dept['id'] ?>">
                            <input id="<?php echo $dept['id'] ?>" class="inputHide" type="radio" name="dept" value="<?php echo $dept['id'] ?>" required>
                            <span class="tag blueDept"><?php echo $dept['nom'] ?></span> </label>
                    <?php endforeach;
                } ?>
            </div>
            <input type="button" class="seemore" value="Voir plus"> <input type="button" class="seeless" value="Voir moins"> <label id="error_dept"> </label>
        </div>
    </div>
    <?php if ($Logged == false) { ?>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <input class="inputText" name="password" type="password" placeholder="Mot de passe"> <label id="error_password"> </label>
            </div>
            <div class="col-xs-12 col-md-4">
                <input class="inputText" name="confirm_password" type="password" placeholder="Confirmation du mot de passe"> <label id="error_confirm_password"> </label>
            </div>
        </div>
    <?php } ?>
    <div class="row mgb_30">
        <input type="submit" value="Etape suivante >" id="insc_etape1" class="nextStep">
    </div>
</div>

<?php echo form_close() ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer>
</script>
<script>
	$(function () {
		$firstLabel = $('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').addClass("hideDept");
		$seeless    = $('.seeless').addClass("hideDept");
		$('.seemore').on('click', function () {
			$($firstLabel).toggleClass("hideDept");
			$($seeless).toggleClass("hideDept");
			$('.seemore').hide();
		});
		$('.seeless').on('click', function () {
			$('.seemore').show();
			$($firstLabel).toggleClass("hideDept");
			$($seeless).toggleClass("hideDept");
		})
	});

</script>
<script>

	$(".school").hide();
	$("#levelSchool").change(function () {
		let val = $(this).val();
		if (val === "2" || val === "3" || val === "4" || val === "5" || val === "6") {
			$(".school").show();
			$(".autre_checkbox_div").show();
			$("#school").prop('required', true);
		} else if (val === "0" || val === "1" || val === "99") {
			$(".school").hide();
			$(".autre_checkbox_div").hide();
			$("#school").prop('required', false);
		}
	});

	$(".autre_school").hide();
	$(".autre_checkbox_div").hide();

	$("input[id=autre_checkbox]").change(function () {
		if (this.checked) {
			$(".autre_school").show();
			$("#autre").prop('required', true);
			$(".school").hide();
			$("#school").prop('required', false);
			$("#school").val('');
			$("#school_id").val('0');
		} else {
			$(".autre_school").hide();
			$("#autre").prop('required', false);
			$("#autre").val('');
			$(".school").show();
			$("#school").prop('required', true);
		}
	});

    /*school liste employeur*/
	$("#school").on('click keyup', function () {
		if ($(this).val().length < 1) {
			$('.drop_list.drop_list_e').hide();
			return false;
		}

		$("#school_id").val(0);
		$(".drop_list_e").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/school",
			data: 'school=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#school_list").html("Chargement...");
			},
			success: function (data) {
				$("#school_list").html("");

				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_e" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#school_list").append(text);
				});

				if (data.length == 0) {
					let text = '<li>Aucun résultat trouvé</li>';
					$("#school_list").append(text);
				}

				$('li.auto_cat_e').click(function (event) {
					event.preventDefault();
					$("#school").val($(this).text());
					$("#school_id").val($(this).attr('item_id'));
					$(".drop_list_e").hide();
				});
			}
		});
	});
</script>
<!-- Erreur if checkbox not checked-->
<script>
	$('#insc_etape1').on('click', function () {

		$.ajax({
			url: base_url + "inscription/firstTimeVerification",
			type: "POST",
			cache: false,
			async: false,
			data: $("#first_time_form").serialize(),
			dataType: 'json',
			success: function (data) {
				if (data.valid_info === false) {
					$(document).find('label[id^="error_"]').each(function () {
						$(this).empty();
					});

					$.each(data.errors, function (key, value) {
						$i = $('label[id="error_' + key + '"]');
						$i.append('<div class="error">' + value + '</div>');
					});

					var firstKey     = Object.keys(data.errors)[0];
					var el           = $('label[id="error_' + firstKey + '"]');
					var elOffset     = el.offset().top;
					var elHeight     = el.height();
					var windowHeight = $(window).height();
					var offset;

					if (elHeight < windowHeight) {
						offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
					} else {
						offset = elOffset;
					}
					var speed = 700;
					$('html, body').animate({scrollTop: offset}, speed);
					return false;
				} else if (data.valid_info === true) {
					$('#first_time_form').submit();
				}
			},
			error: function () {
				alert("Une erreur s'est produite, veuillez nous avertir immédiatement");
				return false;
			}
		});
		return false;
	});
</script>
<script>
	function initAutocomplete() {

		geocoder = new google.maps.Geocoder();

		var mapFields = document.getElementsByClassName('api_geo');


		for (let i = 0; i < mapFields.length; i++) {
			let input            = mapFields[i];
			autocomplete         = new google.maps.places.Autocomplete(input, {types: ['(cities)']});
			autocomplete.inputId = input.id;
			autocomplete.addListener('place_changed', fillInAddress);
		}
	}

	function fillInAddress() {

		var place = this.getPlace();

		place.address_components.forEach(function (element) {
			switch (element.types[0]) {
				case 'locality':
					document.getElementById('ville').setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_2':
					document.getElementById('departement_geo').setAttribute("value", element.long_name);
					break;
				case 'administrative_area_level_1':
					document.getElementById('region').setAttribute("value", element.long_name);
					break;
				case 'country':
					document.getElementById('pays').setAttribute("value", element.long_name);
					break;
				default:
					break;
			}
		});
	}
</script>
<script>
    /* Preview background */
	function rodURL(input) {
		if (input.files && input.files[0]) {
			var reader    = new FileReader();
			reader.onload = function (e) {
				$('.avatarHeader').css('background-image', 'url(' + e.target.result + ')');
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

    /* FILE NAME BACKGROUND */
	$("input[id='file_name']").change(function (e) {
		var $this = $(this);
		$this.next().html($this.val().split('\\').pop());
	});
</script>