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
		$this->assertArrayHasKey('position', $item);
		$this->assertArrayHasKey('title', $item);
		$this->assertArrayHasKey('label', $item);
		$this->assertInternalType('array', $item['position']);
		$this->assertArrayHasKey('lat', $item['position']);
		$this->assertArrayHasKey('lng', $item['position']);
		$this->assertInternalType('string', $item['title']);
		$this->assertInternalType('string', $item['label']);
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
		$this->assertRegExp('#class="google-map"#', $output);
		$this->assertRegExp('#height: 400px#', $output);
		$this->assertRegExp('#width: 100%;#', $output);
	}

}
