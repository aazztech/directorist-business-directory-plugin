<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$time_format = get_option( 'time_format' );
?>

<div class="directorist-single-info directorist-single-info-time">

	<div class="directorist-single-info__label">
		<span class="directorist-single-info__label-icon"><?php directorist_icon( $icon );?></span>
		<span class="directorist-single-info__label--text"><?php echo esc_html( $data['label'] ); ?></span>
	</div>

	<div class="directorist-single-info__value"><?php echo esc_html( date( $time_format, strtotime( esc_html( $value ) ) ) ); ?></div>

</div>