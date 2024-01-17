<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package QC_Underscores
 */

get_header();
?>
	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div id="qc-archive-items">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
						<?php get_template_part( 'template-parts/archive', get_post_type() );?>
				<?php endwhile;?>
			</div>
			<?php the_posts_navigation(array('prev_text'=>'Next','next_text'=>'Previous'));?>

		<?php else :
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
