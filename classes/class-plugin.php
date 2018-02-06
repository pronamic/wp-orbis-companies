<?php

class Orbis_Companies_Plugin extends Orbis_Plugin {
	public function __construct( $file ) {
		parent::__construct( $file );

		$this->set_name( 'orbis_companies' );
		$this->set_db_version( '1.1.0' );

		// Load text domain
		$this->load_textdomain( 'orbis-companies', '/languages/' );

		// Tables
		orbis_register_table( 'orbis_companies' );

		// Actions
		add_action( 'p2p_init', array( $this, 'p2p_init' ) );

		add_action( 'wp_ajax_company_id_suggest', array( $this, 'ajax_suggest_company_id' ) );

		// Content Types
		$this->content_types = new Orbis_Companies_ContentTypes();

		// Admin
		if ( is_admin() ) {
			$this->admin = new Orbis_Companies_Admin( $this );
		}
	}

	/**
	 * Install
	 *
	 * @mysql UPDATE wp_options SET option_value = 0 WHERE option_name = 'orbis_db_version';
	 *
	 * @see Orbis_Plugin::install()
	 */
	public function install() {
		// Tables
		orbis_install_table( 'orbis_companies', '
			id BIGINT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id BIGINT(20) UNSIGNED DEFAULT NULL,
			name VARCHAR(128) NOT NULL,
			e_mail VARCHAR(128) DEFAULT NULL,
			PRIMARY KEY  (id)
		' );

		// Install
		parent::install();
	}

	/**
	 * Posts to posts initialize
	 */
	public function p2p_init() {
		p2p_register_connection_type( array(
			'name' => 'orbis_persons_to_companies',
			'from' => 'orbis_person',
			'to'   => 'orbis_company',
			'title'       => array(
				'from' => __( 'Companies', 'orbis-companies' ),
				'to'   => __( 'Contacts', 'orbis-companies' ),
			),
			'from_labels' => array(
				'singular_name' => __( 'Contact', 'orbis-companies' ),
				'search_items'  => __( 'Search contact', 'orbis-companies' ),
				'not_found'     => __( 'No contacts found.', 'orbis-companies' ),
				'create'        => __( 'Add Contact', 'orbis-companies' ),
				'new_item'      => __( 'New Contact', 'orbis-companies' ),
				'add_new_item'  => __( 'Add New Contact', 'orbis-companies' ),
			),
			'to_labels'   => array(
				'singular_name' => __( 'Company', 'orbis-companies' ),
				'search_items'  => __( 'Search company', 'orbis-companies' ),
				'not_found'     => __( 'No companies found.', 'orbis-companies' ),
				'create'        => __( 'Add Company', 'orbis-companies' ),
				'new_item'      => __( 'New Company', 'orbis-companies' ),
				'add_new_item'  => __( 'Add New Company', 'orbis-companies' ),
			),
		) );
	}

	/**
	 * AJAX suggest company ID.
	 */
	public function ajax_suggest_company_id() {
		global $wpdb;

		$term = filter_input( INPUT_GET, 'term', FILTER_SANITIZE_STRING );

		$query = "
			SELECT
				company.id AS id,
				company.name AS text
			FROM
				$wpdb->orbis_companies AS company
			WHERE
				company.name LIKE %s
			;"
		;

		$like = '%' . $wpdb->esc_like( $term ) . '%';

		$query = $wpdb->prepare( $query, $like ); // unprepared SQL

		$data = $wpdb->get_results( $query ); // unprepared SQL

		echo wp_json_encode( $data );

		die();
	}
}
