/** global: google */
/** global: navigator */
var markersWithoutLure = [];
var map;

function initMap() {
	$.ajax({
		'type': 'GET',
		'global': false,
		'dataType': 'json',
		'url': 'core/process/aru.php',
		'data': {
			'type': 'pokestop'
		},
		'success': function(pokestops) {
			$.getJSON('core/json/variables.json', function(variables) {
				var latitude = 40.845556;                                                                                                                                                                                   
                                var longitude = -74.695; 
				var zoom_level = 11;

				map = new google.maps.Map(document.getElementById('map'), {
					center: {
						lat: latitude,
						lng: longitude
					},
					zoom: zoom_level,
					zoomControl: true,
					scaleControl: false,
					scrollwheel: true,
					disableDoubleClickZoom: false,
					streetViewControl: false,
					mapTypeControlOptions: {
						mapTypeIds: [
							google.maps.MapTypeId.ROADMAP,
							'pogo_style',
							'dark_style',
						]
					}
				});

				$.getJSON('core/json/pogostyle.json', function(data) {
					var styledMap_pogo = new google.maps.StyledMapType(data, { name: 'PoGo' });
					map.mapTypes.set('pogo_style', styledMap_pogo);
				});
				$.getJSON('core/json/darkstyle.json', function(data) {
					var styledMap_dark = new google.maps.StyledMapType(data, { name: 'Dark' });
					map.mapTypes.set('dark_style', styledMap_dark);
				});
				$.getJSON('core/json/defaultstyle.json', function(data) {
					map.set('styles', data);
				});

				$.ajax({
					'type': 'GET',
					'global': false,
					'dataType': 'json',
					'url': 'core/process/aru.php',
					'data': {
						'type': 'maps_localization_coordinates'
					}
				}).done(function(coordinates) {
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
							var pos = {
								lat: position.coords.latitude,
								lng: position.coords.longitude
							};

							if (position.coords.latitude <= coordinates.max_latitude && position.coords.latitude >= coordinates.min_latitude) {
								if (position.coords.longitude <= coordinates.max_longitude && position.coords.longitude >= coordinates.min_longitude) {
									map.setCenter(pos);
								}
							}
						});
					}
				});

				var infowindow = new google.maps.InfoWindow();

				var marker, i;

				for (i = 0; i < pokestops.length; i++) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(pokestops[i][2], pokestops[i][3]),
						map: map,
						icon: {
    url: 'core/img/' + pokestops[i][1],
    scaledSize: new google.maps.Size(35, 35), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
},
						zIndex: 0 + pokestops[i][4]
					});

					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow.setContent(pokestops[i][0]);
							infowindow.open(map, marker);
						}
					})(marker, i));

					if (!pokestops[i][4]) {
						markersWithoutLure.push(marker);
					}
				}
				updateMap(true);
			});
			initSelector();
		}
	});
}

function initSelector() {
	$('#pokestopSelector').click(function() {
		$('#pokestopSelector').addClass('active');
		$('#lureSelector').removeClass('active');
		updateMap(false);
	});
	$('#lureSelector').click(function() {
		$('#lureSelector').addClass('active');
		$('#pokestopSelector').removeClass('active');
		updateMap(true);
	});
}

function updateMap(onlyLured) {
	var i;
	if (onlyLured) {
		for (i = 0; i < markersWithoutLure.length; i++) {
			markersWithoutLure[i].setMap(null);
		}
	} else {
		for (i = 0; i < markersWithoutLure.length; i++) {
			markersWithoutLure[i].setMap(map);
		}
	}
}
