<?php

/***********************************
*	SCRIPT CONTROLS
***********************************/

function wordpress_svg_icon_plugin_load_style() {
	wp_register_style( 'svg-icon-set1-style',  plugin_dir_url(__FILE__).'css/wordpress-svg-icon-plugin-style.css');
}
add_action( 'wp_enqueue_scripts', 'wordpress_svg_icon_plugin_load_style' );
function wordpress_svg_icon_plugin_load_style_dashboard() {