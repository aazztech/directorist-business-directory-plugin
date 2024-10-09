<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
$display_author_email = $dashboard->user_info( 'display_author_email' ) ? $dashboard->user_info( 'display_author_email' ) : 'public';
?>

<form action="#" id="user_preferences" method="post">
	<div class="directorist-user-profile-edit directorist-user_preferences">
		<div class="directorist-card directorist-user-profile-box">
			<div class="directorist-card__header">
				<h3 class="directorist-card__header__title"><?php esc_html_e( 'Preferences', 'directorist' ); ?></h3>
			</div>
			<div class="directorist-card__body">
				<div class="directorist-user-info-wrap">
					<input type="hidden" name="ID" value="<?php echo esc_attr( get_current_user_id() ); ?>">
					<div class="directorist-user-hide-listing">
						<label for="hide_contact_form" class="directorist-toggle">
							<span class="directorist-toggle-label"><?php esc_html_e( 'Hide contact form in my listings', 'directorist' ); ?></span>
							<input id="hide_contact_form" class="directorist-toggle-checkbox" name="directorist_hide_contact_form" value="1" type="checkbox" <?php echo esc_attr( ($dashboard->user_info( 'hide_contact_form' ) == '1' ) ? 'checked' : '' ); ?>>
							<div class="directorist-toggle-switch"></div>
						</label>
					</div>
					<div class="directorist-user-display-author">
						<div class="directorist-form-group">
							<div class="display_author_email">
								<?php esc_html_e( 'Display Email on Author Page', 'directorist' ); ?>
							</div>
							<div class="directorist-flex directorist-flex-wrap directorist-radio-wrapper">
								<div class="directorist-radio directorist-radio-circle">
									<input type="radio" id="public" name="directorist_display_author_email" value="public" <?php checked( $display_author_email, 'public' ); ?>>
									<label class="directorist-radio__label" for="public"><?php esc_html_e('Display to Everyone', 'directorist') ?></label>
								</div>
								<div class="directorist-radio directorist-radio-circle">
									<input type="radio" id="logged_in" name="directorist_display_author_email" value="logged_in" <?php checked( $display_author_email, 'logged_in' ); ?>>
									<label class="directorist-radio__label" for="logged_in"><?php esc_html_e('Display to Logged in Users Only', 'directorist') ?></label>
								</div>
								<div class="directorist-radio directorist-radio-circle">
									<input type="radio" id="none_to_display" name="directorist_display_author_email" value="none_to_display" <?php checked( $display_author_email, 'none_to_display' ); ?>>
									<label class="directorist-radio__label" for="none_to_display"><?php esc_html_e('Don’t Display', 'directorist') ?></label>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="directorist-btn directorist-btn-lg directorist-btn-dark directorist-btn-profile-save" id="update_user_preferences"><?php esc_html_e( 'Save Changes', 'directorist' ); ?></button>
					<div id="directorist-preference-notice"></div>
				</div>
			</div>
		</div>
	</div>
</form>