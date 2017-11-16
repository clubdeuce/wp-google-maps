<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Geocoder
 * @package Clubdeuce\WPGoogleMaps
 */
class Geocoder {

	/**
	 * @var string
	 */
	protected $_api_key;

	/**
	 * KSA_Geocoder constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'api_key' => Google_Maps::api_key(),
		) );

		$this->_api_key = $args['api_key'];

	}

	/**
	 * @return string
	 */
	public function api_key() {

		return $this->_api_key;

	}

	/**
	 * @param  string $address
	 * @return Location|\WP_Error
	 */
	public function geocode( $address ) {

		$location = new \WP_Error(100, 'No results found', array( 'address' => $address ) );
		$url = $this->_make_url( $address );

		$response = $this->_make_request( $url );

		if ( ! is_wp_error( $response ) && count( $response['results'] ) > 0 ) {
			$location = $this->_make_location( $response['results'][0] );
		}

		return $location;

	}

	/**
	 * @param  string $address
	 * @return string
	 */
	private function _make_url( $address ) {

		return sprintf(
			'https://maps.googleapis.com/maps/api/geocode/json?address=%1$s&key=%2$s',
			urlencode( filter_var( $address, FILTER_SANITIZE_STRING ) ),
			self::api_key()
		);

	}

	/**
	 * Convert the response body into an a Location object
	 *
	 * @param  array $results
	 * @return Location
	 */
	private function _make_location( $results ) {

		$response = new Location( array(
			'address'           => $results['formatted_address'],
			'formatted_address' => $results['formatted_address'],
			'state'             => self::_get_state_from_results( $results ),
			'zip_code'          => self::_get_zip_from_results( $results ),
			'latitude'          => $results['geometry']['location']['lat'],
			'longitude'         => $results['geometry']['location']['lng'],
			'place_id'          => $results['place_id'],
			'types'             => $results['types'],
			'viewport'          => $results['geometry']['viewport'],
		) );

		return $response;

	}

	/**
	 * @param  array  $results
	 * @return string
	 */
	private function _get_state_from_results( $results ) {

		return self::_get_value_from_results( 'administrative_area_level_1', $results );

	}

	/**
	 * @param  array $results
	 * @return string
	 */
	private function _get_zip_from_results( $results ) {

		return self::_get_value_from_results( 'postal_code', $results );

	}

	/**
	 * @param  string $value
	 * @param  array  $results
	 * @return string
	 */
	private function _get_value_from_results( $value, $results ) {

		$result_value = '';

		if ( isset( $results['address_components'] ) ) {
			foreach ( $results['address_components'] as $component ) {
				if ( $component['types'][0] === $value ) {
					$result_value = $component['short_name'];
					break;
				}
			}
		}

		return $result_value;

	}

	/**
	 * @param  string $url
	 * @return array|\WP_Error
	 */
	private function _make_request( $url ) {

		$return = new \WP_Error( 1, 'Invalid URL', $url );

		if ( wp_http_validate_url( $url ) ) {
			$request = $this->_get_data( $url );

			$return = new \WP_Error( $request['response']['code'], $request['response']['message'] );

			if ( 200 == $request['response']['code'] ) {
				$return = json_decode( $request['body'], true );
			}

		}

		return $return;

	}

	/**
	 * @param $url
	 * @return array|\WP_Error
	 */
	private function _get_data( $url ) {

		$cache_key = md5( serialize( $url ) );

		if ( ! $data = wp_cache_get( $cache_key ) ) {
			$data = wp_remote_get( $url );
			wp_cache_add( $cache_key, $data, 300 );
		}

		return $data;

	}

}
