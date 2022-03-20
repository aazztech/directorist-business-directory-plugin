<?php
/**
 * @author wpWax
 */

namespace Directorist\Asset_Loader;

if ( ! defined( 'ABSPATH' ) ) exit;

class Enqueue {

    public static function single_listing() {

		wp_enqueue_script( 'directorist-main' );
		wp_enqueue_script( 'directorist-sweetalert-script' );
		wp_enqueue_script( 'directorist-slick' );

		// Map Scripts
        if ( Helper::map_type() == 'openstreet' ) {
            self::openstreet_map_scripts();
        } elseif ( Helper::map_type() == 'google' ) {
            self::google_map_scripts();
        }
    }

	/**
	 * @todo apply icon condition
	 */
	public static function icon_styles() {
		wp_enqueue_style( 'directorist-line-awesome' );
		wp_enqueue_style( 'directorist-font-awesome' );

		return;

		$icon_type = get_directorist_option( 'font_type', '', true );

		if ( 'line' === $icon_type ) {
			wp_enqueue_style( 'directorist-line-awesome' );
		} else {
			wp_enqueue_style( 'directorist-font-awesome' );
		}
	}

    public static function map_styles() {
		if ( Helper::map_type() == 'openstreet' ) {
			wp_enqueue_style( 'directorist-openstreet-map-leaflet' );
			wp_enqueue_style( 'directorist-openstreet-map-openstreet' );
		}
	}

    public static function color_picker_scripts() {
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ) );
		wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris', 'wp-i18n' ) );
	}

	public static function openstreet_map_scripts( $cluster = false ) {
		wp_enqueue_script( 'directorist-openstreet-layers' );
		wp_enqueue_script( 'directorist-openstreet-unpkg' );
		wp_enqueue_script( 'directorist-openstreet-unpkg-index' );
		wp_enqueue_script( 'directorist-openstreet-unpkg-libs' );
		wp_enqueue_script( 'directorist-openstreet-leaflet-versions' );

		if ( $cluster ) {
			wp_enqueue_script( 'directorist-openstreet-leaflet-markercluster-versions' );
		}

		wp_enqueue_script( 'directorist-openstreet-libs-setup' );
		wp_enqueue_script( 'directorist-openstreet-open-layers' );
		wp_enqueue_script( 'directorist-openstreet-crosshairs' );
	}

	public static function google_map_scripts() {
		wp_enqueue_script( 'directorist-google-map' );
		wp_enqueue_script( 'directorist-map-view' );
		wp_enqueue_script( 'directorist-gmap-marker-clusterer' );
	}

}