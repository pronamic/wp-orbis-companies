<?php

class Orbis_Companies_Admin {
	/**
	 * Construct.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		// Project post type
		$this->company_post_type = new Orbis_Projects_AdminCompanyPostType( $plugin );
	}
}
