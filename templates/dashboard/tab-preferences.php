<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
$display_author_email = $dashboard->user_info( 'display_author_email' ) ?? 'public';
?>

<form action="#" id="user_preferences" method="post">
	<div class="directorist-user-profile-edit directorist-user_preferences">

		<div class="directorist-card directorist-user-profile-box">

			<div class="directorist-card__header">

				<h3 class="directorist-card__header__title"><?php esc_html_e( 'Preferences', 'directorist' ); ?></h3>

			</div>

			<div class="directorist-card__body">
				<div class="<?php Helper::directorist_row(); ?>">
					<div class="<?php Helper::directorist_column('lg-4'); ?>">
						<div class="directorist-user-info-wrap">

							<input type="hidden" name="ID" value="<?php echo esc_attr( get_current_user_id() ); ?>">

							<div class="directorist-user-hide-listing">

								<div class="directorist-form-group directorist-checkbox directorist-checkbox-primary">

									<input type="checkbox" id="hide_contact_form" name="directorist_hide_contact_form" value="1" <?php echo esc_attr( ($dashboard->user_info( 'hide_contact_form' ) == '1' ) ? 'checked' : '' ); ?>>
									<label class="directorist-checkbox__label" for="hide_contact_form"><?php esc_html_e( 'Hide contact form in my listings', 'directorist' ); ?></label>

								</div>

							</div>

							<div class="directorist-user-display-author">

								<div class="directorist-form-group">

									<label for="display_author_email"><?php esc_html_e( 'Display Email on Author Page', 'directorist' ); ?></label>

									<select name="directorist_display_author_email" id="display_author_email">
										<option value="public" <?php selected( $display_author_email, 'public' ); ?>><?php esc_html_e('Display to Everyone', 'directorist') ?></option>
										<option value="logged_in" <?php selected( $display_author_email, 'logged_in' ); ?>><?php esc_html_e('Display to Logged in Users Only', 'directorist') ?></option>
										<option value="none_to_display" <?php selected( $display_author_email, 'none_to_display' ); ?>><?php esc_html_e('Don’t Display', 'directorist') ?></option>
									</select>

								</div>

							</div>

							<button type="submit" class="directorist-btn directorist-btn-lg directorist-btn-dark directorist-btn-profile-save" id="update_user_preferences"><?php esc_html_e( 'Save Changes', 'directorist' ); ?></button>

							<div id="directorist-preference-notice"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>