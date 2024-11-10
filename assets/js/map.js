function init(myMap,myLat,myLng) {
	var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(myLat,myLng),
		scrollwheel: false,
        mapTypeControl: false,
        streetViewControl: false,
		styles:[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
	};
	var mapElement = document.getElementById(myMap);
	var map = new google.maps.Map(mapElement, mapOptions);
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(myLat,myLng),
		map: map,
		icon: 'assets/gfx/icon/location.png',
		title: ''
	});
}