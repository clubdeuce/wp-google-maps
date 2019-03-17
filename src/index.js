require('./markerClusterer');
import userLocation, { userLocationError } from './modules/UserLocation';
import Geocoder from './modules/Geocoder';
import Map from './modules/Map';

var gmMaps = {}

jQuery(document).ready(function ($) {

    if ("https:" === window.location.protocol) {
        // getUserLocation().then(position => {
        //     let {latitude, longitude} = position.coords;
        //     gmMaps.userLocation = position;
        //     new Geocoder().addressFromLocation(latitude, longitude, gmMaps)
        //         .then(address => {
        //             gmMaps.userLocation.address = address;
        //             console.log(gmMaps);
        //         });
        // }).catch(error => {
        //     console.log('error', error);
        //     gmMaps.userLocation = userLocationError(error);
        // });

        userLocation().then(position => {
            gmMaps.userLocation = position;
            let {latitude, longitude} = position.coords;
            new Geocoder().addressFromLocation(latitude, longitude)
                .then(address => {
                    gmMaps.userLocation.address = address;
                    console.log(gmMaps);
                });
        });
    }
});

async function getUserLocation() {
    return await userLocation();
}

/**
 * Create a Google map and add it to the gmMaps global varable.
 * 
 * @param {string} mapId       The DOM element id that should contain the map
 * @param {oject} mapParams    The map parameters. At least the 'center' element must be defined. See https://developers.google.com/maps/documentation/javascript/reference/map#MapOptions
 * @param {array} markers      An array containing map markers
 * @param {array} infoWindows  An array containing info window objects
 */
function generate_map(mapId, mapParams, markers, infoWindows) {
    gmMaps[mapId] = new Map(mapId, mapParams, markers, infoWindows);
}