<?php

add_action( 'init', 'enr_register_tax', 0 );
function enr_register_tax(){
	$labels = array(
		'name'              => __( 'Store Locations' ),
		'singular_name'     => __( 'Location' ),
		'search_items'      => __( 'Search Locations' ),
		'all_items'         => __( 'All Locations' ),
		'parent_item'       => __( 'Parent Location' ),
		'parent_item_colon' => __( 'Parent Location:' ),
		'edit_item'         => __( 'Edit Location' ),
		'update_item'       => __( 'Update Location' ),
		'add_new_item'      => __( 'Add New Location' ),
		'new_item_name'     => __( 'New Location Name' ),
		'menu_name'         => __( 'Locations' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'public'			=> true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'			=> array( 'slug' => 'store-locator' )
	);

	register_taxonomy( 'enr_locations', array( 'enr_stores' ), $args );
}
