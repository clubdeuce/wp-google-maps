<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Map_View;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class testMapView
 * @package Clubdeuce\WPGoogleMaps\Tests\UnitTests
 *
 * @coversDefaultClass \Clubdeuce\WPGoogleMaps\Map_View
 */
class testMapView extends TestCase {

	/**
	 * @var Map_View
	 */
	protected $_view;

	public function setUp() {
		$this->_view = new Map_View($this->getMockMapModel());
		parent::setUp();
	}

	/**
	 * @covers ::_make_markers_args
	 * @covers ::__construct
	 */
	public function testMakeMarkersArgs() {
		$args = $this->reflectionMethodInvoke($this->_view, '_make_markers_args');

		$this->assertInternalType('array', $args);

		$item = $args[0];
		$this->assertArrayHasKey('icon', $item);
		$this->assertInternalType('array', $item['icon']);
		$this->assertArrayHasKey('url', $item['icon']);
		$this->assertArrayHasKey('position', $item);
		$this->assertArrayHasKey('title', $item);
		$this->assertArrayHasKey('label', $item);
		$this->assertInternalType('array', $item['position']);
		$this->assertArrayHasKey('lat', $item['position']);
		$this->assertArrayHasKey('lng', $item['position']);
		$this->assertInternalType('string', $item['title']);
		$this->assertInternalType('array', $item['label']);
	}

	/**
	 * @covers ::_make_label_args
	 */
	public function testMakeLabelArgs() {
		$args = $this->reflectionMethodInvokeArgs($this->_view, '_make_label_args', $this->getMockLabel());

		$this->assertInternalType('array', $args);
		$this->assertArrayHasKey('fontFamily', $args);
		$this->assertArrayHasKey('fontSize', $args);
		$this->assertArrayHasKey('fontWeight', $args);
		$this->assertArrayHasKey('text', $args);
	}

	/**
	 * @covers ::_make_info_windows
	 * @covers ::__construct
	 */
	public function testMakeInfoWindows() {
		$windows = $this->reflectionMethodInvoke($this->_view, '_make_info_windows');

		$this->assertInternalType('array', $windows);

		$window = $windows[0];

		$this->assertInternalType('array', $window);
		$this->assertArrayHasKey('content', $window);
		$this->assertArrayHasKey('pixel_offset', $window);
		$this->assertArrayHasKey('position', $window);
		$this->assertArrayHasKey('max_width', $window);
	}

	/**
	 * @covers ::the_map
	 * @covers ::__construct
	 */
	public function testTheMap() {
		ob_start();
		$this->_view->the_map();
		$output = ob_get_clean();

		$this->assertRegExp('#^<div id="map-foo"#', $output);
		$this->assertRegExp('#class="wp-google-map"#', $output);
	}

	/**
	 * @covers ::_map_params
	 */
	public function testMapParams() {

		$params = $this->reflectionMethodInvoke($this->_view, '_map_params');

		$this->assertInternalType('array', $params);

		$this->assertArrayHasKey('center', $params);
		$this->assertArrayHasKey('zoom', $params);
	}
}
