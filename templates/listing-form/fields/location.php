<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.3.1
 */

$placeholder = ! empty( $data['placeholder'] ) ? $data['placeholder'] : '';
$multiple    = $data['type'] == 'multiple' ? 'multiple="multiple"' : '';
$max         = !empty( $data['max_location_creation'] ) ? 'data-max="'. $data['max_location_creation'] .'"' : '';
$create_new  = !empty( $data['create_new_loc'] ) ? ' data-allow_new="'. $data['create_new_loc'] .'"' : '';
?>

<div class="directorist-form-group directorist-form-location-field">

	<?php $listing_form->field_label_template( $data ); ?>

	<select name="<?php echo esc_attr( $data['field_key'] ); ?>" class="directorist-form-element" id="at_biz_dir-location" data-placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php echo esc_attr( $multiple ) ; echo esc_attr( $max ); echo esc_attr( $create_new ); ?> <?php $listing_form->required( $data ); ?>>

		<?php
		if ($data['type'] != 'multiple') {
			echo '<option value="">' . esc_attr( $placeholder ) . '</option>';
		}
		echo $listing_form->add_listing_location_fields();
		?>

	</select>

	<?php $listing_form->field_description_template( $data ); ?>

</div>