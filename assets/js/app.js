function selectbox() {
	$(".selectbox").length > 0 && ($(".selectbox").each(function () {
		var e = $(this).children("ul"), t = e.children("li.selected").length > 0 ? e.children("li.selected") : e.children("li:first-child");
		t.addClass("active"), $(this).children(".selectchoice").html(t.html()), $(this).find('input[type="hidden"]').remove(), $(this).prepend('<input type="hidden" name="' + $(this).attr("name") + '" value="' + t.attr("value") + '" />')
	}), $("html, body").click(function (e) {
		$(e.target).hasClass("selectbox") || $(e.target).parents(".selectbox").length || $(".selectbox").removeClass("open")
	})), $("body").on('click', '.selectbox', function () {
		$(this).toggleClass("open")
	}), $("body").on('click', '.selectbox ul li', function () {
		var e = $(this).closest(".selectbox");
		e.find("*").removeClass("active"), $(this).addClass("active"), e.children(".selectchoice").html($(this).html()), e.children('input[type="hidden"]').val($(this).attr("value"))
	});

	/* Persos conditions */
	$('.selectbox[name="country"] ul li').click(function () {
		var $this = $(this);
		setTimeout(function () {
			var exemple = $this.attr('rel-placeholder');
			var prefixe = $this.attr('value');
			$('.selectinputphoneext').val(prefixe);
			$('.selectinputphone').val('').attr('placeholder', exemple);
		}, 150);
	});
}


/*verification mon number telephone*/
function verification_telephone() {
	let $inputname       = $('input[name="country"]');
	let valExtension     = $inputname.val();
	let $inputTel        = $('.selectinputphone');
	let numeroSaisi      = $inputTel.val();
	let hasError         = false;
	let message          = '';
	let $boxcontentphone = $('.contentphone');

	/* Gestion des erreurs */
	if (numeroSaisi === '') {
		message  = 'Veuillez saisir un numéro de téléphone';
		hasError = true;
	}

	$('.errorboxphone').remove();
	$inputTel.removeClass('errorvalue');
	if (hasError) {
		$inputTel.addClass('errorvalue');
		$boxcontentphone.after('<div class="errorboxphone">' + message + '</div>');
	} else {
		showButtonWaiting();
		$.ajax({
			type: "GET",
			url: base_url + "inscription/confirmation_phone",
			data: {ext: valExtension, phone: numeroSaisi, csrf_token_name: csrf_token},
			dataType: 'json',
			success: function (json) {
				removeButtonWaiting();
				if (json.status === "OK") {
					$("#modalSendTelConfirmation").modal();
				} else {
					$inputTel.addClass('errorvalue');
					$boxcontentphone.after('<div class="errorboxphone">' + json.description + '</div>');
				}
			}
		});
	}

	return false;
}


/*verification mon number telephone*/
function verification_telephone_mentor() {
	let $inputname       = $('input[name="country"]');
	let valExtension     = $inputname.val();
	let $inputTel        = $('.selectinputphone');
	let numeroSaisi      = $inputTel.val();
	let hasError         = false;
	let message          = '';
	let $boxcontentphone = $('.contentphone');


	/* Gestion des erreurs */
	if (numeroSaisi === '') {
		message  = 'Veuillez saisir un numéro de téléphone';
		hasError = true;
	}

	$('.errorboxphone').remove();
	$inputTel.removeClass('errorvalue');
	if (hasError) {
		$inputTel.addClass('errorvalue');
		$boxcontentphone.after('<div class="errorboxphone">' + message + '</div>');
	} else {
		showButtonWaiting();
		$.ajax({
			type: "GET",
			url: base_url + "inscription/confirmation_phoneMentor",
			data: {ext: valExtension, phone: numeroSaisi, csrf_token_name: csrf_token},
			dataType: 'json',
			success: function (json) {
				removeButtonWaiting();
				if (json.status === "OK") {
					$("#modalSendTelConfirmation").modal();
				} else {
					$inputTel.addClass('errorvalue');
					$boxcontentphone.after('<div class="errorboxphone">' + json.description + '</div>');
				}
			}
		});
	}

	return false;
}

function doConfirmernumero() {
	if ($("#code_telephone").val() == "") {
		return false;
	}
	$('#modalSendTelConfirmation .btn_inscription a').hide();
	$('#modalSendTelConfirmation .btn_inscription .loader').show();
	$.ajax({
		type: "POST",
		url: base_url + "compte/do_confirmer_phone",
		data: {code: $("#code_telephone").val(), csrf_token_name: csrf_token},
		dataType: 'json',
		success: function (json) {
			$('#modalSendTelConfirmation .btn_inscription a').show();
			$('#modalSendTelConfirmation .btn_inscription .loader').hide();
			if (json.status == "ok") {
				$('#modalSendTelConfirmation').modal('hide');
				$('.btninprocess').addClass('numvalid').css('opacity', '0.5').html('Votre numéro est validé.')
				if ($('.profil_reservation').length > 0) {
					location.reload();
				}
			} else if (json.status == "no") {
				$(".error_info_tel").html("Le code saisi ne correspond pas au code reçu");
				setTimeout(function () {
					$(".error_info_tel").hide();
				}, 6000);
			} else {
				$(".error_info_tel").html("Le serveur ne marche pas.");
				setTimeout(function () {
					$(".error_info_tel").hide();
				}, 6000);
			}
			return false;
		}

	});
	return false;
}


function doConfirmernumeroMentor() {
	if ($("#code_telephone").val() == "") {
		return false;
	}
	$('#modalSendTelConfirmation .btn_inscription a').hide();
	$('#modalSendTelConfirmation .btn_inscription .loader').show();
	$.ajax({
		type: "POST",
		url: base_url + "compte/do_confirmer_phone_mentor",
		data: {code: $("#code_telephone").val(), csrf_token_name: csrf_token},
		dataType: 'json',
		success: function (json) {
			$('#modalSendTelConfirmation .btn_inscription a').show();
			$('#modalSendTelConfirmation .btn_inscription .loader').hide();
			if (json.status == "ok") {
				$('#modalSendTelConfirmation').modal('hide');
				$('.btninprocess').addClass('numvalid').css('opacity', '0.5').html('Votre numéro est validé.');
				if ($('.profil_reservation').length > 0) {
					location.reload();
				}
			} else if (json.status == "no") {
				$(".error_info_tel").html("Le code saisi ne correspond pas au code reçu");
				setTimeout(function () {
					$(".error_info_tel").hide();
				}, 6000);
			} else {
				$(".error_info_tel").html("Le serveur ne marche pas.");
				setTimeout(function () {
					$(".error_info_tel").hide();
				}, 6000);
			}
			return false;
		}

	});
	return false;
}


function showButtonWaiting() {
	$('.btninprocess').addClass('waitingprocess').css('opacity', '0.5').append('<i class="fa fa-spinner fa-spin"></i>');
}

function removeButtonWaiting() {
	$('.btninprocess').removeClass('waitingprocess').removeAttr('style').find('i').remove();
}

$(document).ready(function () {
	selectbox();
	Formsearch();
	socialNetworks();
	$('.reste_con .groupe_cat_').click(function () {
		var thisCheck = $(this);
		if (thisCheck.is(':checked')) {
			$.ajax({
				type: "GET",
				url: base_url + "wishlist/get_sous_categorie",
				dataType: 'html',
				data: {id: thisCheck.val(), csrf_token_name: csrf_token},
				success: function (list) {
					$("#scat").append(list);
				}
			});
		} else {
			$(".list_s_" + thisCheck.val()).remove();
		}

	});

	$("#ameliorer_f").keyup(function () {
		$("#ameliorer_f").removeClass('error_validation');
	});

	$("#raison_f").keyup(function () {
		$("#raison_f").removeClass('error_validation');
	});

	$('.check_notif :input').click(function () {
		var thisCheck = $(this);
		if (thisCheck.is(':checked')) {
			$.ajax({
				type: "POST",
				url: base_url + "compte/modifications_notifications",
				dataType: 'json',
				data: {notification: thisCheck.val(), name: thisCheck.attr("name"), csrf_token_name: csrf_token},
				success: function (json) {

				}
			});
		}

	});
	$(".add_file_link").click(function (event) {
		event.preventDefault();
		$('#fileinput').trigger('click');
	});
	var doc_preview = 0;
	$('.add_document').on('change', function (e) {
		var files = $(this)[0].files;

		if (files.length > 0) {
			$(this).removeClass("add_document");
			$("#html_add_doc").append('<input type="file" name="files[]"   class="hidden add_document">');
			// On part du principe qu'il n'y qu'un seul fichier
			// étant donné que l'on a pas renseigné l'attribut "multiple"
			var file           = files[0],
				$image_preview = $('#doc_preview_' + doc_preview);

			$image_preview.show();
			var fd = new FormData();
			fd.append('userfile', file);
			fd.append('csrf_token_name', csrf_token);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: base_url + "donner_des_cours/ajouter_document",
				data: fd, // serializes the form's elements.
				dataType: 'json',
				success: function (json) {
					$image_preview.find('a').attr('href', json.msg);
					$("#html_add_doc").append('<input type="hidden" name="list_files[]"  value=' + json.value + '>');
					$('#lien_' + doc_preview).show();
					$('#loading_' + doc_preview).hide();
					doc_preview = doc_preview + 1;
					init_doc();
					return false;
				}
			});

		}
	});

	function init_doc() {
		$('.add_document').on('change', function (e) {
			var files = $(this)[0].files;

			if (files.length > 0) {
				$(this).removeClass("add_document");
				$("#html_add_doc").append('<input type="file" name="files[]"   class="hidden add_document">');
				// On part du principe qu'il n'y qu'un seul fichier
				// étant donné que l'on a pas renseigné l'attribut "multiple"
				var file           = files[0],
					$image_preview = $('#doc_preview_' + doc_preview);
				doc_preview        = doc_preview + 1;
				$image_preview.find('a').attr('href', window.URL.createObjectURL(file));
				init_doc();
			}
		});
	}

	function verification_input_add_cours() {
		var error = false;
		$("#formAddCours :input.required").each(function () {
			if ($.trim($(this).val()) == "") {
				$(this).removeClass("valid").addClass("invalid");
				$(this).parent().parent().addClass('invalid');
				error = true;
			}
		});
		if (error) {
			return false;
		} else {
			return true;
		}
	}

	var variable_preview = 0;
	$(".add_file2").click(function (event) {
		event.preventDefault();
		$('.add_files_2').trigger('click');
	});
	$('.add_files_2').on('change', function (e) {
		var files = $(this)[0].files;

		if (files.length > 0) {
			$(this).removeClass("add_files_2");
			$("#html_files_img").append('<input type="file" name="image[]"   class="hidden add_files_2">');
			// On part du principe qu'il n'y qu'un seul fichier
			// étant donné que l'on a pas renseigné l'attribut "multiple"
			var file           = files[0],
				$image_preview = $('#image_preview_' + variable_preview);
			variable_preview   = variable_preview + 1;
			$image_preview.find('img').attr('src', window.URL.createObjectURL(file));
			init_image();
		}
	});

	function init_image() {
		$('.add_files_2').on('change', function (e) {
			var files = $(this)[0].files;

			if (files.length > 0) {
				$(this).removeClass("add_files_2");
				$("#html_files_img").append('<input type="file" name="image[]"   class="hidden add_files_2">');
				// On part du principe qu'il n'y qu'un seul fichier
				// étant donné que l'on a pas renseigné l'attribut "multiple"
				var file           = files[0],
					$image_preview = $('#image_preview_' + variable_preview);
				variable_preview   = variable_preview + 1;

				// Ici on injecte les informations recoltées sur le fichier pour l'utilisateur
				$image_preview.find('img').attr('src', window.URL.createObjectURL(file));
				init_image();
			}
		});
	}


	$("#formAddCours").submit(function () {
		if (!verification_input_add_cours()) {
			$(".etap1_error").html("Merci de remplir tous les champs");
			$("html, body").animate({scrollTop: 0}, "slow");
			$(".etap1_error").show();
			setTimeout(function () {
				$(".etap1_error").show();
			}, 6000);
			return false;
		} else if ($("#cat_cours").val() == "") {
			show_btn_inscription()
			$("#cat_cours").parent().parent().addClass('invalid');
			$("html, body").animate({scrollTop: 0}, "slow");
			$(".etap1_error").html("Merci de remplir tous les champs");
			$(".etap1_error").show();
			setTimeout(function () {
				$(".etap1_error").show();
			}, 6000);
			return false;
		} else {
			return true;
		}


		return false;
	});
	$("#formAddDemande").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/add_demande",
			data: $("#formAddDemande").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#ModalAddDemande').modal('hide');
				$('#modalADDdemandeConfirmationajoutDEmande').modal('show');
				return false;
			}
		});
		return false;
	});

	/*editer description*/
	$("#formEditerDetail").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/editer_description",
			data: $("#formEditerDetail").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#ModalEditerDetail').modal('hide');
				$('#detail_talent').html(json.description);
				return false;
			}
		});
		return false;
	});

	/*editer Format du rendez-vous*/
	$("#formEditerrendeVous").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/editer_rendez_vous",
			data: $("#formEditerrendeVous").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#ModalEditerFormatRendezVous').modal('hide');
				$('#rende_v_desc').html(json.format_rendez_vous);
				return false;
			}
		});
		return false;
	});
	/*edit centre interet*/
	$("#formEditerCentre").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/editer_centre_interet",
			data: $("#formEditerCentre").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#ModalEditerCentre').modal('hide');
				$('#detail_centre').html(json.centre_interet);
				return false;
			}
		});
		return false;
	});
	/*ajouter langue*/
	$("#formEditerLangues").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_langue",
			data: $("#formEditerLangues").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_langues').html(json.html);
				$('.items_tags').html(json.html1);
				return false;
			}
		});
		return false;
	});
	/*editer tag*/
	$("#formEditerTags").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_tag",
			data: $("#formEditerTags").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_tags').html(json.html);
				$('.tag').html(json.html1);
				return false;
			}
		});
		return false;
	});
	/*ajouter mode*/
	$("#formEditerMode").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_mode",
			data: $("#formEditerMode").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_mode').html(json.html);
				$('.list_formations_html').html(json.html1);
				return false;
			}
		});
		return false;
	});
	/*ajouter langue*/
	$("#formEditerCategories").submit(function () {
		if ($("#categorie_id_talent").val() == 0) return false;
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_categorie",
			data: $("#formEditerCategories").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_cat_html').html(json.html);
				$('.items_categories').html(json.html1);
				return false;
			}
		});
		return false;
	});
	/*ajouter references*/
	$("#formEditerReference").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_reference",
			data: $("#formEditerReference").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_references').html(json.html);
				$('.items_reference').html(json.html1);
				return false;
			}
		});
		return false;
	});

	/*experiences*/
	$("#formEditerExp").submit(function () {
		$.ajax({
			type: "POST",
			url: base_url + "profil/ajouter_experience",
			data: $("#formEditerExp").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				//$('#ModalEditerDetail').modal('hide');
				$('#list_experiences').html(json.html);
				$('.list_expr').html(json.html1);
				return false;
			}
		});
		return false;
	});
	/*portfolio*/


	$("#formEditerPortfolio").submit(function () {
		if ($('#fileportfolio')[0].files[0] == undefined) return false;
		$('.sendButtonport').attr('disabled', true);
		$(".chargement_b").show();
		$(".button_su").hide();
		var fd = new FormData();
		fd.append('file', $('#fileportfolio')[0].files[0]);
		fd.append('titre', $('#titre_port').val());
		fd.append('csrf_token_name', csrf_token);
		fd.append('talent_id', $('#talent_id_').val());
		$.ajax({
			type: "POST",
			processData: false,
			contentType: false,
			url: base_url + "profil/ajouter_portfolio",
			data: fd, // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#list_portfolio').html(json.html);
				$(".chargement_b").hide();
				$(".button_su").show();
				$('.sendButtonport').attr('disabled', false);

				return false;
			}
		});
		return false;
	});
	$('li.auto_cat').click(function (event) {
		event.preventDefault();
		$("#categorie").val($(this).text());
		$("#cat_id").val($(this).attr('item_id'));
		$(".field_talent .drop_list").hide();
	});
	$("#categorie").click(function () {
		$("#categorie").removeClass('error');
		$(".field_talent .drop_list").show();
	});
	/*secteur activite*/
	$("#secteur").click(function () {
		$("#secteur").removeClass('error');
		$(".field_talent .drop_list_s").show();
	});
	$('li.auto_cat_s').click(function (event) {
		event.preventDefault();
		$("#secteur").val($(this).text());
		$("#secteur_id").val($(this).attr('item_id'));
		$(".field_talent .drop_list_s").hide();
	});
	/*departement*/
	$("#departement").click(function () {
		$("#departement").removeClass('error');
		$(".field_talent .drop_list_d").show();
	});
	$('li.auto_cat_d').click(function (event) {
		event.preventDefault();
		$("#departement").val($(this).text());
		$("#departement_id").val($(this).attr('item_id'));
		$(".field_talent .drop_list_d").hide();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/fonction",
			data: 'departement=' + $(this).attr('item_id'),
			dataType: 'json',
			beforeSend: function () {
				$("#fonction_list").html("Chargement...");
			},
			success: function (data) {
				$("#fonction_list").html("");
				var defaultselect = data.length === 1 ? ' selected' : '';
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#fonction_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_fonction" item="' + element.nom + '" item_id="' + element.id + '" ' + defaultselect + '><a href="#">' + element.nom + '</a></li>';
					$("#fonction_list").append(text);

				});
				$('li.auto_fonction').click(function (event) {
					event.preventDefault();
					$("#fonction").val($(this).text());
					$("#fonction_id").val($(this).attr('item_id'));
					$(".location_field .drop_list_f").hide();
				});
			}
		});


	});

	/*fonction*/
	$("#fonction").click(function () {
		$("#fonction").removeClass('error');
		$(".field_talent .drop_list_f").show();
	});
	$('li.auto_cat_f').click(function (event) {
		event.preventDefault();
		$("#fonction").val($(this).text());
		$("#fonction_id").val($(this).attr('item_id'));
		$(".field_talent .drop_list_f").hide();
	});
	$("#fonction").keyup(function () {
		$("#fonction_id").val(0);
		if ($(this).val().length < 2) return;
		$(".location_field .drop_list_f").show();
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/fonction_ajax",
			data: 'fonction=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#fonction_list").html("Chargement...");
			},
			success: function (data) {
				$("#fonction_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#fonction_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_f" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#fonction_list").append(text);

				});
				$('li.auto_cat_f').click(function (event) {
					event.preventDefault();
					$("#fonction").val($(this).text());
					$("#fonction_id").val($(this).attr('item_id'));
					$(".location_field .drop_list_f").hide();
				});
			}
		});
	});
	$("#departement").keyup(function () {
		$(".field_talent .drop_list_d").show();
		$("#departement_id").val(0);
		if ($(this).val().length < 2) return;
		$(".field_talent .drop_list_d").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete",
			data: 'categorie=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#cat_list").html("Chargement...");
			},
			success: function (data) {
				$("#cat_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#cat_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_d" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#cat_list").append(text);
				});

				$('li.auto_cat_d').click(function (event) {
					event.preventDefault();
					$("#departement").val($(this).text());
					$("#departement_id").val($(this).attr('item_id'));
					$(".location_field .drop_list_d").hide();
				});


			}
		});
	});


	$(".departement").change(function () {
		$(".fonction_" + $(this).attr("lid")).html('<option value="">Fonction</option>');
		var $city = $(".fonction_" + $(this).attr("lid"));
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/fonction",
			data: 'departement=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#cat_list").html("Chargement...");
			},
			success: function (data) {
				var defaultselect = data.length === 1 ? ' selected' : '';

				if (data.length === 1) {
					$city.closest('.rowfonction').hide();
				} else {
					$city.closest('.rowfonction').show();
				}

				$.each(data, function (index, element) {
					var text = '<option ' + defaultselect + ' value="' + element.id + '">' + element.nom + '</option>';
					$city.append(text);
				});


			}
		});
	});

	$("#entreprise1").keyup(function () {

		$("#entreprise_id1").val(0);
		if ($(this).val().length < 2) return;
		$(".drop_list_e").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/entreprise",
			data: 'entreprise=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#entreprise_list1").html("Chargement...");
			},
			success: function (data) {
				$("#entreprise_list1").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#entreprise_list1").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_e" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#entreprise_list1").append(text);
				});

				$('li.auto_cat_e').click(function (event) {
					event.preventDefault();
					$("#entreprise1").val($(this).text());
					$("#entreprise_id1").val($(this).attr('item_id'));
					$(".drop_list_e1").hide();
				});
			}
		});
	});

	/*competence*/
	$("#competence").keyup(function () {
		$(".drop_list_c").show();
		$("#competence_id").val(0);
		if ($(this).val().length < 2) return;
		$(".drop_list_c").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/competence",
			data: 'cmp=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#cmp_list").html("Chargement...");
			},
			success: function (data) {
				$("#cmp_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#cmp_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_c" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#cmp_list").append(text);
				});

				$('li.auto_cat_c').click(function (event) {
					event.preventDefault();
					$("#competence").val("");
					$("#competence_id").val($(this).attr('item_id'));
					$(".drop_list_c").hide();

					var value = $(this).attr('item_id');
					var name  = $(this).text();
					$("#delete_langue_r_" + value).remove();
					$("#delete_langue_input_" + value).remove();
					$(".sp_langues1").append("<span class='delete_me' lid='" + value + "' id='delete_langue_r_" + value + "'>" + name + " <i class='ion-android-close'></i></span>  <input id='delete_langue_input_" + value + "'  type='hidden' value='" + value + "' name='competence_id[]' >");
					$('.delete_me').click(function (e) {
						e.preventDefault();
						$("#delete_langue_r_" + $(this).attr("lid")).remove();
						$("#delete_langue_input_" + $(this).attr("lid")).remove();
					});
				});
			}
		});
	});
	$("#secteur").keyup(function () {
		$(".field_talent .drop_list_d").show();
		$("#secteur_id").val(0);
		if ($(this).val().length < 2) return;
		$(".field_talent .drop_list_d").show();

		$.ajax({
			type: "GET",
			url: base_url + "autocomplete/secteur",
			data: 'secteur=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#secteur_list").html("Chargement...");
			},
			success: function (data) {
				$("#secteur_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#secteur_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_cat_s" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#secteur_list").append(text);
				});

				$('li.auto_cat_s').click(function (event) {
					event.preventDefault();
					$("#secteur").val($(this).text());
					$("#secteur_id").val($(this).attr('item_id'));
					$(".field_talent .drop_list_s").hide();
				});
			}
		});
	});
	$("#categorie").keyup(function () {
		$(".field_talent .drop_list").show();
	});

	$("#ville").keyup(function () {
		$("#ville_id").val(0);
		if ($(this).val().length < 2) return;
		$(".location_field .drop_list").show();
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete",
			data: 'ville=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#ville_list").html("Chargement...");
			},
			success: function (data) {
				$("#ville_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#ville_list").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_ville" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#ville_list").append(text);

				});
				$('li.auto_ville').click(function (event) {
					event.preventDefault();
					$("#ville").val($(this).text());
					$("#ville_id").val($(this).attr('item_id'));
					$(".location_field .drop_list").hide();
				});
			}
		});
	});
	$("#ville_insc").keyup(function () {
		$("#ville_id_insc").val(0);
		if ($(this).val().length < 2) return;
		$(".location_field .drop_list").show();
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete",
			data: 'ville=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$("#ville_list_insc").html("Chargement...");
			},
			success: function (data) {
				$("#ville_list_insc").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#ville_list_insc").append(text);
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_ville_insc" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#ville_list_insc").append(text);

				});
				$('li.auto_ville_insc').click(function (event) {
					event.preventDefault();
					$("#ville_insc").val($(this).text());
					$("#ville_id_insc").val($(this).attr('item_id'));
					$(".location_field .drop_list").hide();
				});
			}
		});
	});
	/*keyup recherche*/
	$("#ville_r").keyup(function () {
		$("#ville_id_r").val(0);

		if ($(this).val().length < 2) return;
		$(".location_field .drop_list").show();
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete",
			data: 'ville=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$(".ico_spin").show();
			},
			success: function (data) {
				$("#ville_list_r").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#ville_list_r").append(text);
					$(".ico_spin").hide();
				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_ville_r" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#ville_list_r").append(text);
					$(".ico_spin").hide();
				});
				$('li.auto_ville_r').click(function (event) {
					event.preventDefault();
					$("#ville_r").val($(this).text());
					$("#ville_id_r").val($(this).attr('item_id'));
					$(".location_field .drop_list").hide();
				});
			}
		});
	});

	/*ADD CONTACT*/
	$("#contacteTalent").submit(function () {
		var input = $("#msg_to_user").val();
		if (input == "") {
			$(".msg_err").show();
			setTimeout(function () {
				$(".msg_err").hide();
			}, 6000);
			return false;
		}

		$.ajax({
			type: "POST",
			url: base_url + "profil/send_msg",
			data: $("#contacteTalent").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$('#contacteTalent').hide();
				$('.msg_envois').show();
				return false;
			}
		});
		return false;
	});
	$("#ville_wish").keyup(function () {
		$("#ville_id").val(0);

		if ($(this).val().length < 2) return;
		$(".location_field .drop_list").show();
		$.ajax({
			type: "GET",
			url: base_url + "autocomplete",
			data: 'ville=' + $(this).val(),
			dataType: 'json',
			beforeSend: function () {
				$(".ico_spin").show();
			},
			success: function (data) {
				$("#ville_list").html("");
				if (data.length == 0) {
					var text = '<li>Aucun résultat trouvé</li>';
					$("#ville_list").append(text);
					$(".ico_spin").hide();

				}
				$.each(data, function (index, element) {
					var text = '<li class="auto_ville" item="' + element.value + '" item_id="' + element.id + '"><a href="#">' + element.value + '</a></li>';
					$("#ville_list").append(text);
					$(".ico_spin").hide();

				});
				$('li.auto_ville').click(function (event) {
					event.preventDefault();
					$("#ville_wish").val($(this).text());
					$("#ville_id").val($(this).attr('item_id'));
					$(".location_field .drop_list").hide();
				});
			}
		});
	});
	$('.btn-group button[data-calendar-nav]').each(function () {
		var $this = $(this);
		$this.click(function () {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function () {
		var $this = $(this);
		$this.click(function () {
			calendar.view($this.data('calendar-view'));
		});
	});

	$('#first_day').change(function () {
		var value = $(this).val();
		value     = value.length ? parseInt(value) : null;
		calendar.setOptions({first_day: value});
		calendar.view();
	});

	$('#language').change(function () {
		calendar.setLanguage($(this).val());
		calendar.view();
	});
	/*recherche*/
	$('.delete_me').click(function (e) {
		e.preventDefault();
		$("#delete_langue_r_" + $(this).attr("lid")).remove();
		$("#delete_langue_input_" + $(this).attr("lid")).remove();
	});
	$('#select_lang_r').change(function () {
		var value = $(this).val();
		var name  = $('#select_lang_r option:selected').text();

		$("#delete_langue_r_" + value).remove();
		$("#delete_langue_input_" + value).remove();

		$(".sp_langues1").append("<span class='delete_me' lid='" + value + "' id='delete_langue_r_" + value + "'>" + name + " <i class='ion-android-close'></i></span>  <input id='delete_langue_input_" + value + "'  type='hidden' value='" + value + "' name='langues[]' >");
		$('.delete_me').click(function (e) {
			e.preventDefault();
			$("#delete_langue_r_" + $(this).attr("lid")).remove();
			$("#delete_langue_input_" + $(this).attr("lid")).remove();
		});
	});
	/*tag*/
	$('#select_tag').change(function () {
		var value = $(this).val();
		var name  = $('#select_tag option:selected').text();

		$("#delete_tag_" + value).remove();
		$("#delete_tag_input_" + value).remove();

		$(".sp_tag").append("<span class='delete_me1' lid='" + value + "' id='delete_tag_" + value + "'>" + name + " <i class='ion-android-close'></i></span>  <input id='delete_tag_input_" + value + "'  type='hidden' value='" + value + "' name='tag[]' >");
		$('.delete_me1').click(function (e) {
			e.preventDefault();
			$("#delete_tag_" + $(this).attr("lid")).remove();
			$("#delete_tag_input_" + $(this).attr("lid")).remove();
		});
	});

	$('.delete_me1').click(function (e) {
		e.preventDefault();
		$("#delete_tag_" + $(this).attr("lid")).remove();
		$("#delete_tag_input_" + $(this).attr("lid")).remove();
	});
	/*disponibiliter cours*/
	$('#disp_week_and_soir').click(function (e) {
		e.preventDefault();
		$('.check_disp').attr("checked", false);
		$('.horaire_td').removeClass('active');
		/*check all soir*/
		$('input.check_disp[name=lundi_18_20]').prop("checked", true);
		$('input.check_disp[name=lundi_18_20]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=mardi_18_20]').prop("checked", true);
		$('input.check_disp[name=mardi_18_20]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=mercredi_18_20]').prop("checked", true);
		$('input.check_disp[name=mercredi_18_20]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=jeudi_18_20]').prop("checked", true);
		$('input.check_disp[name=jeudi_18_20]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=vendredi_18_20]').prop("checked", true);
		$('input.check_disp[name=vendredi_18_20]').closest(".horaire_td").addClass('active');


		$('input.check_disp[name=lundi_20_22]').prop("checked", true);
		$('input.check_disp[name=lundi_20_22]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=mardi_20_22]').prop("checked", true);
		$('input.check_disp[name=mardi_20_22]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=mercredi_20_22]').prop("checked", true);
		$('input.check_disp[name=mercredi_20_22]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=jeudi_20_22]').prop("checked", true);
		$('input.check_disp[name=jeudi_20_22]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=vendredi_20_22]').prop("checked", true);
		$('input.check_disp[name=vendredi_20_22]').closest(".horaire_td").addClass('active');


		$('input.check_disp[name=samedi_8_10]').prop("checked", true);
		$('input.check_disp[name=samedi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_10_12]').prop("checked", true);
		$('input.check_disp[name=samedi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_12_14]').prop("checked", true);
		$('input.check_disp[name=samedi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_14_16]').prop("checked", true);
		$('input.check_disp[name=samedi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_16_18]').prop("checked", true);
		$('input.check_disp[name=samedi_16_18]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_18_20]').prop("checked", true);
		$('input.check_disp[name=samedi_18_20]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=samedi_20_22]').prop("checked", true);
		$('input.check_disp[name=samedi_20_22]').closest(".horaire_td").addClass('active');


		$('input.check_disp[name=dimanche_8_10]').prop("checked", true);
		$('input.check_disp[name=dimanche_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_10_12]').prop("checked", true);
		$('input.check_disp[name=dimanche_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_12_14]').prop("checked", true);
		$('input.check_disp[name=dimanche_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_14_16]').prop("checked", true);
		$('input.check_disp[name=dimanche_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_16_18]').prop("checked", true);
		$('input.check_disp[name=dimanche_16_18]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_18_20]').prop("checked", true);
		$('input.check_disp[name=dimanche_18_20]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=dimanche_20_22]').prop("checked", true);
		$('input.check_disp[name=dimanche_20_22]').closest(".horaire_td").addClass('active');

	});
	$('#disp_horaire_tavail').click(function (e) {
		e.preventDefault();
		$('.check_disp').attr("checked", false);
		$('.horaire_td').removeClass('active');
		/*check all soir*/
		$('input.check_disp[name=lundi_8_10]').prop("checked", true);
		$('input.check_disp[name=lundi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=lundi_10_12]').prop("checked", true);
		$('input.check_disp[name=lundi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=lundi_12_14]').prop("checked", true);
		$('input.check_disp[name=lundi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=lundi_14_16]').prop("checked", true);
		$('input.check_disp[name=lundi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=lundi_16_18]').prop("checked", true);
		$('input.check_disp[name=lundi_16_18]').closest(".horaire_td").addClass('active');


		$('input.check_disp[name=mardi_8_10]').prop("checked", true);
		$('input.check_disp[name=mardi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mardi_10_12]').prop("checked", true);
		$('input.check_disp[name=mardi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mardi_12_14]').prop("checked", true);
		$('input.check_disp[name=mardi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mardi_14_16]').prop("checked", true);
		$('input.check_disp[name=mardi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mardi_16_18]').prop("checked", true);
		$('input.check_disp[name=mardi_16_18]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=mercredi_8_10]').prop("checked", true);
		$('input.check_disp[name=mercredi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mercredi_10_12]').prop("checked", true);
		$('input.check_disp[name=mercredi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mercredi_12_14]').prop("checked", true);
		$('input.check_disp[name=mercredi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mercredi_14_16]').prop("checked", true);
		$('input.check_disp[name=mercredi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=mercredi_16_18]').prop("checked", true);
		$('input.check_disp[name=mercredi_16_18]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=jeudi_8_10]').prop("checked", true);
		$('input.check_disp[name=jeudi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=jeudi_10_12]').prop("checked", true);
		$('input.check_disp[name=jeudi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=jeudi_12_14]').prop("checked", true);
		$('input.check_disp[name=jeudi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=jeudi_14_16]').prop("checked", true);
		$('input.check_disp[name=jeudi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=jeudi_16_18]').prop("checked", true);
		$('input.check_disp[name=jeudi_16_18]').closest(".horaire_td").addClass('active');

		$('input.check_disp[name=vendredi_8_10]').prop("checked", true);
		$('input.check_disp[name=vendredi_8_10]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=vendredi_10_12]').prop("checked", true);
		$('input.check_disp[name=vendredi_10_12]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=vendredi_12_14]').prop("checked", true);
		$('input.check_disp[name=vendredi_12_14]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=vendredi_14_16]').prop("checked", true);
		$('input.check_disp[name=vendredi_14_16]').closest(".horaire_td").addClass('active');
		$('input.check_disp[name=vendredi_16_18]').prop("checked", true);
		$('input.check_disp[name=vendredi_16_18]').closest(".horaire_td").addClass('active');
	});

	$('#events-in-modal').change(function () {
		var val = $(this).is(':checked') ? $(this).val() : null;
		calendar.setOptions({modal: val});
	});
	$('#format-12-hours').change(function () {
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({format12: val});
		calendar.view();
	});
	$('#show_wbn').change(function () {
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({display_week_numbers: val});
		calendar.view();
	});
	$('#show_wb').change(function () {
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({weekbox: val});
		calendar.view();
	});

	$("#recupererMonPassword").submit(function () {
		var input = $("#recupererMonPassword :input[name='email']").val();
		if (input == "") {
			$(".erreur_recuperer").html("Merci d'entrer une adresse email.");
			$(".erreur_recuperer").show();
			setTimeout(function () {
				$(".erreur_recuperer").hide();
			}, 6000);
			return false;
		}
		var re       = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		var is_email = re.test(input);
		if (!is_email) {
			$(".erreur_recuperer").html("Merci de verifier votre email.");
			$(".erreur_recuperer").show();
			setTimeout(function () {
				$(".erreur_recuperer").hide();
			}, 6000);
			return false;
		}

		$.ajax({
			type: "POST",
			url: base_url + "auth/recuperer",
			data: {email: input, csrf_token_name: csrf_token}, // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$(".erreur_recuperer").html(json.msg);
				$(".erreur_recuperer").show();
				if (json.status == 'ok') {
					$("#recupererMonPassword").hide();
				}
				return false;
			}
		});
		return false;
	});


	$(".numericOnly").keypress(function (e) {
		if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
	});
	/*reinitialiser*/

	$("#reinitialiserPassword").submit(function () {
		var nouveau_p      = $("#reinitialiserPassword").find('input[name="nouveau_p"]').val();
		var confirmation_p = $("#reinitialiserPassword").find('input[name="confirmation_p"]').val();
		if (nouveau_p == "" || confirmation_p == "") {
			$(".erreur_reinitialiser").html("Merci de remplir tous les champs.");
			$(".erreur_reinitialiser").show();
			setTimeout(function () {
				$(".erreur_reinitialiser").hide();
			}, 6000);
			return false;
		}
		if (nouveau_p.length < 5) {
			$(".erreur_reinitialiser").html("Minimum 5 caractére.");
			$(".erreur_reinitialiser").show();
			setTimeout(function () {
				$(".erreur_reinitialiser").hide();
			}, 6000);
			return false;
		}
		if (nouveau_p != confirmation_p) {
			$(".erreur_reinitialiser").html("La confirmation.");
			$(".erreur_reinitialiser").show();
			setTimeout(function () {
				$(".erreur_reinitialiser").hide();
			}, 6000);
			return false;
		}

		$.ajax({
			type: "POST",
			url: base_url + "auth/do_reinitialiser",
			data: $("#reinitialiserPassword").serialize(), // serializes the form's elements.
			dataType: 'json',
			success: function (json) {
				$(".erreur_reinitialiser").html(json.msg);
				$(".erreur_reinitialiser").show();
				// $('#ModalConnexion').modal('show');
				window.location.href = base_url + "compte";
				return false;
			}
		});
		return false;
	});

	/* cookie Hamon */
	if (readCookie('hamon') == null) {
		$('.hamon').show();
	}


});


function modifierVersement() {
	$(".btn_add").show();
	$(".btn_update").hide();
}

function verified_bd_email(email) {

	$.ajax({
		type: "POST",
		url: base_url + "inscription/verified_email",
		data: {email: email}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			return json.on;
		}
	});
}

function hide_btn_inscription() {
	$(".chargement_b").show();
	$(".borde_b").hide();
}

function show_btn_inscription() {
	$(".chargement_b").hide();
	$(".borde_b").show();
}

/*function inscription*/
function gotoinscription() {
	hide_btn_inscription();
	if (!verification_input()) {
		show_btn_inscription()
		$(".etap1_error").html("Merci de remplir tous les champs");
		$(".etap1_error").show();
		setTimeout(function () {
			$(".etap1_error").show();
		}, 6000);
		return false;
	}
	var input    = $("#formEtape1").find('input[name="email"]').val();
	var re       = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var is_email = re.test(input);
	if (is_email) {
	} else {
		show_btn_inscription()
		$(".etap1_error").html("Votre adresse E-Mail n'a pas un format valide.");
		$(".etap1_error").show();
		setTimeout(function () {
			$(".etap1_error").hide();
		}, 6000);
		return false;
	}
	$.ajax({
		type: "POST",
		url: base_url + "inscription/verified_email",
		data: {email: input, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			if (json.on == 'on') {
				show_btn_inscription();
				$(".etap1_error").html("Votre adresse email est déjà utilisée par un membre.");
				$(".etap1_error").show();
				setTimeout(function () {
					$(".etap1_error").hide();
				}, 6000);
				return false;
			} else {

				data    = $('#paswrd').val();
				var len = data.length;
				if (len < 3) {
					show_btn_inscription();
					setTimeout(function () {
						$(".etap1_error").html("Minimum 3 caractére.");
						$(".etap1_error").show();
					}, 6000);
					return false;
					event.preventDefault();
				}

				$('#ModalInscription').modal('hide');
				show_btn_inscription();
				$('#ModalInscriptionStep2').modal('show');
			}
		}
	});

}

function verification_input() {
	var error = false;
	$("#formEtape1 :input.required").each(function () {
		if ($.trim($(this).val()) == "") {
			$(this).removeClass("valid").addClass("invalid");
			error = true;
		}
	});
	if (error) {
		return false;
	} else {
		return true;
	}
}

function verification_input_etap2() {
	var error = false;
	$("#formEtape2 :input.required").each(function () {
		if ($.trim($(this).val()) == "") {
			$(this).removeClass("valid").addClass("invalid");
			error = true;
		}
	});
	if (error) {
		return false;
	} else {
		return true;
	}
}

function date_naissance_insc() {
	if (!verification_input_etap2()) {
		$(".etap2_error").html("Merci de remplir tous les champs");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}
	if (!$('input.checkbox_ins').is(':checked')) {
		$(".etap2_error").html("Merci de valider les conditions générales.");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}
	$('#ModalInscriptionStep2').modal('hide');
	$('#ModalInscriptionStep3').modal('show');
}

function submit_before_terminer() {
	if (!verification_input_etap2()) {
		$(".etap2_error").html("Merci de remplir tous les champs");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}
	if (!$('input.checkbox_ins').is(':checked')) {
		$(".etap2_error").html("Merci de valider les conditions générales.");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}

	$('#ModalInscriptionStep2').modal('hide');
	$('#ModalInscriptionSteptEL').modal('show');

}

function Terminer() {
	if (!verification_input_etap2()) {
		$(".etap2_error").html("Merci de remplir tous les champs");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}
	if (!$('input.checkbox_ins').is(':checked')) {
		$(".etap2_error").html("Merci de valider les conditions générales.");
		$(".etap2_error").show();
		setTimeout(function () {
			$(".etap2_error").show();
		}, 6000);
		return false;
	}
	$(".chargement_b").show();
	$(".terminer_b").hide();
	var data_post = $("#formEtape1,#formEtape2,#formEtape3").serialize();
	$.ajax({
		type: "POST",
		url: base_url + "inscription/verfy",
		data: data_post, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			if (json.erreur == "off") {
				$(".chargement_b").hide();
				$(".terminer_b").show();
				$('#ModalInscriptionStep2').modal('hide');
				$('#ModalInscriptionSteptEL').modal('hide');
				$('#modalAfterInscription').modal('show');
				if ($(".action_to_d").val() == "devenir") {
					location.href = base_url + "mentor";
				}
			}
		}
	});
}

//form login
function gotosubmitLogin() {
	if ($("#email_login").val() == "" || $("#password_login").val() == "") {
		$(".erreur_connexion").html("Merci de remplir tous les champs.");
		$(".erreur_connexion").show();
		setTimeout(function () {
			$(".erreur_connexion").hide();
		}, 6000);
		return false;
	}
	var input    = $("#email_login").val();
	var re       = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var is_email = re.test(input);
	if (is_email) {
	} else {
		$(".erreur_connexion").html("Votre adresse E-Mail n'a pas un format valide.");
		$(".erreur_connexion").show();
		setTimeout(function () {
			$(".erreur_connexion").hide();
		}, 6000);
		return false;
	}
	$.ajax({
		type: "POST",
		url: base_url + "login/verfy",
		data: $("#form_login").serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			if (json.erreur == "on") {
				$(".erreur_connexion").html(json.msg);
				$(".erreur_connexion").show();
				setTimeout(function () {
					$(".erreur_connexion").hide();
				}, 6000);
				return false;
			} else if (json.erreur == "bloquer") {
				window.location.href = base_url + "bloquer";
			} else {
				if ($(".action_to_d").val() == "normal") {
					location.reload();
				} else {
					location.href = base_url + "mentor";
				}
			}
		}
	});
	return false;
}

function changeMypassword() {
	if ($("#nouveau").val() == "" || $("#confirmation").val() == "") {
		$("#erreur-change-password-profil").html('<p class="erreur_p">Merci de remplir tous les champs</p>');
		$("#erreur-change-password-profil").show();
		setTimeout(function () {
			$("#erreur-change-password-profil").hide();
		}, 6000);
		return false;
	}
	if ($("#nouveau").val() != $("#confirmation").val()) {
		$("#erreur-change-password-profil").html('<p class="erreur_p">Les mots de passe ne sont pas identiques</p>');
		$("#erreur-change-password-profil").show();
		setTimeout(function () {
			$("#erreur-change-password-profil").hide();
		}, 6000);
		return false;
	}
	$.ajax({
		type: "POST",
		url: base_url + "compte/change_password",
		data: $("#change-password-profil").serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$("#erreur-change-password-profil").html(json.msg);
			$("#erreur-change-password-profil").show();
		}
	});
	return false;
}

/*function langue*/
function supprimerLang(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_langue",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			//$('#ModalEditerDetail').modal('hide');
			$('#list_langues').html(json.html);
			$('.items_langues').html(json.html1);
			return false;
		}
	});
}

/*function langue*/
function wait_rechercher() {
	$('body').addClass('searching');
}

/*supprimer tag*/
function supprimerTag(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_tag",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			//$('#ModalEditerDetail').modal('hide');
			$('#list_tags').html(json.html);
			$('.tag').html(json.html1);
			return false;
		}
	});
}

/*function langue*/
function supprimerCategorie(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_categorie",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			//$('#ModalEditerDetail').modal('hide');
			$('#list_cat_html').html(json.html);
			$('.items_categories').html(json.html1);
			return false;
		}
	});
}

function supprimerMode(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_mode",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			//$('#ModalEditerDetail').modal('hide');
			$('#list_mode').html(json.html);
			$('.liste_oper').html(json.html1);
			return false;
		}
	});
}

function supprimerReference(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_reference",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$('#list_references').html(json.html);
			$('.items_reference').html(json.html1);
			return false;
		}
	});
}

function supprimerExperience(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_experience",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$('#list_experiences').html(json.html);
			$('.list_exp').html(json.html1);
			return false;
		}
	});
}

function supprimerPortfolio(id, talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/supprimer_portfolio",
		data: {id: id, talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$('#list_portfolio').html(json.html);
			return false;
		}
	});
}

function initializeClose() {
	$("#categorie").val("");
	$("#cat_id").val(0);
}

/*add  to favoris*/
function gotofavoris(talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/like_favoris",
		data: {talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			if (json.class == 'active') {
				$("#favoris_icon").addClass('active');
				$("#f_ico_co").addClass('fa-heart').removeClass("fa-heart-o");
				return false;
			} else {
				$("#favoris_icon").removeClass('active');
				$("#f_ico_co").addClass('fa-heart-o').removeClass("fa-heart");
			}
		}
	});
	return false;
}

function gotofavoris1(talent_id) {
	$.ajax({
		type: "POST",
		url: base_url + "profil/like_favoris",
		data: {talent_id: talent_id, csrf_token_name: csrf_token}, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			if (json.class == 'active') {
				$("#favoris_icon1").addClass('active');
				$("#f_ico_co1").addClass('fa-heart').removeClass("fa-heart-o");
				return false;
			} else {
				$("#favoris_icon1").removeClass('active');
				$("#f_ico_co1").addClass('fa-heart-o').removeClass("fa-heart");
			}
		}
	});
	return false;
}

$('.coverture_item').click(function () {
	$('.coverture_item').removeClass('active');
	$(this).addClass('active');
	$(this).find('input[type=radio]').prop('checked', true);
});
$('.link_talent').click(function () {
	$(".action_to_d").val("devenir");
});
$("#changeCovertureProfile").submit(function () {
	$.ajax({
		type: "POST",
		url: base_url + "compte/change_coverture",
		data: $(this).serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			location.reload();
		}
	});
	return false;
});
$("#changeCovertureTalent").submit(function () {
	$.ajax({
		type: "POST",
		url: base_url + "compte/change_coverture_talent",
		data: $(this).serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			location.reload();
		}
	});
	return false;
});
/*for callendar*/
$("#formAddIndisponible").submit(function () {
	if ($("#date").val() == "" || $("#titre_indi").val() == "") {
		$(".editer_t_error").html("Merci de remplir tous les champs");
		$(".editer_t_error").show();
		setTimeout(function () {
			$(".editer_t_error").show();
		}, 6000);
		return false;
	}
	$(".chargement_b").show();
	$(".button_su").hide();
	$.ajax({
		type: "POST",
		url: base_url + "calendrier/add_indisponible",
		data: $("#formAddIndisponible").serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$(".chargement_b").hide();
			$(".button_su").show();
			$('.sendButtonport').attr('disabled', false);
			location.reload();
			return false;
		}
	});
	return false;
});
$("#formEditerTalentPrix").submit(function () {
	if (!verification_input_talent1()) {
		$(".editer_t_error").html("Merci de remplir tous les champs");
		$(".editer_t_error").show();
		setTimeout(function () {
			$(".editer_t_error").show();
		}, 6000);
		return false;
	}
	$(".chargement_b").show();
	$(".button_su").hide();
	$.ajax({
		type: "POST",
		url: base_url + "profil/editer_talent_prix",
		data: $("#formEditerTalentPrix").serialize(), // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$(".chargement_b").hide();
			$(".button_su").show();
			$('.sendButtonport').attr('disabled', false);
			location.reload();
			return false;
		}
	});
	return false;
});
$("#formEditerTalent").submit(function () {
	if (!verification_input_talent()) {
		$(".editer_t_error").html("Merci de remplir tous les champs");
		$(".editer_t_error").show();
		setTimeout(function () {
			$(".editer_t_error").show();
		}, 6000);
		return false;
	}


	$(".chargement_b").show();
	$(".button_su").hide();
	var fd = new FormData();


	fd.append('file', $('#file')[0].files[0]);


	var obj    = $(this);
	var params = $(obj).serializeArray();
	$.each(params, function (i, val) {
		fd.append(val.name, val.value);
	});
	$.ajax({
		type: "POST",
		processData: false,
		contentType: false,
		url: base_url + "profil/editer_talent",
		data: fd, // serializes the form's elements.
		dataType: 'json',
		success: function (json) {
			$(".chargement_b").hide();
			$(".button_su").show();
			$('.sendButtonport').attr('disabled', false);
			location.reload();
			return false;
		}
	});
	return false;
});

function verification_input_talent() {
	var error = false;
	$("#formEditerTalent :input.required").each(function () {
		if ($.trim($(this).val()) == "") {
			$(this).removeClass("valid").addClass("invalid");
			error = true;
		}
	});
	if (error) {
		return false;
	} else {
		return true;
	}
}

function verification_input_talent1() {
	var error = false;
	$("#formEditerTalentPrix :input.required").each(function () {
		if ($.trim($(this).val()) == "") {
			$(this).removeClass("valid").addClass("invalid");
			error = true;
		}
	});
	if (error) {
		return false;
	} else {
		return true;
	}
}

function ConfirmationMonNumero() {
	$.ajax({
		type: "POST",
		url: base_url + "compte/confirmation_phone",
		data: {status: "ok", csrf_token_name: csrf_token},
		dataType: 'json',
		success: function (json) {
			if (json.status == "ok") {
				$('.tel_form').show();
				$('.info_tel').hide();
			}
			return false;
		}

	});
	return false;
}


function getAutorization(id) {
	$("#id_dislike_favoris").attr("href", base_url + "mes_activites/dislike_favoris/" + id);
	$('#modalConfirmationDisliketalent').modal('show');
}

function validate() {
	$("#file_error").html("");
	$("#file").css("border-color", "#F0F0F0");
	var file_size = $('#file')[0].files[0].size;
	if (file_size > 2097152) {
		$("#file_error").html("Taille du fichier est supérieure à 2 Mo");
		$("#file").css("border-color", "#FF0000");
		$('#file').val('');
		return false;
	}
	return true;
}

function validate_portfolio() {
	$("#file_error").html("");
	$("#fileportfolio").css("border-color", "#F0F0F0");
	var file_size = $('#fileportfolio')[0].files[0].size;
	if (file_size > 2097152) {
		$("#file_error").html("Taille du fichier est supérieure à 2 Mo");
		$("#fileportfolio").css("border-color", "#FF0000");
		$('#fileportfolio').val('');
		return false;
	}
	return true;
}

function verification_telephone_sociaux() {
	if ($("#numero_de_tel").val() == '' || $("#numero_de_tel").val().length != 9) {
		alert('Merci d\'entrer valide téléphone');
		return false;
	}
	var data_post = $("#formEtape3").serialize();
	$.ajax({
		type: "POST",
		url: base_url + "compte/do_confirmer_phone_sociaux",
		data: data_post,
		dataType: 'json',
		success: function (json) {
			if (json.status == "ok") {
				location.reload();
			}
		}
	});

}


function bolckerMonCompte() {
	if ($("#raison_f").val().trim() == "") {
		$("#raison_f").addClass('error_validation');
		setTimeout(function () {
			$("#raison_f").removeClass('error_validation');
		}, 6000);
		return false;
	} else if ($("#ameliorer_f").val().trim() == "") {
		$("#ameliorer_f").addClass('error_validation');
		setTimeout(function () {
			$("#ameliorer_f").removeClass('error_validation');
		}, 6000);
		return false;
	} else {
		$('#modalFermetureCompte').modal('show');
	}
}

function dofermetureMonCompte() {
	if ($("#pass_confirmation").val() == '') {
		return false;
	}
	var data_post = {password: "test", raisons: $("#raison_f").val(), ameliorer: $("#ameliorer_f").val(), recomandation: $('.checkbox .recomandation_cowanted').val(), csrf_token_name: csrf_token};
	$.ajax({
		type: "POST",
		url: base_url + "compte/fermer_mon_compte",
		data: data_post,
		dataType: 'json',
		success: function (json) {
			if (json.status == "ok") {
				location.reload();
			} else if (json.status == "no") {
				$(".msg").html(json.msg);
			} else {
				$(".msg").html(json.msg);
			}
		}
	});

}

$('.btn-share-with-freind').click(function () {
	$("#modal-partage").modal('hide');
	$(".msg_error").hide();
	$("#form-share-it").show();
	$(".close_after").hide();
	$("#modal-add-share-with-freind").modal('show');
});
$('.bt-submit-share-with-freind').click(function () {
	if ($("#form-share-it").find("input[name='name_user']").val() == "") {
		$(".msg_error").text("Please enter your name.").show().fadeOut(7000);
		return false;
	}
	if (!isEmail($("#form-share-it").find("input[name='to']").val())) {
		$(".msg_error").text("Please enter a valid email address.").show().fadeOut(7000);
		return false;
	}
	if (!isEmail($("#form-share-it").find("input[name='from']").val())) {
		$(".msg_error").text("Please enter a valid email address.").show().fadeOut(7000);
		return false;
	}
	$.ajax({
		type: "POST",
		url: base_url + "login/share",
		data: $("#form-share-it").serialize(),
		dataType: 'json',
		success: function (json) {
			$(".msg_error").text("Thank you.").show();
			$("#form-share-it").hide();
			$(".close_after").show();

		}
	});
	return false;

});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

/* navbar si mobile ou pas */
if ($(window).width() < 768) {
	$(window).scroll(function () {
		if (!$('.nav-top').hasClass("h_r_comp")) {
			if ($(document).scrollTop() == 0) {
				$('.navbar-header').removeClass('h_fixed');
				$('.navbar-brand img').attr('src', base_url + 'assets/img/logo.png');
			} else {
				$('.navbar-header').addClass('h_fixed');
				$('.navbar-brand img').attr('src', base_url + 'assets/img/logo_2.png');
			}
		}
		if ($(document).scrollTop() > 330) {
			$('.tab_nav_profil.bar_prof_fixed').show();
		} else {
			$('.tab_nav_profil.bar_prof_fixed').hide();
		}
	});
} else {
	$(window).scroll(function () {
		if (!$('.nav-top').hasClass("h_r_comp")) {
			if ($(document).scrollTop() == 0) {
				$('.search_row').removeClass('navbar-fixed-top');
				$('.nav-top').removeClass('h_fixed');
				$('.submenu').removeClass('h_fixed');
				$('.navbar-brand img').attr('src', base_url + 'assets/img/logo.png');
			} else {
				$('.search_row').addClass('navbar-fixed-top');
				$('.nav-top').addClass('h_fixed');
				$('.submenu').addClass('h_fixed');
				$('.navbar-brand img').attr('src', base_url + 'assets/img/logo_2.png');
			}
		}
		if ($(document).scrollTop() > 330) {
			$('.tab_nav_profil.bar_prof_fixed').show();
		} else {
			$('.tab_nav_profil.bar_prof_fixed').hide();
		}
	});
}


/**
 *
 * @param id_form
 * @returns {boolean}
 */
function sendForm(id_form) {
	var $form  = $('#' + id_form);
	var retour = true;
	if ($form.length < 1)
		return false;

	/* check inputs */
	$form.find('.required').removeClass('invalid');
	$form.find('.required').each(function () {
		if ($(this).val() == '') {
			$(this).addClass('invalid');
			retour = false;
		}
	});

	if (retour) {
		$form.submit();
	} else {
		bandeauError('Veuillez contrôler les champs.');
	}
}

/**
 *
 * @param message
 */
function bandeau(message) {
	$('.messenger').removeClass('messenger_error').find('.container').text(message);
	$("html, body").animate({scrollTop: 0}).promise().done(function () {
		$('.messenger').animate({
			opacity: "show",
			top: 0
		});
	});
	setTimeout(function () {
		closeMessenger();
	}, 15000);
}

/**
 *
 * @param message
 */
function bandeauError(message, gototop) {
	$('.messenger').addClass('messenger_error').find('.container').html(message);
	if (gototop !== undefined && gototop === false) {
		$('.messenger').animate({
			opacity: "show",
			top: 0
		});
	} else {
		$("html, body").animate({scrollTop: 0}).promise().done(function () {
			$('.messenger').animate({
				opacity: "show",
				top: 0
			});
		});
	}
	setTimeout(function () {
		closeMessenger();
	}, 15000);
}

/**
 *
 */
function closeMessenger() {
	$('.messenger').animate({
		top: '-500px'
	});
}


function postForm(class_name) {
	var $form          = $('.' + class_name);
	var bandeaumessage = false;
	var textError      = '';

	$form.find('textarea.required').each(function () {
		if ($(this).val() === '') {
			bandeaumessage = true;
			textError += 'Le champ ' + $(this).attr('name') + ' est obligatoire<br />';
			$(this).css('border', '1px solid #fc2727');
		}
	});

	$form.find('input.required').each(function () {
		if ($(this).val() === '') {
			bandeaumessage = true;
			textError += 'Le champ ' + $(this).attr('name') + ' est obligatoire<br />';
			$(this).css('border', '1px solid #fc2727');
		}
	});

	if (bandeaumessage) {
		bandeauError(textError, false);
	} else {
		$form.submit();
	}
}


function Formsearch() {
	$('#Formsearch input[type="checkbox"]').click(function () {
		var inputsChecked = $('#Formsearch input[type="checkbox"]:checked');
		if (inputsChecked.length > 0) {
			$('.block_right .mentorbox').hide();
			inputsChecked.each(function () {
				var nameCheckbox  = $(this).attr('name');
				var valueCheckbox = $(this).val();
				if (nameCheckbox === 'university') {
					var $filtercheck = $('.block_right .mentorbox[rel-filter-' + nameCheckbox + ']');
					$filtercheck.each(function () {
						var valueFilter = $(this).attr('rel-filter-' + nameCheckbox);
						if (valueFilter.indexOf(valueCheckbox) > -1) {
							$(this).show();
						}
					});
				} else {
					$('.block_right .mentorbox[rel-filter-' + nameCheckbox + '="' + valueCheckbox + '"]').show();
				}
			});
		} else {
			$('.block_right .mentorbox').show();
		}

		var nb_mentors = $('.block_right .mentorbox:visible').length;
		var textmentor = nb_mentors > 1 ? ' mentors' : ' mentor';

		$('.col-md-7.p_title_relt b').text(nb_mentors + textmentor);
	});
}

function SendPostRDV() {
	$.ajax({
		type: "POST",
		url: base_url + "profil/add_reservation",
		data: $("#formReservation").serialize(), // serializes the form's elements.
		dataType: 'json',
		beforeSend: function () {
			$('#ModalConfirmRDV').modal('toggle');
		},
		success: function (json) {
			$('#modalADDdemandeConfirmationajoutDEmande').modal('show');
			$('.horaire_td.active').removeClass('active').addClass('disabled');
			$("#button_reservation").addClass("me_reserv").prop("disabled", true);
			return false;
		}
	});
	return false;
}

function SendPostNoMentor() {
	var $text_entreprise = $("#f_nomentor input[name=entreprise]");
	var $text_poste      = $("#f_nomentor input[name=poste]");
	var continue_        = true;
	$("#f_nomentor .error").remove();
	if ($text_entreprise.val() == '') {
		$text_entreprise.after('<div class="error">Veuillez renseigner une entreprise.</div>');
		continue_ = false;
	}
	if ($text_poste.val() == '') {
		$text_poste.after('<div class="error">Veuillez renseigner un poste.</div>');
		continue_ = false;
	}

	if (continue_) {
		$.ajax({
			type: "POST",
			url: base_url + "recherche/nomentor",
			data: $("#f_nomentor").serialize(),
			success: function (json) {
				$('#ModalNoFindMentor .modal-body').html('<h3 style="margin-bottom: 20px;">Votre message a été envoyé aux équipes Ulyss.co</h3>' +
					'<a href="#" class="btn_style_send inlineblock" onclick="$(\'#ModalNoFindMentor .close\').click();return false;">OK</a>');
			}
		});
	}
}

/**
 *
 * @param $this
 * @param id_quest
 * @returns {boolean}
 */
function nextQuestion($this, id_quest) {
	var formulaire     = $this.closest('form');
	var activeQuestion = parseInt(id_quest) - 1;
	formulaire.find('.error').remove();

	/* Question 1 */
	if (activeQuestion === 1) {
		if (formulaire.find('select[name="entreprise"]').val() < 1) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez sélectionner une entreprise.</div>');
			return false;
		}
	} else if (activeQuestion === 2) {
		if (formulaire.find('input[name="entInnovante"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 3) {
		if (formulaire.find('input[name="ecouteCollabo"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 4) {
		if (formulaire.find('input[name="goodconditions"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 5) {
		if (formulaire.find('input[name="ambianceEnt"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 6) {
		if (formulaire.find('input[name="evolutionEnt"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 7) {
		if (formulaire.find('input[name="valoriseCollabo"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 8) {
		if (formulaire.find('input[name="remuneration"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 9) {
		if (formulaire.find('input[name="integration_entreprise"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 10) {
		if (formulaire.find('input[name="recommandation"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	}

	formulaire.find('.question' + activeQuestion).fadeOut(250).promise().done(function () {
		formulaire.find('.question' + id_quest).fadeIn(250);
	});
}

/**
 *
 * @param $this
 * @param id_quest
 */
function prevQuestion($this, id_quest) {
	var formulaire     = $this.closest('form');
	var activeQuestion = parseInt(id_quest) + 1;

	if (activeQuestion === 9) {
		if (formulaire.find('.question2 input[name="entInnovante"]:checked').val() === '0') {
			id_quest = 2;
		} else if (formulaire.find('.question4 input[name="goodconditions"]:checked').val() === '0') {
			id_quest = 4;
		}
	}

	formulaire.find('.question' + activeQuestion).fadeOut(250).promise().done(function () {
		formulaire.find('.question' + id_quest).fadeIn(250);
	});
}

/**
 *
 * @param $this
 */
function showComplementQuestion4($this) {
	var formulaire = $this.closest('form');
	var $question  = $this.closest('.questions');
	formulaire.find('.error').remove();
	if (formulaire.find('input[name="knowentreprise_evolution"]:checked').val() === '1') {
		$question.find('.complement').fadeIn(250);
	} else {
		$question.find('.complement').fadeOut(250);
	}
}

/**
 *
 * @param $this
 */
function showComplementQuestion7($this) {
	var formulaire = $this.closest('form');
	var $question  = $this.closest('.questions');
	formulaire.find('.error').remove();
	if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === '0') {
		$question.find('.complement').fadeIn(250);
	} else {
		$question.find('.complement').fadeOut(250);
	}
}

/**
 *
 * @returns {boolean}
 */
function validQuest($this) {
	var formulaire        = $this.closest('form');
	var box_questionnaire = formulaire.closest('.f_reservation');

	if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === undefined) {
		formulaire.find('.question7').find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
		return false;
	} else if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === '0' && formulaire.find('textarea[name="recommandation_ulyss_non"]').val() === '') {
		formulaire.find('.question7').find('.buttons').before('<div class="error" style="margin-top: 10px">Aidez nous en precisant votre choix.</div>');
		return false;
	}

	$.ajax({
		type: "POST",
		url: formulaire.attr('action'),
		data: formulaire.serialize(),
		success: function (response) {
			goToByScroll(box_questionnaire, 80);
			box_questionnaire.html('<span class="thx_questions" style="font-size: 16px;text-align: center;display: block;">Merci d\'avoir pris le temps de répondre !</span>')
			setTimeout(function () {
				box_questionnaire.fadeOut().promise().done(function () {
					box_questionnaire.remove();
					$("html, body").animate({scrollTop: 0});
				});
			}, 2000);
		}
	});
}

/**
 *
 * @param $this
 * @param id_quest
 * @returns {boolean}
 */
function nextQuestionMentor($this, id_quest) {
	var formulaire     = $this.closest('form');
	var activeQuestion = parseInt(id_quest) - 1;
	formulaire.find('.error').remove();

	/* Question 1 */
	if (activeQuestion === 1) {
		if (formulaire.find('input[name="issetrdv"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		}
	} else if (activeQuestion === 2) {
		console.log(formulaire.find('textarea[name="experience_globale_non"]').val());
		if (formulaire.find('input[name="experience_globale"]:checked').val() === undefined) {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		} else if ((formulaire.find('input[name="experience_globale"]:checked').val() === 'Pas du tout satisfait' || formulaire.find('input[name="experience_globale"]:checked').val() === 'Pas satisfait') && formulaire.find('textarea[name="experience_globale_non"]').val() === '') {
			formulaire.find('.question' + activeQuestion).find('.buttons').before('<div class="error" style="margin-top: 10px">Aidez nous en precisant votre choix.</div>');
			return false;
		}
	}

	formulaire.find('.question' + activeQuestion).fadeOut(250).promise().done(function () {
		formulaire.find('.question' + id_quest).fadeIn(250);
	});
}

/**
 *
 * @param $this
 * @param id_quest
 */
function prevQuestionMentor($this, id_quest) {
	var formulaire     = $this.closest('form');
	var activeQuestion = parseInt(id_quest) + 1;

	formulaire.find('.question' + activeQuestion).fadeOut(250).promise().done(function () {
		formulaire.find('.question' + id_quest).fadeIn(250);
	});
}

/**
 *
 * @param $this
 */
function showComplementQuestion2mentor($this) {
	var formulaire = $this.closest('form');
	var $question  = $this.closest('.questions');
	formulaire.find('.error').remove();
	if (formulaire.find('input[name="experience_globale"]:checked').val() === 'Pas du tout satisfait' || formulaire.find('input[name="experience_globale"]:checked').val() === 'Pas satisfait') {
		$question.find('.complement').fadeIn(250);
	} else {
		$question.find('.complement').fadeOut(250);
	}
}

/**
 *
 * @param $this
 */
function showComplementQuestion3mentor($this) {
	var formulaire = $this.closest('form');
	var $question  = $this.closest('.questions');
	formulaire.find('.error').remove();
	if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === '0') {
		$question.find('.complement').fadeIn(250);
	} else {
		$question.find('.complement').fadeOut(250);
	}
}

/**
 *
 * @returns {boolean}
 */
function validQuestMentor($this) {
	var formulaire        = $this.closest('form');
	var box_questionnaire = formulaire.closest('.f_reservation');
	var $question         = $this.closest('.questions');

	if ($question.hasClass('question3')) {
		if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === undefined) {
			formulaire.find('.question3').find('.buttons').before('<div class="error" style="margin-top: 10px">Veuillez choisir une réponse.</div>');
			return false;
		} else if (formulaire.find('input[name="recommandation_ulyss"]:checked').val() === '0' && formulaire.find('textarea[name="recommandation_ulyss_non"]').val() === undefined) {
			formulaire.find('.question3').find('.buttons').before('<div class="error" style="margin-top: 10px">Aidez nous en precisant votre choix.</div>');
			return false;
		}
	}

	$.ajax({
		type: "POST",
		url: formulaire.attr('action'),
		data: formulaire.serialize(),
		success: function () {
			goToByScroll(box_questionnaire, 80);
			box_questionnaire.html('<span class="thx_questions" style="font-size: 16px;text-align: center;display: block;">Merci d\'avoir pris le temps de répondre !</span>')
			setTimeout(function () {
				box_questionnaire.fadeOut().promise().done(function () {
					box_questionnaire.remove();
					$("html, body").animate({scrollTop: 0});
				});
			}, 2000);
		}
	});
}

function showFilters() {
	if ($('#Formsearch').is(':visible')) {
		$('.filterbtn').text('Voir les filtres');
		$('#Formsearch').slideUp();
	} else {
		$('.filterbtn').text('Masquer les filtres');
		$('#Formsearch').slideDown();
	}
}

/**
 *
 * @param id
 */
function goToByScroll($item, enleverhauteur) {
	var scrollpos = $item.offset().top;
	if (enleverhauteur)
		scrollpos = scrollpos - enleverhauteur;
	$('html,body').animate({scrollTop: scrollpos});
}

function socialNetworks() {
	$('a.sharefacebook').click(function () {
		window.open($(this).attr('data-rel'), 'sharer', 'toolbar=0,status=0,width=626,height=500');
		return false;
	});
	$('a.sharetwitter').click(function () {
		window.open($(this).attr('data-rel'), 'sharer', 'toolbar=0,status=0,width=626,height=500');
		return false;
	});
	$('a.sharelinkedin').click(function () {
		window.open($(this).attr('data-rel'), 'sharer', 'toolbar=0,status=0,width=626,height=500');
		return false;
	});
}

function voirplusrencherche($this) {
	$this.closest('.filter_search_ul').find('.checkbox_2').show();
	$this.hide();
}

function closeHamon() {
	createCookie('hamon', 'true', '30');
	$('.hamon').hide();
}

function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";

	document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca     = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name, "", -1);
}

