<?php

/**
 * @author  Brad Dalton
 * @link    https://wp.me/p1lTu0-hQ6
 * Template Name: Template Like Home
 */

add_action( 'genesis_meta', 'parallax_page_template_like_home' );

function parallax_page_template_like_home() {

		// Enqueue parallax script.
		add_action( 'wp_enqueue_scripts', 'parallax_enqueue_parallax_script' );

		// Add parallax-home body class.
		add_filter( 'body_class', 'parallax_body_class' );

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove primary navigation.
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		add_action( 'genesis_loop', 'parallax_page_template_sections' );
		
		add_action( 'wp_enqueue_scripts', 'parallax_template_inline_css' );

}

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'parallax_skip_links_output' );
function parallax_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}
	
	return $links;

}

// Add front page scripts.
function parallax_enqueue_parallax_script() {

	if ( ! wp_is_mobile() ) {
		wp_enqueue_script( 'parallax-script', get_stylesheet_directory_uri() . '/js/parallax.js', array( 'jquery' ), '1.0.0' );
	}

}

// Define parallax-home body class.
function parallax_body_class( $classes ) {

	$classes[] = 'parallax-home';

	return $classes;

}


function parallax_page_template_sections() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'parallax-pro' ) . '</h2>';
	
	$section_one = get_post_meta( get_the_ID(), 'parallax_section_one', true );
    if ( ! empty( $section_one ) ) {
        echo '<div class="home-odd home-section-1 widget-area"><div class="full-height"><div class="wrap">'. do_shortcode( $section_one ) .'</div></div></div>';
    }

	$section_two = get_post_meta( get_the_ID(), 'parallax_section_two', true );
    if ( ! empty( $section_two ) ) {
        echo '<div class="home-even home-section-2 widget-area"><div class="wrap">'. do_shortcode( $section_two ) .'</div></div>';
    }

	$section_three = get_post_meta( get_the_ID(), 'parallax_section_three', true );
    if ( ! empty( $section_three ) ) {
        echo '<div class="home-odd home-section-3 widget-area"><div class="wrap">'. do_shortcode( $section_three ) .'</div></div>';
    }

	$section_four = get_post_meta( get_the_ID(), 'parallax_section_four', true );
    if ( ! empty( $section_four ) ) {
        echo '<div class="home-even home-section-4 widget-area"><div class="wrap">'. do_shortcode( $section_four ) .'</div></div>';
    }

	$section_five = get_post_meta( get_the_ID(), 'parallax_section_five', true );
    if ( ! empty( $section_five ) ) {
        echo '<div class="home-odd home-section-5 widget-area"><div class="wrap">'. do_shortcode( $section_five ) .'</div></div>';
    }

}

function parallax_template_inline_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

  $acf_1   = wp_get_attachment_image_url( get_post_meta( get_the_ID(), 'parallax_image_one', true ), 'full' );
  $image_1 = $acf_1 ? $acf_1 : sprintf( '%s/images/bg-1.jpg', get_stylesheet_directory_uri() );
    
	$background_one = sprintf( 'background-image: url(%s);', $image_1 );

	$inline_one = sprintf( '.home-section-1 { %s }', $background_one );

	if ( $inline_one ) {
		wp_add_inline_style( $handle, $inline_one );
    }
    
    $acf_2   = wp_get_attachment_image_url( get_post_meta( get_the_ID(), 'parallax_image_two', true ), 'full' );
    $image_2 = $acf_2 ? $acf_2 : sprintf( '%s/images/bg-3.jpg', get_stylesheet_directory_uri() );

	$background_two = sprintf( 'background-image: url(%s);', $image_2 );

	$inline_two = sprintf( '.home-section-3 { %s }', $background_two );

	if ( $inline_two ) {
		wp_add_inline_style( $handle, $inline_two );
    }
    
    $acf_3   = wp_get_attachment_image_url( get_post_meta( get_the_ID(), 'parallax_image_three', true ), 'full' );
    $image_3 = $acf_3 ? $acf_3 : sprintf( '%s/images/bg-5.jpg', get_stylesheet_directory_uri() );

	$background_three = sprintf( 'background-image: url(%s);', $image_3 );

	$inline_three = sprintf( '.home-section-5 { %s }', $background_three );

	if ( $inline_three ) {
		wp_add_inline_style( $handle, $inline_three );
    }

}


genesis();
