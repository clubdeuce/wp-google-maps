<?php

use Clubdeuce\WPGoogleMaps\Google_Maps;

define('SRC_DIR', dirname(__DIR__));
define('VENDOR_DIRECTORY', SRC_DIR . '/vendor');
define('TEST_INCLUDES_DIR', SRC_DIR . '/includes');

require_once getenv('WP_TESTS_DIR') . '/tests/phpunit/includes/functions.php';
require getenv('WP_TESTS_DIR') . '/tests/phpunit/includes/bootstrap.php';

require 'includes/testCase.php';

require VENDOR_DIRECTORY . '/autoload.php';

Google_Maps::initialize();
Google_Maps::register_api_key(getenv('MAPS_API_KEY'));
