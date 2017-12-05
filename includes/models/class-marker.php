<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Marker
 * @package Clubdeuce\WPGoogleMaps
 */
class Marker extends Model_Base {

	/**
	 * @var string
	 */
	protected $_address;

	/**
	 * @var Geocoder
	 */
	protected $_geocoder;

	/**
	 * @var array
	 */
	protected $_icon;

	/**
	 * @var Info_Window
	 */
	protected $_info_window;

	/**
	 * @var Marker_Label
	 */
	protected $_label;

	/**
	 * @var double
	 */
	protected $_latitude;

	/**
	 * @var double
	 */
	protected $_longitude;

	/**
	 * @var Location|\WP_Error
	 */
	protected $_location;

	/**
	 * This appears as a tooltip for the marker.
	 *
	 * @var string
	 */
	protected $_title;

	/**
	 * @var array
	 */
	protected $_extra_args = array();

	/**
	 * Marker_Model constructor.
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'address'     => '',
			'icon'        => null,
			'info_window' => '',
			'label'       => new Marker_Label(),
			'title'       => '',
			'latitude'    => null,
			'longitude'   => null,
		) );

		if ( empty( $args['info_window'] ) ) {
			$args['info_window'] = new Info_Window( array(
				'position' => array( 'lat' => $args['latitude'], 'lng' => $args['longitude'] ),
			) );
		}

		parent::__construct( $args );

	}

	/**
	 * @return array
	 */
	public function icon() {

		return $this->_icon;

	}

	/**
	 * @return Info_Window
	 */
	public function info_window() {

		return $this->_info_window;

	}

	/**
	 * @return Marker_Label
	 */
	public function label() {

		if ( is_string( $this->_label ) ) {
			$this->_label = new Marker_Label( array( 'text' => $this->_label ) );
		}

		return $this->_label;

	}

	/**
	 * @return double
	 */
	public function latitude() {

		if ( is_null( $this->_latitude ) && ! is_wp_error( $this->location() ) ) {
			$this->_latitude = $this->location()->latitude();
		}
		return doubleval( $this->_latitude );
	}

	/**
	 * @return Location|\WP_Error
	 */
	public function location() {

		if ( ! is_object( $this->_location ) ) {
			$this->_location = $this->_geocoder()->geocode( $this->_address );
		}

		return $this->_location;

	}

	/**
	 * @return double
	 */
	public function longitude() {

		if ( is_null( $this->_longitude ) && ! is_wp_error( $this->location() ) ) {
			$this->_longitude = doubleval( $this->location()->longitude() );
		}

		return doubleval( $this->_longitude );
	}

	/**
	 * Get the position of this marker. An array with key/value pairs of lat and lng.
	 *
	 * @return array
	 */
	public function position() {

		return array( 'lat' => $this->latitude(), 'lng' => $this->longitude() );

	}

	/**
	 * @return string
	 */
	public function title() {

		return $this->_title;

	}

	/**
	 * @param string|array $icon
	 */
	public function set_icon( $icon ) {

		if ( is_string( $icon ) ) {
			//assume $icon is an URL
			$icon = array(
				'url' => (string)$icon,
			);
		}

		$this->_icon = $icon;

	}

	/**
	 * @param  array $args
	 * @return array
	 */
	public function marker_args( $args = array() ) {

		$args = array_merge( $args, $this->_extra_args );

		$args = wp_parse_args( $args, array(
			'position'  => $this->position(),
			'icon'      => $this->icon(),
			'label'     => $this->label()->options(),
			'title'     => $this->title(),
		) );

		return array_filter( $args );

	}

	/**
	 * @return Geocoder
	 */
	protected function _geocoder() {

		if (! is_a( $this->_geocoder, Geocoder::class ) ) {
			$this->_geocoder = new Geocoder();
		}

		return $this->_geocoder;

	}

}
