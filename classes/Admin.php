<?php
/**
 * Admin
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-2.0-or-later
 * @package   Pronamic\Orbis\Companies
 */

namespace Pronamic\Orbis\Companies;

/**
 * Admin class
 */
class Admin {
	/**
	 * Construct.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		// Project post type
		$this->company_post_type = new AdminCompanyPostType( $plugin );
	}
}
