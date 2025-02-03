<?php
/**
 * Builder custom fields.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$custom_field_meta_key_field = apply_filters(
	'directorist_custom_field_meta_key_field_args',
	array(
		'type'  => 'hidden',
		'label' => __( 'Key', 'directorist' ),
		'value' => 'custom-text',
		'rules' => array(
			'unique'   => true,
			'required' => true,
		),
	)
);

function get_assign_to_field( array $args = array() ) {
	$default = array(
		'type'    => 'radio',
		'label'   => __( 'Assign to', 'directorist' ),
		'value'   => 'form',
		'options' => array(
			array(
				'label' => __( 'Form', 'directorist' ),
				'value' => 'form',
			),
			array(
				'label' => __( 'Category', 'directorist' ),
				'value' => 'category',
			),
		),
	);

	return array_merge( $default, $args );
}

function get_category_select_field( array $args = array() ) {
	$default = array(
		'type'    => 'select',
		'label'   => __( 'Select Category', 'directorist' ),
		'value'   => '',
		'options' => get_cetagory_options(),
	);

	return array_merge( $default, $args );
}

function get_cetagory_options() {
	$terms = get_terms(
		array(
			'taxonomy'   => ATBDP_CATEGORY,
			'hide_empty' => false,
		)
	);

	$directory_type = isset( $_GET['listing_type_id'] ) ? absint( $_GET['listing_type_id'] ) : directorist_get_default_directory();
	$options        = array();

	if ( is_wp_error( $terms ) ) {
		return $options;
	}

	if ( ! count( $terms ) ) {
		return $options;
	}

	foreach ( $terms as $term ) {
		$term_directory_types = get_term_meta( $term->term_id, '_directory_type', true );

		if ( is_array( $term_directory_types ) && in_array( $directory_type, $term_directory_types, true ) ) {
			$options[] = array(
				'id'    => $term->term_id,
				'value' => $term->term_id,
				'label' => $term->name,
			);
		}
	}

	return $options;
}

function get_file_upload_field_options() {
	$options = array(
		array(
			'label' => __( 'All types', 'directorist' ),
			'value' => 'all_types',
		),
		array(
			'label' => __( 'Image types', 'directorist' ),
			'value' => 'image',
		),
		array(
			'label' => __( 'Audio types', 'directorist' ),
			'value' => 'audio',
		),
		array(
			'label' => __( 'Video types', 'directorist' ),
			'value' => 'video',
		),
		array(
			'label' => __( 'Document types', 'directorist' ),
			'value' => 'document',
		),
	);

	foreach ( directorist_get_supported_file_types() as $file_type ) {
		$options[] = array(
			'label' => $file_type,
			'value' => $file_type,
		);
	}

	return $options;
}

return apply_filters(
	'atbdp_form_custom_widgets',
	array(
		'text'         => array(
			'label'   => __( 'Text', 'directorist' ),
			'icon'    => 'uil uil-text',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-text',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Text',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'textarea'     => array(
			'label'   => __( 'Textarea', 'directorist' ),
			'icon'    => 'uil uil-align-left',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'textarea',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-textarea',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Textarea',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'rows'           => array(
					'type'  => 'number',
					'label' => __( 'Rows', 'directorist' ),
					'value' => 8,
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'number'       => array(
			'label'   => __( 'Number', 'directorist' ),
			'icon'    => 'uil uil-0-plus',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'number',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-number',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Number',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'min_value'      => array(
					'type'  => 'number',
					'label' => __( 'Min Value', 'directorist' ),
					'value' => '',
				),
				'max_value'      => array(
					'type'  => 'number',
					'label' => __( 'Max Value', 'directorist' ),
					'value' => '',
				),
				'step'           => array(
					'type'  => 'number',
					'label' => __( 'Step', 'directorist' ),
					'value' => 1,
				),
				'prepend'        => array(
					'type'        => 'text',
					'label'       => __( 'Prepend', 'directorist' ),
					'description' => __( 'Appears before The Input', 'directorist' ),
					'value'       => '',
				),
				'append'         => array(
					'type'        => 'text',
					'label'       => __( 'Append', 'directorist' ),
					'description' => __( 'Appears after The Input', 'directorist' ),
					'value'       => '',
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'url'          => array(
			'label'   => __( 'URL', 'directorist' ),
			'icon'    => 'uil uil-link-add',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-url',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'URL',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'target'         => array(
					'type'  => 'toggle',
					'label' => __( 'Open in new tab', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'date'         => array(
			'label'   => __( 'Date', 'directorist' ),
			'icon'    => 'uil uil-calender',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'date',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-date',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Date',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'time'         => array(
			'label'   => __( 'Time', 'directorist' ),
			'icon'    => 'uil uil-clock',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'time',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-time',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Time',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'color_picker' => array(
			'label'   => __( 'Color Picker', 'directorist' ),
			'icon'    => 'uil uil-palette',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'color',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-color-picker',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Color',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'select'       => array(
			'label'   => __( 'Dropdown', 'directorist' ),
			'icon'    => 'uil uil-file-check-alt',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'select',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-select',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Select',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'options'        => array(
					'type'                 => 'multi-fields',
					'label'                => __( 'Options', 'directorist' ),
					'add-new-button-label' => __( 'Add Option', 'directorist' ),
					'options'              => array(
						'option_value' => array(
							'type'  => 'text',
							'label' => __( 'Value', 'directorist' ),
							'value' => '',
						),
						'option_label' => array(
							'type'  => 'text',
							'label' => __( 'Label', 'directorist' ),
							'value' => '',
						),
					),
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'checkbox'     => array(
			'label'   => __( 'Checkbox', 'directorist' ),
			'icon'    => 'uil uil-check-square',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'checkbox',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-checkbox',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Checkbox',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'options'        => array(
					'type'                 => 'multi-fields',
					'label'                => __( 'Options', 'directorist' ),
					'add-new-button-label' => __( 'Add Option', 'directorist' ),
					'options'              => array(
						'option_value' => array(
							'type'  => 'text',
							'label' => __( 'Value', 'directorist' ),
							'value' => '',
						),
						'option_label' => array(
							'type'  => 'text',
							'label' => __( 'Label', 'directorist' ),
							'value' => '',
						),
					),
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'radio'        => array(
			'label'   => __( 'Radio', 'directorist' ),
			'icon'    => 'uil uil-circle',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'radio',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-radio',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Radio',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'options'        => array(
					'type'                 => 'multi-fields',
					'label'                => __( 'Options', 'directorist' ),
					'add-new-button-label' => __( 'Add Option', 'directorist' ),
					'options'              => array(
						'option_value' => array(
							'type'  => 'text',
							'label' => __( 'Value', 'directorist' ),
							'value' => '',
						),
						'option_label' => array(
							'type'  => 'text',
							'label' => __( 'Label', 'directorist' ),
							'value' => '',
						),
					),
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'assign_to'      => array(
					'type'  => 'toggle',
					'label' => __( 'Assign to Category', 'directorist' ),
					'value' => false,
				),
				'category'       => get_category_select_field(
					array(
						'show_if' => array(
							'where'      => 'self.assign_to',
							'conditions' => array(
								array(
									'key'     => 'value',
									'compare' => '=',
									'value'   => true,
								),
							),
						),
					)
				),
			),
		),

		'file'         => array(
			'label'   => __( 'File Upload', 'directorist' ),
			'icon'    => 'uil uil-paperclip',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'file',
				),
				'field_key'      => array_merge(
					$custom_field_meta_key_field,
					array(
						'value' => 'custom-file',
					)
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'File Upload',
				),
				'description'    => array(
					'type'  => 'text',
					'label' => __( 'Description', 'directorist' ),
					'value' => '',
				),
				'file_type'      => array(
					'type'        => 'select',
					'label'       => __( 'Select a file type', 'directorist' ),
					'description' => __( 'By selecting a file type you are going to allow your users to upload only that or those type(s) of file.', 'directorist' ),
					'value'       => 'image',
					'options'     => get_file_upload_field_options(),
				),
				'file_size'      => array(
					'type'        => 'text',
					'label'       => __( 'File Size', 'directorist' ),
					'description' => __( 'Set maximum file size to upload', 'directorist' ),
					'value'       => '2mb',
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
			),
		),
	)
);
