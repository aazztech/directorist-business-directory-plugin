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

class Directorist_All_Listing extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->az_name = __( 'All Listings', 'directorist' );
		$this->az_base = 'directorist_all_listing';
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

	/**
     * @return mixed[]
     */
    private function az_listing_tags(): array {
		$result = [];
		$tags = get_terms( ATBDP_TAGS );
		foreach ( $tags as $tag ) {
			$result[$tag->slug] = $tag->name;
		}
		return $result;
	}

	/**
     * @return mixed[]
     */
    private function az_listing_locations(): array {
		$result = [];
		$locations = get_terms( ATBDP_LOCATION );
		foreach ( $locations as $location ) {
			$result[$location->slug] = $location->name;
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

	public function az_fields(): array{
		return [
			[
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'General', 'directorist' ),
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'header',
				'label'     => __( 'Show Header?', 'directorist' ),
				'default'   => 'yes',
			],
			[
				'type'      => Controls_Manager::TEXT,
				'id'        => 'header_title',
				'label'     => __( 'Total Listings Found Title', 'directorist' ),
				'default'   => __( 'Listings Found', 'directorist' ),
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'filter',
				'label'     => __( 'Show Filter Button?', 'directorist' ),
				'default'   => 'no',
				'condition' => [ 'header' => 'yes' ],
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'view',
				'label'   => __( 'View As', 'directorist' ),
				'options' => [
					'grid' => __( 'Grid View', 'directorist' ),
					'list' => __( 'List View', 'directorist' ),
					'map'  => __( 'Map View', 'directorist' ),
				],
				'default' => 'grid',
			],
			[
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'map_height',
				'label'     => __( 'Map Height', 'directorist' ),
				'min'       => 300,
				'max'       => 1980,
				'default'   => 500,
				'condition' => [ 'view' => [ 'map' ] ],
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'columns',
				'label'   => __( 'Listings Per Row', 'directorist' ),
				'options' => [
					'6' => __( '6 Items / Row', 'directorist'  ),
					'4' => __( '4 Items / Row', 'directorist'  ),
					'3' => __( '3 Items / Row', 'directorist'  ),
					'2' => __( '2 Items / Row', 'directorist'  ),
				],
				'default' => '3',
				'condition' => [ 'view' => 'grid' ],
			],
			[
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'listing_number',
				'label'     => __( 'Number of Listings to Show', 'directorist' ),
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 6,
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'preview',
				'label'     => __( 'Show Preview Image?', 'directorist' ),
				'default'   => 'yes',
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
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'cat',
				'label'    => __( 'Specify Categories', 'directorist' ),
				'multiple' => true,
				'options'  => $this->az_listing_categories(),
			],
			[
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'tag',
				'label'    => __( 'Specify Tags', 'directorist' ),
				'multiple' => true,
				'options'  => $this->az_listing_tags(),
			],
			[
				'type'     => Controls_Manager::SELECT2,
				'id'       => 'location',
				'label'    => __( 'Specify Locations', 'directorist' ),
				'multiple' => true,
				'options'  => $this->az_listing_locations(),
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'featured',
				'label'     => __( 'Show Featured Only?', 'directorist' ),
				'default'   => 'no',
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'popular',
				'label'     => __( 'Show Popular Only?', 'directorist' ),
				'default'   => 'no',
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'user',
				'label'     => __( 'Only For Logged In User?', 'directorist' ),
				'default'   => 'no',
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'order_by',
				'label'   => __( 'Order by', 'directorist' ),
				'options' => [
					'title' => __( 'Title', 'directorist' ),
					'date'  => __( 'Date', 'directorist' ),
					'price' => __( 'Price', 'directorist' ),
				],
				'default' => 'date',
			],
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'order_list',
				'label'   => __( 'Listings Order', 'directorist' ),
				'options' => [
					'asc'  => __( ' ASC', 'directorist' ),
					'desc' => __( ' DESC', 'directorist' ),
				],
				'default' => 'desc',
			],
			[
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'show_pagination',
				'label'     => __( 'Show Pagination?', 'directorist' ),
				'default'   => 'no',
			],
			[
				'mode' => 'section_end',
			],
		];
	}

	protected function render() {
		$settings = $this->get_settings();

		$atts = [
			'header'                => $settings['header'] ?: 'no',
			'header_title'          => $settings['header_title'],
			'advanced_filter'       => $settings['filter'] ?: 'no',
			'view'                  => $settings['view'],
			'map_height'            => $settings['map_height'],
			'columns'               => $settings['columns'],
			'listings_per_page'     => $settings['listing_number'],
			'show_pagination'       => $settings['show_pagination'] ?: 'no',
			'category'              => $settings['cat'] ? implode( ',', $settings['cat'] ) : '',
			'tag'                   => $settings['tag'] ? implode( ',', $settings['tag'] ) : '',
			'location'              => $settings['location'] ? implode( ',', $settings['location'] ) : '',
			'featured_only'         => $settings['featured'] ?: 'no',
			'popular_only'          => $settings['popular'] ?: 'no',
			'logged_in_user_only'   => $settings['user'] ?: 'no',
			'display_preview_image' => $settings['preview'] ?: 'no',
			'orderby'               => $settings['order_by'],
			'order'                 => $settings['order_list'],
		];

		if ( directorist_is_multi_directory_enabled() ) {
			if ( $settings['type'] ) {
				$atts['directory_type'] = implode( ',', $settings['type'] );
			}
			if ( $settings['default_type'] ) {
				$atts['default_directory_type'] = $settings['default_type'];
			}
		}

		/**
		 * Filters the Elementor All Listing atts to modify or extend it
		 *
		 * @since 7.4.2
		 *
		 * @param array 	$atts 		Available atts in the widgers
		 * @param array 	$settings 	All the settings of the widget
		 */

		$atts = apply_filters( 'directorist_all_listings_elementor_widget_atts', $atts, $settings );

		$this->az_run_shortcode( 'directorist_all_listing', $atts );
	}
}
