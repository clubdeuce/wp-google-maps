<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Model_Base;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestModelBase
 * @package Clubdeuce\WPGoogleMaps\Tests\UnitTests
 *
 * @coversDefaultClass \Clubdeuce\WPGoogleMaps\Model_Base
 */
class TestModelBase extends TestCase {

	/**
	 * @var Model_Base
	 */
	protected $_model;

	public function setUp() {
		$this->_model = new Model_Base(array('foo' => 'bar'));
	}

	/**
	 * @covers ::__construct
	 */
	public function testExtraArgsAreSet() {
		$this->assertEquals('bar', $this->_model->extra_args()['foo']);
	}
	/**
	 * @covers ::__call
	 */
	public function testCallReturnsNullWhenNoProperty() {
		$this->assertNull($this->_model->bar());
	}

	/**
	 * @covers ::__call
	 */
	public function testCallForExtraArgs() {
		$this->assertEquals('bar', $this->_model->foo());
	}

}