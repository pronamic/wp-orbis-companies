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
	 * Plugin.
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Company post type.
	 *
	 * @var AdminCompanyPostType
	 */
	private $company_post_type;

	/**
	 * Construct.
	 *
	 * @param Plugin $plugin Plugin.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		// Project post type
		$this->company_post_type = new AdminCompanyPostType( $plugin );
	}
}
