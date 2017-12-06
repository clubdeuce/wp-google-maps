<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Map
 * @package Clubdeuce\WPGoogleMaps
 *
 * @method bool  fit_bounds()
 * @method array styles()
 */
class Map_Model extends Model_Base {

	/**
	 * @var null|string
	 */
	protected $_background_color = null;

	/**
	 * @var array
	 */
	protected $_center;

	/**
	 * If set to true, the map's zoom level will be altered to ensure all markers are
	 * in the viewport.
	 *
	 * @var bool
	 */
	protected $_fit_bounds;

	/**
	 * The Map element height (default: 400px).
	 * @var string
	 */
	protected $_height = '400px';

	/**
	 * The string to use for the map HTML element id property
	 *
	 * @var string
	 */
	protected $_html_id;

	/**
	 * @var Marker[]
	 */
	protected $_markers = array();

	/**
	 * @var array
	 */
	protected $_styles = array();

	/**
	 * @var bool
	 */
	protected $_use_clusters;

	/**
	 * The Map element width (default: 100%).
	 * @var string
	 */
	protected $_width = '100%';

	/**
	 * @var int
	 */
	protected $_zoom = 5;

	/**
	 * @param Marker $marker
	 */
	public function add_marker( $marker ) {

		$this->_markers[] = $marker;

	}

	/**
	 * @param Marker[] $markers
	 */
	public function add_markers( $markers ) {

		$this->_markers = array_merge( $this->_markers, $markers );

	}

	/**
	 * @return array
	 */
	public function center() {

		$value = null;

		do {
			if ( isset( $this->_center ) ) {
				$value = $this->_center;
				break;
			}

			if ( 0 == count( $this->markers() ) ) {
				break;
			}

			$marker = $this->markers()[0];

			if ( $marker instanceof Marker ) {

				$value = $marker->position();

			}
		} while ( false );

		return $value;

	}

	/**
	 * @return string
	 */
	public function height() {

		return $this->_height;

	}

	/**
	 * @return string
	 */
	public function html_id() {

		if ( ! isset( $this->_html_id ) ) {
			$this->_html_id = sprintf( 'map-%1$s', md5( serialize( array( $this->center(), $this->markers() ) ) ) );
		}

		return $this->_html_id;

	}

	/**
	 * @return Marker[]
	 */
	public function markers() {

		return $this->_markers;

	}

	/**
	 * @return string
	 */
	public function width() {

		return $this->_width;

	}

	/**
	 * @return int
	 */
	public function zoom() {

		return $this->_zoom;

	}

	/**
	 * @param array $center
	 */
	public function set_center( $center ) {

		$center = wp_parse_args( $center, array(
			'lat' => null,
			'lng' => null,
		) );

		$this->_center = $center;

	}

	/**
	 * @param int $zoom
	 */
	public function set_zoom( $zoom ) {

		$this->_zoom = (int)$zoom;

	}

	/**
	 * @param string $height
	 */
	public function set_height( $height ) {

		$this->_height = $height;

	}

	/**
	 * @param string $html_id
	 */
	public function set_html_id( $html_id ) {

		$this->_html_id = $html_id;

	}

	/**
	 * @param array|string $styles
	 */
	public function set_styles( $styles ) {

		do {
			if ( is_string( $styles ) ) {
				$styles = json_decode( $styles, true );
			}

			if ( ! is_array( $styles ) ) {
				trigger_error( __( 'The style property must be an array' ) );
				break;
			}

			$this->_styles = $styles;
		} while ( false );

	}

	/**
	 * @return array
	 *
	 * @todo Refactor to make_params
	 */
	public function make_args() {

		return array(
			'center'          => $this->center(),
			'styles'          => $this->styles(),
			'zoom'            => (int)$this->zoom(),
		);

	}

}
