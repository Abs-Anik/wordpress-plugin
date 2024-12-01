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

class Academy_Batch_Three {
    private static $instance;

    private function __construct() {
        add_filter('the_content', array($this, 'the_content_callback'));
        add_action('wp_footer', array($this, 'wp_footer'));
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
        $url = get_the_permalink();
        $image = '<p><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt="qrcode"></p>';
        $content .= $image;
        return $content;
    }

    public function wp_footer() {
        $url = home_url();
        $image = '<p><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$url.'" alt="qrcode"></p>';
        echo $image;
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