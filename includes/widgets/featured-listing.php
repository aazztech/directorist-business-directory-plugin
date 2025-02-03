<?php
/**
 * @author wpWax
 */

namespace Directorist\Widgets;

use Directorist\Helper;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Featured_Listing extends \WP_Widget {

	public function __construct() {
		$id_base        = 'bdfl_widget';
        $name           = esc_html__( 'Directorist - Featured Listings', 'directorist' );
        $widget_options =             [
            'classname' => 'directorist-widget',
            'description' => esc_html__( 'You can show featured listings by this widget', 'directorist' ),
        ];

		parent::__construct( $id_base, $name, $widget_options );
	}

	public function form( $instance ): void {
		$defaults = [
			'title'               => esc_html__( 'Featured Listings', 'directorist' ),
			'f_listing_num'       => 5,
            'single_only'         => 1,
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label'   => esc_html__( 'Title:', 'directorist' ),
				'type'    => 'text',
            ],
			'f_listing_num' => [
				'label'   => esc_html__( 'Number of Listings', 'directorist' ),
				'type'    => 'text',
			],
            'single_only' => [
				'label'   => esc_html__( 'Display only on single listing', 'directorist' ),
				'type'    => 'checkbox',
				'value'   => 1,
			],
        ];

		Widget_Fields::create( $fields, $instance, $this );
	}

	public function update($new_instance, $old_instance)
    {
        return ['title' => empty( $new_instance['title'] ) ? '' : sanitize_text_field( $new_instance['title'] ), 'f_listing_num' => empty( $new_instance['f_listing_num'] ) ? 5 : sanitize_text_field( $new_instance['f_listing_num'] ), 'single_only' => empty( $new_instance['single_only'] ) ? 0 : 1];
    }

	public function widget( $args, $instance ): void {
        $allowWidget = apply_filters('atbdp_allow_featured_widget', true);

        if (( ! empty( $instance['single_only'] ) && ! is_singular( ATBDP_POST_TYPE ) ) || ! $allowWidget) {
            return;
        }

		echo wp_kses_post( $args['before_widget'] );

		$title = empty($instance['title']) ? esc_html__('Featured Listings', 'directorist') : esc_html($instance['title']);
		$widget_title = $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		echo wp_kses_post( $widget_title );

		Helper::get_template( 'widgets/featured-listing', ['args' => $args, 'instance' => $instance] );

		echo wp_kses_post( $args['after_widget'] );
	}
}