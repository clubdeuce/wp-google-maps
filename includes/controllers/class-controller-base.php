<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Controller_Base
 * @package Clubdeuce\WPGoogleMaps
 */
class Controller_Base {

	/**
	 * @var Model_Base
	 */
	protected $_model;

	/**
	 * @var object
	 */
	protected $_view;

	/**
	 * @param  string $method
	 * @param  array  $args
	 *
	 * @return mixed|null
	 */
	function __call( $method, $args ) {

		$value = null;

		do {
			if ( method_exists( $this->_view, $method ) ) {
				$value = call_user_func_array( array( $this->_view, $method ), $args );
				break;
			}

			$value = call_user_func_array( array( $this->_model, $method ), $args );
		} while ( false );

		return $value;

	}

}
