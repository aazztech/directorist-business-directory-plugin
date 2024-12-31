<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0.11
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div <?php $listings->wrapper_class(); $listings->data_atts(); ?>>
	<div class="directorist-archive-contents__top">
		<?php
			// Display mobile view filter button if enabled
			if ( ! empty( $listings->options['listing_filters_button'] ) ) {
				$listings->mobile_view_filter_template();
			}

			// Render directory type navigation template
			$listings->directory_type_nav_template();

			// Render header bar template
			$listings->header_bar_template();

			// Display full search form if filters button is enabled
			if ( ! empty( $listings->options['listing_filters_button'] ) ) {
				$listings->full_search_form_template();
			}
		?>
	</div>
	<div class="directorist-archive-contents__listings">
		<?php
			$listings->archive_view_template();
		?>
	</div>

</div>