<?php
/*
Plugin Name: Orbis Companies
Plugin URI: https://www.pronamic.eu/plugins/orbis-companies/
Description: The Orbis Companies plugin extends your Orbis environment with the option to manage companies.

Version: 1.0.0
Requires at least: 3.5

Author: Pronamic
Author URI: https://www.pronamic.eu/

Text Domain: orbis-companies
Domain Path: /languages/

License: Copyright (c) Pronamic

GitHub URI: https://github.com/wp-orbis/wp-orbis-companies
*/

/**
 * Autoload.
 */
require_once __DIR__ . '/vendor/autoload_packages.php';

/**
 * Bootstrap.
 */
function orbis_companies_bootstrap() {
	global $orbis_companies_plugin;

	$orbis_companies_plugin = new Orbis_Companies_Plugin( __FILE__ );
}

add_action( 'plugins_loaded', 'orbis_companies_bootstrap' );
