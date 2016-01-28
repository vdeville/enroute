<?php

add_action( 'init', 'enr_register_cpt' );
function enr_register_cpt(){
	$labels = array(
		'name'               => _x( 'Stores', 'post type general name', 'enr' ),
		'singular_name'      => _x( 'Store', 'post type singular name', 'enr' ),
		'menu_name'          => _x( 'Stores', 'admin menu', 'enr' ),
		'name_admin_bar'     => _x( 'Store', 'add new on admin bar', 'enr' ),
		'add_new'            => _x( 'New Store', 'book', 'enr' ),
		'add_new_item'       => __( 'Add New Store', 'enr' ),
		'new_item'           => __( 'New Store', 'enr' ),
		'edit_item'          => __( 'Edit Store', 'enr' ),
		'view_item'          => __( 'View Store', 'enr' ),
		'all_items'          => __( 'Stores', 'enr' ),
		'search_items'       => __( 'Search Stores', 'enr' ),
		'parent_item_colon'  => __( 'Parent Stores:', 'enr' ),
		'not_found'          => __( 'No stores found.', 'enr' ),
		'not_found_in_trash' => __( 'No stores found in Trash.', 'enr' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array( 'title' )
	);

	register_post_type( 'enr_stores', $args );
}
