<?php
namespace AB_Three;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Post_Type {

    public function __construct() {
        add_action('init', array($this, 'init'));
        add_filter('the_content', array($this, 'the_content'));
        add_action('book_category_edit_form_fields', array($this, 'book_category_edit_form_fields'));
    }

    public function init() {
        register_post_type( 'book', array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'Book',
                'add_new_item'  => 'Add New Book',
                'search_items'  => 'Search Books',
                'view_item'     => 'View Book',
                'not_found'     => 'No Books Found',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'page-attributes', 'thumbnail'),
            'hierarchical' => true,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'menu_position' => 3,
            'menu_icon'     => 'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#fff"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32l432 0c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9 320 448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6l0-79.1L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>'),
            'has_archive'   => true,
            'rewrite' => array( 'slug' => 'books' ),
        ) );

        register_taxonomy('book_category', 'book', array(
            'labels' => array(
                'name' => 'Categories',
                'singular_name' => 'Category',
                'add_new_item'  => 'Add New Category',
            ),
            'show_in_rest' => true,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'books-categories' ),
        ));
        register_taxonomy('book_tags', 'book', array(
            'labels' => array(
                'name' => 'Tags',
                'singular_name' => 'Tag',
                'add_new_item'  => 'Add New Tag',
            ),
            'show_in_rest' => true,
            'hierarchical' => false,
        ));
    }

    public function the_content($contents) {

        if(! is_singular('book') ) {
            return $contents;
        }

        $terms = wp_get_post_terms(get_the_ID(), 'book_category');
        ob_start();
        ?>
            <ul>
                <?php foreach($terms as $term): ?>
                    <li><a href="<?php echo get_term_link($term, 'book_category'); ?>"><?php echo $term->name ; ?></a></li>
                <?php endforeach;   ?>
            </ul>
        <?php

        $html = ob_get_clean();

        return $contents.$html;
    }

    public function book_category_edit_form_fields () {
        ?>

        <?php
    }
}