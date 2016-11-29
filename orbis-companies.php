<?php
/*
Plugin Name: Orbis Companies
Plugin URI: https://www.pronamic.eu/plugins/orbis-companies/
Description: The Orbis Companies plugin extends your Orbis environment with the option to manage companies.

Version: 1.0.0
Requires at least: 3.5

Author: Pronamic
Author URI: https://www.pronamic.eu/

Text Domain: orbis_companies
Domain Path: /languages/

License: Copyright (c) Pronamic

GitHub URI: https://github.com/wp-orbis/wp-orbis-companies
*/

/**
 * Includes
 */
require_once 'includes/companies.php';

/**
 * Bootstrap
 */
function orbis_companies_bootstrap() {
	// Classes
	require_once 'classes/orbis-companies-plugin.php';

	// Initialize
	global $orbis_companies_plugin;

	$orbis_companies_plugin = new Orbis_Companies_Plugin( __FILE__ );
}

add_action( 'orbis_bootstrap', 'orbis_companies_bootstrap' );
