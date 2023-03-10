<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GBC_Underscores
 */

?>
<div id="article-actions">
	<span>
		<a class="twitter" aria-label="Share article on Twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo gbc_sprite('twitter');?></a>
		<a class="facebook" aria-label="Share article on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo gbc_sprite('facebook');?></a>
		<a class="email" aria-label="Share article via email" href="mailto:?subject=<?php the_title();?>&body=<?php echo esc_url( get_permalink() );?>" rel="noopener"><?php echo gbc_sprite('email');?></a>
		<a class="print" aria-label="Print this page" href="javascript:void" rel="noopener" onclick="window.print();"><?php echo gbc_sprite('print');?></a>
	</span>
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $img = get_the_post_thumbnail_url(get_the_ID(),'medium') ? get_the_post_thumbnail_url(get_the_ID(),'medium') : gbc_theme_file('icon@2x.png');?>
	<header class="entry-header" style="--article-img:url(<?php echo $img;?>);">

		<div class="entry-header-inner">
		<?php
		echo gbc_get_post_term(get_the_ID());
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

			?>
		<div class="entry-meta">
			<?php
			gbc_underscores_posted_by();
			?>
		</div><!-- .entry-meta -->
		</div><!-- .entry-header-inner -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'gbc-underscores' ),
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
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gbc-underscores' ),
				'after'  => '</div>',
			)
		);
		?>
		<?php 
		$tags = wp_get_post_tags(get_the_ID());
		if(count($tags)){
			$html = '<section class="post_tags" aria-label="Source Tags">';
			$html .= '<hr>';
			foreach($tags as $tag){
				$tag_link = get_tag_link( $tag->term_id );
				$html .= "<a href='{$tag_link}' title='Source Tag: {$tag->name}' class='{$tag->slug} tag-cloud-link'>";
				$html .= "{$tag->name}</a> ";
			}
			$html .= '</section>';
			echo $html;
		}
		?>
	</div><!-- .entry-content -->

	<!-- <footer class="entry-footer">
		<?php gbc_underscores_entry_footer(); ?>
	</footer>-->
</article><!-- #post-<?php the_ID(); ?> -->
