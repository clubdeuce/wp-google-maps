<?php

namespace Clubdeuce\WPGoogleMaps\Tests\Integration;

use Clubdeuce\WPGoogleMaps\Geocoder;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestGeocoder
 * @package            Clubdeuce\WPGoogleMaps\Tests\Integration
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Geocoder
 * @group              geocoder
 */
class TestGeocoder extends TestCase {

	/**
	 * @var Geocoder;
	 */
	private $_geocoder;

	public function setUp() {
		$this->_geocoder = new Geocoder();
	}

	/**
	 * @covers ::geocode
	 * @covers ::_make_location
	 * @covers ::_make_url
	 * @covers ::_make_request
	 * @covers ::_get_data
	 */
	public function testGeocode() {
		$location = $this->_geocoder->geocode('1600 Amphitheatre Parkway, Mountain View, CA 94043');

		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Location', $location);
		$this->assertInternalType('string', $location->address());
		$this->assertInternalType('string', $location->formatted_address());
		$this->assertInternalType('double', $location->latitude());
		$this->assertInternalType('double', $location->longitude());
		$this->assertInternalType('array', $location->viewport());
		$this->assertArrayHasKey('northeast', $location->viewport());
		$this->assertArrayHasKey('southwest', $location->viewport());
		$this->assertInternalType('array', $location->viewport()['northeast']);
		$this->assertArrayHasKey('lat', $location->viewport()['northeast']);
		$this->assertArrayHasKey('lng', $location->viewport()['northeast']);
		$this->assertInternalType('double', $location->viewport()['northeast']['lat']);
		$this->assertInternalType('double', $location->viewport()['northeast']['lng']);
		$this->assertInternalType('array', $location->viewport()['southwest']);
		$this->assertArrayHasKey('lat', $location->viewport()['southwest']);
		$this->assertArrayHasKey('lng', $location->viewport()['southwest']);
		$this->assertInternalType('double', $location->viewport()['southwest']['lat']);
		$this->assertInternalType('double', $location->viewport()['southwest']['lng']);
	}
}
