<?php
/**
 * Singleton class for handling widgets.
 * 
 * @author wpWax
 */

namespace Directorist\Widgets;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Init {

	protected static $instance;

	private function __construct() {
        add_action( 'widgets_init', [ $this , 'register_widgets' ] );
		Widget_Fields::init();
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function register_widgets(): void {
        register_widget( \Directorist\Widgets\Popular_Listings::class );
		register_widget( \Directorist\Widgets\Listing_Video::class );
		register_widget( \Directorist\Widgets\Contact_Form::class );
		register_widget( \Directorist\Widgets\Submit_Listing::class );
		register_widget( \Directorist\Widgets\Login_Form::class );
		register_widget( \Directorist\Widgets\All_Categories::class );
		register_widget( \Directorist\Widgets\All_Locations::class );
		register_widget( \Directorist\Widgets\All_Tags::class );
		register_widget( \Directorist\Widgets\Search_Form::class );
		register_widget( \Directorist\Widgets\Single_Map::class );
		register_widget( \Directorist\Widgets\Similar_Listing::class );
		register_widget( \Directorist\Widgets\Author_Info::class );
		register_widget( \Directorist\Widgets\Featured_Listing::class );
	}
}