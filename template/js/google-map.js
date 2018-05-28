function loadGoogleMap() {}
jQuery(document).ready(function () {

  var locations = [
    ['Ma Dai', 10.776924, 106.654758, 
      { 
        email: 'admin@madai-support.com',
        opening: '08:00 - 21:00',
        phone: '0126 - 922 - 0162'
      }
    ]

  ];
  loadGoogleMap = function() {
    var mapElement = document.getElementById('map-canvas');
    if (mapElement == null) return;
    google.maps.event.addDomListener(window, 'load', initmap);
  
    function initmap() {
      var mainLatlng = new google.maps.LatLng(10.776924, 106.654758);
      var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 16,
        disableDefaultUI: true,
        scrollwheel: false,
        zoomControl: true,
        draggable: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.TOP_RIGHT
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        // The latitude and longitude to center the map (always required)
        center: mainLatlng,
        // How you would like to style the map. 
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{ "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }] }, { "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] }, { "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] }, { "elementType": "labels.text.stroke", "stylers": [{ "color": "#f5f5f5" }] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [{ "color": "#bdbdbd" }] }, { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] }, { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [{ "color": "#757575" }] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [{ "color": "#dadada" }] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [{ "color": "#e5e5e5" }] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [{ "color": "#eeeeee" }] }, { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#c9c9c9" }] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [{ "color": "#9e9e9e" }] }]
      };
  
      // Create the Google Map using our element and options defined above
      map = new google.maps.Map(mapElement, mapOptions);
      //set markers
      setMarkers(map, locations);
    }
  
    var icon1 = {
      url: 'images/map-icon.png',
      // This marker width , high.
      scaledSize: new google.maps.Size(25, 35),
      // The origin for this image
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole
      anchor: new google.maps.Point(12.5, 35)
    };

    function setMarkers(map, locations) {
  
      var marker, i
      //Initialize bounds
      if (locations.length > 1) {
        var bounds = new google.maps.LatLngBounds();
      }
      
      for (i = 0; i < locations.length; i++) {
        var title = locations[i][0];
        var lat = locations[i][1];
        var long = locations[i][2];
        var detail = locations[i][3];
  
        latlngset = new google.maps.LatLng(lat, long);
  
        var marker = new google.maps.Marker({
          map: map, title: title, position: latlngset, icon: icon1,
        });
  

        //content infowindow
        var content = `${title}, email: ${detail.email}, opening: ${detail.opening}, phone: ${detail.phone}`;
  
        var infowindow = new google.maps.InfoWindow()
  
        google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) {
          return function () {
            infowindow.setContent(content);
            infowindow.open(map, marker);
            google.maps.event.addListener(map, 'click', function () {
              infowindow.close();
            });
          };
        })(marker, content, infowindow));
        
        if (!!bounds) {
          bounds.extend(marker.position);
          map.fitBounds(bounds);
        }

        
      }
    }
  }

});




