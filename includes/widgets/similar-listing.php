<?php
/**
 * @author wpWax
 */

namespace Directorist\Widgets;

use Directorist\Helper;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Similar_Listing extends \WP_Widget {

	public function __construct() {
		$id_base        = 'bdsl_widget';
        $name           = esc_html__( 'Directorist - Similar Listings', 'directorist' );
        $widget_options =             [
            'classname' => 'directorist-widget',
            'description' => esc_html__( 'You can show similar listing by this widget', 'directorist' ),
        ];

		parent::__construct( $id_base, $name, $widget_options );
	}

	public function form( $instance ): void {
		$defaults = [
			'title'               => esc_html__( 'Similar Listings', 'directorist' ),
			'sim_listing_num'     => 5,
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label'   => esc_html__( 'Title:', 'directorist' ),
				'type'    => 'text',
            ],
			'sim_listing_num' => [
				'label'   => esc_html__( 'Number of Listings', 'directorist' ),
				'type'    => 'text',
			],
        ];

		Widget_Fields::create( $fields, $instance, $this );
	}

	public function update($new_instance, $old_instance)
    {
        return ['title' => empty( $new_instance['title'] ) ? '' : sanitize_text_field( $new_instance['title'] ), 'sim_listing_num' => empty( $new_instance['sim_listing_num'] ) ? 5 : sanitize_text_field( $new_instance['sim_listing_num'] )];
    }

	public function directorist_related_listings_query( $count ) {
		global $post;
		$directory_type = get_the_terms( get_the_ID(), ATBDP_TYPE );
		$type_id        = empty( $directory_type ) ? '' : $directory_type[0]->term_id;
		$same_author    = get_directorist_type_option( $type_id, 'listing_from_same_author', false );
		$rel_listing_num = empty($count) ? 5 : $count;
		$atbd_cats = get_the_terms($post, ATBDP_CATEGORY);
		$atbd_tags = get_the_terms($post, ATBDP_TAGS);
		// get the tag ids of the listing post type
		$atbd_cats_ids = [];
		$atbd_tags_ids = [];

		if (!empty($atbd_cats)) {
			foreach ($atbd_cats as $atbd_cat) {
				$atbd_cats_ids[] = $atbd_cat->term_id;
			}
		}
		if (!empty($atbd_tags)) {
			foreach ($atbd_tags as $atbd_tag) {
				$atbd_tags_ids[] = $atbd_tag->term_id;
			}
		}
		$args = [
			'post_type' => ATBDP_POST_TYPE,
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => ATBDP_CATEGORY,
					'field' => 'term_id',
					'terms' => $atbd_cats_ids,
				],
				[
					'taxonomy' => ATBDP_TAGS,
					'field' => 'term_id',
					'terms' => $atbd_tags_ids,
				],
			],
			'posts_per_page' => (int)$rel_listing_num,
			'post__not_in' => [$post->ID],
		];
		if( ! empty( $same_author ) ){
			$args['author']  = get_post_field( 'post_author', get_the_ID() );
		}

		return new \WP_Query(apply_filters('atbdp_related_listing_args', $args));
	}

	public function widget( $args, $instance ): void {
        $allowWidget = apply_filters('atbdp_allow_similar_widget', true);

        if (! is_singular( ATBDP_POST_TYPE ) || ! $allowWidget) {
            return;
        }

		$number = empty($instance['sim_listing_num']) ? 5 : $instance['sim_listing_num'];
		$related_listings = $this->directorist_related_listings_query( $number );

		echo wp_kses_post( $args['before_widget'] );

		$title = empty($instance['title']) ? esc_html__('Similar Listings', 'directorist') : esc_html($instance['title']);
		$widget_title = $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		echo wp_kses_post( $widget_title );

		Helper::get_template( 'widgets/similar-listing', ['args' => $args, 'instance' => $instance, 'related_listings' => $related_listings] );

		echo wp_kses_post( $args['after_widget'] );
	}
}