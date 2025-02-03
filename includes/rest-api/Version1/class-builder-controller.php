<?php
/**
 * Directory builder rest controller.
 *
 * @package Directorist\Rest_Api
 * @version  1.0.0
 */

namespace Directorist\Rest_Api\Controllers\Version1;

defined( 'ABSPATH' ) || exit;

use WP_Error;
use WP_REST_Server;

/**
 * REST API directory builder controller class.
 *
 * @package Directorist\Rest_Api
 */
class Builder_Controller extends Abstract_Controller {

	public $taxonomy;
    /**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'directories';

	/**
	 * Register the routes for builder settings.
	 */
	public function register_routes(): void {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
					'args'                => $this->get_collection_params(),
				],
				'schema' => [ $this, 'get_public_item_schema' ],
			]
		);

		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[\d]+)',
			[
				'args'   => [
					'id' => [
						'description' => __( 'Unique identifier for the resource.', 'directorist' ),
						'type'        => 'integer',
					],
				],
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
					'args'                => [
						'context' => $this->get_context_param( [ 'default' => 'view' ] ),
					],
				],
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
				],
				[
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => [ $this, 'delete_item' ],
					'permission_callback' => [ $this, 'delete_item_permissions_check' ],
					'args'                => [
						'force' => [
							'default'     => false,
							'type'        => 'boolean',
							'description' => __( 'Required to be true, as resource does not support trashing.', 'directorist' ),
						],
					],
				],
				'schema' => [ $this, 'get_public_item_schema' ],
			]
		);
	}

	/**
	 * Prepare a single listing category output for response.
	 *
	 * @param WP_Term         $item    Term object.
	 * @param WP_REST_Request $request Request instance.
	 * @return WP_REST_Response
	 */
	public function prepare_item_for_response( $item, $request ) {
		// Created date.
		$date_created = get_term_meta( $item->term_id, '_created_date', true );
		$expiration   = get_term_meta( $item->term_id, 'default_expiration', true );
		$new_status   = get_term_meta( $item->term_id, 'new_listing_status', true );
		$edit_status  = directorist_get_listing_edit_status( $item->term_id );
		$is_default   = get_term_meta( $item->term_id, '_default', true );
		$config       = directorist_get_directory_general_settings( $item->term_id );
		$data         = [
			'id'              => (int) $item->term_id,
			'name'            => $item->name,
			'slug'            => $item->slug,
			'icon'            => null,
			'image_url'       => null,
			'count'           => (int) $item->count,
			'is_default'      => (bool) $is_default,
			'new_status'      => $new_status,
			'edit_status'     => $edit_status,
			'expiration_days' => (int) $expiration,
			'date_created'    => directorist_rest_prepare_date_response( $date_created ),
		];

		if ( ! empty( $config['icon'] ) ) {
			$data['icon'] = $config['icon'];
		}

		if ( ! empty( $config['preview_image'] ) ) {
			$data['image_url'] = $config['preview_image'];
		}

		$context  = empty( $request['context'] ) ? 'view' : $request['context'];
		$data     = $this->add_additional_fields_to_object( $data, $request );
		$data     = $this->filter_response_by_context( $data, $context );
		$response = rest_ensure_response( $data );

		$response->add_links( $this->prepare_links( $item, $request ) );

		/**
		 * Filter a term item returned from the API.
		 *
		 * Allows modification of the term data right before it is returned.
		 *
		 * @param WP_REST_Response  $response  The response object.
		 * @param object            $item      The original term object.
		 * @param WP_REST_Request   $request   Request used to generate the response.
		 */
		return apply_filters( "directorist_rest_prepare_{$this->taxonomy}", $response, $item, $request );
	}

	/**
	 * Get the Category schema, conforming to JSON Schema.
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => $this->taxonomy,
			'type'       => 'object',
			'properties' => [
				'id'          => [
					'description' => __( 'Unique identifier for the resource.', 'directorist' ),
					'type'        => 'integer',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'name'        => [
					'description' => __( 'Category name.', 'directorist' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
				'slug'        => [
					'description' => __( 'An alphanumeric identifier for the resource unique to its type.', 'directorist' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'arg_options' => [
						'sanitize_callback' => 'sanitize_title',
					],
				],
				'image_url'    => [
					'description' => __( 'Preview image url.', 'directorist' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'icon' => [
					'description' => __( 'Icon class.', 'directorist' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
				'count' => [
					'description' => __( 'Number of published listings for the resource.', 'directorist' ),
					'type'        => 'integer',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'is_default' => [
					'description' => __( 'Default directory status.', 'directorist' ),
					'type'        => 'boolean',
					'default'     => false,
					'context'     => [ 'view', 'edit' ],
				],
				'new_status' => [
					'description' => __( 'Newly created listing status under this directory.', 'directorist' ),
					'type'        => 'string',
					'default'     => 'pending',
					'enum'        => [
						'pending',
						'publish',
					],
					'context'     => [ 'view', 'edit' ],
				],
				'edit_status' => [
					'description' => __( 'Edited listing status under this directory.', 'directorist' ),
					'type'        => 'string',
					'default'     => 'pending',
					'enum'        => [
						'pending',
						'publish',
					],
					'context'     => [ 'view', 'edit' ],
				],
				'expiration_days' => [
					'description' => __( 'Validity days for listings under this directory.', 'directorist' ),
					'type'        => 'integer',
					'context'     => [ 'view', 'edit' ],
				],
				'date_created'      => [
					'description' => __( "The date the directory was created, in the site's timezone.", 'directorist' ),
					'type'        => 'date-time',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
			],
		];

		return $this->add_additional_fields_schema( $schema );
	}

	/**
	 * Update term meta fields.
	 *
	 * @param WP_Term         $term    Term object.
	 * @param WP_REST_Request $request Request instance.
	 * @return bool|WP_Error
	 *
	 */
	protected function update_term_meta_fields( $term, $request ) {
		return true;
	}
}
