<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Map_Model;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class testMap
 * @package Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Map_Model
 * @group Map
 */
class testMapModel extends TestCase {

	/**
	 * @var array
	 */
	private $_center = array( 'lat' => 100.23435532, 'lng' => -100.1234642345325 );

	/**
	 * @var Map_Model
	 */
	private $_model;

	public function setUp(): void {

		$this->_model = new Map_Model(array(
			'center'  => $this->_center,
			'markers' => array('foo', 'bar', 'baz'),
			'style'   => array('foo' => 'bar'),
			'zoom'    => 12
		));

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

	/**
	 * @covers  ::set_center
	 * @covers  ::center
	 * @depends testCenter
	 */
	public function testSetCenter() {

		$this->_model->set_center(array( 'lat' => 123.45, 'lng' => -123.45 ));
		$this->assertEquals(array( 'lat' => 123.45, 'lng' => -123.45 ), $this->_model->center());

	}

	/**
	 * @covers  ::set_zoom
	 * @covers  ::zoom
	 * @depends testZoom
	 */
	public function testSetZoom() {

		$this->_model->set_zoom(1);
		$this->assertEquals(1, $this->_model->zoom());

	}

	/**
	 * @covers  ::set_height
	 * @covers  ::height
	 * @depends testHeight
	 */
	public function testSetHeight() {

		$this->_model->set_height('1px');
		$this->assertEquals('1px', $this->_model->height());

	}

	/**
	 * @covers  ::set_html_id
	 * @covers  ::html_id
	 * @depends testHtmlId
	 */
	public function testSetHtmlId() {

		$this->_model->set_html_id('fooid');
		$this->assertEquals('fooid', $this->_model->html_id());

	}

}
