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
	 * @var HTTP
	 */
	protected $_http;

	/**
	 * Geocoder constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'api_key' => Google_Maps::api_key(),
			'http'    => new HTTP(),
		) );

		$this->_api_key = $args['api_key'];
		$this->_http    = $args['http'];

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

		$url = $this->_make_url( $address );

		$response = $this->_http->make_request( $url );

		do {
			if ( is_a( $response, \WP_Error::class ) ) {
				$location = $response;
				break;
			}

			$results = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( 0 === count( $results['results'] ) ) {
				$location = new \WP_Error( '100', sprintf( '%1$s: %2$s', $results['status'], $results['error_message'] ) );
				break;
			}

			$location = $this->_make_location( $results['results'][0] );
		} while ( false );

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
			$this->api_key()
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
			'state'             => $this->_get_state_from_results( $results ),
			'zip_code'          => $this->_get_zip_from_results( $results ),
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

		return $this->_get_value_from_results( 'administrative_area_level_1', $results );

	}

	/**
	 * @param  array $results
	 * @return string
	 */
	private function _get_zip_from_results( $results ) {

		return $this->_get_value_from_results( 'postal_code', $results );

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

}
