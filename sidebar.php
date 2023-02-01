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
	<?php //dynamic_sidebar( 'sidebar-1' ); ?>
    <?php 
    wp_nav_menu(
        array(
            'theme_location' => 'menu-1',
            'menu_id' => 'nav-menu',
            'menu_class' => 'gbc-side-menu',
            'container'=>null,
        )
    );
    echo '<a class="gbc-brand site-icon" href="'.esc_url( home_url( '/' ) ).'" title="'.get_option('blogname').'" rel="home"><img src="'.gbc_theme_file('logo-vertical-text-alt@2x.png').'" alt="'.get_option('blogname').'"></a>';
    
    echo get_search_form(false);
    
    echo gbc_terms_list();
    
    echo gbc_term_props('amusement-parks');
    ?>
</aside><!-- #secondary -->
