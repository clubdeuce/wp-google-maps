<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Model_Base
 * @package Clubdeuce\WPGoogleMaps
 */
class Model_Base {

	/**
	 * @var array
	 */
	protected $_extra_args;

	/**
	 * Model_Base constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		$args = wp_parse_args( $args );

		foreach ( $args as $key => $arg ) {

			if ( property_exists( $this, "_{$key}" ) ) {
				$property = "_{$key}";
				$this->{$property} = $arg;
			}

		}

	}

	/**
	 * @param string $method_name
	 * @param array  $args
	 *
	 * @return mixed|null
	 */
	public function __call( $method_name, $args ) {

		$value = null;

		if ( property_exists( $this, "_{$method_name}" ) ) {
			$property = "_{$method_name}";
			$value    = $this->{$property};
		}

		return $value;

	}

}
