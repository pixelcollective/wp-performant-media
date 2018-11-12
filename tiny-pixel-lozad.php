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



