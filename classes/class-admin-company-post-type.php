<?php

class Orbis_Projects_AdminCompanyPostType {
	/**
	 * Post type.
	 */
	const POST_TYPE = 'orbis_company';

	/**
	 * Construct.
	 */
	public function __construct( $plugin ) {		
		$this->plugin = $plugin;

		add_filter( 'manage_edit-' . self::POST_TYPE . '_columns' , array( $this, 'edit_columns' ) );

		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'save_company' ), 10, 2 );
		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'save_company_sync' ), 500, 2 );
	}

	/**
	 * Edit columns.
	 */
	public function edit_columns( $columns ) {
		$columns = array(
			'cb'                       => '<input type="checkbox" />',
			'title'                    => __( 'Title', 'orbis-companies' ),
			'orbis_company_address'    => __( 'Address', 'orbis-companies' ),
			'orbis_company_online'     => __( 'Online', 'orbis-companies' ),
			'orbis_company_kvk_number' => __( 'Registration Number', 'orbis-companies' ),
			'author'                   => __( 'Author', 'orbis-companies' ),
			'comments'                 => __( 'Comments', 'orbis-companies' ),
			'date'                     => __( 'Date', 'orbis-companies' ),
		);

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

				$website = get_post_meta( $post_id, '_orbis_company_website', true );

				if ( ! empty( $website ) ) {
					printf( '<a href="%s" target="_blank">%s</a>', $website, $website );

					$break = '<br />';
				}

				$email = get_post_meta( $post_id, '_orbis_company_email', true );

				if ( ! empty( $email ) ) {
					printf( $break );

					printf( '<a href="mailto:%s" target="_blank">%s</a>', $email, $email );
				}

				break;
			case 'orbis_company_address':
				$address  = get_post_meta( $post_id, '_orbis_company_address', true );
				$postcode = get_post_meta( $post_id, '_orbis_company_postcode', true );
				$city     = get_post_meta( $post_id, '_orbis_company_city', true );

				printf( '%s<br />%s %s', $address, $postcode, $city );

				break;
			case 'orbis_company_kvk_number':
				$kvk_number = get_post_meta( $post_id, '_orbis_company_kvk_number', true );

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
			array( $this, 'meta_box' ),
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
		$this->plugin->plugin_include( 'admin/meta-box-company-details.php' );
	}

	/**
	 * Save project.
	 *
	 * @param int $post_id
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
		$definition = array(
			'_orbis_company_kvk_number' => FILTER_SANITIZE_STRING,
			'_orbis_company_vat_number' => FILTER_SANITIZE_STRING,
			'_orbis_company_email'      => FILTER_VALIDATE_EMAIL,
			'_orbis_invoice_email'      => FILTER_VALIDATE_EMAIL,
			'_orbis_company_website'    => FILTER_VALIDATE_URL,
			'_orbis_company_address'    => FILTER_SANITIZE_STRING,
			'_orbis_company_postcode'   => FILTER_SANITIZE_STRING,
			'_orbis_company_city'       => FILTER_SANITIZE_STRING,
			'_orbis_company_country'    => FILTER_SANITIZE_STRING,
			'_orbis_company_twitter'    => FILTER_SANITIZE_STRING,
			'_orbis_company_facebook'   => FILTER_SANITIZE_STRING,
			'_orbis_company_linkedin'   => FILTER_SANITIZE_STRING,
		);

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
				array(
					'post_id' => $post_id,
					'name'    => $post->post_title,
				) ,
				array(
					'%d',
					'%s',
				)
			);

			if ( false !== $result ) {
				$orbis_id = $wpdb->insert_id;

				update_post_meta( $post_id, '_orbis_company_id', $orbis_id );
			}
		} else {
			$result = $wpdb->update(
				$wpdb->orbis_companies,
				array( 'name' => $post->post_title ) ,
				array( 'id' => $orbis_id ) ,
				array( '%s' ) ,
				array( '%d' )
			);
		}
	}
}