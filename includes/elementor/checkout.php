<?php
/**
 * @author AazzTech
 */

namespace AazzTech\Directorist\Elementor;

use Elementor\Controls_Manager;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Directorist_Checkout extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->az_name = __( 'Cart/Checkout', 'directorist' );
		$this->az_base = 'directorist_checkout';
		parent::__construct( $data, $args );
	}

	public function az_fields(): array{
		return [
			[
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'General', 'directorist' ),
			],
			[
				'type'      => Controls_Manager::HEADING,
				'id'        => 'sec_heading',
				'label'     => $this->az_texts['checkout'],
			],
			[
				'mode' => 'section_end',
			],
		];
	}

	protected function render() {

		$shortcode = '[directorist_checkout]';

		echo do_shortcode( $shortcode );
	}
}