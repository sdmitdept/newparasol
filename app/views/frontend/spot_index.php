<div class="section map-container">
	<div class="skin-alert-container">
		<div class="skin-alert">
			<img src="<?php echo base_url('assets/images/mark.png') ?>" alt="">
			<h2>SKIN ALERT <b>BEAUTY SPOT</b></h2>
			<h3>Find all the beauty spot in Indonesia & know their skin danger level</h3>
		</div>
	</div>
	<div id="indonesia-map"></div>
	<div id="customTip">
		<div class="top" style="background-image:url('<?php echo base_url('assets/images/home-facts.jpg') ?>')">
			<h1 class="tipTemp"><img src="<?php echo base_url('assets/images/w-sunny.png') ?>"><span>32</span>°C</h1>
			<div class="tipPlace">
				<h2>Ora - Ora Beach</h2>
				<span class="small">Seram - Maluku</span>
			</div>
			<div class="tipDetail">
				<div class="table-container">
					<div class="inner">
						<span class="small">LEVEL</span> <br>
						<b>VERY HOT</b>
					</div>
					<div class="inner">
						SPF <span class="large">30+</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {


		var spots = [
			<?php foreach ($spots as $key => $value): ?>
			{
				name: '<?php echo $value->name ?>', 
				coords: [<?php echo $value->lat ?>, <?php echo $value->lon ?>], 
				city: '<?php echo $value->city ?>', 
				spf: '<?php echo $value->spf ?>',
				temp: '<?php echo number_format($value->temp,0) ?>',
				pic: '<?php echo base_url('uploads/places/r/600x300-'.$value->picture) ?>',
				status: 'mini'
			},
			<?php endforeach ?>
		]

		var map;


		map = new jvm.Map({
			container: $("#indonesia-map"),
			map: 'indonesia-adm1_merc',
			backgroundColor: '#299fdc',
			markers: spots.map(function(h) {
				return {name: h.name, latLng:h.coords}
			}),
			labels: {
				markers: {
					render: function(index) {
						return "";
					}
				}
			},
			series: {
				markers: [{
					attribute: 'image',
					scale: {
						'mini' : baseurl+'/assets/images/mark-mini30.png',
						'normal' : baseurl+'/assets/images/mark-mini.png'
					},
					values: spots.reduce(function(p,c,i){
						p[i] = c.status;
						return p;
					}, {})
				}]
			},
			markersSelectable: true,
			zoomOnScroll: false,
			regionStyle: {
				initial: {
					fill: '#fef461'
				}
			},
			onMarkerClick: function(event, index){
				// console.log('marker-click', index);
				// console.log('marker-click', event);
				var customTip = $('#customTip');

				latLng = spots[index]['coords'];
				markerCoord = map.latLngToPoint(latLng[0],latLng[1]);

				heightTip = customTip.height();
				widthTip = customTip.width();

				customTip.css ({
					left: markerCoord.x - (widthTip/2),
					top: markerCoord.y - (heightTip) + 40
				})

				customTip.find('.tipPlace h2').text(spots[index]['name']);
				customTip.find('.tipPlace .small').text(spots[index]['city']);
				customTip.find('.tipDetail .large').text(spots[index]['spf']);
				customTip.find('.tipTemp span').text(spots[index]['temp']);
				customTip.find('.top').css("background-image","url('"+spots[index]['pic']+"')");

				if (customTip.is(":visible")) {
					customTip.hide();
					customTip.show();
				} else {
					customTip.show();
				}

        	},
			onMarkerSelected: function(event, index, isSelected, selectedMarkers) {
				console.log('selected',index,isSelected);
			}
		})

	})
</script>