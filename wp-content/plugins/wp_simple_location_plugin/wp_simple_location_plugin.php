<?php
/*
  Plugin Name: WordPress Simple Location Plugin
  Plugin URI:  https://github.com/simonrcodrington/Introduction-to-WordPress-Plugins---Location-Plugin
  Description: Creates an interfaces to manage store / business locations on your website. Useful for showing location based information quickly. Includes both a widget and shortcode for ease of use.
  Version:     1.0.0
  Author:      Simon Codrington
  Author URI:  http://www.simoncodrington.com.au
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
defined('ABSPATH') or die('Nope, not accessing this');

class wp_simple_location {

    private $wp_location_trading_hour_days = array();

    public function __construct() {
        add_action('init', array($this, 'set_location_trading_hour_days')); //sets the default trading hour days (used by the content type)
        add_action('init', array($this, 'register_location_content_type')); //register location content type
        add_action('add_meta_boxes', array($this, 'add_location_meta_boxes')); //add meta boxes
        add_action('save_post_wp_locations', array($this, 'save_location')); //save location
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_and_styles')); //admin scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts_and_styles')); //public scripts and styles
        add_filter('the_content', array($this, 'prepend_location_meta_to_content')); //gets our meta data and dispayed it before the content

        register_activation_hook(__FILE__, array($this, 'plugin_activate')); //activate hook
        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivate')); //deactivate hook
    }

    public function set_location_trading_hour_days() {

        //set the default days to use for the trading hours
        $this->wp_location_trading_hour_days = apply_filters('wp_location_trading_hours_days', array('monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
                )
        );
    }

    public function register_location_content_type() {
        $labels = array(
            'name' => 'Location',
            'singular_name' => 'Location',
            'menu_name' => 'Location',
            'name_admin_bar' => 'Location',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Location',
            'new_item' => 'New Location',
            'edit_item' => 'edit_item',
            'view_item' => 'View Location',
            'all_items' => 'All Locations',
            'search_items' => 'Search Locations',
            'parent_item_colon' => 'Parent Location:',
            'not_found' => 'No Locations found.',
            'not_found_in_trash' => 'No Locations found in Trash.',
        );

        $args = array(
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
            'rewrite' => array('slug' => 'locations', 'with_front' => true),
        );
        register_post_type('wp_locations', $args);
    }

    public function add_location_meta_box() {
        add_meta_box(
                'wp_location_meta_box', 'Location Information', array($this, 'location_meta_box_display'), 'wp_locations', 'normal', 'default'
        );
    }

    public function location_meta_box_display($post) {
        wp_nonce_field('wp_location_nonce', 'wp_location_nonce_field');

        $wp_location_phone = get_post_meta($post->ID, 'wp_location_phone', true);
        $wp_location_email = get_post_meta($post->ID, 'wp_location_email', true);
        $wp_location_address = get_post_meta($post->ID, 'wp_location_address', true);
        ?>
        <p>Enter additional information about your location </p>
        <div class="field-container">
            <?php do_action('wp_location_admin_form_start'); ?>
            <div class="field">
                <label for="wp_location_phone">Contact Phone</label>
                <small>main contact number</small>
                <input type="tel" name="wp_location_phone" id="wp_location_phone" value="<?php echo $wp_location_phone; ?>"/>
            </div>
            <div class="field">
                <label for="wp_location_email">Contact Email</label>
                <small>Email contact</small>
                <input type="email" name="wp_location_email" id="wp_location_email" value="<?php echo $wp_location_email; ?>"/>
            </div>
            <div class="field">
                <label for="wp_location_address">Address</label>
                <small>Physical address of your location</small>
                <textarea name="wp_location_address" id="wp_location_address"><?php echo $wp_location_address; ?></textarea>
            </div>
            <?php
            //trading hours
            if (!empty($this->wp_location_trading_hour_days)) {
                echo '<div class="field">';
                echo '<label>Trading Hours </label>';
                echo '<small> Trading hours for the location (e.g 9am - 5pm) </small>';
                //go through all of our registered trading hour days
                foreach ($this->wp_location_trading_hour_days as $day_key => $day_value) {
                    //collect trading hour meta data
                    $wp_location_trading_hour_value = get_post_meta($post->ID, 'wp_location_trading_hours_' . $day_key, true);
                    //dsiplay label and input
                    echo '<label for="wp_location_trading_hours_' . $day_key . '">' . $day_key . '</label>';
                    echo '<input type="text" name="wp_location_trading_hours_' . $day_key . '" id="wp_location_trading_hours_' . $day_key . '" value="' . $wp_location_trading_hour_value . '"/>';
                }
                echo '</div>';
            }
            do_action('wp_location_admin_form_end');
            ?>
        </div>
        <?php
    }

    public function plugin_active() {
        $this->register_location_content_type();
        flush_rewrite_rules();
    }

    public function plugin_deactivate() {
        flush_rewrite_rules();
    }

    public function prepend_location_meta_to_content($content) {
        global $post, $post_type;
        if ($post_type == 'wp_locations' && is_singular('wp_locations')) {
            $wp_location_id = $post->ID;
            $wp_location_phone = get_post_meta($post->ID, 'wp_location_phone', true);
            $wp_location_email = get_post_meta($post->ID, 'wp_location_email', true);
            $wp_location_address = get_post_meta($post->ID, 'wp_location_address', true);

            $html = "";
            $html .= "<section class='meta-data'>";
            do_action('wp_location_meta_data_output_start', $wp_location_id);

            $html .= "<p>";

            if (!empty($wp_location_phone)) {
                $html .= "<b>Location Phone</b>" . $wp_location_phone . "<br/>";
            }
            if (!empty($wp_location_email)) {
                $html .= "<b>Location Email</b>" . $wp_location_email . "<br/>";
            }

            if (!empty($wp_location_address)) {
                $html .= "<b>Location Address</b>" . $wp_location_address . "<br/>";
            }

            $html .= '</p>';

            if (!empty($this->wp_location_trading_hour_days)) {
                $html .= '<p>';
                $html .= '<b>Location Trading Hours </b></br>';
                foreach ($this->wp_location_trading_hour_days as $day_key => $day_value) {
                    $trading_hours = get_post_meta($post->ID, 'wp_location_trading_hours_' . $day_key, true);
                    $html .= '<span class="day">' . $day_key . '</span><span class="hours">' . $trading_hours . '</span></br>';
                }
                $html .= '</p>';
            }

            do_action('wp_location_meta_data_output_end', $wp_location_id);
            $html .= "</section>";
            $html .= $content;
            return $html;
        } else {
            return $content;
        }
    }

    public function get_location_output($arguments = "") {
        $default_args = array(
            'location_id' => '',
            'number_of_locations' => -1
        );
        if (!empty($arguments) && is_array($arguments)) {
            foreach ($arguments as $arg_key => $arg_val) {
                if (array_key_exists($arg_key, $arguments)) {
                    $default_args[$arg_key] = $arg_val;
                }
            }
        }

        $location_args = array(
            'post_type' => 'wp_locations',
            'poss_per_page' => $default_args['number_of_location'],
            'post_status' => 'publish'
        );
        if (!empty($default_args["location_id"])) {
            $location_args['include'] = $default_args['location_id'];
        }
        $html = '';
        $location = get_posts($location_args);
        if ($location) {
            $html .= '<article class="location_list cf">';
            foreach ($locations as $location) {
                $html .= '<section class="location">';
                $wp_location_id = $location->ID;
                $wp_location_title = get_the_title($wp_location_id);
                $wp_location_thumbnail = get_the_post_thumbnail($wp_location_id, 'thumbnail');
                $wp_location_content = apply_filters('the_content', $location->post_content);
                if (!empty($wp_location_content)) {
                    $wp_location_content = strip_shortcodes(wp_trim_words($wp_location_content, 40, '...'));
                }
                $wp_location_permalink = get_permalink($wp_location_id);
                $wp_location_phone = get_post_meta($wp_location_id, 'wp_location_phone', true);
                $wp_location_email = get_post_meta($wp_location_id, 'wp_location_email', true);
                $html = apply_filters('wp_location_before_main_content', $html);
                $html .= '<h2 class="title">';
                $html .= '<a href="' . $wp_location_permalink . '" title="view location">';
                $html .= $wp_location_title;
                $html .= '</a>';
                $html .= '</h2>';
            }
        }
    }

}

$wp_simple_locations = new wp_simple_location;

