<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GBC_Underscores
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="site-guide">
    <div id="site-guide-container">
        <span>
            <?php echo '<a class="gbc-brand site-icon" href="'.esc_url( home_url( '/' ) ).'" title="'.get_option('blogname').'" rel="home"><img src="'.gbc_theme_file('logo-horizontal-text@2x.png').'" aria-label="Green Book Cleveland logo" role="presentation" alt="'.get_option('blogname').'"></a>';?>
            <?php echo get_search_form(false);?>
        </span>
        <?php echo gbc_terms_list();?>
    </div>
</aside><!-- #secondary -->
