<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Location
 * @package Clubdeuce\WPGoogleMaps
 *
 * @method  string address()
 * @method  string formatted_address()
 * @method  string state()
 * @method  string zip_code()
 * @method  float  latitude()
 * @method  string location_type()
 * @method  float  longitude()
 * @method  string place_id()
 * @method  array  type()
 * @method  array  viewport()
 */
class Location extends Model_Base {

	/**
	 * @var string
	 */
	protected $_address;

	/**
	 * @var string
	 */
	protected $_formatted_address;

	/**
	 * @var string
	 */
	protected $_state;

	/**
	 * @var string
	 */
	protected $_zip_code;

	/**
	 * @var float
	 */
	protected $_latitude;

	/**
	 * @var string
	 */
	protected $_location_type;

	/**
	 * @var float
	 */
	protected $_longitude;

	/**
	 * @var string
	 */
	protected $_place_id;

	/**
	 * @var array
	 */
	protected $_viewport = array();

}
