import Geocoder from "./Geocoder";

function geolocateSuccess(position) {
  return {
    success: true,
    position: position,
  };
}

/**
 * 
 * @param {*} error 
 * 
 * @return {object}
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
 * Get the browser location using HTML 5 Geolocation
 * 
 * @return {object}
 */
const userLocation = () => {
  return new Promise( (resolve, reject) => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(resolve, reject);
    } else {
      reject(new Error( 'Navigator is not supported'));
    }
  });
};

export default userLocation;