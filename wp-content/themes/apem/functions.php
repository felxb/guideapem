<?php
/**
 * moonshine functions and definitions
 * @package moonshine
 */


if ( ! function_exists( 'moonshine_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function moonshine_setup() {
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );


	/*
	 * Switch default core markup for search form and gallery fields, to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	) );
}
endif;
add_action( 'after_setup_theme', 'moonshine_setup' );


/**
 * Enqueue scripts and styles.
 */
function shfl_enqueue_scripts() {

	$ajaxStrings = array(
		'ajaxurl'=> admin_url( 'admin-ajax.php'),
		'exemple'=> __("Example","shfl")
	);

	wp_enqueue_script( "jquery" );
	wp_enqueue_style( 'moonshine-style', get_stylesheet_uri(),array(),"2.1" );

}
add_action( 'wp_enqueue_scripts', 'shfl_enqueue_scripts' );


/*enqueue custom admin styles*/
function shfl_admin_enqueue_scripts($hook) {
  wp_enqueue_style( "shfl-custom-style-admin", get_stylesheet_directory_uri()."/style-admin.css");
}
add_action( 'admin_enqueue_scripts', 'shfl_admin_enqueue_scripts' );


/*Custom Post Types*/

function shfl_custom_post_types() {

	/*Definitions*/
	$labels = array(
	    'name' => __('Definitions','shfl'),
	    'singular_name' => __('Definition','shfl'),
	    'add_new' => __('Add New','shfl'),
	    'add_new_item' => __('Add new Definition','shfl'),
	    'edit_item' => __('Edit Definition','shfl'),
	    'new_item' => __('New Definition','shfl'),
	    'view_item' => __('View Definition','shfl'),
	    'search_items' => __('Search Definitions','shfl'),
	    'not_found' =>  __('No Definitions found','shfl'),
	    'not_found_in_trash' => __('No Definitions found in Trash','shfl')	    
	);

	$supports = array('title');

	register_post_type( 'definitions',
	    array(
	      'labels' => $labels,
	      'label' => __('Definitions','shfl'),
	      'description' => __('Definitions to be displayed throughout website.','shfl'),
	      'public' => false,
	      'exclude_from_search' => true,
	      'publicly_queryable'=> false,
	      'supports' => $supports,
	      'hierarchical' => true,
	      'show_ui' => true,
	      'menu_icon' => 'dashicons-admin-links', //https://developer.wordpress.org/resource/dashicons/#index-card
	      'rewrite' => false,
	      'capability_type' => 'post'
	    )
	);

}

add_action( 'init', 'shfl_custom_post_types' );

include('functions-admin.php');
