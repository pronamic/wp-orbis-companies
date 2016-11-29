<?php

function orbis_companies_create_initial_post_types() {
	register_post_type(
		'orbis_company',
		array(
			'label'           => __( 'Companies', 'orbis' ),
			'labels'          => array(
				'name'               => __( 'Companies', 'orbis' ),
				'singular_name'      => __( 'Company', 'orbis' ),
				'add_new'            => _x( 'Add New', 'orbis_company', 'orbis' ),
				'add_new_item'       => __( 'Add New Company', 'orbis' ),
				'edit_item'          => __( 'Edit Company', 'orbis' ),
				'new_item'           => __( 'New Company', 'orbis' ),
				'all_items'          => __( 'All Companies', 'orbis' ),
				'view_item'          => __( 'View Company', 'orbis' ),
				'search_items'       => __( 'Search Companies', 'orbis' ),
				'not_found'          => __( 'No companies found.', 'orbis' ),
				'not_found_in_trash' => __( 'No companies found in Trash.', 'orbis' ),
				'parent_item_colon'  => __( 'Parent Company:', 'orbis' ),
				'menu_name'          => __( 'Companies', 'orbis' ),
			),
			'public'          => true,
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-building',
			'capability_type' => array( 'orbis_company', 'orbis_companies' ),
			'supports'        => array( 'title', 'editor', 'author', 'comments', 'thumbnail', 'custom-fields', 'revisions' ),
			'has_archive'     => true,
			'rewrite'         => array(
				'slug' => _x( 'companies', 'slug', 'orbis' ),
			),
		)
	);

	register_taxonomy(
		'orbis_company_category',
		array( 'orbis_company' ),
		array(
			'hierarchical' => true,
			'labels'       => array(
				'name'              => _x( 'Categories', 'taxonomy general name', 'orbis' ),
				'singular_name'     => _x( 'Category', 'taxonomy singular name', 'orbis' ),
				'search_items'      => __( 'Search Categories', 'orbis' ),
				'all_items'         => __( 'All Categories', 'orbis' ),
				'parent_item'       => __( 'Parent Category', 'orbis' ),
				'parent_item_colon' => __( 'Parent Category:', 'orbis' ),
				'edit_item'         => __( 'Edit Category', 'orbis' ),
				'update_item'       => __( 'Update Category', 'orbis' ),
				'add_new_item'      => __( 'Add New Category', 'orbis' ),
				'new_item_name'     => __( 'New Category Name', 'orbis' ),
				'menu_name'         => __( 'Categories', 'orbis' ),
			),
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array(
				'slug' => _x( 'company-category', 'slug', 'orbis' ),
			),
		)
	);
}

add_action( 'init', 'orbis_companies_create_initial_post_types', 0 ); // highest priority
