class Geocoder {
    constructor() {
        this.geocoder = new google.maps.Geocoder();
    }

    /**
     *
     * @param lat
     * @param lng
     */
    addressFromLocation(lat, lng) {
        return new Promise( (resolve, reject) => {
            let latLng = new google.maps.LatLng(lat, lng);
            this.geocoder.geocode({"latLng": latLng}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        resolve(results[0].formatted_address);
                    }
                } else {
                    reject(results);
                }
            });
        })
    }
}

export default Geocoder;