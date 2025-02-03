<?php
/**
 * @author wpWax
 */

namespace Directorist\Asset_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Scripts {

	/**
	 * Scripts array.
	 *
	 * Each item may contain following arguments:
	 *      $scripts['handle'] => [
	 *          'type' => String, // Accepts css, js
	 *          'path' => String, // Absolute url, without the min/rtl/js extension
	 *          'ext'  => String, // External url, in case the path is absent
	 *          'dep'  => Array [], // Dependency list eg. [jquery]
	 *          'rtl'  => Boolean false, // RTL exists or not
	 *      ];
	 */
	public static function get_all_scripts() {
		$scripts = array(
			// Vendor CSS
			'directorist-openstreet-map-leaflet'      => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'openstreet-map/leaflet',
			),
			'directorist-openstreet-map-openstreet'   => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'openstreet-map/openstreet',
			),
			'directorist-select2-style'               => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'select2',
			),
			'directorist-unicons'                     => array(
				'type' => 'css',
				'path' => DIRECTORIST_ICON_URL . 'unicons/css/line',
			),
			'directorist-font-awesome'                => array(
				'type' => 'css',
				'path' => DIRECTORIST_ICON_URL . 'font-awesome/css/all',
			),
			'directorist-line-awesome'                => array(
				'type' => 'css',
				'path' => DIRECTORIST_ICON_URL . 'line-awesome/css/line-awesome',
			),
			'directorist-ez-media-uploader-style'     => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'ez-media-uploader',
				'rtl'  => true,
			),
			'directorist-swiper-style'                => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'swiper',
			),
			'directorist-sweetalert-style'            => array(
				'type' => 'css',
				'path' => DIRECTORIST_VENDOR_CSS . 'sweetalert',
			),

			// Public CSS
			'directorist-main-style'                  => array(
				'type' => 'css',
				'path' => DIRECTORIST_CSS . 'public-main',
				'rtl'  => true,
			),

			// Support v7 CSS
			'directorist-support-v7-style'            => array(
				'type' => 'css',
				'path' => DIRECTORIST_CSS . 'support-v7-style',
				'rtl'  => true,
			),

			// Admin CSS
			'directorist-admin-style'                 => array(
				'type' => 'css',
				'path' => DIRECTORIST_CSS . 'admin-main',
				'rtl'  => true,
				'dep'  => array(
					'directorist-font-awesome',
					'directorist-line-awesome',
				),
			),

			// Vendor JS
			'directorist-no-script'                   => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'no-script',
			),
			'directorist-swiper'                      => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'swiper',
			),
			'directorist-openstreet-layers'           => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/openstreetlayers',
			),
			'directorist-openstreet-unpkg'            => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/unpkg-min',
			),
			'directorist-openstreet-unpkg-index'      => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/unpkg-index',
			),
			'directorist-openstreet-unpkg-libs'       => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/unpkg-libs',
			),
			'directorist-openstreet-leaflet-versions' => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/leaflet-versions',
			),
			'directorist-openstreet-libs-setup'       => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/libs-setup',
			),
			'directorist-openstreet-open-layers'      => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/openlayers/openlayers',
			),
			'directorist-openstreet-crosshairs'       => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/openlayers4jgsi/crosshairs',
			),
			'directorist-openstreet-leaflet-markercluster-versions' => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'openstreet-map/leaflet.markercluster-versions',
			),
			'google-map-api'                          => array(
				'type' => 'js',
				'ext'  => self::gmap_url(),
			),
			'directorist-markerclusterer'             => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'markerclusterer',
			),
			'directorist-openstreet-map'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'openstreet-map',
				'dep'  => array(
					'jquery',
					'directorist-openstreet-layers',
					'directorist-openstreet-unpkg',
					'directorist-openstreet-unpkg-index',
					'directorist-openstreet-unpkg-libs',
					'directorist-openstreet-leaflet-versions',
					'directorist-openstreet-leaflet-markercluster-versions',
					'directorist-openstreet-libs-setup',
					'directorist-openstreet-open-layers',
					'directorist-openstreet-crosshairs',
				),
			),
			'directorist-google-map'                  => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'google-map',
				'dep'  => array(
					'jquery',
					'google-map-api',
					'directorist-markerclusterer',
				),
			),
			'directorist-select2-script'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'select2',
			),
			'directorist-sweetalert'                  => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'sweetalert',
			),
			'directorist-popper'                      => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'popper',
			),
			'directorist-tooltip'                     => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'tooltip',
			),
			'directorist-ez-media-uploader'           => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'ez-media-uploader',
			),
			'directorist-jquery-barrating'            => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'jquery.barrating',
			),
			'directorist-uikit'                       => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'uikit',
			),
			'directorist-validator'                   => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'validator',
			),
			'directorist-font-awesome-icons'          => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'icon-picker/font-awesome',
			),
			'directorist-line-awesome-icons'          => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'icon-picker/line-awesome',
			),
			'directorist-icon-picker'                 => array(
				'type' => 'js',
				'path' => DIRECTORIST_VENDOR_JS . 'icon-picker/icon-picker',
				'dep'  => array(
					'directorist-font-awesome-icons',
					'directorist-line-awesome-icons',
				),
			),

			// Global JS
			'directorist-global-script'               => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'global-main',
			),

			// Public JS
			'directorist-widgets'                     => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'widgets',
			),
			'directorist-all-listings'                => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'all-listings',
			),
			'directorist-search-form'                 => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'search-form',
			),
			'directorist-listing-slider'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'listing-slider',
			),
			'directorist-dashboard'                   => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'directorist-dashboard',
			),
			'directorist-all-authors'                 => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'all-authors',
			),
			'directorist-author-profile'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'author-profile',
			),
			'directorist-all-location-category'       => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'all-location-category',
			),
			'directorist-account'                     => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'account',
			),
			'directorist-range-slider'                => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'range-slider',
			),
			'directorist-releated-listings-slider'    => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-releated-listings-slider',
			),
			'directorist-atmodal'                     => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-atmodal',
			),
			'directorist-geolocation'                 => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'global-geolocation',
			),
			'directorist-geolocation-widget'          => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-geolocation-widget',
			),
			'directorist-search-listing'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-search-listing',
			),
			'directorist-search-form-listing'         => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-search-form-listing',
			),
			'directorist-checkout'                    => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'checkout',
			),
			'directorist-single-listing-openstreet-map-custom-script' => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-single-listing-openstreet-map-custom-script',
			),
			'directorist-single-listing-openstreet-map-widget-custom-script' => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-single-listing-openstreet-map-widget-custom-script',
			),
			'directorist-single-listing-gmap-custom-script' => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-single-listing-gmap-custom-script',
			),
			'directorist-single-listing-gmap-widget-custom-script' => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'public-single-listing-gmap-custom-script',
			),
			'directorist-add-listing'                 => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'add-listing',
			),
			'directorist-single-listing'              => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'single-listing',
			),
			'directorist-plupload'                    => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'directorist-plupload',
				'dep'  => array( 'jquery', 'plupload-handlers' ),
			),

			// Admin JS
			'directorist-admin-script'                => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-main',
			),
			'directorist-admin-builder-archive'       => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-builder-archive',
			),
			'directorist-multi-directory-builder'     => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-multi-directory-builder',
				'dep'  => array( 'lodash' ),
			),
			'directorist-settings-manager'            => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-settings-manager',
				'dep'  => array( 'lodash' ),
			),
			'directorist-plugins'                     => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-plugins',
			),
			'directorist-import-export'               => array(
				'type' => 'js',
				'path' => DIRECTORIST_JS . 'admin-import-export',
			),
		);

		return apply_filters( 'directorist_scripts', $scripts );
	}

	private static function gmap_url() {
		$api = get_directorist_option( 'map_api_key', 'AIzaSyCwxELCisw4mYqSv_cBfgOahfrPFjjQLLo' );
		$url = '//maps.googleapis.com/maps/api/js?key=' . $api . '&libraries=places&callback=Function.prototype';
		return $url;
	}
}
