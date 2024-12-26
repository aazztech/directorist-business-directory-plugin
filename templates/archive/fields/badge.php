<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<!-- <span class="directorist-badge directorist-info-item directorist-badge-<?php echo esc_attr( $class )?>">
    <?php if ( $class == 'featured' ) : ?>
        <?php directorist_icon( 'fas fa-star' ); ?>
        <span class="directorist-badge-tooltip directorist-badge-tooltip__featured"><?php esc_html_e( 'Featured', 'directorist'); ?></span>
    <?php elseif ( $class == 'new' ) : ?>
        <?php directorist_icon( 'fas fa-bolt' ); ?>
        <span class="directorist-badge-tooltip directorist-badge-tooltip__new"><?php esc_html_e( 'New', 'directorist'); ?></span>
    <?php elseif ( $class == 'popular' ) : ?>
        <?php directorist_icon( 'fas fa-fire' ); ?>
        <span class="directorist-badge-tooltip directorist-badge-tooltip__popular"><?php esc_html_e( 'Popular', 'directorist'); ?></span>
    <?php endif;?>
</span> -->


<span class="directorist-badge directorist-info-item directorist-badge-<?php echo esc_attr( $class )?> <?php echo $class === 'featured' ? 'directorist-badge-' . esc_attr( $class ) . '--only-text' : ''; ?>">
    <?php if ( $class == 'featured' ) : ?>
        <?php esc_html_e( 'Featured', 'directorist'); ?>
    <?php elseif ( $class == 'new' ) : ?>
        <?php directorist_icon( 'fas fa-bolt' ); ?>
        <span class="directorist-badge-tooltip directorist-badge-tooltip__new"><?php esc_html_e( 'New', 'directorist'); ?></span>
    <?php elseif ( $class == 'popular' ) : ?>
        <?php directorist_icon( 'fas fa-fire' ); ?>
        <span class="directorist-badge-tooltip directorist-badge-tooltip__popular"><?php esc_html_e( 'Popular', 'directorist'); ?></span>
    <?php endif;?>
</span>