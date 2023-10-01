<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.7.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-search-field single_search_field directorist-form-group search-form-field">

	<label class="directorist-search-field__label"><?php echo esc_attr( $data['placeholder'] ); ?></label>

	<input class="search_fields directorist-form-element directorist-search-field__input" type="url" name="custom_field[<?php echo esc_attr( $data['field_key'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" placeholder="" <?php echo ! empty( $data['required'] ) ? 'required="required"' : ''; ?>>

	<div class="directorist-search-field__btn directorist-search-field__btn--clear">
		<i class="directorist-icon-mask" aria-hidden="true" style="--directorist-icon: url(https://revamp.local/wp-content/plugins/directorist/assets/icons/font-awesome/svgs/solid/times-circle.svg)"></i>	
	</div>

</div>