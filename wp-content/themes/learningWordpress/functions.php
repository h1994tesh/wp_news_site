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

function ourWidgetsInit() {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar1',
        'before_widget' => '<ul>',
        'after_widget' => '</ul>'
    ));
    register_sidebar(array(
        'name' => 'Product Categories',
        'id' => 'sidebar2'
    ));
}

add_action('widgets_init', 'ourWidgetsInit');

function learningWordpress_customize_register($wp_customize) {
    $wp_customize->add_section('learningWordpress_link_color', array(
        'title' => __('Standard Colors', 'learningWordpress'),
        'description' => '',
        'priority' => 30,
    ));

    $wp_customize->add_setting('learningWordpress_link_color', array(
        'default' => '#fff',
        'type' => 'theme_mod',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'learningWordpress_link_color', array(
        'label' => __('Link Colors', 'learningWordpress'),
        'section' => 'learningWordpress_link_color',
        'settings' => 'learningWordpress_link_color',
    )));


    /* $wp_customize->add_section('learningWordpress_btn_color', array(
      'title' => __('Button Colors', 'learningWordpress'),
      'description' => '',
      'priority' => 31,
      ));

      $wp_customize->add_setting('learningWordpress_btn_color', array(
      'default' => '#006ec3',
      'type' => 'theme_mod',
      ));

      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'learningWordpress_btn_color', array(
      'label' => __('Button Colors', 'learningWordpress'),
      'section' => 'learningWordpress_btn_color',
      'settings' => 'learningWordpress_btn_color',
      ))); */
}

add_action('customize_register', 'learningWordpress_customize_register');

function learningWordpress_customize_css() {
    ?>
    <style>
        a:link,
        a:visited {
            color: <?php echo get_theme_mod('learningWordpress_link_color'); ?>;
        }
        .button{
            background-color: <?php echo get_theme_mod('learningWordpress_btn_color'); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'learningWordpress_customize_css');

// add footer callout section to admin appearance customize screen

function learningWordpress_footer_callout($wp_customize) {

    $wp_customize->add_section('learningWordpress-footer-callout-section', array(
        'title' => __('Footer Callout', 'learningWordpress'),
        'priority' => 10,
    ));
    /* $wp_customize->add_setting('learningWordpress-footer-callout-headline', array(
      'default' => 'Example Headline text!',
      'type' => 'theme_mod'
      ));
      $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'learningWordpress-footer-callout-headline-section', array(
      'label' => 'Headline',
      'section' => 'learningWordpress-footer-callout-headline-section',
      'setting' => 'learningWordpress-footer-callout-headline'
      ))); */
}

add_action('customize_register', 'learningWordpress_footer_callout');

add_action('init', 'learningWordpress_register_my_post_types');

function learningWordpress_register_my_post_types() {

    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'add_new' => 'Add New Product',
        'add_new_item' => 'Add New Product',
        'edit_item' => 'Edit Product',
        'new_item' => 'New Product',
        'all_items' => 'All Products',
        'view_item' => 'View Product',
        'search_items' => 'Search Products',
        'not_found' => 'No products found',
        'not_found_in_trash' => 'No products found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Products',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'taxonomies' => array('category'),
        'rewrite' => array('products'),
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments')
    );

    register_post_type('products', $args);
    flush_rewrite_rules();
}

function learningWordpress_css() {

    echo "
    <style type='text/css'>
    .fs-has-title{display: none;}
    </style>
    ";
}

add_action('admin_head', 'learningWordpress_css');

add_action('init', 'learningWordpress_product_type_taxonomy');

function learningWordpress_product_type_taxonomy() {

    $labels = array(
        'name' => 'Type',
        'singular_name' => 'Types',
        'search_items' => 'Search Types',
        'all_items' => 'All Types',
        'parent_item' => 'Parent Type',
        'parent_item_colon' => 'Parent Type:',
        'edit_item' => 'Edit Type',
        'update_item' => 'Update Type',
        'add_new_item' => 'Add New Type',
        'new_item_name' => 'New Type Name',
        'menu_name' => 'Type'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => true
    );
    register_taxonomy('type', 'products', $args);
}

?>