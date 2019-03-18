export default class Map {
    constructor(mapId, params, options = []) {
        this.gMap    = new google.maps.Map(document.getElementById(mapId), params);
        this.params  = params;
        this.options = options;
    }

    /**
     * @param   {Array} mapMarkers
     * @returns {Array}
     */
    addMarkers(mapMarkers, map) {
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
     * @param {Array} markers
     * @param {Array} windows
     */
    addInfoWindows(markers, windows, map) {
        if (! jQuery.isEmptyObject(windows)) {
            const infoWindow = new google.maps.InfoWindow();
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
    fitBounds(markers, map) {
        // Automatically ensure all markers fit on the map
        // see https://wrightshq.com/playground/placing-multiple-markers-on-a-google-map-using-api-3/
        if( 1 <= jQuery(markers).length ) {
            let bounds = new google.maps.LatLngBounds();
            jQuery.each(markers, function(key, marker) {
                // Add the position of the marker to the bounds object
                bounds.extend(marker.getPosition());
                map.fitBounds(bounds);
            });
        }

        /**
         * Enforce a maximum zoom of 15
         */
        google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
            if(15 < map.getZoom()) {
            map.setZoom(15);
            }
        });
    }
}
