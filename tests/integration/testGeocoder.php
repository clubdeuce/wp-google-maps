<?php

namespace Clubdeuce\WPGoogleMaps\Tests\Integration;

use Clubdeuce\WPGoogleMaps\Geocoder;
use Clubdeuce\WPGoogleMaps\Google_Maps;
use Clubdeuce\WPGoogleMaps\Location;
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

	public function setUp(): void {
		Google_Maps::register_api_key(getenv('MAPS_API_KEY'));
		$this->_geocoder = new Geocoder();
	}

	/**
	 * @covers ::geocode
	 * @covers ::_make_location
	 * @covers ::_make_url
	 */
	public function testGeocode() {
		$location = $this->_geocoder->geocode('1600 Pennsylvania Avenue NW Washington DC');

		$this->assertInstanceOf(Location::class, $location);
		$this->assertIsString($location->address());
		$this->assertIsString($location->formatted_address());
		$this->assertIsFloat($location->latitude());
		$this->assertIsFloat($location->longitude());
		$this->assertIsArray($location->viewport());
		$this->assertArrayHasKey('northeast', $location->viewport());
		$this->assertArrayHasKey('southwest', $location->viewport());
		$this->assertIsArray($location->viewport()['northeast']);
		$this->assertArrayHasKey('lat', $location->viewport()['northeast']);
		$this->assertArrayHasKey('lng', $location->viewport()['northeast']);
		$this->assertIsFloat($location->viewport()['northeast']['lat']);
		$this->assertIsFloat($location->viewport()['northeast']['lng']);
		$this->assertIsArray($location->viewport()['southwest']);
		$this->assertArrayHasKey('lat', $location->viewport()['southwest']);
		$this->assertArrayHasKey('lng', $location->viewport()['southwest']);
		$this->assertIsFloat($location->viewport()['southwest']['lat']);
		$this->assertIsFloat($location->viewport()['southwest']['lng']);
	}

	/**
	 * @covers ::geocode
	 */
	public function testGeocodeFailureBadAPIKey() {

		$geocoder = new Geocoder(array('api_key' => 'foo'));
		$this->assertInstanceOf( \WP_Error::class, $geocoder->geocode('1600 Pennsylvania Avenue NW Washington DC'));

	}
}
