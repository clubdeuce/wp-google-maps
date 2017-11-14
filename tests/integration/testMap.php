<?php

namespace Clubdeuce\WPGoogleMaps\Tests\Integration;

use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestMarker
 * @package            Clubdeuce\WPGoogleMaps\Tests\Integration
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Map
 * @group              Map
 * @group              Integration
 */
class TestMap extends TestCase {

	/**
	 * @var Map
	 */
	private $_map;

	public function setUp() {
		$this->_map = new Map(array('center' => array('lat' => 100, 'lng' => -100), 'zoom' => 12));

		$this->_map->add_marker(new Marker(array(
			'address'  => '1600 Amphitheatre Parkway, Mountain View, CA 94043, USA',
			'title'    => 'Sample Location'
		)));

		parent::setUp();
	}

	/**
	 * @covers ::center
	 */
	public function testCenter() {
		$this->assertEquals(array('lat' => 100, 'lng' => -100), $this->_map->center());
	}

	/**
	 * @covers ::zoom
	 */
	public function testZoom() {
		$this->assertEquals(12, $this->_map->zoom());
	}

	/**
	 * @covers \Clubdeuce\WPGoogleMaps\Marker::location
	 */
	public function testMarkers() {
		$markers = $this->_map->markers();

		$this->assertInternalType('array', $markers);

		$marker = $markers[0];
		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Location', $marker->location());
		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Marker_Label', $marker->label());
		$this->assertInternalType('double', $marker->latitude());
		$this->assertInternalType('double', $marker->longitude());
		$this->assertInternalType('string', $marker->title());
		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Info_Window', $marker->info_window());
		$this->assertInternalType('array', $marker->marker_args());
	}

}
