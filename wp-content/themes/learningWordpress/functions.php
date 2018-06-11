<?php

function learningWordpress_styles() {
    wp_enqueue_style('theme-styles-reset', get_template_directory_uri() . '/css/reset.css');
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/css/styles.css');
}

add_action('wp_enqueue_scripts', 'learningWordpress_styles');

function learningWordpress_function() {

    wp_enqueue_script('myscript', get_template_directory_uri() . '/js/jquery.js');
    wp_enqueue_script('myscript-1', get_template_directory_uri() . '/js/slider.js');
    wp_enqueue_script('myscript-2', get_template_directory_uri() . '/js/superfish.js');
    wp_enqueue_script('myscript-3', get_template_directory_uri() . '/js/custom.js');
}

add_action('wp_enqueue_scripts', 'learningWordpress_function');

function learningWordpress_admin_bar() {
    return false;
}

add_filter('show_admin_bar', 'learningWordpress_admin_bar');

/* customize excerpt word count length */

function custom_excerpt_length() {
    return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length');


/* theme setup */

function learningWordpress_setup() {
    /* register menus in admin */
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        'foooter' => __('Secondary Menu'),
    ));

    /* add feature image support */
    add_theme_support('post-thumbnails');
    add_image_size('small-thumbnail', 180, 120, true);
    add_image_size('banner-image', 920, 210, true);
    add_image_size('left-top-banner-image', 920, 210, array("left", "top"));
    /* add post format support
      add_theme_support('post-formats', array('aside', 'gallery', 'link'));
     */
}

add_action('after_setup_theme', 'learningWordpress_setup');

function learningWordpress_posts_formats() {
    /* add post format support */
    add_theme_support('post-formats', array('aside', 'gallery', 'link'));
}

add_action('after_setup_theme', 'learningWordpress_posts_formats');
/* add our widget locations */
function ourWidgetsInit(){
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar1',
        'before_widget' => '<ul>',
        'after_widget' => '</ul>'
    ));
}
add_action('widgets_init', 'ourWidgetsInit');

function learningWordpress_customize_register(){
    
}