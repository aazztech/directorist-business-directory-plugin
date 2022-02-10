<?php
/**
 * @author wpWax
 */

namespace Directorist\Asset_Loader;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Enqueue_Widgets {

	public static function widget_search() {
		wp_enqueue_script( 'directorist-select2-script' );
		wp_enqueue_script( 'directorist-range-slider' );
		wp_enqueue_script( 'directorist-jquery-barrating' );
		wp_enqueue_script( 'directorist-geolocation-widget' );

		// Custom Scripts
		wp_enqueue_script( 'directorist-search-form-listing' );
		wp_enqueue_script( 'directorist-search-listing' );

	}
}