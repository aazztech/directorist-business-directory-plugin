<?php
/**
 * @author  AazzTech
 * @since   6.7
 * @version 7.0.3.3
 */
?>

<div class="directorist-form-group directorist-form-location-field">
	<?php $listing_form->field_label_template( $data ); ?>

	<select name="<?php echo esc_attr( $data['field_key'] ); ?>" class="directorist-form-element" id="at_biz_dir-location" data-placeholder="<?php echo $data['placeholder']; ?>" <?php
	 echo $data['type'] == 'multiple' ? 'multiple="multiple"' : '';  echo !empty( $data['max_location_creation'] ) ? 'data-max="'. $data['max_location_creation'] .'"' : '';  echo !empty( $data['create_new_loc'] ) ? 'data-allow_new="'. $data['create_new_loc'] .'"' : ''; ?>>
		<?php
			echo ( $data['type'] === 'single' ) ? '<option></option>' : '';
			echo $listing_form->add_listing_location_fields();
		?>
	</select>

	<?php $listing_form->field_description_template( $data ); ?>
</div>
