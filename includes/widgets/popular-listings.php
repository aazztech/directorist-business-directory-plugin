<?php
/**
 * @author wpWax
 */

namespace Directorist\Widgets;

use Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Popular_Listings extends \WP_Widget {

	public function __construct() {
		$id_base        = 'bdpl_widget';
        $name           = esc_html__( 'Directorist - Popular Listings', 'directorist' );
        $widget_options =             [
            'classname' => 'atbd_widget',
            'description' => esc_html__( 'You can show popular listing by this widget', 'directorist' ),
        ];

		parent::__construct( $id_base, $name, $widget_options );
	}

	public function form( $instance ) {
		$defaults = [
			'title'           => esc_html__( 'Popular Listings', 'directorist' ),
			'pop_listing_num' => 5,
			'single_only'     => 1,
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label'   => esc_html__( 'Title:', 'directorist' ),
				'type'    => 'text',
            ],
			'pop_listing_num' => [
				'label'   => esc_html__( 'Number of Listings:', 'directorist' ),
				'type'    => 'number',
			],
			'single_only' => [
				'label'   => esc_html__( 'Display only on single listing', 'directorist' ),
				'type'    => 'checkbox',
			],
        ];

		Widget_Fields::create( $fields, $instance, $this );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = [];

		$instance['title']            = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['pop_listing_num']  = ! empty( $new_instance['pop_listing_num'] ) ? sanitize_text_field( $new_instance['pop_listing_num'] ) : '';
		$instance['single_only']      = isset( $new_instance['single_only'] ) ? 1 : 0;

		return $instance;
	}

	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . apply_filters( 'widget_title', esc_html( $instance['title'] ) ) . wp_kses_post( $args['after_title'] );
		}

		Helper::get_template( 'widgets/popular-listings', compact( 'args', 'instance' ) );

		echo wp_kses_post( $args['after_widget'] );
	}
}