<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Model_Base
 * @package Clubdeuce\WPGoogleMaps
 *
 * @method array extra_args()
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

		foreach ( $args as $key => $value ) {

			$this->set( $key, $value );

		}

	}

	/**
	 * @param string $property
	 * @param mixed  $value
	 */
	public function set( $property, $value ) {

		do {
			if ( property_exists( get_called_class(), "_{$property}" ) ) {
				$property = "_{$property}";
				$this->{$property} = $value;
				break;
			}

			$this->_extra_args[ $property ] = $value;
		} while ( false );

	}

	/**
	 * @param string $method_name
	 * @param array  $args
	 *
	 * @return mixed|null
	 */
	public function __call( $method_name, $args ) {

		$value = null;

		do {
			if ( property_exists( $this, "_{$method_name}" ) ) {
				$property = "_{$method_name}";
				$value    = $this->{$property};
				break;
			}

			if ( isset( $this->extra_args()[ $method_name ] ) ) {
				$value = $this->extra_args()[ $method_name ];
				break;
			}
		} while ( false );

		return $value;

	}

}
