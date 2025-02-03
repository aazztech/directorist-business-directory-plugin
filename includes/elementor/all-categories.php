<?php
/**
 * @author AazzTech
 */

namespace AazzTech\Directorist\Elementor;

use Elementor\Controls_Manager;
use Directorist\Helper;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Directorist_All_Categories extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->az_name = __( 'Listing Categories', 'directorist' );
		$this->az_base = 'directorist_all_categories';
		parent::__construct( $data, $args );
	}

	/**
     * @return mixed[]
     */
    private function az_listing_categories(): array {
		$result = [];
		$categories = get_terms( ATBDP_CATEGORY );
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}

		return $result;
	}

	private function az_listing_types() {
		$directories = directorist_get_directories();

		if ( is_wp_error( $directories ) || empty( $directories ) ) {
			return [];
		}

		return wp_list_pluck( $directories, 'name', 'slug' );
	}

	protected function az_fields(): array{
		return [
			[
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'General', 'directorist' ),
			],
			[
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'type',
				'label'    => __( 'Directory Types', 'directorist' ),
				'multiple' => true,
				'options'  => $this->az_listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true],
			],
			[
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'default_type',
				'label'    => __( 'Default Directory Types', 'directorist' ),
				'options'  => $this->az_listing_types(),
				'condition' => directorist_is_multi_directory_enabled() ? '' : ['nocondition' => true],
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'view',
				'label'   => __( 'View As', 'directorist' ),
				'options' => [
					'grid' => __( 'Grid View', 'directorist' ),
					'list' => __( 'List View', 'directorist' ),
				],
				'default' => 'grid',
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'columns',
				'label'   => __( 'Categories Per Row', 'directorist' ),
				'options' => [
					'1' => __( '1 Item / Row', 'directorist'  ),
					'2' => __( '2 Items / Row', 'directorist'  ),
					'3' => __( '3 Items / Row', 'directorist'  ),
					'4' => __( '4 Items / Row', 'directorist'  ),
					'6' => __( '6 Items / Row', 'directorist'  ),
				],
				'default' => '3',
				'condition' => [ 'view' => [ 'grid' ] ],
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'order_by',
				'label'   => __( 'Order by', 'directorist' ),
				'options' => [
					'id'    => __( 'ID', 'directorist' ),
					'count' => __( 'Count', 'directorist' ),
					'name'  => __( 'Name', 'directorist' ),
					'slug'  => __( 'Slug', 'directorist' ),
				],
				'default' => 'id',
			],
			[
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'slug',
				'label'    => __( 'Specify Categories', 'directorist' ),
				'multiple' => true,
				'options'  => $this->az_listing_categories(),
				'condition' => [ 'order_by' => [ 'slug' ] ],
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'order_list',
				'label'   => __( 'Categories Order', 'directorist' ),
				'options' => [
					'asc'  => __( ' ASC', 'directorist' ),
					'desc' => __( ' DESC', 'directorist' ),
				],
				'default' => 'desc',
			],
			[
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'number_cat',
				'label'     => __( 'Number of Categories to Show', 'directorist' ),
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 6,
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'user',
				'label'     => __( 'Only For Logged In User?', 'directorist' ),
				'default'   => 'no',
			],
			[
				'mode' => 'section_end',
			],
		];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$atts = [
			'view'                => $settings['view'],
			'columns'             => $settings['columns'],
			'cat_per_page'        => $settings['number_cat'],
			'orderby'             => $settings['order_by'],
			'order'               => $settings['order_list'],
			'logged_in_user_only' => $settings['user'] ?: 'no',
			'slug'                => $settings['slug'] ? implode( ',', $settings['slug'] ) : '',
		];

		if ( directorist_is_multi_directory_enabled() ) {
			if ( $settings['type'] ) {
				$atts['directory_type'] = implode( ',', $settings['type'] );
			}

			if ( $settings['default_type'] ) {
				$atts['default_directory_type'] = $settings['default_type'];
			}
		}

		$this->az_run_shortcode( 'directorist_all_categories', $atts );
	}
}