<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Location;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestLocationModel
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Model_Base
 * @group              location
 */
class TestLocationModel extends TestCase {

	/**
	 * @var Location
	 */
	private $_location;

	public function setUp(): void {
		$this->_location = new Location([
			'address'           => '1600 Amphitheatre Parkway Mountain View CA',
			'formatted_address' => '1600 Amphitheatre Parkway, Mountain View, CA, 12345',
			'latitude'          => 100.12345,
			'longitude'         => -100.12345,
			'place_id'          => 'foobar',
			'viewport'          => ['foo', 'bar'],
		] );
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testAddress() {
		$this->assertEquals('1600 Amphitheatre Parkway Mountain View CA', $this->_location->address());
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testFormattedAddress() {
		$this->assertEquals('1600 Amphitheatre Parkway, Mountain View, CA, 12345', $this->_location->formatted_address());
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testLatitude() {
		$this->assertEquals(100.12345, $this->_location->latitude());
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testLongitude() {
		$this->assertEquals(-100.12345, $this->_location->longitude());
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testPlaceId() {
		$this->assertEquals('foobar', $this->_location->place_id());
	}

	/**
	 * @covers ::__call
	 * @covers ::__construct
	 */
	public function testViewport() {
		$this->assertEquals(['foo', 'bar'], $this->_location->viewport());
	}

}
