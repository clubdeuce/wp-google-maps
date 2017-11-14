<?php

namespace Clubdeuce\WPGoogleMaps\Tests;
use Mockery\Mock;

/**
 * Class TestCase
 * @package Clubdeuce\WPLib\Components\GoogleMaps\Tests
 */
class TestCase extends \WP_UnitTestCase {

	/**
	 * @param $class
	 * @param $property
	 * @return mixed
	 */
	public function getReflectionPropertyValue( $class, $property )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->getValue( $class );
	}

	/**
	 * @param $class
	 * @param $property
	 * @param $value
	 */
	public function setReflectionPropertyValue( $class, $property, $value )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->setValue( $class, $value );
	}

	/**
	 * @param $class
	 * @param $method
	 * @return mixed
	 */
	public function reflectionMethodInvoke( $class, $method )
	{
		$reflection = new \ReflectionMethod( $class, $method );
		$reflection->setAccessible( true );
		if (is_string($class)) {
			$class = null;
		}
		return $reflection->invoke( $class );
	}

	/**
	 * @param  object $class
	 * @param  string $method
	 * @param  $args
	 * @return mixed
	 */
	public function reflectionMethodInvokeArgs( $class, $method, $args )
	{
		$reflection = new \ReflectionMethod( $class, $method );
		$reflection->setAccessible( true );
		if (is_string($class)) {
			$class = null;
		}

		return $reflection->invoke( $class, $args );
	}

	/**
	 * @return string
	 */
	protected function get_sample_response() {

		return file_get_contents( __DIR__ . '/geocoder-response.json' );

	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockGeocoder() {
		$geocoder = \Mockery::mock('\Clubdeuce\WPGoogleMaps\Geocoder');
		$geocoder->shouldReceive('geocode')->andReturn($this->getMockLocation());

		return $geocoder;
	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockLocation() {
		$location = \Mockery::mock('\Clubdeuce\WPGoogleMaps\Location');
		$location->shouldReceive('address')->andReturn('1600 Amphitheatre Parkway, Mountain View, CA 94043, USA');
		$location->shouldReceive('formatted_address')->andReturn('1600 Amphitheatre Parkway, Mountain View, CA 94043, USA');
		$location->shouldReceive('state')->andReturn('CA');
		$location->shouldReceive('zip_code')->andReturn('94043');
		$location->shouldReceive('latitude')->andReturn(37.4224764);
		$location->shouldReceive('longitude')->andReturn(-122.0842499);
		$location->shouldReceive('place_id')->andReturn('ChIJ2eUgeAK6j4ARbn5u_wAGqWA');
		$location->shouldReceive('type')->andReturn('street_address');
		$location->shouldReceive('viewport')->andReturn(array(
			'northeast' => array(
				'lat'   => 37.4238253802915,
				'lng'   => -122.0829009197085
			),
			'sourhwest' => array(
				'lat'   => 37.4211274197085,
				'lng'   => -122.0855988802915
			)
		));

		return $location;
	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockLabel() {

		$label = \Mockery::mock('\Clubdeuce\WPGoogleMaps\Marker_Label');

		$label->shouldReceive('color')->andReturn('black');
		$label->shouldReceive('font_family')->andReturn('Helvetica');
		$label->shouldReceive('font_size')->andReturn('14');
		$label->shouldReceive('font_weight')->andReturn(400);
		$label->shouldReceive('text')->andReturn('Sample Label Text');

		return $label;

	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockInfoWindow() {

		$window = \Mockery::mock('\Clubdeuce\WPGoogleMaps\Info_Window');

		$window->shouldReceive('content')->andReturn('Sample Info Window Content');
		$window->shouldReceive('pixel_offset')->andReturn(12);
		$window->shouldReceive('position')->andReturn(null);
		$window->shouldReceive('max_width')->andReturn(null);
		return $window;

	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockMarker() {

		$marker = \Mockery::mock('\Clubeuce\WPGoogleMaps\Marker');

		$marker->shouldReceive('label')->andReturn($this->getMockLabel());
		$marker->shouldReceive('position')->andReturn(array('lat' => 100, 'lng' => -100));
		$marker->shouldReceive('title')->andReturn('Sample Title');
		$marker->shouldReceive('info_window')->andReturn($this->getMockInfoWindow());

		return $marker;
	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getMockMapModel() {

		$model = \Mockery::mock('\Clubdeuce\WPGoogleMaps\Map');

		$model->shouldReceive('markers')->andReturn(array($this->getMockMarker()));
		$model->shouldReceive('height')->andReturn(400);
		$model->shouldReceive('width')->andReturn('100%');
		$model->shouldReceive('html_id')->andReturn('map-foo');
		$model->shouldReceive('make_args')->andReturn(array('center' => array('lat' => 100, 'lng' => -100), 'zoom' => 5));
		return $model;
	}
}
