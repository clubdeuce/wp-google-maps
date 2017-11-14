<?php

namespace Clubdeuce\WPGoogleMaps\Tests\Integration;

use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class testMarker
 * @package Clubdeuce\WPGoogleMaps\Tests\Integration
 *
 * @coversDefaultClass \Clubdeuce\WPGoogleMaps\Marker
 * @group              Integration
 * @group              Marker
 */
class testMarker extends TestCase {

	/**
	 * @var Marker
	 */
	protected $_marker;

	public function setUp() {
		$this->_marker = new Marker(array('address' => '1600 Ampitheatre Parkway '));
	}

	/**
	 * @covers ::__construct
	 * @covers ::info_window
	 */
	public function testInfoWindow() {
		$window = $this->_marker->info_window();

		$this->assertInternalType('string', $window->content());
		$this->assertInternalType('integer', $window->pixel_offset());
		$this->assertInternalType('array', $window->position());
		$this->assertNull($window->max_width());
	}

	/**
	 * @covers ::__construct
	 * @covers \Clubdeuce\WPGoogleMaps\Marker::__construct
	 */
	public function testMarkerLabel() {
		$label = $this->_marker->label();

		$this->assertInternalType('string', $label->color());
		$this->assertInternalType('string', $label->font_family());
		$this->assertInternalType('string', $label->font_size());
		$this->assertInternalType('string', $label->font_weight());
		$this->assertInternalType('string', $label->text());
	}

}
