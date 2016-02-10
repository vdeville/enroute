<?php
/**
 * Plugin Name: Enroute
 * Plugin URI: https://wordpress.org/plugins/enroute/
 * Description: Show your visitors how to get to you, during their journey.
 * Version: 1.0
 * Author: Yusri Mathews
 * Author URI: http://yusrimathews.co.za/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Enroute Plugin
 * Copyright (C) 2015, Yusri Mathews - yo@yusrimathews.co.za
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

function enroute_activation(){
	global $current_user;
	$user_id = $current_user->ID;

	update_user_meta( $user_id, 'enroute_plugin_activation', date( 'F j, Y' ) );
	update_user_meta( $user_id, 'enroute_rate_ignore', 'false' );
	update_user_meta( $user_id, 'enroute_donate_ignore', 'false' );
}
register_activation_hook( __FILE__, 'enroute_activation' );

include_once('inc/notices.php');
include_once('inc/post-types.php');
include_once('inc/taxonomies.php');
include_once('inc/custom-meta.php');

add_action( 'admin_enqueue_scripts', 'enroute_scripts_admin' );
function enroute_scripts_admin(){
	wp_enqueue_style( 'enroute-font-awesome', plugin_dir_url( __FILE__ ) . 'vendor/font-awesome/4.4.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'enroute-menu-css', plugin_dir_url( __FILE__ ) . 'css/menu.min.css', array( 'enroute-font-awesome' ) );
	if( get_post_type( get_the_ID() ) == 'page' ){
		wp_enqueue_style( 'enroute-admin-css', plugin_dir_url( __FILE__ ) . 'css/admin.min.css', array( 'enroute-font-awesome' ) );
		wp_enqueue_script( 'enroute-admin-js', plugin_dir_url( __FILE__ ) . 'js/admin.min.js', array( 'jquery' ) );
	}
}

add_action( 'media_buttons', 'enroute_sbtn', 99 );
function enroute_sbtn(){
	if( get_post_type( get_the_ID() ) == 'page' ){
		echo '<a href="#" id="enroute_sbtn" class="button"><i class="fa fa-road"></i> Add Enroute</a>';
	}
}

function enroute_get_stores(){
	$enr_stores = get_posts( array(
		'post_type' => 'enr_stores',
		'orderby'	=> 'title',
		'order'		=> 'ASC',
		'posts_per_page' => -1
	) );

	$enr_map_locations = array();
	$enr_map_locations_counter = 0;
	foreach ( $enr_stores as $k => $v ) :
		$enr_gps = get_post_meta( $v->ID, '_enr_gps' );
		$enr_address = get_post_meta( $v->ID, '_enr_address' );
		$enr_email = get_post_meta( $v->ID, '_enr_email' );
		$enr_tel = get_post_meta( $v->ID, '_enr_tel' );
		if( !empty( $enr_gps ) ){
			$enr_map_locations[$enr_map_locations_counter]['id'] = $v->ID;
			$enr_map_locations[$enr_map_locations_counter]['name'] = $v->post_title;
			$enr_map_locations[$enr_map_locations_counter]['address'] = ( isset( $enr_address[0] ) ? $enr_address[0] : '' );
			$enr_map_locations[$enr_map_locations_counter]['email'] = ( isset( $enr_email[0] ) ? $enr_email[0] : '' );
			$enr_map_locations[$enr_map_locations_counter]['tel'] = ( isset( $enr_tel[0] ) ? $enr_tel[0] : '' );
			$explode_gps = explode( ',', $enr_gps[0] );
			$enr_map_locations[$enr_map_locations_counter]['gps']['lat'] = ( isset( $explode_gps[0] ) ? trim( $explode_gps[0] ) : '' );
			$enr_map_locations[$enr_map_locations_counter]['gps']['lng'] = ( isset( $explode_gps[1] ) ? trim( $explode_gps[1] ) : '' );
			$enr_map_locations_counter++;
		}
	endforeach;

	return $enr_map_locations;
}

function enroute_get_tax_stores( $term_id ){
	$enr_stores = get_posts( array(
		'post_type' => 'enr_stores',
		'orderby'	=> 'title',
		'order'		=> 'ASC',
		'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'enr_locations',
                'field' => 'id',
                'terms' => $term_id,
                'include_children' => false
            )
        )
	) );

	$enr_map_locations = array();
	$enr_map_locations_counter = 0;
	foreach ( $enr_stores as $k => $v ) :
		$enr_gps = get_post_meta( $v->ID, '_enr_gps' );
		$enr_address = get_post_meta( $v->ID, '_enr_address' );
		$enr_email = get_post_meta( $v->ID, '_enr_email' );
		$enr_tel = get_post_meta( $v->ID, '_enr_tel' );
		if( !empty( $enr_gps ) ){
			$enr_map_locations[$enr_map_locations_counter]['id'] = $v->ID;
			$enr_map_locations[$enr_map_locations_counter]['name'] = $v->post_title;
			$enr_map_locations[$enr_map_locations_counter]['address'] = ( isset( $enr_address[0] ) ? $enr_address[0] : '' );
			$enr_map_locations[$enr_map_locations_counter]['email'] = ( isset( $enr_email[0] ) ? $enr_email[0] : '' );
			$enr_map_locations[$enr_map_locations_counter]['tel'] = ( isset( $enr_tel[0] ) ? $enr_tel[0] : '' );
			$explode_gps = explode( ',', $enr_gps[0] );
			$enr_map_locations[$enr_map_locations_counter]['gps']['lat'] = ( isset( $explode_gps[0] ) ? trim( $explode_gps[0] ) : '' );
			$enr_map_locations[$enr_map_locations_counter]['gps']['lng'] = ( isset( $explode_gps[1] ) ? trim( $explode_gps[1] ) : '' );
			$enr_map_locations_counter++;
		}
	endforeach;

	return $enr_map_locations;
}

add_action( 'wp_enqueue_scripts', 'enroute_scripts' );
function enroute_scripts(){
	if( !is_404() && !is_tax() ){
		$page_object = get_post( get_the_ID() ); 
		$page_content = $page_object->post_content;
	}

	if( is_page( get_the_ID() ) && has_shortcode( $page_content, 'enroute' ) || is_tax( 'enr_locations' ) ){

        if( is_page( get_the_ID() ) && has_shortcode( $page_content, 'enroute' ) ){
           $enr_map_locations = enroute_get_stores();
        } elseif( is_tax( 'enr_locations' ) ){
            global $wp_query;
            $term = $wp_query->get_queried_object();
            $enr_tax_locations = enroute_get_tax_stores( $term->term_id );
        }
        
		wp_enqueue_style( 'enroute-font-awesome', plugin_dir_url( __FILE__ ) . 'vendor/font-awesome/4.4.0/css/font-awesome.min.css' );
		wp_enqueue_style( 'enroute-public-css', plugin_dir_url( __FILE__ ) . 'css/public.min.css', array( 'enroute-font-awesome' ) );

		if( !empty( $enr_map_locations ) ){
			wp_enqueue_script( 'enroute-google-api', 'http://maps.googleapis.com/maps/api/js' );
			wp_register_script( 'enroute-script-js', plugin_dir_url( __FILE__ ) . 'js/map-script.min.js', array( 'enroute-google-api' ) );
			$enr_pass = array(
				'enr_map_locations' => $enr_map_locations
			);
			wp_localize_script( 'enroute-script-js', 'enr_pass', $enr_pass );
			wp_enqueue_script( 'enroute-script-js' );
        } elseif( !empty( $enr_tax_locations ) ){
			wp_enqueue_script( 'enroute-google-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places' );
			wp_register_script( 'enroute-script-js', plugin_dir_url( __FILE__ ) . 'js/tax-script.min.js', array( 'enroute-google-api' ) );
			$enr_pass = array(
				'enr_map_locations' => $enr_tax_locations
			);
			wp_localize_script( 'enroute-script-js', 'enr_pass', $enr_pass );
			wp_enqueue_script( 'enroute-script-js' );
        }

		wp_enqueue_script( 'enroute-public-js', plugin_dir_url( __FILE__ ) . 'js/public.min.js', array( 'jquery' ) );

	}
}

add_action( 'wp_print_scripts', 'enroute_dequeue_scripts', 100 );
function enroute_dequeue_scripts(){
	global $pagenow;

	if( !is_404() && !is_admin() && !is_tax() && $pagenow != 'wp-login.php' && !is_search() ){
		$page_object = get_post( get_the_ID() ); 
		$page_content = $page_object->post_content;
	}

	if( is_page( get_the_ID() ) && has_shortcode( $page_content, 'enroute' ) || is_tax( 'enr_locations' ) ){
		wp_dequeue_script( 'google_map' );
	}

}

add_shortcode( 'enroute', 'enroute_shortcode' );
function enroute_shortcode( $atts ){

	if( !is_404() ){
		$page_object = get_post( get_the_ID() ); 
		$page_content = $page_object->post_content;
	}

	if( is_page( get_the_ID() ) && has_shortcode( $page_content, 'enroute' ) ){

        $enr_map_locations = enroute_get_stores();
		$height = ( isset( $atts['height'] ) ? $atts['height'] : '400' );

		$shortcodeOutput = '<div id="enroute-holder">';

			if( !empty( $enr_map_locations ) ){
				$shortcodeOutput .= '<div id="enroute-map" class="enroute-map-container" style="height: ' . $height . 'px;"></div>';

				$shortcodeOutput .= '<div id="enroute-output" class="enroute-map-container" style="height: ' . $height . 'px; display: none;"></div>';
				$shortcodeOutput .= '<div id="enroute-route">';
					$shortcodeOutput .= '<div class="split">';
						$shortcodeOutput .= '<input type="text" id="enroute-from" class="enroute-control" value="" onfocus="enroute_geolocate()" placeholder="Enter your address">';
					$shortcodeOutput .= '</div>';
					$shortcodeOutput .= '<div class="split">';
						$shortcodeOutput .= '<select id="enroute-to" class="enroute-control">';
							$shortcodeOutput .= '<option value="">Select your nearest store</option>';
							foreach( $enr_map_locations as $k => $v ){
								$shortcodeOutput .= '<option value="' . $v['gps']['lat'] . ', ' . $v['gps']['lng'] . '">' . $v['name'] . '</option>';
							}
						$shortcodeOutput .= '</select>';
					$shortcodeOutput .= '</div>';
					$shortcodeOutput .= '<div class="split">';
						$shortcodeOutput .= '<input type="button" class="enroute-btn" id="enroute-submit" value="Get Route" onclick="enroute_getmap()">';
					$shortcodeOutput .= '</div>';
					$shortcodeOutput .= '<div id="enroute-controls-top" class="enroute-map-controls" style="display: none;">';
						$shortcodeOutput .= '<input type="button" class="enroute-btn enroute-print" onclick="enroute_printmap()" value="Print" />';
						$shortcodeOutput .= '<input type="button" class="enroute-btn" onclick="enroute_clearoutput()" value="Clear" />';
					$shortcodeOutput .= '</div>';
					$shortcodeOutput .= '<div id="enroute-directions" style="display: none;"></div>';
					$shortcodeOutput .= '<div id="enroute-controls-bottom" class="enroute-map-controls" style="display: none;">';
						$shortcodeOutput .= '<input type="button" class="enroute-btn enroute-print" onclick="enroute_printmap()" value="Print" />';
						$shortcodeOutput .= '<input type="button" class="enroute-btn" onclick="enroute_clearoutput()" value="Clear" />';
					$shortcodeOutput .= '</div>';
				$shortcodeOutput .= '</div>';
			}

		$shortcodeOutput .= '</div>';
		
		return $shortcodeOutput;

	} else {
		echo '<p>Something is wrong with your Enroute shortcode. Please use our built in shortcode generator to assist you.</p>';
	}

}

add_filter( 'template_include', 'enroute_template_override' );
function enroute_template_override( $template ){

    if( is_tax( 'enr_locations' ) ){
        $has_template = locate_template( 'taxonomy-enr_locations.php' );
        
        if( $has_template != '' ){
            $template = get_stylesheet_directory() . '/taxonomy-enr_locations.php';
        } else {
            $template = plugin_dir_path( __FILE__ ) . '/templates/taxonomy-enr_locations.php';
        }
    }

    return $template;
}
