<?php
/**
 * Directorist Radio Field class.
 *
 */
namespace Directorist\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Radio_Field extends Base_Field {

	public $type = 'radio';

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
		$value = $this->get_value( $posted_data );

		if ( ! in_array( $value, $this->get_options(), true ) ) {
			$this->add_error( sprintf( __( '[%s] Invalid value.', 'directorist' ), $value ) );

			return false;
		}

		return true;
	}
}

Fields::register( new Radio_Field() );
