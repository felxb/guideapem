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
  wp_enqueue_style( 'menu', get_stylesheet_directory_uri() . '/css/menu.css' );
  wp_enqueue_style( 'questionnaire', get_stylesheet_directory_uri() . '/css/questionnaire.css' );
	wp_enqueue_style( 'main-responsiveness', get_stylesheet_directory_uri() . '/style-responsiveness.css' );
	wp_enqueue_style( 'search', get_stylesheet_directory_uri() . '/css/search.css' );

}
add_action( 'wp_enqueue_scripts', 'shfl_enqueue_scripts' );


/*enqueue custom admin styles*/
function shfl_admin_enqueue_scripts($hook) {
  wp_enqueue_style( "shfl-custom-style-admin", get_stylesheet_directory_uri()."/style-admin.css");
}
add_action( 'admin_enqueue_scripts', 'shfl_admin_enqueue_scripts' );


/*Custom Post Types*/

function shfl_get_use_slug() {

    // array of slug data
    $slugs = array( 
        'fr_FR' => 'utilisation',
        'fr_CA' => 'utilisation',
        'en_CA' => 'use'
    );
    // return a default slug
    if( ! defined( 'WPLANG' ) || ! WPLANG || 'en_US' == WPLANG || !array_key_exists(WPLANG, $slugs) ) return 'use';

    return $slugs[WPLANG];
}

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
				'capability_type' => 'post',
				'has_archive' => true
	    )
	);

		/*Definitions*/
		$labels = array(
	    'name' => __('Music uses','shfl'),
	    'singular_name' => __('Music use','shfl'),
	    'add_new' => __('Add New','shfl'),
	    'add_new_item' => __('Add new Music use','shfl'),
	    'edit_item' => __('Edit Music use','shfl'),
	    'new_item' => __('New Music use','shfl'),
	    'view_item' => __('View Music use','shfl'),
	    'search_items' => __('Search Music uses','shfl'),
	    'not_found' =>  __('No Music uses found','shfl'),
	    'not_found_in_trash' => __('No Music uses found in Trash','shfl')	    
	);

	$supports = array('title');

	$slug = shfl_get_use_slug();

	register_post_type( 'use',
	    array(
	      'labels' => $labels,
	      'label' => __('Music uses','shfl'),
	      'description' => __('Music uses to be displayed throughout website.','shfl'),
	      'public' => true,
	      'exclude_from_search' => false,
	      'publicly_queryable'=> true,
	      'supports' => $supports,
	      'hierarchical' => false,
	      'show_ui' => true,
	      'menu_icon' => 'dashicons-admin-links', //https://developer.wordpress.org/resource/dashicons/#index-card
	      'rewrite' =>  array(
					'slug' => $slug,
					'with_front' => true,
					'pages' => true
				),
				'capability_type' => 'post',
				'has_archive' => false
	    )
	);

}

add_action( 'init', 'shfl_custom_post_types' );


 
function shfl_custom_taxonomy() {
 
	// the taxonomy of the music use 

  $labels = array(
    'name' => __( 'Types', 'shfl' ),
    'singular_name' => _x( 'Type',  'shfl' ),
    'search_items' =>  __( 'Search Type' ),
    'all_items' => __( 'All Types' ),
    'parent_item' => __( 'Parent Type' ),
    'parent_item_colon' => __( 'Parent Type:' ),
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'menu_name' => __( 'Types' ),
  );    
 
  register_taxonomy('types',array('use'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type' ),
  ));
 
}


add_action( 'init', 'shfl_custom_taxonomy', 0 );

function shfl_custom_option() {

	// Questionnaire in the admin view as option
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page(array(
			'page_title' 	=> 'Questionnaire',
			'menu_title'	=> 'Questionnaire',
			'menu_slug' 	=> 'menu_questionnaire',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));
	}
}

add_action( 'init', 'shfl_custom_option', 0 );

add_action('admin_menu','remove_default_post_type');

function remove_default_post_type() {
    remove_menu_page('edit.php');
}


/*
 *
 *
 * For searching into custom fields
 *
 */

/**
 * [list_searcheable_acf list all the custom fields we want to include in our search query]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf(){
	$list_searcheable_acf = array("title", "sub_title", "excerpt_short", "excerpt_long", "resume_de_lutilisation", "procedure_legale_et_administrative", "mise_en_garde_et_utilisations_liees");
	return $list_searcheable_acf;
}
/**
 * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
 * @param  [query-part/string]      $where    [the initial "where" part of the search query]
 * @param  [object]                 $wp_query []
 * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function advanced_custom_search( $where, &$wp_query ) {

	global $wpdb;

	if ( empty( $where ))
		return $where;

	// get search expression
	$terms = $wp_query->query_vars[ 's' ];

	// explode search expression to get search terms
	$exploded = explode( ' ', $terms );
	if( $exploded === FALSE || count( $exploded ) == 0 )
		$exploded = array( 0 => $terms );

	// reset search in order to rebuilt it as we whish
	$where = '';

	// get searcheable_acf, a list of advanced custom fields you want to search content in
	$list_searcheable_acf = list_searcheable_acf();
	foreach( $exploded as $tag ) :
		$where .= " 
          AND (
            ({$wpdb->base_prefix}posts.post_title LIKE '$tag')
            OR EXISTS (
              SELECT * FROM {$wpdb->base_prefix}postmeta
	              WHERE post_id = {$wpdb->base_prefix}posts.ID
	                AND (";
		foreach ($list_searcheable_acf as $searcheable_acf) :
			if ($searcheable_acf == $list_searcheable_acf[0]):
				$where .= " (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
			else :
				$where .= " OR (meta_key LIKE '%" . $searcheable_acf . "%' AND meta_value LIKE '%$tag%') ";
			endif;
		endforeach;
		$where .= ")
            )
        )";
	endforeach;

	return $where;
}

add_filter( 'posts_where', function ( $where, \WP_Query $q ) 
{
    if( ! is_admin() && $q->is_main_query() && $q->is_search()) // No global $wp_query here
    {
        return advanced_custom_search($where, $q);
    }

    return $where;      

}, 10, 2 ); // Note the priority 10 and number of input arguments is 2

// add_filter( 'posts_search', 'advanced_custom_search', 500, 2 );




/*
 *
 * End custom search stuff
 *
 */






/*

Definitions

Work processed every time a post is saved. meaning post type use or definition
For the three fields of the use post we have a corresponding _ui field that should be used for ui only.


*/


// make ui for post and definitions
function make_ui_for_definition_and_post($definition, $post_id){

	$fields = array('resume_de_lutilisation', 'procedure_legale_et_administrative', 'mise_en_garde_et_utilisations_liees');
	
	foreach ($fields as $field) {
		make_ui_for_field_and_definition_in_post($definition, $field, $post_id);
	}

	return;
}

function replace_definition_in_content($search, $content, $definition_content){
	return preg_replace('#(?!<a.*?)(?-i)(\b'.$search.'\b)(?![^<>]*?>)#si' , '<a class="definition" href="#" data-trigger="focus" data-toggle="popover" title="' . $search . '" data-content="' . $definition_content . '">' . $search . '</a>', $content );
}

function make_ui_for_field_and_definition_in_post($definition, $field_name, $post_id){
	$definition_title = $definition->post_title;
	$definition_title_lc = strtolower($definition_title);
	$definition_title_uc = strtoupper($definition_title);

	$definition_content = get_field('definition', $definition->ID, false);
	$field_content = get_field($field_name . '_ui', $post_id, false); 

	$field_content = replace_definition_in_content($definition_title, $field_content, $definition_content);
	$field_content = replace_definition_in_content($definition_title_lc, $field_content, $definition_content);
	$field_content = replace_definition_in_content($definition_title_uc, $field_content, $definition_content);

	/*
		Definition matching with ponctuation around. every time with first letter uppercase and normal casing.
	*/
	// dot at the end
	$variant = $definition_title . '.';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = $definition_title_lc . '.';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = $definition_title_uc . '.';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);

	// dot at the begining
	$variant = '.' . $definition_title;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = '.' . $definition_title_lc;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = '.' . $definition_title_uc;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);

	// coma at the end
	$variant = $definition_title . ',';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = $definition_title_lc . ',';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = $definition_title_uc . ',';
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);

	// coma at the begining
	$variant = ',' . $definition_title;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = ',' . $definition_title_lc;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);
	$variant = ',' . $definition_title_uc;
	$field_content = replace_definition_in_content($variant, $field_content, $definition_content);

	return update_field($field_name . '_ui', $field_content, $post_id);
}


function process_definitions_work() {

	$query = new WP_Query( 
		array( 
			'post_type' => 'use',
			'posts_per_page' => -1
		) 
	);

	$posts = $query->posts;


	$query = new WP_Query(
		array( 
			'post_type' => 'definitions',
			'nopaging' => true,
			'posts_per_page' => -1
		)
	);

	$all_definitions =  $query->posts;

	$fields = array('resume_de_lutilisation', 'procedure_legale_et_administrative', 'mise_en_garde_et_utilisations_liees');

	foreach ($posts as $post) {

	
		foreach ($fields as $field) {
			update_field($field . '_ui', get_field( $field, $post->ID ), $post->ID);
		}

		foreach ($all_definitions as $def) {
			make_ui_for_definition_and_post( $def, $post->ID);
		}

	}

	
}

add_action( 'save_post', 'process_definitions_work' );


add_filter('show_admin_bar', '__return_false');


/*
*
* End Definitions
*
*/





include('functions-admin.php');
