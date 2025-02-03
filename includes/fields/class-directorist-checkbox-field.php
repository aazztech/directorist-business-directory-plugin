<?php
/**
 * Directorist Checkbox Field class.
 */
namespace Directorist\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Checkbox_Field extends Base_Field {

	public $type = 'checkbox';

	public function get_options(): array {
		$options = $this->options;

		if ( ! is_array( $options ) ) {
			return [];
		}

		return array_map( static function( array $option ) {
			return str_replace( '&lt;', '<', $option['option_value'] );
		}, $options );
	}

	public function validate( $posted_data ): bool {
		$value = (array) $this->get_value( $posted_data );

		if ( ( count( array_intersect( $value, $this->get_options() ) ) !== count( $value ) ) ) {
			$this->add_error( sprintf( __( '[%s] Invalid value.', 'directorist' ), implode( ', ', array_diff( $value, $this->get_options() ) ) ) );

			return false;
		}

		return true;
	}
	
	public function sanitize( $posted_data ) {
		return directorist_clean( $this->get_value( $posted_data ) );
	}
}

Fields::register( new Checkbox_Field() );
