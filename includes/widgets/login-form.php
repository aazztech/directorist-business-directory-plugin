<?php
/**
 * @author wpWax
 */

namespace Directorist\Widgets;

use Directorist\Helper;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Login_Form extends \WP_Widget {

	public function __construct() {
		$id_base        = 'bdlf_widget';
        $name           = esc_html__( 'Directorist - Login Form', 'directorist' );
        $widget_options =             [
            'classname' => 'directorist-widget',
            'description' => esc_html__( 'You can show login form for logged out users by this widget', 'directorist' ),
        ];

		parent::__construct( $id_base, $name, $widget_options );
	}

	public function form( $instance ): void {
		$defaults = [
			'title'           => esc_html__( 'Login Form', 'directorist' ),
			'single_only'     => 1,
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label'   => esc_html__( 'Title:', 'directorist' ),
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
        return ['title' => empty( $new_instance['title'] ) ? '' : sanitize_text_field( $new_instance['title'] ), 'single_only' => empty( $new_instance['single_only'] ) ? 0 : 1];
    }

	public function widget( $args, $instance ): void {
        if (( ! empty( $instance['single_only'] ) && ! is_singular( ATBDP_POST_TYPE ) ) || is_user_logged_in()) {
            return;
        }

		echo wp_kses_post( $args['before_widget'] );

		$title = empty($instance['title']) ? esc_html__('Login Form', 'directorist') : esc_html($instance['title']);
		$widget_title = $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		echo wp_kses_post( $widget_title );

		Helper::get_template( 'widgets/login-form', ['args' => $args, 'instance' => $instance] );

		echo wp_kses_post( $args['after_widget'] );
	}
}