require('./markerClusterer');
import userLocation from './modules/UserLocation';
import Geocoder from './modules/Geocoder';
import Map from './modules/Map';

const gmMaps = {};

jQuery(document).ready(function ($) {
    let geocoder = new Geocoder();

    if ("https:" === window.location.protocol) {
        gmMaps.userLocation = userLocation();
        if('success' === gmMaps.userLocation.status) {
            gmMaps.userLocation.address = geocoder.addressFromLocation(gmMaps.userLocation);
        }
    }
});

/**
 * Create a Google map and add it to the gmMaps global varable.
 * 
 * @param {string} mapId       The DOM element id that should contain the map
 * @param {oject} mapParams    The map parameters. At least the 'center' element must be defined. See https://developers.google.com/maps/documentation/javascript/reference/map#MapOptions
 * @param {array} markers      An array containing map markers
 * @param {array} infoWindows  An array containing info window objects
 */
function generate_map(mapId, mapParams, markers, infoWindows = []) {
    gmMaps[mapId] = new Map(mapId, mapParams, markers, infoWindows);
}