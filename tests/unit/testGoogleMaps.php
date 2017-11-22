<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\Geocoder;
use Clubdeuce\WPGoogleMaps\Google_Maps;
use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestGoogleMaps
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\Google_Maps
 */
class TestGoogleMaps extends TestCase {

	/**
	 * @covers ::register_api_key
	 * @covers ::api_key
	 */
	public function testAPIKey() {

		Google_Maps::register_api_key('12345');
		$this->assertEquals('12345', Google_Maps::api_key());

	}

	/**
	 * @covers ::geocoder
	 */
	public function testGeocoder() {

		$this->assertInstanceOf(Geocoder::class, Google_Maps::geocoder());

	}

	/**
	 * @covers ::make_new_map
	 */
	public function testMakeNewMap() {

		$this->assertInstanceOf(Map::class, Google_Maps::make_new_map());

	}

	/**
	 * @covers ::register_script_condition
	 * @covers ::script_conditions
	 */
	public function testScriptConditions() {

		Google_Maps::register_script_condition('is_search');

		$conditions = Google_Maps::script_conditions();

		$this->assertInternalType('array', $conditions);
		$this->assertContains('is_search', $conditions);

	}

	/**
	 * @covers ::_wp_enqueue_scripts_9
	 * @covers ::_evaluate_conditions
	 * @covers ::_register_scripts
	 */
	public function testScriptsAreEnqueued() {

		Google_Maps::register_script_condition(true);
		do_action('wp_enqueue_scripts');

		$this->assertTrue(wp_script_is('google-maps',  'enqueued'));
		$this->assertTrue(wp_script_is('map-control', 'enqueued'));

	}

	/**
	 * @covers ::make_marker_by_address
	 */
	public function testMakeMarkerByAddress() {

		$this->assertInstanceOf(Marker::class, Google_Maps::make_marker_by_address('123 Anywhere Street'));

	}

	/**
	 * @covers ::make_marker_by_position
	 */
	public function testMakeMarkerByPosition() {

		$marker = Google_Maps::make_marker_by_position( 123.45, -123.45);

		$this->assertInstanceOf(Marker::class, $marker);

	}

	/**
	 * @covers ::driving_directions_href
	 */
	public function testDrivingDirectionsHref() {

		$address = '123 Anywhere Street';
		$uri     = Google_Maps::driving_directions_href($address);
		$pattern = sprintf('#^https://.*?%1$s.*?#', preg_quote(urlencode($address)));

		$this->assertRegExp($pattern, $uri);
		$this->assertNotFalse(wp_http_validate_url($uri));

	}

	/**
	 * @covers ::version
	 */
	public function testVersion() {

		$this->assertInternalType('string', Google_Maps::version());
	}

	/**
	 * @covers ::source_dir
	 */
	public function testSourceDir() {

		$this->assertEquals(SRC_DIR, Google_Maps::source_dir());
	}

}
