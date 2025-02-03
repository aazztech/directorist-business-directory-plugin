<?php
/**
 * @author wpWax
 */

namespace Directorist\Widgets;

use Directorist\Helper;

if (! defined( 'ABSPATH' )) {
    exit;
}

class All_Categories extends \WP_Widget {

	public function __construct() {
		$id_base        = 'bdcw_widget';
        $name           = esc_html__( 'Directorist - Categories', 'directorist' );
        $widget_options =             [
            'classname' => 'directorist-widget',
            'description' => esc_html__( 'You can show Categories by this widget', 'directorist' ),
        ];

		parent::__construct( $id_base, $name, $widget_options );
	}

	public function form( $instance ): void {
		$defaults = [
			'title'                 => esc_html__( 'Directorist Categories', 'directorist' ),
			'display_as'            => 'list',
            'order_by'              => 'id',
            'order'                 => 'asc',
            'max_number'            => '',
            'immediate_category'    => 1,
            'hide_empty'            => 1,
            'show_count'            => 1,
            'single_only'           => 1,
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label'   => esc_html__( 'Title:', 'directorist' ),
				'type'    => 'text',
            ],
			'display_as' => [
				'label'   => esc_html__( 'View as:', 'directorist' ),
				'type'    => 'select',
                'options' => [
                    'list'      => esc_html__( 'List', 'directorist' ),
                    'dropdown'  => esc_html__( 'Dropdown', 'directorist' )
                ]
			],
            'order_by' => [
				'label'   => esc_html__( 'Order By:', 'directorist' ),
				'type'    => 'select',
                'options' => [
                    'id'      => esc_html__( 'Id', 'directorist' ),
                    'count'   => esc_html__( 'Count', 'directorist' ),
                    'name'    => esc_html__( 'Name', 'directorist' ),
                    'slug'    => esc_html__( 'Slug', 'directorist' )
                ]
			],
            'order' => [
				'label'   => esc_html__( 'Sort By:', 'directorist' ),
				'type'    => 'select',
                'options' => [
                    'asc'    => esc_html__( 'Ascending', 'directorist' ),
                    'desc'   => esc_html__( 'Descending', 'directorist' ),
                ]
			],
            'max_number'       => [
				'label'   => esc_html__( 'Maximum Number:', 'directorist' ),
				'type'    => 'text',
            ],
            'immediate_category' => [
				'label'   => esc_html__( 'Show all the top-level categories only', 'directorist' ),
				'type'    => 'checkbox',
				'value'   => 1,
			],
            'hide_empty' => [
				'label'   => esc_html__( 'Hide empty categories', 'directorist' ),
				'type'    => 'checkbox',
				'value'   => 1,
			],
            'show_count' => [
				'label'   => esc_html__( 'Display listing counts', 'directorist' ),
				'type'    => 'checkbox',
				'value'   => 1,
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
        return ['title' => empty( $new_instance['title'] ) ? '' : sanitize_text_field( $new_instance['title'] ), 'display_as' => empty( $new_instance['display_as'] ) ? 'list' : sanitize_text_field( $new_instance['display_as'] ), 'order_by' => empty( $new_instance['order_by'] ) ? 'id' : sanitize_text_field( $new_instance['order_by'] ), 'order' => empty( $new_instance['order'] ) ? 'asc' : sanitize_text_field( $new_instance['order'] ), 'immediate_category' => empty( $new_instance['immediate_category'] ) ? 0 : 1, 'hide_empty' => empty( $new_instance['hide_empty'] ) ? 0 : 1, 'show_count' => empty( $new_instance['show_count'] ) ? 0 : 1, 'single_only' => empty( $new_instance['single_only'] ) ? 0 : 1, 'max_number' => empty( $new_instance['max_number'] ) ? '' : $new_instance['max_number']];
    }

	public function widget( $args, $instance ): void {
        $allowWidget = apply_filters('atbdp_allow_categories_widget', true);

        if (( ! empty( $instance['single_only'] ) && ! is_singular( ATBDP_POST_TYPE ) ) || ! $allowWidget) {
            return;
        }

		echo wp_kses_post( $args['before_widget'] );

		$title = empty($instance['title']) ? esc_html__('Directorist Categories', 'directorist') : esc_html($instance['title']);
		$widget_title = $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];

		echo wp_kses_post( $widget_title );


        $query_args = [
            'template'       => empty( $instance['display_as'] ) ? 'list' : sanitize_text_field( $instance['display_as'] ),
            'parent'         => empty( $instance['parent'] ) ? 0 : (int) $instance['parent'],
            'term_id'        => empty( $instance['parent'] ) ? 0 : (int) $instance['parent'],
            'hide_empty'     => empty( $instance['hide_empty'] ) ? 0 : 1,
            'orderby'        => empty( $instance['order_by'] ) ? 'id' : sanitize_text_field( $instance['order_by'] ),
            'order'          => empty( $instance['order'] ) ? 'asc' : sanitize_text_field( $instance['order'] ),
            'max_number'     => empty( $instance['max_number'] ) ? '' : $instance['max_number'],
            'show_count'     => empty( $instance['show_count'] ) ? 0 : 1,
            'single_only'    => empty( $instance['single_only'] ) ? 0 : 1,
            'pad_counts'     => true,
            'immediate_category' => empty( $instance['immediate_category'] ) ? 0 : 1,
            'active_term_id' => 0,
            'ancestors'      => []
        ];


        if( $query_args['immediate_category'] !== 0 ) {

            $term_slug = get_query_var( ATBDP_CATEGORY );

            if( '' != $term_slug ) {
            $term = get_term_by( 'slug', $term_slug, ATBDP_CATEGORY );
            $query_args['active_term_id'] = $term->term_id;

            $query_args['ancestors'] = get_ancestors( $query_args['active_term_id'], 'atbdp_categories' );
            $query_args['ancestors'][] = $query_args['active_term_id'];
            $query_args['ancestors'] = array_unique( $query_args['ancestors'] );
            }

        }

        if( 'dropdown' == $query_args['template'] ) {
            $categories = $this->dropdown_categories( $query_args );
        } else {
            $categories = $this->directorist_categories_list( $query_args );
        }

		Helper::get_template( 'widgets/all-categories', ['args' => $args, 'instance' => $instance, 'query_args' => $query_args, 'categories' => $categories] );

		echo wp_kses_post( $args['after_widget'] );
	}

    public function directorist_categories_list( $settings ) {

        if( $settings['immediate_category'] && ($settings['term_id'] > $settings['parent'] && ! in_array( $settings['term_id'], $settings['ancestors'] )) ) {

            return null;

        }

        $args = [
            'taxonomy'     => ATBDP_CATEGORY,
            'orderby'      => $settings['orderby'],
            'order'        => $settings['order'],
            'hide_empty'   => $settings['hide_empty'],
            'parent'       => $settings['term_id'],
            'hierarchical' => !empty( $settings['hide_empty'] ),
            'child_of'     => 0,
            'number'       => empty($settings['max_number']) ? '' : $settings['max_number']
        ];

        $terms = get_terms( $args );
        $parent = $args['parent'];
        $child_class = empty($parent) ? 'directorist-widget-taxonomy directorist-widget-category' : 'directorist-taxonomy-list__sub-item';
        $html = '';
        if( count( $terms ) > 0 ) {
            $i = 1;
            $html .= '<div class="' .$child_class. '">';
            foreach( $terms as $term ) {
                $settings['term_id']    = $term->term_id;
                $child_category         = get_term_children( $term->term_id, ATBDP_CATEGORY );
                $plus_icon              = (!empty($child_category) && empty($parent) )? directorist_icon( 'las la-angle-down', false ) : '';
                $icon                   = get_term_meta($term->term_id,'category_icon',true);
                $child_icon             = empty($parent)  ? directorist_icon( $icon, false ) : '';
                $child_icon_class       = $child_icon ? 'directorist-taxonomy-list__icon' : 'directorist-taxonomy-list__icon-default';
                $children               = get_term_children( $term->term_id, ATBDP_CATEGORY );
                $has_icon               = $parent ? '' : 'directorist-taxonomy-list__card--icon';
                $has_child_class = empty( $children ) ? '' : 'directorist-taxonomy-list__toggle';

                $count = 0;
                if( ! empty( $settings['hide_empty'] ) || ! empty( $settings['show_count'] ) ) {
                    $count = atbdp_listings_count_by_category( $term->term_id );

                    if (! empty( $settings['hide_empty'] ) && 0 == $count) {
                        continue;
                    }
                }

                $html .= '<div class="directorist-taxonomy-list-one">';
                $html .= '<div class="directorist-taxonomy-list">';
                $html .= '<a href="' . \ATBDP_Permalink::atbdp_get_category_page( $term ) . '" class="directorist-taxonomy-list__card ' . $has_child_class . ' ' . $has_icon . '">';
                $html .= '<span class="' . $child_icon_class . '">' . $child_icon . '</span>';
                $html .= '<span class="directorist-taxonomy-list__name">' . $term->name . '</span>';
                if( ! empty( $settings['show_count'] ) ) {
                    $expired_listings = atbdp_get_expired_listings(ATBDP_CATEGORY, $term->term_id);
                    $number_of_expired = $expired_listings->post_count;
                    $number_of_expired = empty($number_of_expired)?'0':$number_of_expired;
                    $total = ($count !== 0)?($count-$number_of_expired):$count;
                    $html .= '<span class="directorist-taxonomy-list__count"> (' . $total . ') </span>';
                }

                if( empty( $settings['immediate_category'] ) && empty( $settings['hide_empty'] ) ) {
                    $html .= $plus_icon ? '<span class="directorist-taxonomy-list__toggler">'. $plus_icon . '</span>' : '';
                }

                $html .= '</a>';
                $html .= $this->sub_categories_list( $settings );
                $html .= '</div>';
                $html .= '</div>';
                if(!empty($args['number']) && $i++ == $args['number']) {
                    break;
                }
            }

            $html .= '</div>';

        }

        return $html;

    }

    public function sub_categories_list( $settings ) {
        if( $settings['immediate_category'] && ($settings['term_id'] > $settings['parent'] && ! in_array( $settings['term_id'], $settings['ancestors'] )) ) {
            return null;
        }

        $args = [
            'taxonomy'     => ATBDP_CATEGORY,
            'orderby'      => $settings['orderby'],
            'order'        => $settings['order'],
            'hide_empty'   => $settings['hide_empty'],
            'parent'       => $settings['term_id'],
            'hierarchical' => !empty( $settings['hide_empty'] ),
            'child_of'     => 0,
            'number'       => empty($settings['max_number']) ? '' : $settings['max_number']
        ];

        $terms = get_terms( $args );
        $parent = $args['parent'];
        $child_class = empty($parent) ? '' : 'directorist-taxonomy-list__sub-item';
        $html = '';
        if( count( $terms ) > 0 ) {
            $i = 1;
            $html .= '<ul class="' .$child_class. '">';
            foreach( $terms as $term ) {
                $settings['term_id'] = $term->term_id;
                $child_category      = get_term_children( $term->term_id, ATBDP_CATEGORY );
                $plus_icon           = (empty($child_category) )? '' : directorist_icon( 'las la-plus', false );
                $icon                = get_term_meta($term->term_id,'category_icon',true);
                $child_icon          = empty($parent)  ? directorist_icon( $icon, false ) : '';
                $has_icon               = $parent ? '' : 'directorist-taxonomy-list__card--icon';
                $has_child_class = empty( $child_category ) ? '' : 'directorist-taxonomy-list__sub-item-toggle';

                $count = 0;
                if( ! empty( $settings['hide_empty'] ) || ! empty( $settings['show_count'] ) ) {
                    $count = atbdp_listings_count_by_category( $term->term_id );

                    if (! empty( $settings['hide_empty'] ) && 0 == $count) {
                        continue;
                    }
                }

                $html .= '<li>';
                $html .= '<a href="' . \ATBDP_Permalink::atbdp_get_category_page( $term ) . '" class="' . $has_child_class . ' ' . $child_icon . '">';
                $html .= '<span class="directorist-taxonomy-list__name">' . $term->name . '</span>';
                if( ! empty( $settings['show_count'] ) ) {
                    $expired_listings = atbdp_get_expired_listings(ATBDP_CATEGORY, $term->term_id);
                    $number_of_expired = $expired_listings->post_count;
                    $number_of_expired = empty($number_of_expired)?'0':$number_of_expired;
                    $total = ($count !== 0)?($count-$number_of_expired):$count;
                    $html .= '<span class="directorist-taxonomy-list__count"> (' .
                    $total . ') </span>';
                }

                $html .= $plus_icon ? '<span class="directorist-taxonomy-list__sub-item-toggler"></span>' : '';
                $html .= '</a>';
                $html .= $this->sub_categories_list( $settings );
                $html .= '</li>';
                if(!empty($args['number']) && $i++ == $args['number']) {
                    break;
                }
            }

            $html .= '</ul>';

        }

        return $html;
    }

    public function dropdown_categories( $settings, $prefix = '' ) {
        if ( $settings['immediate_category'] &&
			( $settings['term_id'] > $settings['parent'] ) &&
			! in_array( $settings['term_id'], $settings['ancestors'] ) ) {
			return null;
        }

        $term_slug = get_query_var( ATBDP_CATEGORY );

        $args = [
            'taxonomy'     => ATBDP_CATEGORY,
            'orderby'      => $settings['orderby'],
            'order'        => $settings['order'],
            'hide_empty'   => $settings['hide_empty'],
            'parent'       => empty($settings['term_id']) ? '' : $settings['term_id'],
            'hierarchical' => ! empty( $settings['hide_empty'] ),
            'number'       => empty($settings['max_number']) ? '' : $settings['max_number']
        ];

        $terms = get_terms( $args );

		if ( is_wp_error( $terms ) ) {
			return null;
		}

        $html = '';

		foreach( $terms as $term ) {
			$settings['term_id'] = $term->term_id;

			$html .= sprintf( '<option value="%s" %s>', $term->term_id, selected( $term->term_id, $term_slug, false ) );
			$html .= $prefix . $term->name;

			if ( ! empty( $settings['show_count'] ) ) {
				$html .= ' (' . $term->count . ')';
			}

			//$html .= $this->dropdown_locations( $settings, $prefix . '&nbsp;&nbsp;&nbsp;' );
			$html .= '</option>';
		}

        return $html;
    }
}