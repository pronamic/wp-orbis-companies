<?php

class Orbis_Companies_ContentTypes {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize.
	 */
	public function init() {
		register_post_type(
			'orbis_company',
			array(
				'label'           => __( 'Companies', 'orbis-companies' ),
				'labels'          => array(
					'name'               => __( 'Companies', 'orbis-companies' ),
					'singular_name'      => __( 'Company', 'orbis-companies' ),
					'add_new'            => _x( 'Add New', 'orbis_company', 'orbis-companies' ),
					'add_new_item'       => __( 'Add New Company', 'orbis-companies' ),
					'edit_item'          => __( 'Edit Company', 'orbis-companies' ),
					'new_item'           => __( 'New Company', 'orbis-companies' ),
					'all_items'          => __( 'All Companies', 'orbis-companies' ),
					'view_item'          => __( 'View Company', 'orbis-companies' ),
					'search_items'       => __( 'Search Companies', 'orbis-companies' ),
					'not_found'          => __( 'No companies found.', 'orbis-companies' ),
					'not_found_in_trash' => __( 'No companies found in Trash.', 'orbis-companies' ),
					'parent_item_colon'  => __( 'Parent Company:', 'orbis-companies' ),
					'menu_name'          => __( 'Companies', 'orbis-companies' ),
				),
				'public'          => true,
				'menu_position'   => 30,
				'menu_icon'       => 'dashicons-building',
				'capability_type' => array( 'orbis_company', 'orbis_companies' ),
				'supports'        => array( 'title', 'editor', 'author', 'comments', 'thumbnail', 'custom-fields', 'revisions' ),
				'has_archive'     => true,
				'rewrite'         => array(
					'slug' => _x( 'companies', 'slug', 'orbis-companies' ),
				),
			)
		);

		register_taxonomy(
			'orbis_company_category',
			array( 'orbis_company' ),
			array(
				'hierarchical' => true,
				'labels'       => array(
					'name'              => _x( 'Categories', 'taxonomy general name', 'orbis-companies' ),
					'singular_name'     => _x( 'Category', 'taxonomy singular name', 'orbis-companies' ),
					'search_items'      => __( 'Search Categories', 'orbis-companies' ),
					'all_items'         => __( 'All Categories', 'orbis-companies' ),
					'parent_item'       => __( 'Parent Category', 'orbis-companies' ),
					'parent_item_colon' => __( 'Parent Category:', 'orbis-companies' ),
					'edit_item'         => __( 'Edit Category', 'orbis-companies' ),
					'update_item'       => __( 'Update Category', 'orbis-companies' ),
					'add_new_item'      => __( 'Add New Category', 'orbis-companies' ),
					'new_item_name'     => __( 'New Category Name', 'orbis-companies' ),
					'menu_name'         => __( 'Categories', 'orbis-companies' ),
				),
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => _x( 'company-category', 'slug', 'orbis-companies' ),
				),
			)
		);
	}
}