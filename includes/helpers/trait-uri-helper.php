<?php
/**
 * @author wpWax
 */

namespace Directorist;

if ( ! defined( 'ABSPATH' ) ) exit;

trait URI_Helper {

	public static function get_template_contents( $template, $args = array() ) {
		ob_start();
		self::get_template( $template, $args );
		return ob_get_clean();
	}

	public static function template_directory() {
		$dir = ATBDP_DIR. 'templates/';
		return $dir;
	}

	public static function theme_template_directory() {
		$dir = apply_filters( 'directorist_template_directory', 'directorist' );
		return $dir;
	}

	public static function template_path( $template, $args = array() ) {
		$theme_template  = self::theme_template_directory() . '/' . $template . '.php';
		$theme_file_path = locate_template( $theme_template );

		if ( $theme_file_path ) {
			$file_path = $theme_file_path;
		}
		else {
			$file_path = self::template_directory() . $template . '.php';
		}

		$file_path = apply_filters( 'directorist_template_file_path', $file_path, $template, $args );

		return $file_path;
	}

	public static function get_template( $template, $args = array(), $shortcode_key = '' ) {
		if ( is_array( $args ) ) {
			extract( $args );
		}

		// Load extension template if exist

		if ( ! empty( $shortcode_key ) ) {
			$default = [ 'template_directory' => '', 'file_path' => '', 'base_directory' => '' ];
			$ex_args = apply_filters( "atbdp_ext_template_path_{$shortcode_key}", $default, $args );
			$ex_args = array_merge( $default, $ex_args );

			$extension_path = atbdp_get_extension_template_path( $ex_args['template_directory'], $ex_args['file_path'], $ex_args['base_directory'] );

			if ( file_exists( $extension_path ) ) {
				$old_template_data = isset( $GLOBALS['atbdp_template_data'] ) ? $GLOBALS['atbdp_template_data'] : null;
				$GLOBALS['atbdp_template_data'] = $args;

				include $extension_path;

				$GLOBALS['atbdp_template_data'] = $old_template_data;
				return;
			}
		}

		$template = apply_filters( 'directorist_template', $template, $args );
		$file = self::template_path( $template, $args );

		if ( file_exists( $file ) ) {
			include $file;
		}
	}

	public static function get_theme_template_path_for( $template ) {
		$template_path = locate_template( $template . '.php' );
		$singular_path = locate_template( 'singular.php' );
		$index_path    = locate_template( 'index.php' );

		if ( $template_path ) {
			return $template_path;
		}
		elseif ( $singular_path ) {
			return $singular_path;
		}
		else {
			return $index_path;
		}
	}

	public static function is_field_allowed_in_atts( $widget_name, $atts = [] ) {
		$atts = ! empty( $atts[ $widget_name ] ) ? $atts[ $widget_name ] : '';
		
		if ( $atts && ( 'no' == $atts ) ){
			return false;
		}
		return true;
	}
}