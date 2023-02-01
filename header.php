<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GBC_Underscores
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://use.typekit.net/mfh4dtn.css">
	<?php wp_head(); ?>
</head>
<body <?php body_class((is_front_page() || is_home()) ? 'homepage' : null); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'gbc-underscores' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			echo '<a class="gbc-brand site-title" href="'.esc_url( home_url( '/' ) ).'" title="'.get_option('blogname').'" rel="home"><img src="'.gbc_theme_file('text@2x.png').'" alt="'.get_option('blogname').'"></a>';
			?>
			<?php
			$gbc_underscores_description = get_bloginfo( 'description', 'display' );
			if ( $gbc_underscores_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $gbc_underscores_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->
