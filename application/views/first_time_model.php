<div class="modal fade ent_mod" id="deptUserModal" role="dialog">
    <div class="modal-dialog" style="margin-top: 100px; height: 100%;">
        <div class="modal-content">
            <h1>Bienvenue <?php echo $User->prenom ?></h1>
            <p>Afin de vous proposer une sélection de mentors correspondants à votre profil, veuillez choisir le département professionnel qui vous correspond : </p>
            <!--<div id="progress-inputs" class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-vluemax="100" style="width:0%;">
                    <span class="sr-only">0%</span>
                </div>
            </div>-->

            <?php echo form_open('inscription', 'autocomplete="off" id="input-progress"') ?>
            <div class="candidatDept">
                <input type="button" id="seemore" value="Voir plus">
                <?php if ($departements != null) {
                    foreach ($departements as $dept): ?>
                        <label for="<?php echo $dept['id'] ?>" id="label<?php echo $dept['id'] ?>">
                            <input id="<?php echo $dept['id'] ?>" type="radio" name="dept" value="<?php echo $dept['id'] ?>" required> <span class="tag blueDept"><?php echo $dept['nom'] ?></span>
                        </label>
                    <?php endforeach;
                } ?>
            </div>
            <p>Veuillez selectioner votre niveau d'étude</p>
            <select name="levelSchool" id="levelSchool" required>
                <option value="" selected="selected">.....</option>
                <option value="">Aucun diplôme</option>
                <option value="0">Bac</option>
                <option value="1">Bac +1</option>
                <option value="2">Bac +2</option>
                <option value="3">Bac +3</option>
                <option value="4">Bac +4</option>
                <option value="5">Bac +5</option>
                <option value="6">Au delà de Bac +5</option>
            </select>


            <div class="school">
                <p>Nom de l'école</p>
                <input type="text" id="school" name="schoollabel" value="" placeholder="Nom de l'école">

                <input type="hidden" id="school_id" name="school_id" value="-1">

                <div class="drop_list drop_list_e" style="display:none;">
                    <ul id="school_list"></ul>
                </div>
            </div>
            <div class="autre_checkbox_div">
                <input type="checkbox" id="autre_checkbox" name="autre_checkbox"> <label for="autre_checkbox">Mon école n'est pas dans la liste</label>
            </div>
            <div class="autre_school">
                <p>Renseignez le nom de l'école</p>
                <input type="text" id="autre" name="autre" value="<?php echo set_value('autre'); ?>" placeholder="Nom autre école">
            </div>
            <input type="submit" value="VALIDER" class="validDept">
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
	$('#input-progress').submit(function () {
		$('#deptUserModal').modal('hide');
	});
	$(function () {
		$firstLabel = $('#label1, #label2, #label4, #label7, #label8, #label9, #label10, #label11, #label12, #label14, #label16, #label17').addClass("hideDept");
		$('#seemore').on('click', function () {
			$($firstLabel).toggleClass("hideDept");
		});
		if ($firstLabel === false) {
			$('#seemore').value('Voir moins');
		}
	})

</script>
<script>

	$(".school").hide();
	$("#levelSchool").change(function () {
		var val = $(this).val();
		if (val === "2" || val === "3" || val === "4" || val === "5" || val === "6") {
			$(".school").show();
			$(".autre_checkbox_div").show();
			$("#school").prop('required', true);
		} else if (val === "0" || val === "1") {
			$(".school").hide();
			$(".autre_checkbox_div").hide();
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
	var y = $('<div class="error">Veuilez choisir un département</div>');
	var z = $('<div class="error">Veuillez choisir une école ou cocher "Mon ecole n\'existe pas" </div>');

	$('.validDept').on('click', function () {

		let dep = $('.candidatDept input[type=radio]:checked').length;

		let schoolid = $('#school_id').val();

		if (dep === 0) {
			$('.candidatDept').append(y);
		}

		let validbox = $('input[id=autre_checkbox]').prop('checked');
		if (schoolid === '0' && validbox === false) {
			$('.school').prepend(z);
			return false;
		}
	});
</script>