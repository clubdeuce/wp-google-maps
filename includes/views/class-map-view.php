<?php

namespace Clubdeuce\WPGoogleMaps;

/**
 * Class Map_View
 * @package Clubdeuce\WPGoogleMaps
 */
class Map_View {

	/**
	 * @var Map
	 */
	protected $_model;

	/**
	 * Map_View constructor.
	 *
	 * @param Map $model
	 */
	public function __construct( $model ) {
		
		$this->_model = $model;
		
	}

	/**
	 * @param array $args
	 */
	public function the_map( $args = array() ) { 
		
		$args = wp_parse_args( $args, array(
			'template' => Google_Maps::source_dir() . '/templates/map-view.php',
		) );

		require $args['template'];
		
	}
	
	/**
	 * @return array
	 */
	protected function _make_markers_args() {

		$marker_args = array();

		foreach ( $this->_model->markers() as $marker ) {
			$marker_args[] = array(
				'position'  => $marker->position(),
				'title'     => $marker->title(),
				'label'     => self::_make_label_args( $marker->label() ),
			);
		}

		return array_filter( $marker_args );

	}

	/**
	 * @param  Marker_Label $label
	 *
	 * @return array
	 */
	protected function _make_label_args( $label ) {

		$args = array();

		if ( ! empty( $label->text() ) ) {
			$args = array(
				'color'      => $label->color(),
				'fontFamily' => $label->font_family(),
				'fontSize'   => $label->font_size(),
				'fontWeight' => $label->font_weight(),
				'text'       => $label->text(),
			);
		}

		return $args;

	}

	/**
	 * @return array
	 */
	protected function _make_info_windows() {

		$windows = array();

		/**
		 * @var Marker $marker
		 */
		foreach( $this->_model->markers() as $marker ) {
			$info_window = $marker->info_window();
			$windows[]   = array(
				'content'      => $info_window->content(),
				'pixel_offset' => $info_window->pixel_offset(),
				'position'     => $info_window->position(),
				'max_width'    => $info_window->max_width(),
			);
		}

		return $windows;

	}
	
}