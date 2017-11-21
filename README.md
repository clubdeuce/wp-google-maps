# WP Google Maps

[![Join the chat at https://gitter.im/clubdeuce/wp-google-maps](https://badges.gitter.im/clubdeuce/wp-google-maps.svg)](https://gitter.im/clubdeuce/wp-google-maps?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Waffle.io - Columns and their card count](https://badge.waffle.io/clubdeuce/wp-google-maps.svg?columns=all)](https://waffle.io/clubdeuce/wp-google-maps)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clubdeuce/wp-google-maps/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clubdeuce/wp-google-maps/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clubdeuce/wp-google-maps/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/clubdeuce/wp-google-maps/?branch=master)
[![Build Status](https://travis-ci.org/clubdeuce/wp-google-maps.svg?branch=master)](https://travis-ci.org/clubdeuce/wp-google-maps)

A Google Maps library for WordPress.


## Installation

This project can be installed via [Composer](https://getcomposer.org):

`composer require clubdeuce\wp-google-maps`

Simply include `autoload.php` from your `vendor` directory and the library will be included.


## Usage

A simple example:

```

use Clubdeuce\WPGoogleMaps\Google_Maps;
use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Map_View;

Google_Maps::initialize();

// Register the conditions under which to load the necessary javascript
// You can use WP specific ( e.g. is_single, is_search, etc ) or any 
// valid callback function or closure.
Google_Maps::register_script_condition( 'is_single' );

//Create a new map object
$map = Google_Maps::make_new_map();

//Create a new marker object
$marker = Google_Maps::make_marker_by_address( '1600 Pennsylvania Ave NW Washington DC' );

//Set the info window content
$marker->info_window()->set_content( 'The White House' );

//Add the marker to the map
$map->add_marker( $marker );

//Render the map
$map->the_map();
```