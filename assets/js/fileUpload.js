$(function () {
// Configure Cloudinary
// with credentials available on
// your Cloudinary account dashboard
	$.cloudinary.config({cloud_name: 'rulyss777', api_key: '572468937947984'});
// Upload button
	var uploadButton = $('#submit');
// Upload button event
	uploadButton.on('click', function (e) {
		// Initiate upload
		cloudinary.openUploadWidget({cloud_name: 'rulyss777', upload_preset: 'aytg0vq0', tags: ['cgal']},
			function (error, result) {
				if (error) console.log(error);
				// If NO error, log image data to console
				var id = result[0].public_id;
				console.log(processImage(id));
			});
	});
})

function processImage(id) {
	var options = {
		client_hints: true,
	};
	return '<img src="' + $.cloudinary.url(id, options) + '" style="width: 100%; height: auto"/>';
}