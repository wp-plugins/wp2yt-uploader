<?php

/***********************************
*	SCRIPT CONTROLS
***********************************/

function load_icon_set1_style() {
	wp_register_style( 'svg-icon-set1-style',  plugin_dir_url(__FILE__).'css/wp-svg-icon-set1-plugin-style.css');
}
add_action( 'wp_enqueue_scripts', 'load_icon_set1_style' );
function load_icon_set1_style_dashboard() {