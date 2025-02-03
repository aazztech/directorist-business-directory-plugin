<?php
/**
 * Review form builder data class.
 *
 * @package Directorist\Review
 * @since 8.0
 */
namespace Directorist\Review;
use ATBDP_Permalink;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Builder {

	protected $fields	= [];
	protected bool $cookies_consent;
	protected bool $gdpr_consent;
	protected $gdpr_consent_label;
	protected $rating_type;
	private static ?\Directorist\Review\Builder $instance 	= null;

	public static function get( $data ): \Directorist\Review\Builder {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $data );
		}

		return self::$instance;
	}

	private function __construct( $data ) {
		$this->load_data( $data );
		$this->cookies_consent 		= ! empty( $data['review_cookies_consent'] );
		$this->gdpr_consent    		= ! empty( $data['review_enable_gdpr_consent'] );
		$this->rating_type    		= empty( $data['rating_type'] ) ? 'single' : $data['rating_type'];
		$this->gdpr_consent_label	= empty( $data['review_gdpr_consent_label'] ) ? sprintf(
			__( 'I have read and agree to the <a href="%s" target="_blank">Privacy Policy</a> and <a href="%s" target="_blank">Terms of Service</a>', 'directorist' ),
			esc_url( ATBDP_Permalink::get_privacy_policy_page_url() ),
			esc_url( ATBDP_Permalink::get_terms_and_conditions_page_url() )
		) : $data['review_gdpr_consent_label'];;
	}

	public function load_data( $data ): void  {
		$this->fields = $data['fields'] ?? [];
	}

	/**
	 * Get rating type.
	 *
	 * @return string
	 */
	public function get_rating_type() {
		return $this->rating_type;
	}

	public function is_rating_type_single(): bool {
		return $this->rating_type === 'single';
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

	/**
	 * Get the label for the comment field.
	 *
	 * @deprecated 8.0 Use get_comment_field_label() instead.
	 * @param string $default Default label text if not set.
	 * @return string The label for the comment field.
	 */
	public function get_comment_label( $default = '' ) {
		_deprecated_function( __METHOD__, '8.0' );
		return $this->get_comment_field_label( $default );
	}

	/**
	 * Get comment field label.
	 *
	 * @param string $default Default label text.
	 * @return string
	 */
	public function get_comment_field_label( $default = '' ) {
		return $this->get_field( 'comment_label', $default );
	}

	public function get_comment_placeholder( $default = '' ) {
		return $this->get_field( 'comment', 'placeholder', $default );
	}

	public function is_cookies_consent_active(): bool {
		return $this->cookies_consent;
	}

	public function is_gdpr_consent(): bool {
		return $this->gdpr_consent;
	}

	public function gdpr_consent_label() {
		return $this->gdpr_consent_label;
	}

	public function is_website_field_active(): bool {
		return (bool) $this->get_field( 'website', 'enable', false );
	}

	protected function get_field( $field_key, $attr = 'label', $default = false ) {
		$field_key = "review_{$field_key}";
		return ( ( isset( $this->fields[ $field_key ][ $attr ] ) && $this->fields[ $field_key ][ $attr ] !== '' ) ? $this->fields[ $field_key ][ $attr ] : $default );
	}
}
