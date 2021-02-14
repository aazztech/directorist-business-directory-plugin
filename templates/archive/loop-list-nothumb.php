<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['list_fields']['template_data']['list_view_without_thumbnail'];
?>

<div class="directorist-listing-single directorist-listing-card directorist-listing-card--list directorist-listing-no-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<div class="directorist-listing-single__header">

		<div class="directorist-listing-single__header__left">
			<div class="directorist-listing-single__info"><?php $listings->render_loop_fields($loop_fields['body']['top']); ?></div>
		</div>
		
		<div class="directorist-listing-single__header__right">
			<div class="directorist-listing-single__action"><?php $listings->render_loop_fields($loop_fields['body']['right']); ?></div>
		</div>

	</div>

	<div class="directorist-listing-single__content">

		<div class="directorist-listing-single__content__body">
			<div class="directorist-listing-single__info--list"><ul><?php $listings->render_loop_fields($loop_fields['body']['bottom'], '<li>', '</li>'); ?></ul></div>
			<div class="directorist-listing-single__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
		</div>

		<div class="directorist-listing-single__meta">
			<div class="directorist-listing-single__meta--left">
				<?php $listings->render_loop_fields($loop_fields['footer']['left']); ?>
			</div>
			<div class="directorist-listing-single__meta--right">
				<?php $listings->render_loop_fields($loop_fields['footer']['right']); ?>
			</div>
		</div>

	</div>
	
</div>