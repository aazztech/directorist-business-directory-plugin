<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$img_size_class = ( 'contain' === $data['background-size'] ) ? '' : ' plasmaSlider__cover';
?>
<div id="directorist-single-listing-slider" class=""
	data-width="<?php echo esc_attr( $data['width'] ); ?>"
	data-height="<?php echo esc_attr( $data['height'] ); ?>"
	data-rtl="<?php echo esc_attr( $data['rtl'] ); ?>"
	data-show-thumbnails="<?php echo esc_attr( $data['show-thumbnails'] ); ?>"
	data-background-size="<?php echo esc_attr( $data['background-size'] ); ?>"
	data-blur-background="<?php echo esc_attr( $data['blur-background'] ); ?>"
	data-background-color="<?php echo esc_attr( $data['background-color'] ); ?>"
	data-thumbnail-background-color="<?php echo esc_attr( $data['thumbnail-bg-color'] ); ?>">

	<div class="directorist-swiper directorist-single-listing-slider">
		<div class="swiper-wrapper">
			<?php
				if ( ! empty( $data['images'] )  ):
					foreach ( $data['images'] as $image ) {
						$img_src = $image['src'];
						$img_alt = $image['alt'];
						$output = "<div class='swiper-slide'><img src={$img_src} alt={$img_alt} /></div>" . "\n";
						echo wp_kses_post( $output );
					}
				endif;
			?>
		</div>
		<div class='directorist-swiper__navigation'>
			<div class='directorist-swiper__nav directorist-swiper__nav--prev directorist-swiper__nav--prev-single-listing'><?php directorist_icon('las la-angle-left')?></div>
			<div class='directorist-swiper__nav directorist-swiper__nav--next directorist-swiper__nav--next-single-listing'><?php directorist_icon('las la-angle-right')?></div>
		</div>

		<div class='directorist-swiper__pagination directorist-swiper__pagination--single-listing'></div>
	</div>

	<div class="directorist-swiper directorist-single-listing-slider-thumb">
		<div class="swiper-wrapper">
			<?php
				if ( ! empty( $data['images'] )  ):
					foreach ( $data['images'] as $image ) {
						$img_src = $image['src'];
						$img_alt = $image['alt'];
						$output = "<div class='swiper-slide'><img src={$img_src} alt={$img_alt} /></div>" . "\n";
						echo wp_kses_post( $output );
					}
				endif;
			?>
		</div>
		<div class='directorist-swiper__navigation'>
			<div class='directorist-swiper__nav directorist-swiper__nav--prev directorist-swiper__nav--prev-single-listing-thumb'><?php directorist_icon('las la-angle-left')?></div>
			<div class='directorist-swiper__nav directorist-swiper__nav--next directorist-swiper__nav--next-single-listing-thumb'><?php directorist_icon('las la-angle-right')?></div>
		</div>

		<div class='directorist-swiper__pagination directorist-swiper__pagination--single-listing-thumb'></div>
	</div>

</div>