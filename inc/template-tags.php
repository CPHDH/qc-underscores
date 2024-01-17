<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package QC_Underscores
 */

if ( ! function_exists( 'qc_underscores_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function qc_underscores_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'qc-underscores' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'qc_underscores_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function qc_underscores_posted_by() {
		$multiple_authors = get_post_custom_values('multiple_authors', 'ID' );
		$authname = $multiple_authors ? $multiple_authors[0] : get_the_author();
		$authhref = !$multiple_authors ? esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) : '/author/qc-team/';
		
		
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Posted by %s', 'post author', 'qc-underscores' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( $authhref ) . '">' . esc_html( $authname ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'qc_underscores_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function qc_underscores_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'qc-underscores' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'qc-underscores' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'qc-underscores' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'qc-underscores' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'qc-underscores' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'qc-underscores' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'qc_underscores_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function qc_underscores_post_thumbnail() {
		if ( post_password_required() || is_attachment()  ) {
			return;
		}

		if ( is_singular() && has_post_thumbnail() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php elseif(has_post_thumbnail()) : ?>
		
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>
			
		<?php else:?>
			<!-- location type archive -->
			<?php if(isset(get_queried_object()->slug)):?>
				<?php $svg_src = qc_sprite_src(qc_term_props(get_queried_object()->slug));?>
				<span class="qc-mask-container"><a class="post-thumbnail qc-mask-svg" style="mask-image: url(<?php echo $svg_src;?>)" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				</a></span>
			<!-- all locations archive -->
			<?php else:?>
				<?php 
				$post = get_post();
				$terms = get_the_terms($post, 'location_types');
				$term = is_array($terms) ? end($terms) : null; // last in array
				$slug = isset($term) && isset($term->slug) ? $term->slug : 'default';
				$svg_src = qc_sprite_src(qc_term_props($slug));
				?>
				<span class="qc-mask-container"><a class="post-thumbnail qc-mask-svg" style="mask-image: url(<?php echo $svg_src;?>)" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				</a></span>
			<?php endif;?>
		<?php endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
