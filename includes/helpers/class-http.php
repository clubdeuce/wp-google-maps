<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class HTTP
 * @package Clubdeuce\WPGoogleMaps
 */
class HTTP {

	/**
	 * @param  string $url
	 * @return \WP_HTTP_Response|\WP_Error
	 */
	public function make_request( $url ) {

		$return = new \WP_Error( 1, 'Invalid URL', $url );

		if ( wp_http_validate_url( $url ) ) {
			$request = $this->_get_data( $url );

			$return = new \WP_Error( $request['response']['code'], $request['response']['message'] );

			if ( 200 == $request['response']['code'] ) {
				$return = $request;
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