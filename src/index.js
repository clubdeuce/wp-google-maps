require('./markerClusterer');
import userLocation from './modules/UserLocation';
import Geocoder from './modules/Geocoder';
import Map from './modules/Map';

window.gmMaps = {};

jQuery(document).ready(function ($) {

    if ("https:" === window.location.protocol) {
        userLocation().then(position => {
            window.gmMaps.userLocation = position;
            let {latitude, longitude} = position.coords;
            new Geocoder().addressFromLocation(latitude, longitude)
                .then(address => {
                    window.gmMaps.userLocation.address = address;
                });
        });
    }
});

/**
 * Create a Google map and add it to the gmMaps global varable.
 * 
 * @param {string} mapId       The DOM element id that should contain the map
 * @param {object} mapParams    The map parameters. At least the 'center' element must be defined. See https://developers.google.com/maps/documentation/javascript/reference/map#MapOptions
 * @param {array} markers      An array containing map markers
 * @param {array} infoWindows  An array containing info window objects
 */
window.generate_map = function(mapId, mapParams, markers, infoWindows, options = []) {
    let map            = new Map(mapId, mapParams, markers, infoWindows);
    let gMap           = map.gMap;
    let mapMarkers     = map.addMarkers(markers, gMap);

    map.addInfoWindows(mapMarkers, infoWindows, gMap);

    if(options.fitBounds) {
        map.fitBounds(mapMarkers, gMap);
    }

    if (options.useClusters) {
        new MarkerClusterer(gMap, mapMarkers, {
            imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
        });
    }

    window.gmMaps[mapId] = {
        map: gMap,
        params: mapParams,
        markers: mapMarkers,
        infoWindows: infoWindows,
    }
}