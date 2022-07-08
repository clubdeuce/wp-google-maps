<?php

namespace Clubdeuce\WPGoogleMaps\Tests\UnitTests;

use Clubdeuce\WPGoogleMaps\HTTP;
use Clubdeuce\WPGoogleMaps\Tests\TestCase;

/**
 * Class TestHttp
 * @package            Clubdeuce\WPGoogleMaps\Tests\UnitTests
 * @coversDefaultClass Clubdeuce\WPGoogleMaps\HTTP
 * @group              http
 */
class TestHttp extends TestCase {

	/**
	 * @var HTTP
	 */
	protected $_http;

	/**
	 * 
	 */
	public function setUp(): void {
		$this->_http = new HTTP();
	}

	/**
	 * @covers ::make_request
	 */
	public function testMakeRequest() {
		$this->assertIsArray($this->_http->make_request('https://wordpress.com'));
	}

	/**
	 * @covers ::make_request
	 */
	public function testMakeRequestInvalidURL() {
		$this->assertInstanceOf('WP_Error', $this->_http->make_request('foo.bar'));
	}

	/**
	 * @covers ::_get_data
	 */
	public function testGetDataCache() {
		wp_cache_add( md5(serialize('foo.bar')), 'foobar');

		$this->assertEquals('foobar', $this->reflectionMethodInvokeArgs($this->_http, '_get_data', 'foo.bar'));
	}

}