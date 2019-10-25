<?php
/*
Plugin Name: &nbsp;✨WP Performant Media✨
Description: Simple lazy-loading images with an elegant focus effect.
Plugin URI: https://github.com/pixelcollective/wp-performant-media
Author: Tiny Pixel Collective, Kelly Mears <developers@tinypixel.io>
Version: 1.0.0
Author URI: https://tinypixel.io
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Performant_Media {
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, "load_scripts" ) );

		add_filter( 'the_content', array( $this, "lazyloader_filter" ) );
		
	}

	public function load_scripts() {
		wp_enqueue_script( 'wp-performant-media.js', plugins_url( 'dist/wp-performant-media.js',  __FILE__ ), [], '1.0.0', true );
		wp_enqueue_style( 'wp-performant-media.css', plugins_url( 'dist/wp-performant-media.css',  __FILE__ ), [], '1.0.0' );
	}

	public function lazyloader_filter( $content ) {
		$content = preg_replace( "/<img(.*?)(src=|srcset=)(.*?)>/i", '<img$1data-$2$3>', $content );
		$content = preg_replace( '/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lazy-load"$3>', $content );
		$content = preg_replace( '/<img((?:(?!class=).)*?)>/i', '<img class="lazy-load"$1>', $content);
		return $content;
	}
}

new WP_Performant_Media();
