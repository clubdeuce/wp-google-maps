<?php

namespace Clubdeuce\WPGoogleMaps\Tests\Integration;

use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Map_Model;
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
		$this->_map = new Map(array(
			'center'  => array('lat' => 100, 'lng' => -100),
			'html_id' => 'foo-id',
			'styles'  => array('foo' => 'bar'),
			'zoom'    => 12
		));

		$this->_map->add_marker(new Marker(array(
			'address'       => '1600 Amphitheatre Parkway, Mountain View, CA 94043, USA',
			'title'         => 'Sample Location',
			'opacity'       => 0.5,
		)));

		parent::setUp();
	}

	/**
	 * @covers ::__call
	 */
	public function testCenter() {
		$this->assertEquals(array('lat' => 100, 'lng' => -100), $this->_map->center());
	}

	/**
	 * @covers ::__call
	 */
	public function testZoom() {
		$this->assertEquals(12, $this->_map->zoom());
	}

	/**
	 * @covers \Clubdeuce\WPGoogleMaps\Marker::location
	 * @covers \Clubdeuce\WPGoogleMaps\Marker::marker_args
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
		$this->assertInternalType('array', $args = $marker->marker_args());
		$this->assertArrayHasKey('title', $args);
		$this->assertArrayHasKey('opacity', $args);

	}

	/**
	 * @covers ::__construct
	 * @covers \Clubdeuce\WPGoogleMaps\Controller_Base::__call
	 * @covers \Clubdeuce\WPGoogleMaps\Model_Base::__call
	 */
	public function testStyle() {
		$style = $this->_map->styles();

		$this->assertInternalType('array', $style);
		$this->assertArrayHasKey('foo', $style);
		$this->assertEquals('bar', $style['foo']);
	}

	/**
	 * @covers ::__construct
	 * @covers \Clubdeuce\WPGoogleMaps\Controller_Base::__call
	 * @covers \Clubdeuce\WPGoogleMaps\Map_View::the_map_params
	 * @covers \Clubdeuce\WPGoogleMaps\Map_View::_map_params
	 */
	public function testMapParams() {
		ob_start();
		$this->_map->the_map_params();

		$params = ob_get_clean();

		$this->assertInternalType('string', $params);

		$params = json_decode($params, true);
		$this->assertInternalType('array', $params);
		$this->assertArrayHasKey('center', $params);
		$this->assertArrayHasKey('zoom', $params);
	}
}
