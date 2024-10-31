<?php
/*
Plugin Name: Posts RSS Feeds
Plugin URI: https://profiles.wordpress.org/cynob
Description: This plugin helps to generate xml feeds of post/page/custom post type.  
Author: cynob
Contributors: cynob
Version: 1.0.0
Author URI: http://cynob.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('CBPRF_PAGE_DIR', plugin_dir_path(__FILE__).'pages/');

//Include menu and assign page
function cbprf_plugin_menu() {
	add_menu_page("Posts RSS Feeds", "Posts RSS Feeds", "administrator", "cbprf-settings-page", "cbprf_plugin_pages", 'dashicons-rss', 38);
	add_submenu_page("cbprf-settings-page", "About Us", "About Us", "administrator", "cbprf-about-us", "cbprf_plugin_pages");
}
add_action("admin_menu", "cbprf_plugin_menu");

function cbprf_plugin_pages() {
   $itm = CBPRF_PAGE_DIR.$_GET["page"].'.php';
   include($itm);
}

//set feed template to page
add_filter( 'page_template', 'cbprf_feed_page_template' );
function cbprf_feed_page_template( $page_template )
{  
    if ( is_page( 'media-rss' ) ) { 
        $page_template = plugin_dir_path(__FILE__) . 'pages/custom-feed.php';
    }
    return $page_template;
}

//create feed page start
function cbprf_check_page_feed_page_exist(){
	if( get_page_by_title( 'media-rss' ) == NULL ){
	 cbprf_create_pages_feed( 'media-rss' );
	}
}

add_action('init','cbprf_check_page_feed_page_exist');
function cbprf_create_pages_feed($pageName) {
	$createPage = array(
		'post_title'    => $pageName,
		'post_content'  => 'Starter content',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_type'     => 'page',
		'post_name'     => $pageName
	);

	// Insert the post into the database
	wp_insert_post( $createPage );
}
//create feed page end

//add admin css
function cbprf_admin_css() {
  wp_register_style('cbprf_admin_css', plugins_url('includes/feed-admin-style.css',__FILE__ ));
  wp_enqueue_style('cbprf_admin_css');
}
add_action( 'admin_init','cbprf_admin_css' );
?>