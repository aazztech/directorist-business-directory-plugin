<?php
/**
 * Abstract Rest Terms Controller
 *
 * @package Directorist\Rest_Api
 * @version  1.0.0
 */

namespace Directorist\Rest_Api\Controllers\Version1;

defined( 'ABSPATH' ) || exit;

use WP_Error;
use WP_REST_Server;

/**
 * Terms controller class.
 */
abstract class Terms_Controller extends Abstract_Controller {

	public $total_terms;
    public $sort_column;
    /**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = '';

	/**
	 * Taxonomy.
	 *
	 * @var string
	 */
	protected $taxonomy = '';

	/**
	 * Cached taxonomies by attribute id.
	 *
	 * @var array
	 */
	protected $taxonomies_by_id = [];

	/**
	 * Register the routes for terms.
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
				[
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_item' ],
					'permission_callback' => [ $this, 'create_item_permissions_check' ],
					'args'                => array_merge(
						$this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
						[
							'name' => [
								'type'        => 'string',
								'description' => __( 'Name for the resource.', 'directorist' ),
								'required'    => true,
							],
						]
					),
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
	 * Check if a given request has access to read the terms.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function get_items_permissions_check( $request ) {
		$permissions = $this->check_permissions( $request, 'read' );
		if ( is_wp_error( $permissions ) ) {
			return $permissions;
		}

		if ( ! $permissions ) {
			return new WP_Error( 'directorist_rest_cannot_view', __( 'Sorry, you cannot list resources.', 'directorist' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}

	/**
	 * Check if a given request has access to create a term.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function create_item_permissions_check( $request ) {
		$permissions = $this->check_permissions( $request, 'create' );
		if ( is_wp_error( $permissions ) ) {
			return $permissions;
		}

		if ( ! $permissions ) {
			return new WP_Error( 'directorist_rest_cannot_create', __( 'Sorry, you are not allowed to create resources.', 'directorist' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}

	/**
	 * Check if a given request has access to read a term.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function get_item_permissions_check( $request ) {
		$permissions = $this->check_permissions( $request, 'read' );
		if ( is_wp_error( $permissions ) ) {
			return $permissions;
		}

		if ( ! $permissions ) {
			return new WP_Error( 'directorist_rest_cannot_view', __( 'Sorry, you cannot view this resource.', 'directorist' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}

	/**
	 * Check if a given request has access to update a term.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function update_item_permissions_check( $request ) {
		$permissions = $this->check_permissions( $request, 'edit' );
		if ( is_wp_error( $permissions ) ) {
			return $permissions;
		}

		if ( ! $permissions ) {
			return new WP_Error( 'directorist_rest_cannot_edit', __( 'Sorry, you are not allowed to edit this resource.', 'directorist' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}

	/**
	 * Check if a given request has access to delete a term.
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|boolean
	 */
	public function delete_item_permissions_check( $request ) {
		$permissions = $this->check_permissions( $request, 'delete' );
		if ( is_wp_error( $permissions ) ) {
			return $permissions;
		}

		if ( ! $permissions ) {
			return new WP_Error( 'directorist_rest_cannot_delete', __( 'Sorry, you are not allowed to delete this resource.', 'directorist' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}

	/**
	 * Check permissions.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @param string          $context Request context.
	 * @return bool|WP_Error
	 */
	protected function check_permissions( $request, $context = 'read' ) {
		// Get taxonomy.
		$taxonomy = $this->taxonomy;
		if ( ! $taxonomy || ! taxonomy_exists( $taxonomy ) ) {
			return new WP_Error( 'directorist_rest_taxonomy_invalid', __( 'Taxonomy does not exist.', 'directorist' ), [ 'status' => 404 ] );
		}

		// Check permissions for a single term.
		$id = intval( $request['id'] );
		if ( $id !== 0 ) {
			$term = get_term( $id, $taxonomy );

			if ( is_wp_error( $term ) || ! $term ) {
				return new WP_Error( 'directorist_rest_term_invalid', __( 'Resource does not exist.', 'directorist' ), [ 'status' => 404 ] );
			}

			return directorist_rest_check_listing_term_permissions( $taxonomy, $context, $term->term_id );
		}

		return directorist_rest_check_listing_term_permissions( $taxonomy, $context );
	}

	/**
	 * Get terms associated with a taxonomy.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function get_items( $request ) {
		$taxonomy      = $this->taxonomy;
		$prepared_args = $this->prepare_query_args( $request );

		/**
		 * Filter the query arguments, before passing them to `get_terms()`.
		 *
		 * Enables adding extra arguments or setting defaults for a terms
		 * collection request.
		 *
		 * @see https://developer.wordpress.org/reference/functions/get_terms/
		 *
		 * @param array           $prepared_args Array of arguments to be
		 *                                       passed to get_terms.
		 * @param WP_REST_Request $request       The current request.
		 */
		$prepared_args = apply_filters( "directorist_rest_{$taxonomy}_query", $prepared_args, $request );

		do_action( 'directorist_rest_before_query', 'get_term_items', $request, $prepared_args, $taxonomy );

		if (! empty( $prepared_args['listing'] )) {
            $query_result = $this->get_terms_for_listing( $prepared_args, $request );
            $total_terms  = $this->total_terms;
        } elseif (! empty( $request['directory'] )) {
            $_prepared_args = $prepared_args;
            unset( $_prepared_args['number'] );
            unset( $_prepared_args['offset'] );
            $terms               = get_terms( $taxonomy, $_prepared_args );
            $queried_directories = ( is_array( $request['directory'] ) ) ? $request['directory'] : [ $request['directory'] ];
            $terms = array_filter( $terms, function( $term ) use( $queried_directories ): bool {
					$directories = get_term_meta( $term->term_id, '_directory_type', true );

					if ( empty( $directories ) || ! is_array( $directories ) ) {
						return false;
					}

					$exists = array_intersect( $queried_directories, $directories );
					return ( $exists !== [] );
				} );
            $offset       = $prepared_args['offset'] ?: 0;
            $query_result = array_slice( $terms, $offset, $prepared_args['number'] );
            $total_terms  = count( $terms );
            if ( $offset >= $total_terms ) {
					$query_result = [];
				}
        } else {
				$query_result = get_terms( $taxonomy, $prepared_args );

				$count_args = $prepared_args;
				unset( $count_args['number'] );
				unset( $count_args['offset'] );
				$total_terms = wp_count_terms( $taxonomy, $count_args );

				// Ensure we don't return results when offset is out of bounds.
				// See https://core.trac.wordpress.org/ticket/35935.
				if ( $prepared_args['offset'] && $prepared_args['offset'] >= $total_terms ) {
					$query_result = [];
				}

				// wp_count_terms can return a falsy value when the term has no children.
				if ( ! $total_terms ) {
					$total_terms = 0;
				}
			}

		$response = [];
		foreach ( $query_result as $term ) {
			$data       = $this->prepare_item_for_response( $term, $request );
			$response[] = $this->prepare_response_for_collection( $data );
		}

		$response = rest_ensure_response( $response );

		// Store pagination values for headers then unset for count query.
		$per_page = (int) $prepared_args['number'];
		$page     = ceil( ( ( (int) $prepared_args['offset'] ) / $per_page ) + 1 );

		$response->header( 'X-WP-Total', (int) $total_terms );
		$max_pages = ceil( $total_terms / $per_page );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		$base = add_query_arg( $request->get_query_params(), rest_url( '/' . $this->namespace . '/' . $this->rest_base ) );
		if ( $page > 1 ) {
			$prev_page = $page - 1;
			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}
			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}
		if ( $max_pages > $page ) {
			$next_page = $page + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );
			$response->link_header( 'next', $next_link );
		}

		do_action( 'directorist_rest_after_query', 'get_term_items', $request, $prepared_args, $taxonomy );

		return apply_filters( 'directorist_rest_response', $response, 'get_term_items', $request, $prepared_args, $taxonomy );
	}

	/**
	 * Prepare query arguments for taxonomy query.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return array Prepared query args.
	 */
	public function prepare_query_args( $request ) {
		$taxonomy      = $this->taxonomy;
		$prepared_args = [
			'exclude'    => $request['exclude'],
			'include'    => $request['include'],
			'order'      => $request['order'],
			'orderby'    => $request['orderby'],
			'listing'    => $request['listing'],
			'hide_empty' => $request['hide_empty'],
			'number'     => $request['per_page'],
			'search'     => $request['search'],
			'slug'       => $request['slug'],
		];

		if ( ! empty( $request['offset'] ) ) {
			$prepared_args['offset'] = $request['offset'];
		} else {
			$prepared_args['offset'] = ( $request['page'] - 1 ) * $prepared_args['number'];
		}

		$taxonomy_obj = get_taxonomy( $taxonomy );

		if ( $taxonomy_obj->hierarchical && isset( $request['parent'] ) ) {
			if (0 === $request['parent']) {
                // Only query top-level terms.
                $prepared_args['parent'] = 0;
            } elseif ($request['parent']) {
                $prepared_args['parent'] = $request['parent'];
            }
		}

		return $prepared_args;
	}

	/**
	 * Create a single term for a taxonomy.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Request|WP_Error
	 */
	public function create_item( $request ) {
		$taxonomy = $this->taxonomy;
		$name     = $request['name'];
		$args     = [];
		$schema   = $this->get_item_schema();

		if ( ! empty( $schema['properties']['description'] ) && isset( $request['description'] ) ) {
			$args['description'] = $request['description'];
		}
		if ( isset( $request['slug'] ) ) {
			$args['slug'] = $request['slug'];
		}
		if ( isset( $request['parent'] ) ) {
			if ( ! is_taxonomy_hierarchical( $taxonomy ) ) {
				return new WP_Error( 'directorist_rest_taxonomy_not_hierarchical', __( 'Can not set resource parent, taxonomy is not hierarchical.', 'directorist' ), [ 'status' => 400 ] );
			}
			$args['parent'] = $request['parent'];
		}

		do_action( 'directorist_rest_before_query', 'create_term_items', $request, $args, $taxonomy );

		$term = wp_insert_term( $name, $taxonomy, $args );

		if ( is_wp_error( $term ) ) {
			$error_data = [ 'status' => 400 ];

			// If we're going to inform the client that the term exists,
			// give them the identifier they can actually use.
			$term_id = $term->get_error_data( 'term_exists' );
			if ( $term_id ) {
				$error_data['resource_id'] = $term_id;
			}

			return new WP_Error( $term->get_error_code(), $term->get_error_message(), $error_data );
		}

		$term = get_term( $term['term_id'], $taxonomy );

		$this->update_additional_fields_for_object( $term, $request );

		// Add term data.
		$meta_fields = $this->update_term_meta_fields( $term, $request );
		if ( is_wp_error( $meta_fields ) ) {
			wp_delete_term( $term->term_id, $taxonomy );

			do_action( 'directorist_rest_after_query', 'create_term_items', $request, $args, $taxonomy );

			return $meta_fields;
		}

		do_action( 'directorist_rest_after_query', 'create_term_items', $request, $args, $taxonomy );

		/**
		 * Fires after a single term is created or updated via the REST API.
		 *
		 * @param WP_Term         $term      Inserted Term object.
		 * @param WP_REST_Request $request   Request object.
		 * @param boolean         $creating  True when creating term, false when updating.
		 */
		do_action( "directorist_rest_insert_{$taxonomy}", $term, $request, true );

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $term, $request );
		$response = rest_ensure_response( $response );
		$response->set_status( 201 );

		$base = '/' . $this->namespace . '/' . $this->rest_base;

		$response->header( 'Location', rest_url( $base . '/' . $term->term_id ) );

		return apply_filters( 'directorist_rest_response', $response, 'create_term_items', $request, $args, $taxonomy );
	}

	/**
	 * Get a single term from a taxonomy.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Request|WP_Error
	 */
	public function get_item( $request ) {
		$taxonomy = $this->taxonomy;
		$id       = (int) $request['id'];

		do_action( 'directorist_rest_before_query', 'get_term_item', $request, $id, $taxonomy );

		$term = get_term( (int) $request['id'], $taxonomy );

		if ( is_wp_error( $term ) ) {
			return $term;
		}

		$response = $this->prepare_item_for_response( $term, $request );

		do_action( 'directorist_rest_after_query', 'get_term_item', $request, $id, $taxonomy );

		$response = apply_filters( 'directorist_rest_response', $response, 'get_term_item', $request, $id, $taxonomy );

		return rest_ensure_response( $response );
	}

	/**
	 * Update a single term from a taxonomy.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Request|WP_Error
	 */
	public function update_item( $request ) {
		$taxonomy      = $this->taxonomy;
		$id            = (int) $request['id'];

		do_action( 'directorist_rest_before_query', 'update_term_item', $request, $id, $taxonomy );

		$term          = get_term( (int) $request['id'], $taxonomy );
		$schema        = $this->get_item_schema();
		$prepared_args = [];

		if ( isset( $request['name'] ) ) {
			$prepared_args['name'] = $request['name'];
		}
		if ( ! empty( $schema['properties']['description'] ) && isset( $request['description'] ) ) {
			$prepared_args['description'] = $request['description'];
		}
		if ( isset( $request['slug'] ) ) {
			$prepared_args['slug'] = $request['slug'];
		}
		if ( isset( $request['parent'] ) ) {
			if ( ! is_taxonomy_hierarchical( $taxonomy ) ) {
				return new WP_Error( 'directorist_rest_taxonomy_not_hierarchical', __( 'Can not set resource parent, taxonomy is not hierarchical.', 'directorist' ), [ 'status' => 400 ] );
			}
			$prepared_args['parent'] = $request['parent'];
		}

		// Only update the term if we haz something to update.
		if ( $prepared_args !== [] ) {
			$update = wp_update_term( $term->term_id, $term->taxonomy, $prepared_args );
			if ( is_wp_error( $update ) ) {
				do_action( 'directorist_rest_after_query', 'update_term_item', $request, $id, $taxonomy );
				return $update;
			}
		}

		$term = get_term( $id, $taxonomy );

		$this->update_additional_fields_for_object( $term, $request );

		// Update term data.
		$meta_fields = $this->update_term_meta_fields( $term, $request );

		if ( is_wp_error( $meta_fields ) ) {
			do_action( 'directorist_rest_after_query', 'update_term_item', $request, $id, $taxonomy );
			return $meta_fields;
		}

		/**
		 * Fires after a single term is created or updated via the REST API.
		 *
		 * @param WP_Term         $term      Inserted Term object.
		 * @param WP_REST_Request $request   Request object.
		 * @param boolean         $creating  True when creating term, false when updating.
		 */
		do_action( "directorist_rest_insert_{$taxonomy}", $term, $request, false );

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $term, $request );

		do_action( 'directorist_rest_after_query', 'update_term_item', $request, $id, $taxonomy );

		$response = apply_filters( 'directorist_rest_response', $response, 'update_term_item', $request, $id, $taxonomy );

		return rest_ensure_response( $response );
	}

	/**
	 * Delete a single term from a taxonomy.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function delete_item( $request ) {
		$taxonomy = $this->taxonomy;
		$force    = isset( $request['force'] ) && (bool) $request['force'];

		// We don't support trashing for this type, error out.
		if ( ! $force ) {
			return new WP_Error( 'directorist_rest_trash_not_supported', __( 'Resource does not support trashing.', 'directorist' ), [ 'status' => 501 ] );
		}

		$id = (int) $request['id'];

		do_action( 'directorist_rest_before_query', 'delete_term_item', $request, $id, $taxonomy );

		$term = get_term( $id, $taxonomy );

		$request->set_param( 'context', 'edit' );
		$response = $this->prepare_item_for_response( $term, $request );

		$retval = wp_delete_term( $term->term_id, $term->taxonomy );

		do_action( 'directorist_rest_after_query', 'delete_term_item', $request, $id, $taxonomy );

		if ( ! $retval ) {
			return new WP_Error( 'directorist_rest_cannot_delete', __( 'The resource cannot be deleted.', 'directorist' ), [ 'status' => 500 ] );
		}

		/**
		 * Fires after a single term is deleted via the REST API.
		 *
		 * @param WP_Term          $term     The deleted term.
		 * @param WP_REST_Response $response The response data.
		 * @param WP_REST_Request  $request  The request sent to the API.
		 */
		do_action( "directorist_rest_delete_{$taxonomy}", $term, $response, $request );

		return apply_filters( 'directorist_rest_response', $response, 'delete_term_item', $request, $id, $taxonomy );
	}

	/**
	 * Prepare links for the request.
	 *
	 * @param object          $term   Term object.
	 * @param WP_REST_Request $request Full details about the request.
	 * @return array Links for the given term.
	 */
	protected function prepare_links( $term, $request ) {
		$base = '/' . $this->namespace . '/' . $this->rest_base;

		$links = [
			'self'       => [
				'href' => rest_url( trailingslashit( $base ) . $term->term_id ),
			],
			'collection' => [
				'href' => rest_url( $base ),
			],
		];

		if ( $term->parent ) {
			$parent_term = get_term( (int) $term->parent, $term->taxonomy );
			if ( $parent_term ) {
				$links['up'] = [
					'href' => rest_url( trailingslashit( $base ) . $parent_term->term_id ),
				];
			}
		}

		return $links;
	}

	/**
	 * Update term meta fields.
	 *
	 * @param WP_Term         $term    Term object.
	 * @param WP_REST_Request $request Full details about the request.
	 * @return bool|WP_Error
	 */
	protected function update_term_meta_fields( $term, $request ) {
		return true;
	}

	/**
	 * Get the terms attached to a listing.
	 *
	 * This is an alternative to `get_terms()` that uses `get_the_terms()`
	 * instead, which hits the object cache. There are a few things not
	 * supported, notably `include`, `exclude`. In `self::get_items()` these
	 * are instead treated as a full query.
	 *
	 * @param array           $prepared_args Arguments for `get_terms()`.
	 * @param WP_REST_Request $request       Full details about the request.
	 * @return array List of term objects. (Total count in `$this->total_terms`).
	 */
	protected function get_terms_for_listing( $prepared_args, $request ) {
		$taxonomy = $this->taxonomy;

		$query_result = get_the_terms( $prepared_args['listing'], $taxonomy );
		if ( empty( $query_result ) ) {
			$this->total_terms = 0;
			return [];
		}

		// get_items() verifies that we don't have `include` set, and default.
		// ordering is by `name`.
		if ( ! in_array( $prepared_args['orderby'], [ 'name', 'none', 'include' ], true ) ) {
			switch ( $prepared_args['orderby'] ) {
				case 'id':
					$this->sort_column = 'term_id';
					break;
				case 'slug':
				case 'term_group':
				case 'description':
				case 'count':
					$this->sort_column = $prepared_args['orderby'];
					break;
			}
			usort( $query_result, [ $this, 'compare_terms' ] );
		}
		if ( strtolower( $prepared_args['order'] ) !== 'asc' ) {
			$query_result = array_reverse( $query_result );
		}

		// Pagination.
		$this->total_terms = count( $query_result );

		return array_slice( $query_result, $prepared_args['offset'], $prepared_args['number'] );
	}

	/**
	 * Comparison function for sorting terms by a column.
	 *
	 * Uses `$this->sort_column` to determine field to sort by.
	 *
	 * @param stdClass $left Term object.
	 * @param stdClass $right Term object.
	 * @return int <0 if left is higher "priority" than right, 0 if equal, >0 if right is higher "priority" than left.
	 */
	protected function compare_terms( $left, $right ) {
		$col       = $this->sort_column;
		$left_val  = $left->$col;
		$right_val = $right->$col;

		if ( is_int( $left_val ) && is_int( $right_val ) ) {
			return $left_val - $right_val;
		}

		return strcmp( $left_val, $right_val );
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		$params = null;

		$params['context']['default'] = 'view';

		$params['exclude']    = [
			'description'       => __( 'Ensure result set excludes specific IDs.', 'directorist' ),
			'type'              => 'array',
			'items'             => [
				'type' => 'integer',
			],
			'default'           => [],
			'sanitize_callback' => 'wp_parse_id_list',
		];
		$params['include']    = [
			'description'       => __( 'Limit result set to specific ids.', 'directorist' ),
			'type'              => 'array',
			'items'             => [
				'type' => 'integer',
			],
			'default'           => [],
			'sanitize_callback' => 'wp_parse_id_list',
		];
		$params['offset']     = [
			'description'       => __( 'Offset the result set by a specific number of items. Applies to hierarchical taxonomies only.', 'directorist' ),
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['order']      = [
			'description'       => __( 'Order sort attribute ascending or descending.', 'directorist' ),
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_key',
			'default'           => 'asc',
			'enum'              => [
				'asc',
				'desc',
			],
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['orderby']    = [
			'description'       => __( 'Sort collection by resource attribute.', 'directorist' ),
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_key',
			'default'           => 'name',
			'enum'              => [
				'id',
				'include',
				'name',
				'slug',
				'term_group',
				'description',
				'count',
			],
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['hide_empty'] = [
			'description'       => __( 'Whether to hide resources not assigned to any listings.', 'directorist' ),
			'type'              => 'boolean',
			'default'           => false,
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['parent']     = [
			'description'       => __( 'Limit result set to resources assigned to a specific parent. Applies to hierarchical taxonomies only.', 'directorist' ),
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['listing']    = [
			'description'       => __( 'Limit result set to resources assigned to a specific listing.', 'directorist' ),
			'type'              => 'integer',
			'default'           => null,
			'validate_callback' => 'rest_validate_request_arg',
		];
		$params['slug']       = [
			'description'       => __( 'Limit result set to resources with a specific slug.', 'directorist' ),
			'type'              => 'string',
			'validate_callback' => 'rest_validate_request_arg',
		];

		return $params;
	}
}
