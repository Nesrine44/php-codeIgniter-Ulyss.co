/*entreprise liste employeur*/
$("#entreprise").on('click keyup', function () {
	if ($(this).val().length < 3) {
		$('.drop_list.drop_list_e').hide();
		return false;
	}

	$("#entreprise_id").val(0);
	$(".drop_list_e").show();

	$.ajax({
		type: "GET",
		url: base_url + "autocomplete/entreprise",
		data: 'entreprise=' + $(this).val(),
		dataType: 'json',
		beforeSend: function () {
			$("#entreprise_list").html("Chargement...");
		},
		success: function (data) {
			$("#entreprise_list").html("");
			if (data.length === 0) {
				var text = '<li>Aucun résultat trouvé</li>';
				$("#entreprise_list").append(text);
			}
			$.each(data, function (index, element) {
				var text = '<li class="auto_cat_e" item="' + element.value + '" item_id="' + element.id + '"><a href="#"> ' + element.value + '  <img src="' + element.logo + '" style="width:25px;height:25px;" border="0"/> </a></li>';
				$("#entreprise_list").append(text);
			});

			$('li.auto_cat_e').click(function (event) {
				event.preventDefault();
				$("#entreprise").val($(this).text());
				$("#entreprise_id").val($(this).attr('item_id'));
				$(".drop_list_e").hide();
			});


		}
	});
});
