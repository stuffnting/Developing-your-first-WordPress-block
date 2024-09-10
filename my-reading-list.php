<?php
/**
 * Plugin Name:       My Reading List
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.6
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Grover Stones
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-reading-list
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register a book custom post type
 */
add_action( 'init', 'my_reading_list_register_book_post_type' );
function my_reading_list_register_book_post_type() {
    register_post_type(
        'book',
        array(
            'labels'       => array(
                'name'          => 'Books',
                'singular_name' => 'Book',
            ),
            'public'       => true,
            'has_archive'  => true,
            'supports'     => array( 'title', 'editor', 'thumbnail' ),
            'show_in_rest' => true
        ) 
    );
}

/**
 * Add featured image to the book post type
 */
add_action( 'rest_api_init', 'my_reading_list_register_book_featured_image' );
function my_reading_list_register_book_featured_image() {
    register_rest_field(
        'book',
        'featured_image_src',
        array(
            'get_callback' => 'my_reading_list_get_book_featured_image_src',
            'schema'       => null,
        )
    );
}
function my_reading_list_get_book_featured_image_src( $object ) {
    if ( $object['featured_media'] ) {
        $img = wp_get_attachment_image_src( $object['featured_media'], 'medium' );
        return $img[0];
    }
    return false;
}

function my_reading_list_render_callback( $attributes ) {
	$args  = array(
			'post_type' => 'book',
	);
	$books = get_posts( $args );

	$wrapper_attributes = get_block_wrapper_attributes();

	$output  = '';
	$output .= sprintf( '<div %1$s>', $wrapper_attributes );
	$output .= '<p>My Reading List – hello from the rendered content!</p>';

	foreach ( $books as $book ) {
			$output .= '<div>';
			$output .= '<h2>' . $book->post_title . '</h2>';
			if ( $attributes['showImage'] ) {
					$output .= get_the_post_thumbnail( $book->ID, 'medium' );
			}
			if ( $attributes['showContent'] ) {
					$output .= $book->post_content;
			}
			$output .= '</div>';
	}

	$output .= '</div>';

	return $output;
}

add_action( 'init', 'my_reading_list_reading_list_block_init' );
function my_reading_list_reading_list_block_init() {
	register_block_type( __DIR__ . '/build', array( 'render_callback' => 'my_reading_list_render_callback' ) );
}
