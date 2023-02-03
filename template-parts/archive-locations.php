<?php
/**
 * Template part for displaying locations archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GBC_Underscores
 */

?>
<article class="post-location-item" style="--article-img:url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'medium');?>);">
	<header class="entry-header">
		<div class="entry-header-inner">
			<h3 class="entry-title-home"><a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark"><?php echo get_the_title();?></a></h3>
		</div>
	</header>
</article>