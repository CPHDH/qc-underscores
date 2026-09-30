<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package QC_Underscores
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function qc_underscores_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'qc-archive-items',
			'render'    => 'qc_underscores_infinite_scroll_render',
			'footer'    => false,
			'wrapper'	=> false,
		)
	);

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support(
		'jetpack-content-options',
		array(
			'post-details' => array(
				'stylesheet' => 'qc-underscores-style',
				'date'       => '.posted-on',
				'categories' => '.cat-links',
				'tags'       => '.tags-links',
				'author'     => '.byline',
				'comment'    => '.comments-link',
			),
			'featured-images' => array(
				'archive' => true,
				'post'    => true,
				'page'    => true,
			),
		)
	);
}
add_action( 'after_setup_theme', 'qc_underscores_jetpack_setup' );

if ( ! function_exists( 'qc_underscores_infinite_scroll_render' ) ) :
	/**
	 * Custom render function for Infinite Scroll.
	 */
	function qc_underscores_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/archive', get_post_type() );
			endif;
		}
	}
endif;

/**
 * Only enable Infinite Scroll on archive and search views, the templates that output the #qc-archive-items container.
 *
 * @param bool $supported Whether Infinite Scroll is supported for the current request.
 * @return bool
 */
function qc_underscores_infinite_scroll_supported( $supported ) {
	return $supported && ( is_archive() || is_search() );
}
add_filter( 'infinite_scroll_archive_supported', 'qc_underscores_infinite_scroll_supported' );

/**
 * Keep the static front page out of Infinite Scroll queries.
 *
 * Jetpack posts to home_url( '/?infinity=scrolling' ) and builds the query from that request's main query, then layers on the (non-empty) query_args sent by the browser. Because the front page is a static page, the base query carries page_id/pagename for it, and the archive's empty page_id can't override it, so every request asks for "posts of type X that are also the front page" and comes back empty.
 *
 * @param array $query_args Query args Jetpack is about to run.
 * @return array
 */
function qc_underscores_infinite_scroll_query_args( $query_args ) {
	$requested = isset( $_REQUEST['query_args'] ) && is_array( $_REQUEST['query_args'] ) ? wp_unslash( $_REQUEST['query_args'] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- read-only, only used to check for presence.
	foreach ( array( 'page_id', 'pagename' ) as $var ) {
		if ( empty( $requested[ $var ] ) ) {
			unset( $query_args[ $var ] );
		}
	}
	return $query_args;
}
add_filter( 'infinite_scroll_query_args', 'qc_underscores_infinite_scroll_query_args', 20 );

/**
 * Re-render the batch if Jetpack's own capture came back empty.
 *
 * Jetpack calls wp_head() before and inside the output buffer it uses to capture the render callback. If anything hooked to wp_head opens an output buffer and leaves it open (WP-Optimize's WPO_Page_Optimizer did on Green Book Cleveland), Jetpack's ob_get_clean() reads that buffer instead of the rendered posts, and the response is {"type":"empty"} even though the query found posts. Rendering here, in a buffer we open and close ourselves with no wp_head() in between, sidesteps that.
 *
 * @param array    $results    Response data.
 * @param array    $query_args Query args that were run.
 * @param WP_Query $wp_query   The Infinite Scroll query.
 * @return array
 */
function qc_underscores_infinite_scroll_rerender( $results, $query_args, $wp_query ) {
	if ( ! empty( $results['html'] ) || empty( $wp_query->posts ) ) {
		return $results;
	}

	$wp_query->rewind_posts();
	ob_start();
	qc_underscores_infinite_scroll_render();
	$html = ob_get_clean();

	if ( '' === trim( (string) $html ) ) {
		return $results;
	}

	global $currentday;
	$results['type']       = 'success';
	$results['html']       = $html;
	$results['lastbatch']  = The_Neverending_Home_Page::is_last_batch();
	$results['currentday'] = $currentday;

	return $results;
}
add_filter( 'infinite_scroll_results', 'qc_underscores_infinite_scroll_rerender', 5, 3 );
