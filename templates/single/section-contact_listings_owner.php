<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( $listing->contact_owner_form_disabled() ) {
	return;
}
?>

<section class="directorist-card directorist-card-contact-owner <?php echo esc_attr( $class );?>" <?php $listing->section_id( $id ); ?>>

	<header class="directorist-card__header">

		<h3 class="directorist-card__header__title">
			<?php if ( ! empty( $icon ) ) : ?>
				<span class="directorist-card__header-icon"><?php directorist_icon( $icon );?></span>
			<?php endif; ?>
			<span class="directorist-card__header-text"><?php echo esc_html( $label );?></span>
		</h3>

	</header>

	<div class="directorist-card__body">

		<form action="atbdp_public_send_contact_email" class="directorist-contact-owner-form" data-form-id="atbdp_stcode_contact_email">

			<div class="directorist-contact-owner-form-inner">

				<div class="directorist-form-group">
					<input type="text" class="directorist-form-element" name="atbdp-contact-name" placeholder="<?php esc_attr_e( 'Name', 'directorist' ); ?>" required />
				</div>

				<div class="directorist-form-group">
					<input type="email" class="directorist-form-element" name="atbdp-contact-email" placeholder="<?php esc_attr_e( 'Email', 'directorist' ); ?>" required />
				</div>

				<div class="directorist-form-group">
					<textarea class="directorist-form-element" name="atbdp-contact-message" rows="3" placeholder="<?php esc_attr_e( 'Message...', 'directorist' ); ?>" required></textarea>
				</div>

				<input type="hidden" name="atbdp-post-id" value="<?php echo esc_attr( $listing->id ); ?>" />
				<input type="hidden" name="atbdp-listing-email" value="<?php echo esc_attr( $listing->contact_owner_email() ); ?>" />

				<p class="directorist-contact-message-display"></p>

				<button type="submit" class="directorist-btn directorist-btn-light directorist-btn-md directorist-btn-submit"><?php esc_html_e( 'Submit now', 'directorist' ); ?></button>

			</div>

		</form>

	</div>

</section>