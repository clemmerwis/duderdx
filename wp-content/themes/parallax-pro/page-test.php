<?php
/**
* Template Name: Test Template
* Description: Template for a test page
* Template Post Type: page
*/


//* Add custom body class
add_filter( 'body_class', 'add_test_body_class' );
function add_test_body_class( $classes ) {
  $classes[] = 'test';
	return $classes;
}

//* Define a layout here it is full-width (no-sidebar)
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );


// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );



//* Display test widget area after registering it in functions file
add_action( 'genesis_loop', 'test_widget' );
function test_widget() {
  genesis_widget_area(
      'test', array(
        'before' => '<div class="one-half first test widget-area"><div class="wrap">',
        'after'  => '</div></div><div class="clearfix"></div>',
      ) 
  );
}

// Search for markup_open, copy to template or functions file, then slightly alter function name
// if ( is_page(15) ) {

//   remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
//   add_action( 'genesis_entry_footer', 'cjl_genesis_entry_footer_markup_open', 5 );
//   function cjl_genesis_entry_footer_markup_open() {
//     if ( post_type_supports( get_post_type(), 'genesis-entry-meta-after-content' ) ) {
//       printf( '<div %s>', genesis_attr( 'entry-footer' ) );
//     }
//   }
  
//   remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
//   add_action( 'genesis_entry_footer', 'cjl_genesis_entry_footer_markup_close', 15 );
//   function cjl_genesis_entry_footer_markup_close() {
// 	  if ( post_type_supports( get_post_type(), 'genesis-entry-meta-after-content' ) ) {
// 		  echo '</div>';
// 	  }
//   }

// }

// Limit entry content (post content)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'test_genesis_do_post_content' );
function test_genesis_do_post_content() {
  printf( '<div %s>', genesis_attr( 'entry-content' ) );
  printf ( the_content_limit(300, "Read more") );
  echo '</div>'; //** end .entry-content
}

// Replace page content with blog loop using genesis custom loop
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'cjl_custom_loop');
function cjl_custom_loop() {
  global $paged;
 
  $args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
	);

  genesis_custom_loop( $args );
}
// Remove pagination
// remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );


// Replace page content with blog loop using wordpress loop
// remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_before_loop', 'be_test_custom_loop' );
function be_test_custom_loop() {
  global $post;
 
	// arguments, adjust as needed
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 2,
		'post_status'    => 'publish',
		'paged'          => get_query_var( 'paged' ),
	);
 
	global $wp_query;
	$wp_query = new WP_Query( $args );
 
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		do_action( 'genesis_before_entry' );
	
		printf( '<article %s>', genesis_attr( 'entry' ) );
	
			do_action( 'genesis_entry_header' );
		
			do_action( 'genesis_before_entry_content' );
			printf( '<div %s>', genesis_attr( 'entry-content' ) );
			printf ( the_content_limit(100, "Read more") );
			echo '</div>'; //** end .entry-content
			do_action( 'genesis_after_entry_content' );
			
			do_action( 'genesis_entry_footer' );
	
		echo '</article>';
	
		do_action( 'genesis_after_entry' );
		$loop_counter++;
	endwhile; /** end of one post **/
    // this is pagination 
    // do_action( 'genesis_after_endwhile' );
	else : /** if no posts exist **/
		do_action( 'genesis_loop_else' );
	endif; /** end loop **/
 
	wp_reset_query();
}


genesis();

