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
		$this->_marker = new Marker(array(
			'address' => '1600 Ampitheatre Parkway',
			'title'   => 'Headquarters',
			'opacity' => 1.0,
		));
	}

	/**
	 * @covers ::__construct
	 * @covers \Clubdeuce\WPGoogleMaps\Model_Base::__call
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

	/**
	 * @covers ::marker_args
	 */
	public function testMarkerArgs() {
		$args = $this->_marker->marker_args();

		$this->assertInternalType('array', $args);
		$this->assertArrayHasKey('opacity', $args );
		$this->assertArrayHasKey('position', $args );
		$this->assertArrayHasKey('title', $args);
		$this->assertEquals(1.0, $args['opacity']);
		$this->assertEquals('Headquarters', $args['title']);
	}

	/**
	 * @covers \Clubdeuce\WPGoogleMaps\Model_Base::__call
	 */
	public function testMagicMethods() {
		$this->assertEquals(1.0, $this->_marker->opacity());
		$this->assertEquals('Headquarters', $this->_marker->title());
	}

}
