<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;
use Mockery\Mock;

/**
 * Class TestMarkerModel
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Marker
 * @group              Marker
 */
class TestMarkerModel extends TestCase {

	/**
	 * @var Marker
	 */
	private $_model;

	/**
	 * @var array
	 */
	private $_position = array('lat' => 37.4224764, 'lng' => -122.0842499);

	public function setUp() {

		$this->_model = new Marker([
			'address'  => $this->_address,
			'geocoder' => $this->getMockGeocoder(),
			'info_window' => $this->getMockInfoWindow(),
			'title'    => 'Sample Title',
			'label'    => '12',
		]);
	}

	/**
	 * @covers ::latitude
	 */
	public function testLatitude() {
		$this->assertEquals($this->_position['lat'], $this->_model->latitude());
	}

	/**
	 * @covers ::longitude
	 */
	public function testLongitude() {
		$this->assertEquals($this->_position['lng'], $this->_model->longitude());
	}

	/**
	 * @covers ::_geocoder
	 */
	public function testGeocoder() {
		$this->assertEquals($this->getMockGeocoder(), $this->reflectionMethodInvoke($this->_model, '_geocoder'));
	}

	/**
	 * @covers ::_geocoder
	 */
	public function testCreateGeocoder() {
		$Marker = new Marker();
		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Geocoder',  $this->reflectionMethodInvoke($Marker, '_geocoder'));
	}

	/**
	 * @covers ::position
	 */
	public function testPosition() {
		$this->assertEquals($this->_position, $this->_model->position());
	}

	/**
	 * @covers ::title
	 */
	public function testTitle() {
		$this->assertEquals('Sample Title', $this->_model->title());
	}

	/**
	 * @covers ::label
	 */
	public function testLabel() {

		$this->assertInstanceOf('\Clubdeuce\WPGoogleMaps\Marker_Label', $this->_model->label());

	}

	/**
	 * @covers ::location
	 */
	public function testLocation() {

		$this->assertEquals($this->getMockLocation(), $this->_model->location());
	}

	/**
	 * @covers ::info_window
	 */
	public function testInfoWindow() {

		$this->assertEquals($this->getMockInfoWindow(), $this->_model->info_window());
	}

	/**
	 * @covers ::marker_args
	 */
	public function testMarkerArgs() {

		$args = $this->_model->marker_args();

		$this->assertInternalType('array', $args);
		$this->assertArrayHasKey('position', $args);
		$this->assertArrayHasKey('label', $args);
		$this->assertArrayHasKey('title', $args);
		$this->assertEquals($this->_position, $args['position']);
		$this->assertEquals('Sample Title', $args['title']);
		$this->assertArrayNotHasKey('icon', $args);
	}

	/**
	 * @covers ::set_icon
	 * @covers ::icon
	 */
	public function testSetIcon() {

		$this->_model->set_icon('http://example.com/foo.png');

		$this->assertInternalType('array', $icon = $this->_model->icon() );
		$this->assertArrayHasKey('url', $icon);
		$this->assertInternalType('string', $icon['url']);
		$this->assertEquals('http://example.com/foo.png', $icon['url']);

	}

}
