<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Google_Maps
 * @package Clubdeuce\WPGoogleMaps
 */
class Google_Maps {

	/**
	 * @var string
	 */
	protected static $_version = '0.2.5';

	/**
	 * @var string
	 */
	protected static $_api_key = '';

	/**
	 * @var Geocoder
	 */
	protected static $_geocoder;

	/**
	 * These conditions will be used to determine whether to enqueue the Google Maps JS.
	 *
	 * @var array
	 */
	protected static $_script_conditions = array();

	/**
	 * The path to this library's directory
	 *
	 * @var string
	 */
	protected static $_source_dir;

	/**
	 * The url to this module's directory
	 *
	 * @var string
	 */
	protected static $_source_url;

	/**
	 *
	 */
	public static function initialize() {

		self::$_source_dir = dirname( __DIR__ );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, '_wp_enqueue_scripts_9' ), 9 );

	}

	/**
	 * @return string
	 */
	public static function api_key() {

		return static::$_api_key;

	}

	/**
	 * @param  array $args
	 * @return Map
	 */
	public static function make_new_map( $args = array() ) {

		$class = __NAMESPACE__ . '\Map';
		return new $class( $args );

	}

	/**
	 * @param string $key
	 */
	public static function register_api_key( $key ) {

		static::$_api_key = filter_var( $key, FILTER_SANITIZE_STRING );

	}

	/**
	 * @param callable|bool $condition
	 */
	public static function register_script_condition( $condition ) {

		static::$_script_conditions[] = $condition;

	}

	public static function _wp_enqueue_scripts_9() {

		self::_register_scripts();

		if ( self::_evaluate_conditions() ) {
			wp_enqueue_script( 'map-control' );
			wp_enqueue_script( 'google-marker-clusterer' );
			wp_enqueue_style( 'map' );
		}
	}

	/**
	 * @param  string $address
	 * @param  array  $args
	 * @return Marker
	 */
	public static function make_marker_by_address( $address, $args = array() ) {

		$args = wp_parse_args( $args, array(
			'address' => $address,
			'geocoder' => self::geocoder(),
		) );

		return new Marker( $args );

	}

	/**
	 * @param float $lat
	 * @param float $lng
	 *
	 * @return Marker
	 */
	public static function make_marker_by_position( $lat, $lng, $args = array() ) {

		$args = wp_parse_args( $args, array(
			'geocoder'  => self::geocoder(),
			'latitude'  => $lat,
			'longitude' => $lng,
		));

		return new Marker( $args );

	}

	/**
	 * @param  string $destination
	 * @param  array  $args
	 * @return string
	 */
	public static function driving_directions_href($destination, $args = array() ) {

		$args = wp_parse_args( $args, array(
			'start' => 'My Location',
		) );

		return sprintf( 'https://maps.google.com/maps?saddr=%1$s&daddr=%2$s', urlencode( $args['start'] ), urlencode( $destination ) );
	}

	/**
	 * @return string
	 */
	public static function source_dir() {

		return self::$_source_dir;

	}

	/**
	 * @return string
	 */
	public static function source_url() {

		$path = dirname( __DIR__ );

		$url = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $path );

		if ( is_ssl() ) {
			$url = preg_replace( '#^https*:\/\/([a-zA-z0-9\.]*)#', 'https://$1', $url );
		}

		return $url;

	}

	/**
	 * @return string
	 */
	public static function version() {

		return self::$_version;

	}

	/**
	 * @return Geocoder
	 */
	public static function geocoder() {

		if ( ! isset( static::$_geocoder ) ) {
			static::$_geocoder = new Geocoder( [ 'api_key' => self::api_key() ] );
		}

		return static::$_geocoder;

	}

	/**
	 * @return bool
	 */
	protected static function _evaluate_conditions() {

		$result     = false;
		$conditions = self::_script_conditions();

		foreach( $conditions as $key => $condition ) {
			if ( is_callable( $condition ) ) {
				$conditions[ $key ] = call_user_func( $condition );
			}
		}

		if ( in_array( true, $conditions ) ) {
			$result = true;
		}

		return $result;

	}

	/**
	 *
	 */
	protected static function _register_scripts() {

		$key    = static::api_key();
		$source = sprintf( '%1$s/dist/scripts/maps.min.js', self::source_url() );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$source = sprintf( '%1$s/assets/maps.js', self::source_url() );
		}

		wp_register_script( 'google-maps', "https://maps.google.com/maps/api/js?v=3&key={$key}", false, '3.0', true );
		wp_register_script( 'google-marker-clusterer', self::source_url() . '/assets/markerclusterer.js', array(), '1.0.1', true );
		wp_register_script( 'map-control', $source, array( 'jquery', 'google-maps' ), self::version(), true );
		wp_register_style( 'map', self::source_url() . '/assets/map.css' );
		
	}

	/**
	 * @return array
	 */
	protected static function _script_conditions() {

		return static::$_script_conditions;

	}

}
