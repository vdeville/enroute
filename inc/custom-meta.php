<?php

function enr_metaboxes( $meta_boxes ){
    $prefix = '_enr_';
    $meta_boxes['enr_store_info'] = array(
        'id' => 'enr_store_info',
        'title' => 'Store Information',
        'pages' => array('enr_stores'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
			array(
			    'name' => 'Physical Address',
			    'id' => $prefix . 'address',
			    'type' => 'textarea_small'
			),
			array(
			    'name' => 'GPS Co-ordinates',
			    'desc' => 'Latitude and longitude only. Example: "-33.9248685, 18.4240553". Degrees, minutes, seconds will be generated automatically.',
			    'id'   => $prefix . 'gps',
			    'type' => 'text_medium',
			),
			array(
			    'name' => 'Telephone Number',
			    'id'   => $prefix . 'tel',
			    'type' => 'text_medium',
			),
			array(
			    'name' => 'Email Address',
			    'id'   => $prefix . 'email',
			    'type' => 'text_medium',
			),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'enr_metaboxes' );

add_action( 'init', 'enr_initialize_metaboxes', 9999 );
function enr_initialize_metaboxes(){
    if( !class_exists( 'cmb_Meta_Box' ) ){
        require_once( 'custom-meta/init.php' );
    }
}
