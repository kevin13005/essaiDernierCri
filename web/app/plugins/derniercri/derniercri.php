<?php
/**
 * Plugin Name:         derniercri
 * Description:         front end avec vue js pour un back avec wordpress!
 * Version:             1.0.0
 * Author:              Kevin Prevost
 * 
 * Be sure to rename the folder this file is in and this file to match what your plugin will be called. The names must be the same so WordPress knows where to look.
 */

function load_vuescripts() {
    wp_enqueue_style( 'vue_wp_styles', plugin_dir_url( __FILE__ ) . 'dist/css/app.css' );
    wp_register_script( 'vue_wp_compiled', plugin_dir_url( __FILE__ ) . 'dist/js/app.js', true );
    wp_register_script( 'vue_wp_dependencies', plugin_dir_url( __FILE__ ) . 'dist/js/chunk-vendors.js', true );
}

add_action( 'wp_enqueue_scripts', 'load_vuescripts' );

function attach_vue() {
    wp_enqueue_script( 'vue_wp_compiled' );
    wp_enqueue_script( 'vue_wp_dependencies' );

    return "<div id='app'>{{ template }}</div>";
}

add_shortcode( 'vue_wp', 'attach_vue' );

// Add the shortcode [vue_wp] to any page or post.
// The shorcode can be whatever. [vue_wp] is just an example.
?>