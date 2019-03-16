class Geocoder {
    constructor() {
        this.geocoder = new google.maps.Geocoder();
    }
}

/**
 *
 * @param lat
 * @param lng
 */
Geocoder.prototype.addressFromLocation = (lat, lng) => {
    let latLng   = new google.maps.LatLng(lat, lng);
    
    this.geocoder.geocode({"latLng": latLng}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                return results[0].formatted_address;
            }
        }
    });
};

export default Geocoder;