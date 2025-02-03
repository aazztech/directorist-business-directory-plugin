<?php
/**
 * @author AazzTech
 */

namespace AazzTech\Directorist\Elementor;

use Elementor\Controls_Manager;

if (! defined( 'ABSPATH' )) {
    exit;
}

class Directorist_Transaction_Failure extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ) {
		$this->az_name = __( 'Transaction Failure', 'directorist' );
		$this->az_base = 'directorist_transaction_failure';
		parent::__construct( $data, $args );
	}


	protected function az_fields(): array{
		return [
			[
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'General', 'directorist' ),
			],
			[
				'type'      => Controls_Manager::HEADING,
				'id'        => 'sec_heading',
				'label'     => $this->az_texts['transaction'],
			],
			[
				'mode' => 'section_end',
			],
		];
	}

	protected function render() {

		$shortcode = '[directorist_transaction_failure]';

		echo do_shortcode( $shortcode );
	}
}