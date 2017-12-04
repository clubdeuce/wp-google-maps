<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Map
 * @package Clubdeuce\WPGoogleMaps
 *
 * @property Map_Model $_model
 * @property Map_View  $_view
 *
 * @method array center()
 * @method array Marker[]
 * @method array styles()
 * @method void  the_map()
 * @method void  the_map_params()
 * @method int   zoom()
 *
 * @mixin    Map_Model
 * @mixin    Map_View
 */
class Map extends Controller_Base {

	/**
	 * @var Map_Model
	 */
	protected $_model;

	/**
	 * @var Map_View
	 */
	protected $_view;

	/**
	 * Map constructor.
	 *
	 * @param array $args
	 */
	function __construct( $args = array() ) {

		$this->_model = $model = new Map_Model( $args );
		$this->_view  = new Map_View( $model );

	}

}
