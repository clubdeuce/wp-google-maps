<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class testMap
 * @package Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Map
 * @group Map
 */
class testMapModel extends TestCase {

	/**
	 * @var array
	 */
	private $_center = array( 'lat' => 100.23435532, 'lng' => -100.1234642345325 );

	/**
	 * @var Map
	 */
	private $_model;

	public function setUp() {

		$this->_model = new Map(array('center' => $this->_center, 'markers' => array('foo', 'bar', 'baz'), 'zoom' => 12));

	}

	/**
	 * @covers ::center
	 */
	public function testCenter() {

		$this->assertEquals($this->_center, $this->_model->center());

	}

	/**
	 * @covers ::markers
	 */
	public function testMarkers() {

		$this->assertEquals(array('foo','bar','baz'), $this->_model->markers());

	}

	/**
	 * @depends testMarkers
	 * @covers ::add_marker
	 */
	function testAddMarker() {

		$this->_model->add_marker('foobar');

		$this->assertContains('foobar', $this->_model->markers());

	}

	/**
	 * @depends testMarkers
	 * @covers ::add_markers
	 */
	function testAddMarkers() {

		$this->_model->add_markers(array('foobar', 'barbaz'));

		$markers = $this->_model->markers();

		$this->assertContains('foobar', $markers);
		$this->assertContains('barbaz', $markers);

	}

	/**
	 * @covers ::zoom
	 */
	public function testZoom() {
		$this->assertEquals(12, $this->_model->zoom());
	}

	/**
	 * @covers ::make_args
	 */
	public function testMakeArgs() {

		$args = $this->_model->make_args();

		$this->assertInternalType('array', $args);
		$this->assertArrayHasKey('center', $args);
		$this->assertArrayHasKey('zoom', $args);
		$this->assertInternalType('array', $args['center']);
		$this->assertInternalType('integer', $args['zoom']);
		$this->assertArrayHasKey('lat', $args['center']);
		$this->assertArrayHasKey('lat', $args['center']);
		$this->assertInternalType('float', $args['center']['lat']);
		$this->assertInternalType('float', $args['center']['lng']);

	}

	/**
	 * @covers ::height
	 */
	public function testHeight() {

		$this->assertEquals('400px', $this->_model->height());

	}

	/**
	 * @covers ::width
	 */
	public function testWidth() {

		$this->assertEquals('100%', $this->_model->width());

	}

	/**
	 * @covers ::html_id
	 */
	public function testHtmlId() {

		$id = $this->_model->html_id();

		$this->assertInternalType('string', $id);
		$this->assertStringStartsWith('map-', $id);

	}

}
