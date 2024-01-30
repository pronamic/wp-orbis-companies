<?php
/**
 * Plugin
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-2.0-or-later
 * @package   Pronamic\Orbis\Companies
 */

namespace Pronamic\Orbis\Companies;

/**
 * Plugin class
 */
class Plugin {
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );

		add_action( 'p2p_init', [ $this, 'p2p_init' ] );

		add_action( 'wp_ajax_company_id_suggest', [ $this, 'ajax_suggest_company_id' ] );

		// Content Types
		$this->content_types = new ContentTypes();

		// Admin
		if ( is_admin() ) {
			$this->admin = new Admin( $this );
		}
	}

	public function init() {
		global $wpdb;

		$wpdb->orbis_companies = $wpdb->prefix . 'orbis_companies';

		$version = '1.1.0';

		if ( \get_option( 'orbis_companies_db_version' ) !== $version ) {
			$this->install();

			\update_option( 'orbis_companies_db_version', $version );
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
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $wpdb->orbis_companies (
				id BIGINT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
				post_id BIGINT(20) UNSIGNED DEFAULT NULL,
				name VARCHAR(128) NOT NULL,
				e_mail VARCHAR(128) DEFAULT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;
		";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		\dbDelta( $sql );

		\maybe_convert_table_to_utf8mb4( $wpdb->orbis_companies );
	}

	/**
	 * Posts to posts initialize
	 */
	public function p2p_init() {
		p2p_register_connection_type(
			[
				'name'        => 'orbis_persons_to_companies',
				'from'        => 'orbis_person',
				'to'          => 'orbis_company',
				'title'       => [
					'from' => __( 'Companies', 'orbis-companies' ),
					'to'   => __( 'Contacts', 'orbis-companies' ),
				],
				'fields'      => [
					'note' => [
						'title' => __( 'Note', 'orbis-companies' ),
						'type'  => 'text',
					],
				],
				'from_labels' => [
					'singular_name' => __( 'Contact', 'orbis-companies' ),
					'search_items'  => __( 'Search contact', 'orbis-companies' ),
					'not_found'     => __( 'No contacts found.', 'orbis-companies' ),
					'create'        => __( 'Add Contact', 'orbis-companies' ),
					'new_item'      => __( 'New Contact', 'orbis-companies' ),
					'add_new_item'  => __( 'Add New Contact', 'orbis-companies' ),
					'help'          => __( 'Please note: these are contacts who do not necessarily work at this company. Handle the removal of connected contacts with great care. In many cases, deleting connected contacts is not desirable.', 'orbis-companies' ),
				],
				'to_labels'   => [
					'singular_name' => __( 'Company', 'orbis-companies' ),
					'search_items'  => __( 'Search company', 'orbis-companies' ),
					'not_found'     => __( 'No companies found.', 'orbis-companies' ),
					'create'        => __( 'Add Company', 'orbis-companies' ),
					'new_item'      => __( 'New Company', 'orbis-companies' ),
					'add_new_item'  => __( 'Add New Company', 'orbis-companies' ),
					'help'          => __( 'Please note: this contact does not necessarily work at these companies. Handle the removal of connected companies with great care. In many cases, deleting connected companies is not desirable.', 'orbis-companies' ),
				],
			] 
		);

		/**
		 * Posts 2 Users.
		 *
		 * @link https://github.com/scribu/wp-posts-to-posts/wiki/Posts-2-Users
		 */
		p2p_register_connection_type(
			[
				'name'        => 'orbis_users_to_companies',
				'from'        => 'user',
				'to'          => 'orbis_company',
				'title'       => [
					'from' => __( 'Companies', 'orbis-companies' ),
					'to'   => __( 'Users', 'orbis-companies' ),
				],
				'from_labels' => [
					'singular_name' => __( 'User', 'orbis-companies' ),
					'search_items'  => __( 'Search user', 'orbis-companies' ),
					'not_found'     => __( 'No users found.', 'orbis-companies' ),
					'create'        => __( 'Add User', 'orbis-companies' ),
					'new_item'      => __( 'New User', 'orbis-companies' ),
					'add_new_item'  => __( 'Add New User', 'orbis-companies' ),
				],
				'to_labels'   => [
					'singular_name' => __( 'Company', 'orbis-companies' ),
					'search_items'  => __( 'Search company', 'orbis-companies' ),
					'not_found'     => __( 'No companies found.', 'orbis-companies' ),
					'create'        => __( 'Add Company', 'orbis-companies' ),
					'new_item'      => __( 'New Company', 'orbis-companies' ),
					'add_new_item'  => __( 'Add New Company', 'orbis-companies' ),
				],
			] 
		);
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
			;";

		$like = '%' . $wpdb->esc_like( $term ) . '%';

		$query = $wpdb->prepare( $query, $like ); // unprepared SQL

		$data = $wpdb->get_results( $query ); // unprepared SQL

		echo wp_json_encode( $data );

		die();
	}
}
