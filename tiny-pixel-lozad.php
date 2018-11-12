<?php
/*
Plugin Name: &nbsp;✨WP Performant Media✨
Description: Simple lazy-loading images with subtle CSS transition and polyfill support.
Plugin URI: https://github.com/pixelcollective/tiny-lozad
Author: Tiny Pixel Collective, Kelly Mears <developers@tinypixel.io>
Version: 1.0.0
Author URI: https://tinypixel.io
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap CMB2
 * 
 */
require_once plugin_dir_path( __FILE__ ). 'CMB2/init.php';

function cmb2_sample_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_pixel_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'test_metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Regular text field
	$cmb->add_field( array(
		'name'       => __( 'Test Text', 'cmb2' ),
		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	// URL text field
	$cmb->add_field( array(
		'name' => __( 'Website URL', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );

	// Email text field
	$cmb->add_field( array(
		'name' => __( 'Test Text Email', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'email',
		'type' => 'text_email',
		// 'repeatable' => true,
	) );
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script( 'intersection-observer-polyfill', plugins_url( 'vend/intersection-observer.js',  __FILE__ ), [], null, true );
    wp_enqueue_script( 'lozad', plugins_url( 'vend/lozad.js',  __FILE__ ), ['intersection-observer-polyfill'], null, true );
    wp_enqueue_script( 'pixel_lazy', plugins_url('tiny-pixel-lozad.js',  __FILE__ ), ['lozad'], null, true );
});

add_filter('the_content', function ($content) {
	$content = preg_replace( "/<img(.*?)(src=|srcset=)(.*?)>/i", '<img$1data-$2$3>', $content );
	$content = preg_replace( '/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lazy-load"$3>', $content );
	$content = preg_replace( '/<img((?:(?!class=).)*?)>/i', '<img class="lazy-load"$1>', $content);
	return $content;
});



