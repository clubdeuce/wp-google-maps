var gmMaps;
var geocoder = new google.maps.Geocoder;

/**
 * @param error
 */
function userLocationError(error) {
  var errorMessage = "";

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

  gmMaps["userLocation"] = {status: "error", code: error.code, message: errorMessage};
}

/**
 * Get the browser location using HTML 5 Geolocation
 */
function userLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      gmMaps["userLocation"] = {position: position};
      addressFromLocation(position.coords.latitude, position.coords.longitude);
    }, userLocationError);
  }
}

jQuery(document).ready(function ($) {
  if ("https" === window.location.protocol) {
    userLocation();
  }
});

/**
 * @param   map
 * @param   {Array} mapMarkers
 * @returns {Array}
 */
function addMarkers(map, mapMarkers) {
  markers = [];

  jQuery.each(mapMarkers, function (key, object) {
    object.map = map;
    marker = new google.maps.Marker(object);
    markers.push(marker);
  });

  return markers;
}

/**
 *
 * @param map
 * @param {Array} markers
 * @param {Array} windows
 */
function addInfoWindows(map, markers, windows) {
  jQuery.each(markers, function(key, marker){
    // Add the info box open click listener only if there is info window content
    if (windows[key].content.trim()) {
      marker.addListener("click", function () {
        infoWindow.setContent(iWindow.content);
        infoWindow.open(map, marker);
      });
    }
  });
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
  var address = "";
  geocoder.geocode({"latLng": latLng}, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        gmMaps["userLocation"]["address"] = results[0].formatted_address;
      }
    }
  });
}

/**
 * @param map
 * @param markers
 * @returns {boolean}
 */
function fitBounds(map, markers) {
  var fitBounds = false;

  // Automatically ensure all markers fit on the map
  // see https://wrightshq.com/playground/placing-multiple-markers-on-a-google-map-using-api-3/
  if( 1 < jQuery(markers).length ) {
    var bounds = new google.maps.LatLngBounds();
    jQuery.each(markers, function(key, marker) {
      // Add the position of the marker to the bounds object
      bounds.extend(marker.getPosition());
      map.fitBounds(bounds);
    });
    fitBounds = true;
  }

  return fitBounds;
}

/**
 *
 * @param mapId
 * @param mapParams
 * @param mapMarkers
 * @param infoWindows
 */
function generate_map(mapId, mapParams, mapMarkers, infoWindows) {
  var map        = new google.maps.Map(document.getElementById(mapId), mapParams);
  var infoWindow = new google.maps.InfoWindow();

  var markers = addMarkers(map, mapMarkers);

  if (gmMaps.fitBounds) {
    fitBounds(map, markers);
  }

  addInfoWindows(map, markers, infoWindows);

  if (gmMaps.useClusters) {
    var markerClusterer = new MarkerClusterer(map, markers, {
      imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
    });
  }

  // Add the map, markers, and infoWindow objects to a global variable
  gmMaps[mapId] = {map: map, markers: markers, infoWindow: infoWindow, markerClusterer: markerClusterer};
}