<?php
// Enqueue theme CSS
function custom_theme_assets() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
// Hook to enqueue scripts and styles
add_action('wp_enqueue_scripts', 'custom_theme_assets');

// Tilføj Featured Image-support
add_theme_support('post-thumbnails');
?>