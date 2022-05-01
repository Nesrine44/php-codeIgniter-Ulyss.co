<?php
/* @var $this CI_Loader */
/* @var $BusinessEntreprise BusinessEntreprise */
/* @var $BusinessUser BusinessUser */
?>

<head>
    <!--  CSS et JS pour le calendar     -->
    <link rel="stylesheet" href="/assets/css/fullcalendar.min.css"/>

    <script src="<?php echo base_url() ?>scripts/fullcalendar/lib/moment.min.js"></script>
    <script src="<?php echo base_url() ?>scripts/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?php echo base_url() ?>scripts/fullcalendar/gcal.js"></script>
    <script src='<?php echo base_url() ?>scripts/fullcalendar/locale/fr.js'></script>
    <!---------------------------------->
</head>
<div class="modal fade ent_mod" id="calendrierRdvModal" role="dialog">
    <div class="modal-dialog calendaroverflow">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="calendarLegend"><img src="/assets/img/glyphicons-stopGREEN.png" alt="rendez-vous terminé">Terminé <img src="/assets/img/glyphicons-stopYELLOW.png" alt="rendez-vous terminé"> En
                attente <img src="/assets/img/glyphicons-stopBLUE.png" alt="rendez-vous terminé"> Confirmé <img src="/assets/img/glyphicons-stopRED.png" alt="rendez-vous terminé">Annulé
            </div>
            <div id="calendar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar">
                                <!-- le calendar -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" language="javascript">

	$('.calendarModal').on("click", function () {
		$.ajax({
			type: "GET",
			url: base_url + "fragment/Calendar/get_events_ent",
			dataType: 'json',
			success: function (event) {
				$('#calendar').fullCalendar({
					eventLimit: true,
					textEscape: false,
					theme: true,
					themeSystem: 'bootstrap4',
					nowIndicator: true,
					header: {
						left: 'prev today next',
						center: 'title',
						right: 'month,agendaWeek,agendaDay listMonth',
					},
					buttonIcons: {
						prev: 'left-single-arrow',
						next: 'right-single-arrow',
					},
					minTime: "08:00:00",
					maxTime: "22:00:00",
					eventSources: [
						{
							color: '#6ba5c1',
							textColor: '#ffffff',
							events: event.V
						},
						{
							color: '#ff3f3f',
							textColor: '#ffffff',
							events: event.R
						},
						{
							color: '#ffbb3f',
							textColor: '#ffffff',
							events: event.A
						},
						{
							color: '#3f9f3f',
							textColor: '#ffffff',
							events: event.T
						}
					],
					eventRender: function (event, eventElement) {
						eventElement.popover({
							html: true,
							title: event.title,
							content: event.description,
							trigger: 'hover',
							placement: 'top',
							container: 'body',

						});

						if (event.imageurl) {
							eventElement.find("div.fc-content").prepend("<img src='" + event.imageurl + "' width='25' height='25' style='border-radius = 50px;' >");
						}
					}
				});
			}
		});
	});


</script>
