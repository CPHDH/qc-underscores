<?php
/**
* Template Name: GBC Homepage
*
* @package WordPress
* @subpackage GBC_Underscores
* @since GBC Underscores 1.0
*/

get_header();
?>

	<section id="homepage-hero" style="background-image:url(<?php echo get_the_post_thumbnail_url();?>);">
		<div id="homepage-hero-cta">
			<?php echo '<img alt="Green Book Cleveland" src="'.gbc_theme_file('banner.png').'" alt="'.get_option('blogname').'">';?>
			<!-- <h2>Green Book Cleveland</h2> -->
			<h3>Black Entertainment, Leisure, and Recreation in Northeast Ohio</h3>
			<a class="button" href="/introduction"><?php echo gbc_sprite('info');?>Read the Introduction</a>
		</div>
	</section>
	
	<main id="primary" class="site-main homepage">
		<h2><?php echo gbc_sprite('map');?>Locations Map</h2>
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
		<?php echo gbc_term_blocks();?>
	</section>
	
	<section id="homepage-tags">
		<div id="homepage-tags-inner">
		<h2><?php echo gbc_sprite('tags');?>Source Tags</h2>
		<?php echo wp_tag_cloud(array(
			'post_type'=>'locations',
			'smallest'=>14,
			'largest'=>14,
			'show_count'=>1
		));?>
		</div>
	</section>
	
	<section id="homepage-location-types">
		<?php echo gbc_posts_recent();?>
	</section>
	
	<section id="homepage-contact-form">
		<h2><?php echo gbc_sprite('megaphone');?>Participate</h2>
		<div id="homepage-contact-inner">
			<div id="cta-contact">
				<h3>Share your story</h3>
				<p>In partnership with the <a href="https://csudigitalhumanities.org/">Center for Public History + Digital Humanities</a> at Cleveland State University and the <a href="https://www.nps.gov/cuva/index.htm">Cuyahoga Valley National Park</a>, the Green Book Cleveland Collaborative is collecting oral histories, gathering newspaper accounts, and scanning old photos to share on this website. If you have a story to tell, we want to hear from you!</p><p>Use the contact form or send us an email at:<br><a href="mailto:info@greenbookcleveland.org?subject=Green%20Book%20Cleveland">info@greenbookcleveland.org</a></p>
			</div>
			<?php echo do_shortcode('[contact-form-7 id="3369" title="Contact form 1"]');?>
		</div>
	</section>

<?php
//get_sidebar();
get_footer();
