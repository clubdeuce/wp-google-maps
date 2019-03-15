export default class Map {
    constructor(mapId, params, markers = [], infoWindows = []) {
        this.map = new google.maps.map(documentGetElementById(mapId, params));
        this.addMarkers(markers);
        this.addInfoWindows(markers, infoWindows);
        if (gmMaps.fitBounds) {
            this.fitBounds();
        }

        if (gmMaps.useClusters) {
            new MarkerClusterer(this.map, markers, {
                imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
            });
        }
    }
}

/**
 * @param   {Array} mapMarkers
 * @returns {Array}
 */
Map.prototype.addMarkers = (mapMarkers) => {
    var markers = [];

    jQuery.each(mapMarkers, function (key, object) {
        object.map = this.map;
        var marker = new google.maps.Marker(object);
        markers.push(marker);
    });

    return markers;
}

/**
 *
 * @param {Array} markers
 * @param {Array} windows
 */
Map.prototype.addInfoWindows = (markers, windows) => {
    if (! jQuery.isEmptyObject(windows)) {
    jQuery.each(markers, function(key, marker){
        if(windows[key].content) {
        // Add the info box open click listener only if there is info window content
        if (windows[key].content.trim()) {
            marker.addListener("click", function () {
            infoWindow.setContent(windows[key].content);
            infoWindow.open(this.map, marker);
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
Map.prototype.fitBounds = (markers) => {
    let fitBounds = false;
    let {map} = this;

    // Automatically ensure all markers fit on the map
    // see https://wrightshq.com/playground/placing-multiple-markers-on-a-google-map-using-api-3/
    if( 1 <= jQuery(markers).length ) {
        let bounds = new google.maps.LatLngBounds();
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