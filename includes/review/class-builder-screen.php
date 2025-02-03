<?php
/**
 * Builder screen class.
 *
 * @package Directorist\Review
 * @since 7.1.0
 */
namespace Directorist\Review;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Builder_Screen {

	public static function init(): void {
		add_filter( 'directorist/builder/config', [ self::class, 'register_config' ] );
		add_filter( 'directorist/builder/fields', [ self::class, 'register_fields' ] );
		add_filter( 'directorist/builder/layouts', [ self::class, 'register_layout' ] );
	}

	public static function register_config( $config ) {
		return $config;
	}

	public static function register_layout( $layouts ) {
		return $layouts;
	}

	public static function get_fields(): array {
		return [];
	}

	public static function register_fields( $fields ): array {
		return array_merge( $fields, self::get_fields() );
	}
}

Builder_Screen::init();
