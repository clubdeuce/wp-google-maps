<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Marker_Label;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class testMarkerLabelModel
 * @package Clubdeuce\WPGoogleMaps\Tests\UnitTests
 *
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Marker_Label
 *
 * @group MarkerLabel
 * @group Marker
 */
class testMarkerLabelModel extends TestCase {

	/**
	 * @var Marker_Label
	 */
	private $_model;

	public function setUp() {

		$this->_model = new Marker_Label();
		parent::setUp();

	}

	/**
	 * @covers ::color
	 * @covers ::font_family
	 * @covers ::font_size
	 * @covers ::font_weight
	 * @covers ::text
	 * @covers ::__construct
	 */
	public function testDefaults() {

		$this->assertEquals('black', $this->_model->color());
		$this->assertInternalType('string', $this->_model->font_family());
		$this->assertEmpty($this->_model->font_family());
		$this->assertEquals('14px', $this->_model->font_size());
		$this->assertEquals('400', $this->_model->font_weight());
		$this->assertInternalType('string', $this->_model->text());
		$this->assertEmpty($this->_model->text());

	}

	/**
	 * @covers ::color
	 * @covers ::font_family
	 * @covers ::font_size
	 * @covers ::font_weight
	 * @covers ::text
	 * @covers ::__construct
	 * @depends testDefaults
	 */
	public function testPassedArguments() {

		$model = new Marker_Label(array(
			'color'       => 'blue',
			'font_family' => 'Arial',
			'font_size'   => '22px',
			'font_weight' => 900,
			'text'        => 'Lorem ipsum dolor est',
		));

		$this->assertEquals('blue', $model->color());
		$this->assertEquals('Arial', $model->font_family());
		$this->assertEquals('22px', $model->font_size());
		$this->assertEquals('900', $model->font_weight());
		$this->assertEquals('Lorem ipsum dolor est', $model->text());

	}

	/**
	 * @covers ::options
	 */
	public function testOptionsEmpty() {
		$this->assertEmpty($this->_model->options());
	}

	/**
	 * @covers ::__construct
	 * @depends testPassedArguments
	 */
	public function testOptions() {
		$label = new Marker_Label(array(
			'color'       => 'blue',
            'font_family' => 'Arial',
            'font_size'   => '22px',
            'font_weight' => 900,
            'text'        => 'Lorem ipsum dolor est',
			)
		);

		$options = $label->options();

		$this->assertInternalType('array', $options);
		$this->assertArrayHasKey('color', $options);
		$this->assertArrayHasKey('fontFamily', $options);
		$this->assertArrayHasKey('fontSize', $options);
		$this->assertArrayHasKey('fontWeight', $options);
		$this->assertArrayHasKey('text', $options);
	}

	/**
	 * @covers ::json_object
	 */
	public function testJsonObject() {
		$options = array(
			'color'       => 'blue',
			'font_family' => 'Arial',
			'font_size'   => '22px',
			'font_weight' => 900,
			'text'        => 'Lorem ipsum dolor est',
		);

		$label = new Marker_Label($options);

		$expected = json_encode(array(
			'color'      => 'blue',
			'fontFamily' => 'Arial',
			'fontSize'   => '22px',
			'fontWeight' => '900',
			'text'       => 'Lorem ipsum dolor est',
		));

		$this->assertEquals($expected, $label->json_object());
	}
}
