<?php
/**
 * Review form builder data class.
 *
 * @package Directorist\Review
 * @since 8.0
 */
namespace Directorist\Review;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Builder {

	protected $fields          = array();
	protected $cookies_consent = false;
	private   static $instance = null;

	public static function get( $data ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $data );
		}

		return self::$instance;
	}

	private function __construct( $data ) {
		$this->load_data( $data );
		$this->cookies_consent = isset( $data['review_cookies_consent'] ) ? true : false;
	}

	public function load_data( $data )  {
		$this->fields = $data['fields'];
	}

	/**
	 * Get rating type.
	 *
	 * @return string
	 */
	public function get_rating_type() {
		return $this->get_field( 'rating_type', 'single' );
	}

	public function is_rating_type_single() {
		return $this->get_field( 'rating_type', 'single' ) === 'single';
	}

	public function get_name_label( $default = '' ) {
		return $this->get_field( 'name', 'label', $default );
	}

	public function get_name_placeholder( $default = '' ) {
		return $this->get_field( 'name', 'placeholder', $default );
	}

	public function get_email_label( $default = '' ) {
		return $this->get_field( 'email', 'label', $default );
	}

	public function get_email_placeholder( $default = '' ) {
		return $this->get_field( 'email', 'placeholder', $default );
	}

	public function get_website_label( $default = '' ) {
		return $this->get_field( 'website', 'label', $default );
	}

	public function get_website_placeholder( $default = '' ) {
		return $this->get_field( 'website', 'placeholder', $default );
	}

	public function get_comment_placeholder( $default = '' ) {
		return $this->get_field( 'comment', 'placeholder', $default );
	}

	public function is_cookies_consent_active() {
		return (bool) $this->cookies_consent;
	}

	public function is_website_field_active() {
		return (bool) $this->get_field( 'website', 'enable', false );
	}

	protected function get_field( $field_key, $attr = 'label', $default = false ) {
		$field_key = "review_{$field_key}";
		return ( ( isset( $this->fields[ $field_key ][ $attr ] ) && $this->fields[ $field_key ][ $attr ] !== '' ) ? $this->fields[ $field_key ][ $attr ] : $default );
	}
}
