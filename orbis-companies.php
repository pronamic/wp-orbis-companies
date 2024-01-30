<?php
/**
 * Orbis Companies
 *
 * @package   Pronamic\Orbis\Companies
 * @author    Pronamic
 * @copyright 2024 Pronamic
 * @license   GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Orbis Companies
 * Plugin URI:        https://wp.pronamic.directory/plugins/orbis-companies/
 * Description:       The Orbis Companies plugin extends your Orbis environment with the option to manage companies.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pronamic
 * Author URI:        https://www.pronamic.eu/
 * Text Domain:       orbis-companies
 * Domain Path:       /languages/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://wp.pronamic.directory/plugins/orbis-companies/
 * GitHub URI:        https://github.com/pronamic/wp-orbis-companies
 */

namespace Pronamic\Orbis\Companies;

/**
 * Autoload.
 */
require_once __DIR__ . '/vendor/autoload_packages.php';

/**
 * Bootstrap.
 */
\add_action(
	'plugins_loaded',
	function () {
		\load_plugin_textdomain( 'orbis-companies', false, \dirname( \plugin_basename( __FILE__ ) ) . '/languages' );

		global $orbis_companies_plugin;

		$orbis_companies_plugin = new Plugin();
	}
);
