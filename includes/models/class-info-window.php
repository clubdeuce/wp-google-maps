<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Info_Window
 * @package Clubdeuce\WPGoogleMaps
 */
class Info_Window extends Model_Base {

	/**
	 * @var string
	 */
	protected $_content = '';

	/**
	 * @var int
	 */
	protected $_pixel_offset = 0;

	/**
	 * @var array
	 */
	protected $_position;

	/**
	 * @var int
	 */
	protected $_max_width;

	/**
	 * @param string $content
	 */
	public function set_content( $content ) {

		$this->_content = $content;

	}

	/**
	 * @param int $offset
	 */
	public function set_pixel_offset( $offset ) {

		$this->_pixel_offset = $offset;

	}

	/**
	 * @param array $position
	 */
	public function set_position( $position ) {

		$position = wp_parse_args( $position, array(
			'lat' => null,
			'lng' => null,
		) );

		$this->_position = $position;

	}

	/**
	 * @param int $width
	 */
	public function set_max_width( $width ) {

		$this->_max_width = $width;

	}

}
