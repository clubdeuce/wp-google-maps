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

	public function setUp(): void {
		$this->_view = new Map_View($this->getMockMapModel());
		parent::setUp();
	}

	/**
	 * @covers ::_make_markers_args
	 * @covers ::_make_marker_args
	 * @covers ::__construct
	 */
	public function testMakeMarkersArgs() {
		$args = $this->reflectionMethodInvoke($this->_view, '_make_markers_args');

		$this->assertIsArray($args);

		$item = $args[0];
		$this->assertArrayHasKey('opacity', $item);
		$this->assertEquals(1.0, $item['opacity']);
		$this->assertArrayHasKey('position', $item);
		$this->assertArrayHasKey('title', $item);
		$this->assertArrayHasKey('label', $item);
		$this->assertIsArray($item['position']);
		$this->assertArrayHasKey('lat', $item['position']);
		$this->assertArrayHasKey('lng', $item['position']);
		$this->assertIsString($item['title']);
		$this->assertIsArray($item['label']);
	}

	/**
	 * @covers ::_make_label_args
	 */
	public function testMakeLabelArgs() {
		$args = $this->reflectionMethodInvokeArgs($this->_view, '_make_label_args', $this->getMockLabel());

		$this->assertIsArray($args);
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

		$this->assertIsArray($windows);

		$window = $windows[0];

		$this->assertIsArray($window);
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

		$this->assertMatchesRegularExpression('#^<div id="map-foo"#', $output);
		$this->assertMatchesRegularExpression('#class="wp-google-map"#', $output);
	}

	/**
	 * @covers ::_map_params
	 */
	public function testMapParams() {

		$params = $this->reflectionMethodInvoke($this->_view, '_map_params');

		$this->assertIsArray($params);

		$this->assertArrayHasKey('center', $params);
		$this->assertArrayHasKey('zoom', $params);
	}

	/**
	 * @covers ::_camel_case
	 */
	public function testCamelCase() {

		$this->assertEquals('fooBarBaz', $this->reflectionMethodInvokeArgs( $this->_view, '_camel_case', 'foo_bar_baz'));

	}
}
