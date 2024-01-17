<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package QC_Underscores
 */

?>
<!-- <div id="article-actions">
	<span>
		<a class="twitter" aria-label="Share article on Twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo qc_sprite('twitter');?></a>
		<a class="facebook" aria-label="Share article on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo qc_sprite('facebook');?></a>
		<a class="email" aria-label="Share article via email" href="mailto:?subject=<?php the_title();?>&body=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo qc_sprite('email');?></a>
		<a class="print" aria-label="Print this page" href="javascript:void" rel="noopener" onclick="window.print();"><?php echo qc_sprite('print');?></a>
	</span>
</div> -->

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header id="hero" style="background-image:url(<?php echo get_the_post_thumbnail_url();?>);">
	<div id="hero-inner">
		<h2 class="special"><span><?php echo trim(str_replace(array('/'), array('<wbr>/'), get_the_title()));?></span></h2>
		<p>
			<?php qc_underscores_posted_by();?><?php echo qc_get_post_term(get_the_ID(),true) ? ' in '.qc_get_post_term(get_the_ID()) : null;?>
		</p>
	</div>
</header>
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'qc-underscores' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'qc-underscores' ),
				'after'  => '</div>',
			)
		);
		?>
		<?php 
		// Tags
		$tags = wp_get_post_tags(get_the_ID());
		if(count($tags)){
			foreach ( $tags as $key => $tag ) {
				$link = get_term_link( intval($tag->term_id), $tag->taxonomy );
				if ( is_wp_error( $link ) ) return false;
				$tags[$key]->link = $link;
				$tags[$key]->id = $tag->term_id;
			}
			$html = '<section class="post_tags" aria-label="Tags">';
			$html .= '<hr>';
			$html .= wp_generate_tag_cloud($tags,array(
					'post_type'=>'locations',
					'smallest'=>14,
					'largest'=>28,
					'separator'=>'  ',
					'show_count'=>0,
					'orderby'=> 'name',
					'order'=> 'ASC',
				));
			$html .= '</section>';
			echo $html;
		}
		// Location Types
		echo qc_term_blocks(get_the_ID(),'type-blocks-container-single');
		?>
	</div><!-- .entry-content -->

	<!-- <footer class="entry-footer">
		<?php qc_underscores_entry_footer(); ?>
	</footer>-->
</article><!-- #post-<?php the_ID(); ?> -->
