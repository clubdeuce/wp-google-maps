<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Geocoder;
use Clubdeuce\WPGoogleMaps\HTTP;
use Clubdeuce\WPGoogleMaps\Location;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;
use Mockery\Mock;

/**
 * Class TestGeocoder
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Geocoder
 * @group              geocoder
 */
class TestGeocoder extends TestCase {

	/**
	 * @var Geocoder
	 */
	private $_geocoder;

	/**
	 * @var string
	 */
	private $_api_key = '12345';

	/**
	 *
	 */
	public function setUp(): void {
		$this->_geocoder = new Geocoder(['api_key' => $this->_api_key]);
	}

	/**
	 * @covers ::__construct
	 * @covers ::api_key
	 */
	public function testConstructorWithAPIKey() {
		$this->assertEquals($this->_api_key, $this->_geocoder->api_key());
	}

	/**
	 * @covers ::_make_url
	 */
	public function testMakeUrl() {
		$response = $this->reflectionMethodInvokeArgs($this->_geocoder, '_make_url', '123 Anywhere Street New York 10001');

		$this->assertIsString($response);
		$this->assertRegExp('/address\=123\+Anywhere\+Street\+New\+York\+10001/', $response);
		$this->assertRegExp("/key={$this->_api_key}/", $response);
	}

	/**
	 * @covers ::_make_location
	 */
	public function testMakeLocation() {
		$response = json_decode($this->get_sample_response(), true);

		/**
		 * @var Location $location
		 */
		$location = $this->reflectionMethodInvokeArgs($this->_geocoder, '_make_location', $response['results'][0] );

		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Location', $location);
		$this->assertEquals('1600 Amphitheatre Parkway, Mountain View, CA 94043, USA', $location->address());
		$this->assertEquals('1600 Amphitheatre Parkway, Mountain View, CA 94043, USA', $location->formatted_address());
		$this->assertEquals(37.4224764, $location->latitude());
		$this->assertEquals(-122.0842499, $location->longitude());
		$this->assertEquals('ChIJ2eUgeAK6j4ARbn5u_wAGqWA', $location->place_id());
		$this->assertIsArray($location->viewport());
		$this->assertArrayHasKey('northeast', $location->viewport());
		$this->assertArrayHasKey('southwest', $location->viewport());
		$this->assertIsArray($location->viewport()['northeast']);
		$this->assertArrayHasKey('lat', $location->viewport()['northeast']);
		$this->assertArrayHasKey('lng', $location->viewport()['northeast']);
		$this->assertEquals(37.4238253802915, $location->viewport()['northeast']['lat']);
		$this->assertEquals(-122.0829009197085, $location->viewport()['northeast']['lng']);
		$this->assertIsArray($location->viewport()['southwest']);
		$this->assertArrayHasKey('lat', $location->viewport()['southwest']);
		$this->assertArrayHasKey('lng', $location->viewport()['southwest']);
		$this->assertEquals(37.4211274197085, $location->viewport()['southwest']['lat']);
		$this->assertEquals(-122.0855988802915, $location->viewport()['southwest']['lng']);
		$this->assertEquals('CA', $location->state());
		$this->assertEquals('94043', $location->zip_code());
	}

	/**
	 * @covers ::_get_value_from_results
	 * @covers ::_get_state_from_results
	 */
	public function testGetStateFromResults() {
		$this->assertEquals('CA', $this->reflectionMethodInvokeArgs(
			$this->_geocoder,
			'_get_state_from_results',
			json_decode($this->get_sample_response(), true)['results'][0]
		));
	}

	/**
	 * @covers ::_get_value_from_results
	 * @covers ::_get_zip_from_results
	 */
	public function testGetZipFromResults() {
		$this->assertEquals('94043', $this->reflectionMethodInvokeArgs(
			$this->_geocoder,
			'_get_zip_from_results',
			json_decode($this->get_sample_response(), true)['results'][0]
		));
	}

	/**
	 * @covers ::geocode
	 */
	public function testGeocodeWithWPErrorResponse() {
		$http = \Mockery::mock(HTTP::class);

		$http->shouldReceive('make_request')->andReturn(new \WP_Error());

		$geocoder = new Geocoder(array('http' => $http));

		$this->assertInstanceOf(\WP_Error::class, $geocoder->geocode('foo'));
	}
}
