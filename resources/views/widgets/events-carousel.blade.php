<div class="widget" data-widget="events-carousel">
<div id="events-carousel" class="carousel slide panel" data-ride="carousel">			
	<ol class="carousel-indicators dark out">
		<li class="active" data-slide-to="0" data-target="#events-carousel"></li>
		<li data-slide-to="1" data-target="#events-carousel"></li>
		<li class="" data-slide-to="2" data-target="#events-carousel"></li>
	</ol>
	<div class="carousel-inner dragzone">
	</div>
</div>
</div>

{{--Event carousel--}}
<script type="text/javascript" src="/assets/js/app/widgets/events-carousel.js"></script>
<script type="text/javascript">
	$(function () {
		var Events = function () {
			this.options = [];
			this.data = $.ajax({
				dataType: "json",
				data: {
					start: '1970-01-01',
					end: '2100-01-01'
				},
				type: "GET",
				url: "{{URL::route('api.calendar')}}",
				async: false
			}).responseText;
		};

		var events = new Events();
		var eventsCarousel = new EventsCarousel($('#events-carousel'), events);
	});
</script>