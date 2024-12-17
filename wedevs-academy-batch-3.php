<?php
/**
 * Plugin Name: Academy Batch Three
 * Plugin URI: https://example.com
 * Description: This is plugin description.
 * Version: 1.0.0
 * Author: Anik
 * Author URI: https://example.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wedevs-academy-batch-3
 */

 if ( !defined( 'ABSPATH' ) ) {
    return;
 }

class Academy_Batch_Three {
    private static $instance;

    private function __construct() {
        // add_filter('the_content', array($this, 'the_content_callback'));
        // add_action('wp_footer', array($this, 'wp_footer'));
        // add_filter('body_class', array($this, 'body_class'), 10, 2);
        $this->define_constants();
        $this->load_classes();
    }

    public static function get_instance() {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();
        return self::$instance;
    }
    public function the_content_callback($content) {
        // return "Hi Anik";
        //return $content; // filter hook can change the data
        $is_show = apply_filters('academy_show_post_content_qr_code', true);
        if ( ! $is_show ) {
            return $content;
        }
        
        $url = get_the_permalink();
        $custom_class = implode( " ", apply_filters('qr_code_css_classes', array()) );
        $image = '<p><img class="'.$custom_class.'" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt="qrcode"></p>';
        $content .= $image;
        return $content;
    }

    public function wp_footer() {
        
        $url = home_url();
        $image = '<p><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt="qrcode"></p>';
        echo $image;
        do_action('before_footer_qr_code', array(1,2,3), 'Mr. Anik');
    }

    public function body_class($classes, $css_class) {
        print_r( $classes);
        $classes[] = 'my-image-class';
        return $classes;
    }

    private function define_constants () {
        define('AB_THREE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    }

    private function load_classes () {
        require_once AB_THREE_PLUGIN_PATH . 'includes/Admin_Menu.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Custom_Column.php';

        new AB_Three_Admin_Menu();
        new AB_Three\Custom_Column();
    }
}

Academy_Batch_Three::get_instance();

 // Filter Hook procedure process

//  function abt_the_content_callback($content) {
//     // return "Hi Anik";
//     //return $content; // filter hook can change the data
//     $url = get_the_permalink();
//     $image = '<p><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt="qrcode"></p>';
//     $content .= $image;
//     return $content;
//  }
//  add_filter('the_content', 'abt_the_content_callback');