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

	public function setUp(): void {

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

	/**
	 * @covers  ::set_content
	 * @depends testContent
	 */
	public function testSetContent() {

		$this->_model->set_content( 'Foo Content' );
		$this->assertEquals( 'Foo Content', $this->_model->content() );

	}

	/**
	 * @covers  ::set_pixel_offset
	 * @depends testPixelOffset
	 */
	public function testSetPixelOffset() {

		$this->_model->set_pixel_offset( '22' );
		$this->assertEquals(22, $this->_model->pixel_offset() );

	}

	/**
	 * @covers  ::set_position
	 * @depends testPosition
	 */
	public function testSetPosition() {

		$this->_model->set_position(array('lat' => 123.45, 'lng' => -123.45));
		$this->assertEquals(array('lat' => 123.45, 'lng' => -123.45), $this->_model->position());

	}

	/**
	 * @covers  ::set_position
	 * @depends testSetPosition
	 */
	public function testSetPositionWrong() {

		$this->_model->set_position('foo');

		$position = $this->_model->position();

		$this->assertInternalType('array', $position);
		$this->assertArrayHasKey('lat', $position);
		$this->assertArrayHasKey('lng', $position);
		$this->assertNull($position['lat']);
		$this->assertNull($position['lng']);

	}

	/**
	 * @covers  ::set_max_width
	 * @depends testMaxWidth
	 */
	public function testSetMaxWidth() {

		$this->_model->set_max_width( '400px' );
		$this->assertEquals('400px', $this->_model->max_width());
	}
}
