<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Info_Window;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestInfoWindowModel
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Info_Window
 * @group              InfoWindow
 */
class TestInfoWindowModel extends TestCase {

	/**
	 * @var Info_Window
	 */
	private $_model;

	public function setUp() {

		$this->_model = new Info_Window(array(
			'content'      => 'Lorem ipsum dolor est.',
			'pixel_offset' => 20,
			'position'    => array('lat' => 100.946382, 'lng' => -100.9473927),
			'max_width'    => 500,

		));
		parent::setUp();

	}

	/**
	 * @coversNothing
	 */
	public function testContent() {

		$this->assertEquals('Lorem ipsum dolor est.', $this->_model->content());

	}

	/**
	 * @coversNothing
	 */
	public function testPixelOffset() {

		$this->assertEquals(20, $this->_model->pixel_offset());

	}

	/**
	 * @coversNothing
	 */
	public function testPosition() {

		$this->assertEquals(array('lat' => 100.946382, 'lng' => -100.9473927), $this->_model->position());

	}

	/**
	 * @coversNothing
	 */
	public function testMaxWidth() {

		$this->assertEquals(500, $this->_model->max_width());

	}

}
