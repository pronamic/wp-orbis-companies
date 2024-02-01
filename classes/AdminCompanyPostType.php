<?php
/**
 * Admin company post type 
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-2.0-or-later
 * @package   Pronamic\Orbis\Companies
 */

namespace Pronamic\Orbis\Companies;

/**
 * Admin company post type class
 */
class AdminCompanyPostType {
	/**
	 * Post type.
	 */
	const POST_TYPE = 'orbis_company';

	/**
	 * Construct.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		add_filter( 'manage_edit-' . self::POST_TYPE . '_columns', [ $this, 'edit_columns' ] );

		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', [ $this, 'custom_columns' ], 10, 2 );

		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		add_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_company' ], 10, 2 );
		add_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_company_sync' ], 500, 2 );
	}

	/**
	 * Edit columns.
	 */
	public function edit_columns( $columns ) {
		$columns = [
			'cb'                       => '<input type="checkbox" />',
			'title'                    => __( 'Title', 'orbis-companies' ),
			'orbis_company_address'    => __( 'Address', 'orbis-companies' ),
			'orbis_company_online'     => __( 'Online', 'orbis-companies' ),
			'orbis_company_kvk_number' => __( 'Registration Number', 'orbis-companies' ),
			'author'                   => __( 'Author', 'orbis-companies' ),
			'comments'                 => __( 'Comments', 'orbis-companies' ),
			'date'                     => __( 'Date', 'orbis-companies' ),
		];

		return $columns;
	}

	/**
	 * Custom columns.
	 *
	 * @param string $column
	 */
	public function custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'orbis_company_online':
				$break = '';

				$website = get_post_meta( $post_id, '_orbis_website', true );

				if ( ! empty( $website ) ) {
					printf( '<a href="%s" target="_blank">%s</a>', $website, $website );

					$break = '<br />';
				}

				$email = get_post_meta( $post_id, '_orbis_email', true );

				if ( ! empty( $email ) ) {
					printf( $break );

					printf( '<a href="mailto:%s" target="_blank">%s</a>', $email, $email );
				}

				break;
			case 'orbis_company_address':
				$address  = get_post_meta( $post_id, '_orbis_address', true );
				$postcode = get_post_meta( $post_id, '_orbis_postcode', true );
				$city     = get_post_meta( $post_id, '_orbis_city', true );

				printf( '%s<br />%s %s', $address, $postcode, $city );

				break;
			case 'orbis_company_kvk_number':
				$kvk_number = get_post_meta( $post_id, '_orbis_kvk_number', true );

				if ( ! empty( $kvk_number ) ) {
					$url = sprintf( 'https://openkvk.nl/kvk/%s/', $kvk_number );

					printf( '<a href="%s" target="_blank">%s</a>', $url, $kvk_number );
				}

				break;
		}
	}

	/**
	 * Add meta boxes.
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'orbis_company_details',
			__( 'Company Details', 'orbis-companies' ),
			[ $this, 'meta_box' ],
			'orbis_company',
			'normal',
			'high'
		);
	}

	/**
	 * Meta box.
	 *
	 * @param mixed $post
	 */
	public function meta_box( $post ) {
		include __DIR__ . '/../admin/meta-box-company-details.php';
	}

	/**
	 * Save project.
	 *
	 * @param int   $post_id
	 * @param mixed $post
	 */
	public function save_company( $post_id, $post ) {
		// Doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Verify nonce
		$nonce = filter_input( INPUT_POST, 'orbis_company_details_meta_box_nonce', FILTER_SANITIZE_STRING );
		if ( ! wp_verify_nonce( $nonce, 'orbis_save_company_details' ) ) {
			return;
		}

		// Check permissions
		if ( ! ( 'orbis_company' === $post->post_type && current_user_can( 'edit_post', $post_id ) ) ) {
			return;
		}

		// OK
		$definition = [
			'_orbis_kvk_number'        => FILTER_SANITIZE_STRING,
			'_orbis_vat_number'        => FILTER_SANITIZE_STRING,
			'_orbis_email'             => FILTER_VALIDATE_EMAIL,
			'_orbis_accounting_email'  => FILTER_VALIDATE_EMAIL,
			'_orbis_invoice_email'     => FILTER_VALIDATE_EMAIL,
			'_orbis_invoice_reference' => FILTER_SANITIZE_STRING,
			'_orbis_website'           => FILTER_VALIDATE_URL,
			'_orbis_address'           => FILTER_SANITIZE_STRING,
			'_orbis_postcode'          => FILTER_SANITIZE_STRING,
			'_orbis_city'              => FILTER_SANITIZE_STRING,
			'_orbis_country'           => FILTER_SANITIZE_STRING,
			'_orbis_iban'              => FILTER_SANITIZE_STRING,
			'_orbis_twitter'           => FILTER_SANITIZE_STRING,
			'_orbis_facebook'          => FILTER_SANITIZE_STRING,
			'_orbis_linkedin'          => FILTER_SANITIZE_STRING,
		];

		$data = filter_input_array( INPUT_POST, $definition );

		foreach ( $data as $key => $value ) {
			if ( empty( $value ) ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	/**
	 * Sync project with Orbis tables
	 */
	function save_company_sync( $post_id, $post ) {
		// Doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check post type
		if ( ! ( 'orbis_company' === $post->post_type ) ) {
			return;
		}

		// Revision
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Publish
		if ( 'publish' !== $post->post_status ) {
			return;
		}

		// OK
		global $wpdb;

		// Orbis company ID
		$orbis_id = get_post_meta( $post_id, '_orbis_company_id', true );

		if ( empty( $orbis_id ) ) {
			$result = $wpdb->insert(
				$wpdb->orbis_companies,
				[
					'post_id' => $post_id,
					'name'    => $post->post_title,
				],
				[
					'%d',
					'%s',
				]
			);

			if ( false !== $result ) {
				$orbis_id = $wpdb->insert_id;

				update_post_meta( $post_id, '_orbis_company_id', $orbis_id );
			}
		} else {
			$result = $wpdb->update(
				$wpdb->orbis_companies,
				[ 'name' => $post->post_title ],
				[ 'id' => $orbis_id ],
				[ '%s' ],
				[ '%d' ]
			);
		}
	}
}
