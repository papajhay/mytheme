<?php
add_action('wp_enqueue_scripts', function (){
    wp_enqueue_style('mytheme-child', get_stylesheet_uri());
}, 11);

add_action('after_setup_theme', function () {
    load_child_theme_textdomain('mytheme-enfant', get_stylesheet_directory() . '/languages');
});

add_filter('montheme_search_title', function () {
    return 'Recherche : %s';
});