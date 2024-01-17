<?php
/**
* Template Name: QC Homepage
*
* @package WordPress
* @subpackage QC_Underscores
* @since QC Underscores 1.0
*/

get_header();
?>

	<section id="hero" style="background-image:url(<?php echo get_the_post_thumbnail_url();?>);">
		<div id="hero-inner">
			<h2 class="special"><span>Queer Cleveland</span></h2>
			<h3>LGBT+ History in Northeast Ohio</h3>
			<a class="button" href="/introduction"><?php echo qc_sprite('info');?>Read the Introduction</a>
		</div>
	</section>
	
	<main id="primary" class="site-main homepage">
		<h2><?php echo qc_sprite('map');?>Locations Map</h2>
		<?php // user content (global map)
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'page' );
			endwhile;
		endif;
		?>
	</main><!-- #main -->
	
	<section id="homepage-location-blocks">
		<?php echo qc_term_blocks();?>
	</section>
	
	<section id="homepage-tags">
		<div id="homepage-tags-inner">
		<h2><?php echo qc_sprite('tags');?>Tags</h2>
		<?php echo wp_tag_cloud(array(
			'post_type'=>'locations',
			'smallest'=>14,
			'largest'=>28,
			'separator'=>'  ',
			'show_count'=>0,
			'orderby'=> 'name',
			'order'=> 'ASC',
		));?>
		</div>
	</section>
	
	<section id="homepage-location-types">
		<?php echo qc_posts_recent(12);?>
	</section>
	
	<section id="homepage-contact-form">
		<h2><?php echo qc_sprite('megaphone');?>Participate</h2>
		<div id="homepage-contact-inner">
			<div id="cta-contact">
				<h3>Share your story</h3>
				<p>The <a href="https://csudigitalhumanities.org/">Center for Public History + Digital Humanities</a> at Cleveland State University is collecting oral histories, gathering newspaper accounts, and scanning old photos to share on this website. If you have a story to tell, we want to hear from you!</p><p>Use the contact form or send us an email at:<br><a href="mailto:info@queerclevelandhistories.org?subject=Queer%20Cleveland">info@queerclevelandhistories.org</a></p>
			</div>
			<?php echo do_shortcode('[contact-form-7 id="f602e16" title="Contact form 1"]');?>
		</div>
	</section>

<?php
//get_sidebar();
get_footer();
