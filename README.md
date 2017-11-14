# WP Google Maps

A Google Maps library for WordPress.

## Usage

A simple example:

```
use Clubdeuce\WPGoogleMaps\Google_Maps;
use Clubdeuce\WPGoogleMaps\Map;
use Clubdeuce\WPGoogleMaps\Marker;
use Clubdeuce\WPGoogleMaps\Map_View;

Google_Maps::register_script_condition( 'is_single' );
$map = new Map();
$map->add_marker( new Marker( array( 'address' => '1600 Amphitheatre Parkway, Mountain View, CA 94043') ) );
$view = new Map_View( $map );
$view->the_map();
```