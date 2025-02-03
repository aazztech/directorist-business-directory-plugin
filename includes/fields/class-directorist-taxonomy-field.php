<?php
/**
 * Directorist Taxonomy Field class.
 *
 */
namespace Directorist\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Taxonomy_Field extends Base_Field {

	public $type = 'taxonomy';

	abstract protected function get_taxonomy() : string;

	abstract public function user_can_create() : bool;

	public function user_can_select_multiple() : bool {
		return $this->__get( 'type' ) === 'multiple';
	}

	public function get_value( $posted_data ) {
		if ( ! isset( $posted_data['tax_input'] ) ) {
			return null;
		}

		if ( ! in_array( $this->get_taxonomy(), [ ATBDP_TAGS, ATBDP_LOCATION, ATBDP_CATEGORY ], true ) ) {
			return null;
		}
		
		if ( ! isset( $posted_data['tax_input'][ $this->get_taxonomy() ] ) ) {
			return null;
		}

		$terms = (array) directorist_get_var( $posted_data['tax_input'][ $this->get_taxonomy() ], [] );
		$terms = array_map( 'directorist_sanitize_term_item', $terms );

		return array_filter( $terms );
	}
}
