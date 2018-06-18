<?php
/*
  Plugin Name: My Custom Plugin
  Description: Custom Plugin for wordpress
  Version:     1.0.0
  Author:      Hitesh Gandhi
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
  {Plugin Name} is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  {Plugin Name} is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with {Plugin Name}. If not, see {License URI}.
 * 
 */

defined('ABSPATH') or die('Nope, not accessing this');

function my_custom_plugin_setup_post_type() {

    $labels = array(
        'name' => 'Custom Plugin',
        'singular_name' => 'Custom Plugin',
        'menu_name' => 'Custom Plugin',
        'name_admin_bar' => 'Custom Plugin',
        'add_new' => 'Add new custom',
        'add_new_item' => 'Add new custom item',
        'new_item' => 'New Custom',
        'edit_item' => 'Edit Custom',
        'view_item' => 'View Custom',
        'all_items' => 'All Custom',
        'search_items' => 'Search Custom',
        'parent_item_colon' => 'Parent Custom:',
        'not_found' => 'No Custom Found.',
        'not_found_in_trash' => 'No Custom Found in Trash.'
    );

    $arg = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav' => true,
        'query_var' => true,
        'hierarchical' => false,
        'supports' => array('title', 'thumbnail', 'editor'),
        'has_archive' => true,
        'menu_position' => 20,
        'show_in_admin_bar' => true,
        'menu_icon' => 'dashicons-location-alt',
        'rewrite' => array('slug' => 'custom-plugin', 'with_front' => true),
    );
    register_post_type('my_custom_plugin', $arg);
}

add_action('init', 'my_custom_plugin_setup_post_type');

function my_custom_plugin_install() {
    my_custom_plugin_setup_post_type();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'my_custom_plugin_install');

function my_custom_plugin_deactivation() {
    unregister_post_type('book');
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'my_custom_plugin_deactivation');

function my_custom_plugin_uninstall() {
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die;
    }
}

register_uninstall_hook(__FILE__, 'my_custom_plugin_uninstall');

//function my_custom_plugin_options_page(){
//    add_menu_page('Custom Plugin', 'Custom Plugin', 'manage_options', 'custom-plugin');
//}
//
//add_action('admin_init', 'my_custom_plugin_options_page');
//function my_custom_plugin_remove_options_page(){
//    remove_menu_page('custom-plugin');
//}
//add_action('admin_menu', 'my_custom_plugin_remove_options_page');
/**
 * generate a Delete link based on the homepage url
 */
function my_custom_plugin_delete_link($content) {
    if (is_single() && in_the_loop() && is_main_query()) {
        $url = add_query_arg([
            'action' => 'my_custom_post_delete',
            'post' => get_the_ID()
                ], home_url());
        return $content . '<a href="' . esc_url($url) . '">' . esc_html('Delete Custom Post', 'my_custom_plugin') . '</a>';
    }
    return null;
}

/**
 * request handler
 */
function my_custom_plugin_delete_post() {
    if (isset($_GET["action"]) && $_GET["action"] === 'my_custom_post_delete') {
        die('ddddd');
    }
}

add_filter('the_content', 'my_custom_plugin_appendText');

function my_custom_plugin_appendText($content) {

    if (is_single()) {
        $content.= '<h3>Enjoyed this article?</h3>';
        $content.= '<p>Subscribe to my <a href="#">RSS feed</a>!</p>';
    }
    return $content;
}

function my_custom_plugin_changeTitle($title) {
    return $title .= " Hitesh Gandhi";
}

add_filter('wp_title', 'my_custom_plugin_changeTitle');

function my_custom_plugin_css() {
    ?>
    <style>
        .textAndRelatedProducts {
            padding: 20px;
        }
    </style>
    <?php
}
?><?php
add_action('wp_head', 'my_custom_plugin_css');

function my_custom_plugin_create_menu() {
    add_menu_page('Custom Top Menu', 'Custom Top Menu', 'manage_options', 'custom-top-menu', 'custom_plugin_menu_function');
    //call register settings function
    add_action('admin_init', 'my_custom_plugin_register_settings');
}

function my_custom_plugin_register_settings() {
    //register our settings
    register_setting('my-custom-plugin-settings-group', 'my_custom_plugin_options', 'my_custom_plugin_sanitize_options');
}

add_action('admin_menu', 'my_custom_plugin_create_menu');

function custom_plugin_menu_function() {
    ?>
    <div class="wrap">
        <h2>Halloween Plugin Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields('my-custom-plugin-settings-group'); ?>
            <?php $my_custom_plugin_options = get_option('my_custom_plugin_options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Name</th>
                    <td><input type="text" name="my_custom_plugin_options[option_name]"
                               value="<?php echo esc_attr($my_custom_plugin_options['option_name']); ?>" />
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary"
                       value="Save Changes" />
            </p>
        </form>
    </div>
    <?php
}
