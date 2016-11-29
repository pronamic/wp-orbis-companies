<?php

class Orbis_Companies_Plugin extends Orbis_Plugin {
	public function __construct( $file ) {
		parent::__construct( $file );

		$this->set_name( 'orbis_companies' );
		$this->set_db_version( '1.1.0' );

		// Actions
		add_action( 'p2p_init', array( $this, 'p2p_init' ) );

		// Includes
		$this->plugin_include( 'includes/post.php' );

		// Tables
		orbis_register_table( 'orbis_companies' );
	}

	public function loaded() {
		$this->load_textdomain( 'orbis_companies', '/languages/' );
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

	//////////////////////////////////////////////////

	/**
	 * Posts to posts initialize
	 */
	public function p2p_init() {
		p2p_register_connection_type( array(
			'name' => 'orbis_persons_to_companies',
			'from' => 'orbis_person',
			'to'   => 'orbis_company',
			'title'       => array(
				'from' => __( 'Companies', 'orbis' ),
				'to'   => __( 'Contacts', 'orbis' ),
			),
			'from_labels' => array(
				'singular_name' => __( 'Contact', 'orbis' ),
				'search_items'  => __( 'Search contact', 'orbis' ),
				'not_found'     => __( 'No contacts found.', 'orbis' ),
				'create'        => __( 'Add Contact', 'orbis' ),
				'new_item'      => __( 'New Contact', 'orbis' ),
				'add_new_item'  => __( 'Add New Contact', 'orbis' ),
			),
			'to_labels'   => array(
				'singular_name' => __( 'Company', 'orbis' ),
				'search_items'  => __( 'Search company', 'orbis' ),
				'not_found'     => __( 'No companies found.', 'orbis' ),
				'create'        => __( 'Add Company', 'orbis' ),
				'new_item'      => __( 'New Company', 'orbis' ),
				'add_new_item'  => __( 'Add New Company', 'orbis' ),
			),
		) );
	}
}
