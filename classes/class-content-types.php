<?php

class Orbis_Companies_ContentTypes {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
	}

	/**
	 * Initialize.
	 */
	public function init() {
		register_post_type(
			'orbis_company',
			[
				'label'           => __( 'Companies', 'orbis-companies' ),
				'labels'          => [
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
				],
				'public'          => true,
				'menu_position'   => 30,
				'menu_icon'       => 'dashicons-building',
				'capability_type' => [ 'orbis_company', 'orbis_companies' ],
				'supports'        => [
					'title',
					'editor',
					'author',
					'comments',
					'thumbnail',
					'custom-fields',
					'revisions',
				],
				'has_archive'     => true,
				'show_in_rest'    => true,
				'rest_base'       => 'orbis/companies',
				'rewrite'         => [
					'slug' => _x( 'companies', 'slug', 'orbis-companies' ),
				],
			]
		);

		register_taxonomy(
			'orbis_company_category',
			[ 'orbis_company' ],
			[
				'hierarchical' => true,
				'labels'       => [
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
				],
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => [
					'slug' => _x( 'company-category', 'slug', 'orbis-companies' ),
				],
			]
		);

		register_taxonomy(
			'orbis_payment_method',
			[ 'orbis_company' ],
			[
				'hierarchical' => true,
				'labels'       => [
					'name'              => _x( 'Payment Methods', 'taxonomy general name', 'orbis-companies' ),
					'singular_name'     => _x( 'Payment Method', 'taxonomy singular name', 'orbis-companies' ),
					'search_items'      => __( 'Search Payment Methods', 'orbis-companies' ),
					'all_items'         => __( 'All Payment Methods', 'orbis-companies' ),
					'parent_item'       => __( 'Parent Payment Method', 'orbis-companies' ),
					'parent_item_colon' => __( 'Parent Payment Method:', 'orbis-companies' ),
					'edit_item'         => __( 'Edit Payment Method', 'orbis-companies' ),
					'update_item'       => __( 'Update Payment Method', 'orbis-companies' ),
					'add_new_item'      => __( 'Add New Payment Method', 'orbis-companies' ),
					'new_item_name'     => __( 'New Payment Method Name', 'orbis-companies' ),
					'menu_name'         => __( 'Payment Methods', 'orbis-companies' ),
				],
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => [
					'slug' => _x( 'payment-methods', 'slug', 'orbis-companies' ),
				],
				'meta_box_cb'  => false,
			]
		);

		register_taxonomy(
			'orbis_invoice_shipping_method',
			[ 'orbis_company' ],
			[
				'hierarchical' => true,
				'labels'       => [
					'name'              => _x( 'Invoice Shipping Methods', 'taxonomy general name', 'orbis-companies' ),
					'singular_name'     => _x( 'Invoice Shipping Method', 'taxonomy singular name', 'orbis-companies' ),
					'search_items'      => __( 'Search Invoice Shipping Methods', 'orbis-companies' ),
					'all_items'         => __( 'All Invoice Shipping Methods', 'orbis-companies' ),
					'parent_item'       => __( 'Parent Invoice Shipping Method', 'orbis-companies' ),
					'parent_item_colon' => __( 'Parent Invoice Shipping Method:', 'orbis-companies' ),
					'edit_item'         => __( 'Edit Invoice Shipping Method', 'orbis-companies' ),
					'update_item'       => __( 'Update Invoice Shipping Method', 'orbis-companies' ),
					'add_new_item'      => __( 'Add New Invoice Shipping Method', 'orbis-companies' ),
					'new_item_name'     => __( 'New Invoice Shipping Method Name', 'orbis-companies' ),
					'menu_name'         => __( 'Invoice Shipping Methods', 'orbis-companies' ),
				],
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => [
					'slug' => _x( 'invoice-shipping-methods', 'slug', 'orbis-companies' ),
				],
				'meta_box_cb'  => false,
			]
		);
	}
}
