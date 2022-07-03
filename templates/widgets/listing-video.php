<?php
/**
 * @author  wpWax
 * @since   7.3.0
 * @version 7.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
$videourl   = ! empty( $videourl ) ? esc_attr( ATBDP()->atbdp_parse_videos( $videourl ) ) : '';
?>

<div class="atbdp">
    <iframe class="embed-responsive-item" src="<?php echo $videourl; ?>" allowfullscreen></iframe>
</div>

