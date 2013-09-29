<?php
/*
Plugin Name: Pixel FAQs
Plugin URI: https://github.com/pixeljunction/pxlfaqs
Description: A WordPress plugin to easily add an FAQs section to your WordPress site.
Version: 1.0
Author: Mark Wilkinson
Author URI: http://markwilkinson.me
License: GPLv2 or later
*/

/* load plugin template tags */
require_once dirname( __FILE__ ) . '/inc/template-tags.php';

/***************************************************************
* Function pxlfaq_register_post_types()
* Register the necessary post types for the site.
***************************************************************/
function pxlfaq_register_post_types() {

	$pxlfaq_labels = apply_filters( 'pxlfaq_post_type_labels', array(
		'name' => _x( 'FAQs', 'post type general name' ),
		'singular_name' => _x( 'FAQ', 'post type singular name' ),
		'add_new' => _x( 'Add New', 'FAQ' ),
	    'add_new_item' => __( 'Add New FAQ' ),
	    'edit_item' => __( 'Edit FAQ' ),
	    'new_item' => __( 'New FAQ' ),
	    'view_item' => __( 'View FAQ' ),
	    'search_items' => __( 'Search FAQs' ),
	    'not_found' =>  __( 'No FAQs found' ),
	    'not_found_in_trash' => __( 'No FAQs found in Trash' ), 
	    'parent_item_colon' => '',
	    'menu_name' => 'FAQs'
	 ) );
	
	register_post_type( 'pxlfaq_faq',
		array(
			'labels' => $pxlfaq_labels,
			'public' => true,
			'menu_position' => 25,
			'supports' => array( 'title', 'editor' ),
			'query_var' => true,
			'rewrite' => array( 'slug' => 'faqs', 'with_front' => false ),
			'has_archive' => true,
		)
	);

}

add_action( 'init', 'pxlfaq_register_post_types' );

/***************************************************************
* Function pxlfaq_register_taxonomies()
* Register the necessary custom taxonomies for the plugin.
***************************************************************/
function pxlfaq_register_taxonomies() {
	
	/* register the faw category taxonomy */
	register_taxonomy( 'pxlfaq_faq_cat', 'pxlfaq_faq',
		array(
			'labels' => apply_filters( 'pxlfaq_faq_cat_labels',
				array(
					'name' => _x( 'FAQ Category', 'taxonomy general name' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name' ),
					'search_items' =>  __( 'Search Categories' ),
					'all_items' => __( 'All Categories' ),
					'parent_item' => __( 'Parent Category' ),
					'parent_item_colon' => __( 'Parent Category:' ),
					'edit_item' => __( 'Edit Category' ), 
					'update_item' => __( 'Update Category' ),
					'add_new_item' => __( 'Add New Category' ),
					'new_item_name' => __( 'New Category Name' ),
					'menu_name' => __( 'Categories' ),
				)
			),
			'hierarchical' => true,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'faq-category' )
		)
	);
	
	/* register the faq tag taxonomy */
	register_taxonomy( 'pxlfaq_faq_tag', 'pxlfaq_faq',
		array(
			'labels' => apply_filters( 'pxlfaq_faq_tag_labels',
				array(
					'name' => _x( 'FAQ Tags', 'taxonomy general name' ),
					'singular_name' => _x( 'FAQ Tag', 'taxonomy singular name' ),
					'search_items' =>  __( 'Search FAQ Tags' ),
					'all_items' => __( 'All FAQ Tags' ),
					'edit_item' => __( 'Edit FAQ Tag' ), 
					'update_item' => __( 'Update FAQ Tag' ),
					'add_new_item' => __( 'Add New FAQ Tag' ),
					'new_item_name' => __( 'New FAQ Tag Name' ),
					'menu_name' => __( 'FAQ Tags' ),
				)
			),
			'hierarchical' => false,
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'faq-tags' )
		)
	);

}

add_action( 'init', 'pxlfaq_register_taxonomies' );

/**************************************************************************
* Function pxlfaq_enqueue_scripts()
* Enqueues the necessary scripts for the plugin
**************************************************************************/
function pxlfaq_enqueue_scripts() {

	/* check this is an FAQ post type */
    if( 'pxlfaq_faq' == get_post_type() ) {
    
    	/* register a stlyesheet */
    	wp_register_style( 'pxlfaq_style', plugins_url( '/css/pxlfaq-style.css', __FILE__ ) );
    	
    	/* enqueue the styes */
    	wp_enqueue_style( 'pxlfaq_style' );
    
    	/* enqueue the wordpress jquery script */
		wp_enqueue_script( 'jquery' );
		
		/* register the accordion script */
		wp_register_script( 'pxlfaq_accordion', plugins_url( '/js/jquery-accordion.js', __FILE__ ), 'jquery' );
		
		/* enqueue the accordion script */
		wp_enqueue_script( 'pxlfaq_accordion' );
		
	}	
	
}

add_action( 'wp_enqueue_scripts', 'pxlfaq_enqueue_scripts' );

/**************************************************************************
* Function pxlfaq_do_theme_redirect()
* Only includes theme redirect files if there is no 404
* @param $url - URL of the template file to include
**************************************************************************/
function pxlfaq_do_theme_redirect( $url ) {
    
    global $post, $wp_query;
    	
	/* include the template file name passed to the function */
    include_once( $url );
    die();
       
}


/***************************************************************
* Function pxlfaq_load_templates()
* Checks for an FAQ template in the theme before defaulting to
* a template in this plugin templates folder.
***************************************************************/
function pxlfaq_load_templates() {
	
	global $wp;
	
	/* get the plugin directory */
    $pxlfaq_plugindir = dirname( __FILE__ );
    
    /* check whether this is the faw post type archive */
	if( is_post_type_archive( 'pxlfaq_faq' ) ) {
	
		/* set the name of the template file name for this post type */
        $pxlfaq_template_filename = 'archive-pxlfaq_faq.php';
        
        /* check whether a file for this template exists in the theme */
        if( file_exists( STYLESHEETPATH . '/' . $pxlfaq_template_filename ) ) {
        	
        	/* there is a file in the theme so lets use it */
            $pxlfaq_return_template = STYLESHEETPATH . '/' . $pxlfaq_template_filename;
        
        /* no template file exists in the theme */
        } else {
        	
        	/* return the path of the template file from the plugin folder */
            $pxlfaq_return_template = $pxlfaq_plugindir . '/templates/' . $pxlfaq_template_filename;
        
        }
        
        /* do the redirecting based on which temlplates file was returned from above */
        pxlfaq_do_theme_redirect( $pxlfaq_return_template );
	
	}
	
}

add_action( 'template_redirect', 'pxlfaq_load_templates' );