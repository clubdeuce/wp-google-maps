/* global google MarkerClusterer*/
let geocoder   = new google.maps.Geocoder;
let infoWindow = new google.maps.InfoWindow();

/**
 * @param error
 */
function userLocationError(error) {
  let errorMessage = "";

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
    default:
      errorMessage = "An unknown error occurred.";
      break;
  }

  return {status: "error", code: error.code, message: errorMessage};
}

/**
 *
 * @param lat
 * @param lng
 */
function addressFromLocation(lat, lng) {
  let geocoder = new google.maps.Geocoder;
  let latLng = new google.maps.LatLng(lat, lng);
  
  geocoder.geocode({"latLng": latLng}, function (results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        gmMaps.userLocation.address = results[0].formatted_address;
      }
    }
  });
}

/**
 * Get the browser location using HTML 5 Geolocation
 */
function userLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      gmMaps.userLocation = {
        status: "success",
        position: position,
        address: null
      };
      addressFromLocation(position.coords.latitude, position.coords.longitude)
    }, function(error){
      gmMaps.userLocation = userLocationError(error);
    });
  }
}

jQuery(document).ready(function ($) {
  if ("https:" === window.location.protocol) {
    userLocation();
  }
});

/**
 * @param   map
 * @param   {Array} mapMarkers
 * @returns {Array}
 */
function addMarkers(map, mapMarkers) {
  var markers = [];

  jQuery.each(mapMarkers, function (key, object) {
    object.map = map;
    var marker = new google.maps.Marker(object);
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
  if (! jQuery.isEmptyObject(windows)) {
    jQuery.each(markers, function(key, marker){
      if(windows[key].content) {
        // Add the info box open click listener only if there is info window content
        if (windows[key].content.trim()) {
          marker.addListener("click", function () {
            infoWindow.setContent(windows[key].content);
            infoWindow.open(map, marker);
          });
        }
      }
    });
  }
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
  if( 1 <= jQuery(markers).length ) {
    var bounds = new google.maps.LatLngBounds();
    jQuery.each(markers, function(key, marker) {
      // Add the position of the marker to the bounds object
      bounds.extend(marker.getPosition());
      map.fitBounds(bounds);
    });
    fitBounds = true;
  }

  /**
   * Enforce a maximum zoom of 15
   */
  google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
    if(15 < map.getZoom()) {
      map.setZoom(15);
    }
  });

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
  let map     = new google.maps.Map(document.getElementById(mapId), mapParams);
  let markers = addMarkers(map, mapMarkers);

  if (gmMaps) {
    if (gmMaps.fitBounds) {
      fitBounds(map, markers);
    }
    if (gmMaps.useClusters) {
      var markerClusterer = new MarkerClusterer(map, markers, {
        imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
      });
    }
  }

  addInfoWindows(map, markers, infoWindows);

  // Add the map, markers, and infoWindow objects to a global variable
  gmMaps[mapId] = {map: map, markers: markers, infoWindow: infoWindow, markerClusterer: markerClusterer};
}