var gmMaps = {};
var geocoder = new google.maps.Geocoder;

jQuery(document).ready(function ($) {
  if ('https' == window.location.protocol) {
    userLocation();
  }
});

/**
 *
 * @param mapId
 * @param mapParams
 * @param mapMarkers
 * @param infoWindows
 */
function generate_map(mapId, mapParams, mapMarkers, infoWindows) {
  var map = new google.maps.Map(document.getElementById(mapId), {
    center: mapParams.center,
    zoom: Number(mapParams.zoom)
  });
  var markers = [];
  var bounds = new google.maps.LatLngBounds();
  var infoWindow = new google.maps.InfoWindow();

  jQuery.each(mapMarkers, function (key, object) {
    object.map = map;
    var marker = new google.maps.Marker(object);
    markers.push(marker);

    // Add the position of the marker to the bounds object
    bounds.extend(object.position);

    // Add the info box open click listener only if there is info window content
    if (infoWindows[key].content.trim()) {
      marker.addListener('click', function () {
        infoWindow.setContent(infoWindows[key].content);
        infoWindow.open(map, marker);
      });
    }
  });

  // Add a listener to enforce a minimum zoom level after the map is resized to fit all markers
  google.maps.event.addListenerOnce(map, 'bounds_changed', function () {
    if (this.getZoom() > 15) {
      this.setZoom(15);
    }
  });

  // Automatically ensure all markers fit on the map
  // see https://wrightshq.com/playground/placing-multiple-markers-on-a-google-map-using-api-3/
  map.fitBounds(bounds);

  // Add the map, markers, and infoWindow objects to a global variable
  gmMaps[mapId] = {map: map, markers: markers, infoWindow: infoWindow};
}

// Get the browser location using HTML 5 Geolocation
function userLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      gmMaps["userLocation"] = {position: position};
      addressFromLocation(position.coords.latitude, position.coords.longitude);
    }, userLocationError);
  }
}

function userLocationError(error) {
  var errorMessage = '';

  switch (error.code) {
    case error.PERMISSION_DENIED:
      errorMessage = "User denied the request for Geolocation.";
      break;
    case error.POSITION_UNAVAILABLE:
      errorMessage = "Location information is unavailable.";
      break;
    case error.TIMEOUT:
      errorMessage = "The request to get user location timed out.";
      break;
    case error.UNKNOWN_ERROR:
      errorMessage = "An unknown error occurred.";
      break;
  }

  gmMaps['userLocation'] = {status: 'error', code: error.code, message: errorMessage};
}

/**
 *
 * @param lat
 * @param lng
 * @returns {*}
 */
function addressFromLocation(lat, lng) {
  var geocoder = new google.maps.Geocoder;
  var latLng = new google.maps.LatLng(lat, lng);
  var address = '';
  geocoder.geocode({'latLng': latLng}, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        gmMaps['userLocation']['address'] = results[0].formatted_address;
      }
    }
  });
}