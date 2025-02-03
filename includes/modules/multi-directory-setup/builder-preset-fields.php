<?php
/**
 * Builder preset fields.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return apply_filters(
	'atbdp_form_preset_widgets',
	array(
		'title'         => array(
			'label'    => __( 'Title', 'directorist' ),
			'icon'     => 'las la-text-height',
			'canTrash' => false,
			'options'  => array(
				'type'        => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'   => array(
					'type'  => 'hidden',
					'value' => 'listing_title',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'       => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Title',
				),
				'placeholder' => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'required'    => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => true,
				),
			),
		),

		'description'   => array(
			'label'   => __( 'Description', 'directorist' ),
			'icon'    => 'uil uil-align-left',
			'show'    => true,
			'options' => array(
				'type'           => array(
					'type'    => 'select',
					'label'   => __( 'Type', 'directorist' ),
					'value'   => 'wp_editor',
					'options' => array(
						array(
							'label' => __( 'Textarea', 'directorist' ),
							'value' => 'textarea',
						),
						array(
							'label' => __( 'WP Editor', 'directorist' ),
							'value' => 'wp_editor',
						),
					),
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'listing_content',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Description',
				),
				'placeholder'    => array(
					'type'    => 'text',
					'label'   => __( 'Placeholder', 'directorist' ),
					'value'   => '',
					'show_if' => array(
						'where'      => 'self.type',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'textarea',
							),
						),
					),
				),
				'required'       => array(
					'type'  => 'toggle',
					'name'  => 'required',
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

		'tagline'       => array(
			'label'   => __( 'Tagline', 'directorist' ),
			'icon'    => 'uil uil-text-fields',
			'show'    => true,
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'tagline',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Tagline',
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

			),
		),

		'pricing'       => array(
			'label'   => __( 'Pricing', 'directorist' ),
			'icon'    => 'uil uil-bill',
			'options' => array(
				'field_key'                    => array(
					'type'  => 'hidden',
					'value' => 'pricing',
					'rules' => array(
						'unique'   => true,
						'required' => false,
					),
				),
				'label'                        => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Pricing',
				),
				'pricing_type'                 => array(
					'type'    => 'select',
					'label'   => __( 'Select Pricing Type', 'directorist' ),
					'value'   => 'both',
					// 'show-default-option' => true,
					'options' => array(
						array(
							'value' => 'both',
							'label' => 'Both',
						),
						array(
							'value' => 'price_unit',
							'label' => 'Price Unit',
						),
						array(
							'value' => 'price_range',
							'label' => 'Price Range',
						),
					),
				),
				'price_range_label'            => array(
					'type'    => 'text',
					'show_if' => array(
						'where'      => 'self.pricing_type',
						'compare'    => 'or',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'both',
							),
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'price_range',
							),
						),
					),
					'label'   => __( 'Price Range Label', 'directorist' ),
					'value'   => 'Price Range',
				),
				'price_range_placeholder'      => array(
					'type'    => 'text',
					'show_if' => array(
						'where'      => 'self.pricing_type',
						'compare'    => 'or',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'both',
							),
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'price_range',
							),
						),
					),
					'label'   => __( 'Price Range Placeholder', 'directorist' ),
					'value'   => 'Select Price Range',
				),
				'price_unit_field_type'        => array(
					'type'    => 'select',
					'label'   => __( 'Price Unit Field Type', 'directorist' ),
					'show_if' => array(
						'where'      => 'self.pricing_type',
						'compare'    => 'or',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'both',
							),
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'price_unit',
							),
						),
					),
					'value'   => 'number',
					'options' => array(
						array(
							'value' => 'number',
							'label' => 'Number',
						),
						array(
							'value' => 'text',
							'label' => 'Text',
						),
					),
				),
				'price_unit_field_label'       => array(
					'type'    => 'text',
					'label'   => __( 'Price Unit Field label', 'directorist' ),
					'show_if' => array(
						'where'      => 'self.pricing_type',
						'compare'    => 'or',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'both',
							),
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'price_unit',
							),
						),
					),
					'value'   => 'Price [USD]',
				),
				'price_unit_field_placeholder' => array(
					'type'    => 'text',
					'label'   => __( 'Price Unit Field Placeholder', 'directorist' ),
					'show_if' => array(
						'where'      => 'self.pricing_type',
						'compare'    => 'or',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'both',
							),
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'price_unit',
							),
						),
					),
					'value'   => 'Price of this listing. Eg. 100',
				),
				'only_for_admin'               => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
				'modules'                      => array(
					'type'  => 'hidden',
					'value' => array(
						'price_unit'  => array(
							'label'     => __( 'Price Unit', 'directorist' ),
							'type'      => 'text',
							'field_key' => 'price_unit',
						),
						'price_range' => array(
							'label'     => __( 'Price Range', 'directorist' ),
							'type'      => 'text',
							'field_key' => 'price_range',
						),
					),
				),
			),
		),

		'excerpt'       => array(
			'label'   => __( 'Excerpt', 'directorist' ),
			'icon'    => 'uil uil-paragraph',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'textarea',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'excerpt',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Excerpt',
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
			),
		),

		'location'      => array(
			'label'   => 'Location',
			'icon'    => 'uil uil-map-marker',
			'options' => array(
				'field_key'             => array(
					'type'  => 'hidden',
					'value' => 'tax_input[at_biz_dir-location][]',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'                 => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Location',
				),
				'placeholder'           => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'type'                  => array(
					'type'    => 'radio',
					'value'   => 'multiple',
					'label'   => __( 'Selection Type', 'directorist' ),
					'options' => array(
						array(
							'label' => __( 'Single Selection', 'directorist' ),
							'value' => 'single',
						),
						array(
							'label' => __( 'Multi Selection', 'directorist' ),
							'value' => 'multiple',
						),
					),
				),
				'create_new_loc'        => array(
					'type'  => 'toggle',
					'label' => __( 'Allow New', 'directorist' ),
					'value' => false,
				),
				'max_location_creation' => array(
					'type'        => 'number',
					'label'       => __( 'Maximum Number', 'directorist' ),
					'placeholder' => 'Here 0 means unlimited',
					'value'       => '0',
					'show_if'     => array(
						'where'      => 'self.type',
						'conditions' => array(
							array(
								'key'     => 'value',
								'compare' => '=',
								'value'   => 'multiple',
							),
						),
					),
				),
				'required'              => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin'        => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
			),
		),

		'tag'           => array(
			'label'   => __( 'Tag', 'directorist' ),
			'icon'    => 'las la-tag',
			'options' => array(
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'tax_input[at_biz_dir-tags][]',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Tag',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => 'Tag',
				),
				'type'           => array(
					'type'    => 'radio',
					'value'   => 'multiple',
					'label'   => __( 'Selection Type', 'directorist' ),
					'options' => array(
						array(
							'label' => __( 'Single Selection', 'directorist' ),
							'value' => 'single',
						),
						array(
							'label' => __( 'Multi Selection', 'directorist' ),
							'value' => 'multiple',
						),
					),
				),
				'required'       => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'allow_new'      => array(
					'type'  => 'toggle',
					'label' => __( 'Allow New', 'directorist' ),
					'value' => true,
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
			),
		),

		'category'      => array(
			'label'   => __( 'Category', 'directorist' ),
			'icon'    => 'uil uil-folder-open',
			'options' => array(
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'admin_category_select[]',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Category',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => '',
				),
				'type'           => array(
					'type'    => 'radio',
					'value'   => 'multiple',
					'label'   => __( 'Selection Type', 'directorist' ),
					'options' => array(
						array(
							'label' => __( 'Single Selection', 'directorist' ),
							'value' => 'single',
						),
						array(
							'label' => __( 'Multi Selection', 'directorist' ),
							'value' => 'multiple',
						),
					),
				),
				'create_new_cat' => array(
					'type'  => 'toggle',
					'label' => __( 'Allow New', 'directorist' ),
					'value' => false,
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

		'map'           => array(
			'label'   => __( 'Map', 'directorist' ),
			'icon'    => 'uil uil-map',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'map',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'map',
				),
				'label'          => array(
					'type'  => 'hidden',
					'value' => __( 'Map', 'directorist' ),
				),
				'lat_long'       => array(
					'type'  => 'text',
					'label' => __( 'Enter Coordinates Label', 'directorist' ),
					'value' => __( 'Or Enter Coordinates (latitude and longitude) Manually', 'directorist' ),
				),
				'only_for_admin' => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
			),
		),

		'address'       => array(
			'label'   => __( 'Address', 'directorist' ),
			'icon'    => 'uil uil-map-pin',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'address',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Address',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => __( 'Listing address eg. New York, USA', 'directorist' ),
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

		'zip'           => array(
			'label'   => __( 'Zip or Post Code', 'directorist' ),
			'icon'    => 'uil uil-map-pin',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'zip',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Zip/Post Code',
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
			),
		),

		'phone'         => array(
			'label'   => 'Phone',
			'icon'    => 'uil uil-phone',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'tel',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'phone',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Phone',
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
				'whatsapp'       => array(
					'type'  => 'toggle',
					'label' => __( 'Link with WhatsApp', 'directorist' ),
					'value' => false,
				),
			),
		),

		'phone2'        => array(
			'label'   => 'Phone 2',
			'icon'    => 'uil uil-phone',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'tel',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'phone2',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Phone 2',
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
				'whatsapp'       => array(
					'type'  => 'toggle',
					'label' => __( 'Link with WhatsApp', 'directorist' ),
					'value' => false,
				),
			),
		),

		'fax'           => array(
			'label'   => 'Fax',
			'icon'    => 'uil uil-print',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'number',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'fax',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Fax',
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
			),
		),

		'email'         => array(
			'label'   => 'Email',
			'icon'    => 'uil uil-envelope',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'email',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'email',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Email',
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
			),
		),

		'website'       => array(
			'label'   => 'Website',
			'icon'    => 'uil uil-globe',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'website',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Website',
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
			),
		),

		'social_info'   => array(
			'label'   => 'Social Info',
			'icon'    => 'uil uil-users-alt',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'add_new',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'social',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Social Info',
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

		'image_upload'  => array(
			'label'   => __( 'Images', 'directirst' ),
			'icon'    => 'uil uil-image',
			'options' => array(
				'type'                  => array(
					'type'  => 'hidden',
					'value' => 'media',
				),
				'field_key'             => array(
					'type'  => 'hidden',
					'value' => 'listing_img',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'                 => array(
					'type'  => 'hidden',
					'value' => __( 'Images', 'directorist' ),
				),
				'select_files_label'    => array(
					'type'  => 'text',
					'label' => __( 'Select Files Label', 'directorist' ),
					'value' => 'Select Files',
				),
				'max_image_limit'       => array(
					'type'  => 'number',
					'label' => __( 'Max Image Limit', 'directorist' ),
					'value' => 5,
				),
				'max_per_image_limit'   => array(
					'type'        => 'number',
					'label'       => __( 'Max Upload Size Per Image in MB', 'directorist' ),
					'description' => __( 'Here 0 means unlimited.', 'directorist' ),
					'value'       => 0,
				),
				'max_total_image_limit' => array(
					'type'  => 'number',
					'label' => __( 'Total Upload Size in MB', 'directorist' ),
					'value' => 2,
				),
				'required'              => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
				'only_for_admin'        => array(
					'type'  => 'toggle',
					'label' => __( 'Admin Only', 'directorist' ),
					'value' => false,
				),
			),
		),

		'video'         => array(
			'label'   => 'Video',
			'icon'    => 'uil uil-video',
			'options' => array(
				'type'           => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key'      => array(
					'type'  => 'hidden',
					'value' => 'videourl',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'label'          => array(
					'type'  => 'text',
					'label' => __( 'Label', 'directorist' ),
					'value' => 'Video',
				),
				'placeholder'    => array(
					'type'  => 'text',
					'label' => __( 'Placeholder', 'directorist' ),
					'value' => 'Only YouTube & Vimeo URLs.',
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

		'terms_privacy' => array(
			'label'   => __( 'Terms & Privacy', 'directorist' ),
			'icon'    => 'uil uil-text-fields',
			'show'    => true,
			'options' => array(
				'type'      => array(
					'type'  => 'hidden',
					'value' => 'text',
				),
				'field_key' => array(
					'type'  => 'hidden',
					'value' => 'privacy_policy',
					'rules' => array(
						'unique'   => true,
						'required' => true,
					),
				),
				'text'      => array(
					'label'    => __( 'Text', 'directorist' ),
					'type'     => 'textarea',
					'editor'   => 'wp_editor',
					'editorID' => 'wp_editor_terms_privacy',
					'value'    => sprintf(
						__( 'I agree to the <a href="%1$s" target="_blank">Privacy Policy</a> and <a href="%2$s" target="_blank">Terms of Service</a>', 'directorist' ),
						ATBDP_Permalink::get_privacy_policy_page_url(),
						ATBDP_Permalink::get_terms_and_conditions_page_url(),
					),
				),
				'required'  => array(
					'type'  => 'toggle',
					'label' => __( 'Required', 'directorist' ),
					'value' => false,
				),
			),
		),
	)
);
