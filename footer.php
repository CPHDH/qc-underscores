<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GBC_Underscores
 */

?>
	</div><!-- #primary-container -->
	<footer id="colophon" class="site-footer">
		<div class="site-info">
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'A project of the %1$s', 'gbc-underscores' ), '<a href="https://csudigitalhumanities.org">Center for Public History + Digital Humanities at Cleveland State University</a>' );
				?>
				<br>
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Powered by %s', 'gbc-underscores' ), '<a target="_blank" href="'.esc_url( __( 'https://wpplacepress.org/', 'gbc-underscores' ) ).'">WordPress + PlacePress</a>' );
				?>
				<br>&copy; <?php echo date('Y');?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
