<?php
/**
 * Directorist Builder Field Abstract class.
 *
 */
namespace Directorist\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Base_Field {

	public $type = 'base';

	protected array $props;

	protected $errors = [];

	public function __construct( array $props = [] ) {
		$this->props = $props;
	}

	public function __get( $name ) {
		return $this->props[ $name ] ?? null;
	}

	public function __set( $name, $value ) {
		return $this->props[ $name ] = $value;
	}

	public function __isset( $name ) {
		return isset( $this->props[ $name ] );
	}

	public function get_props(): array {
		return $this->props;
	}

	public function get_key() : string {
		return ( string ) $this->field_key;
	}

	public function get_internal_key() : string {
		return ( string ) $this->widget_key;
	}

	public function is_admin_only() : bool {
		return ( bool ) $this->only_for_admin;
	}

	public function is_required() : bool {
		return ( bool ) $this->required;
	}

	public function is_preset() : bool {
		return $this->widget_group === 'preset';
	}

	public function is_category_only(): bool
    {
        return !($this->is_preset() || empty( $this->__get( 'assign_to' ) ) || $this->__get( 'assign_to' ) === 'form');
    }

	public function get_assigned_category() {
		if ( ! $this->is_category_only() || empty( $this->__get( 'category' ) ) ) {
			return 0;
		}

		return absint( $this->__get( 'category' ) );
	}

	public function add_error( $message = '' ): void {
		if ( ! isset( $this->errors[ $this->get_internal_key() ] ) ) {
			$this->errors[ $this->get_internal_key() ] = [];
		}

		$this->errors[ $this->get_internal_key() ][] = $message;
	}

	public function get_error(): string {
		return isset( $this->errors[ $this->get_internal_key() ] ) ? implode( ' ', $this->errors[ $this->get_internal_key() ] ) : '';
	}

	public function has_error(): bool {
		return ( !in_array($this->get_error(), ['', '0'], true) );
	}

	public function get_value( array $posted_data ) {
		return directorist_get_var( $posted_data[ $this->get_key() ] );
	}

	public function is_value_empty( array $posted_data ): bool {
		$value = $this->get_value( $posted_data );
		return ( is_null( $value ) || ( is_string( $value ) && $value === '' ) || ( $value === [] ) );
	}

	public function validate( $posted_data ): bool {
		return true;
	}

	public function sanitize( array $posted_data ) {
		return directorist_clean( $this->get_value( $posted_data ) );
	}
}
