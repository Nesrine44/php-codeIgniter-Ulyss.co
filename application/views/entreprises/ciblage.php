<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 11/09/2018
 * Time: 14:17
 */
/* @var array $departements */
/* @var array $categories */
/* @var $BusinessEntreprise BusinessEntreprise */
?>
<script src="/assets/js/mapFrance/ammap.js"></script>
<script src="/assets/js/mapFrance/france2016High.js"></script>
<script src="/assets/js/mapFrance/frenchGuianaHigh.js"></script>
<script src="/assets/js/mapFrance/guadeloupeHigh.js"></script>
<script src="/assets/js/mapFrance/martiniqueHigh.js"></script>
<script src="/assets/js/mapFrance/reunionHigh.js"></script>
<script src="/assets/js/mapFrance/newCaledoniaHigh.js"></script>
<script src="/assets/js/mapFrance/light.js"></script>
<div class="modal fade ent_mod" id="ciblageModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h2>Sélectionnez les critères de mise en avant </h2>
            <h3>Choix des départements professionnel :</h3>

            <?php echo form_open('/entreprise/entreprises/ciblage', 'method="post"') ?>

            <input type="hidden" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>"/>
            <p>
                <?php foreach ($categories as $cat): ?>
                    <label for="cat<?php echo $cat->id; ?>"><input id="cat<?php echo $cat->id; ?>" type="checkbox" name="cat[]" value="<?php echo $cat->id; ?>"><span class="tag"><?php echo $cat->nom; ?></span></label>
                <?php endforeach ?></p>
            <h3>Choix des zones géographique :</h3>
            <input class="apigeo inputText mgb_30" autocomplete="off" name="region" id="cible_Region" type="text" placeholder="Ville / Région / Pays" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
            <div class="target_location"></div>

            <input type="submit" value="Valider">

            <?php echo form_close() ?>

        </div>
    </div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFtumB6p_lAaZk09zSpBCzkjyYJN-nuIE&libraries=places&callback=initAutocomplete"
        async defer>
</script>
<script type="text/javascript">
	var hideTag = document.getElementById('tagApi').hidden;

	function initAutocomplete() {

		geocoder = new google.maps.Geocoder();

		var mapFields = document.getElementsByClassName('apigeo');


		for (let i = 0; i < mapFields.length; i++) {
			let input            = mapFields[i];
			autocomplete         = new google.maps.places.Autocomplete(input, {types: ['(regions)']});
			autocomplete.inputId = input.id;
			autocomplete.addListener('place_changed', fillInAddress);
		}
	}

	function fillInAddress() {
		// Get the place details from the autocomplete object.

		var place    = autocomplete.getPlace();
		var location = place.formatted_address;
		var tab      = [location];
		console.log(location);

		// crée des <li> et stoquer les informaton dedans

		var text = '<div class="selected-element" item="" item_id="">';

		$('.target_location').html(text);
		console.log(place.address_components);
	}

</script>