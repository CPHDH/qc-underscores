<?php
/**
 * GBC Underscores functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GBC_Underscores
 */

if ( ! defined( '_GBC_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_GBC_VERSION', '1.0.0' );
}

// simple helper for getting theme files 
function gbc_theme_file($filename, $dir='images'){
	return get_template_directory_uri().'/'.$dir.'/'.$filename;
}

// icon helper for sprite sheet
function gbc_sprite($icon){
	return '<svg class="sprite" viewBox="0 0 55 46.9"><use xlink:href="'.get_template_directory_uri().'/images/sprites.svg#'.$icon.'" /></svg>';
}

function gbc_term_props($term, $prop='icon'){
	if(!$term){
		exit;
	}
	$slugs = array(
		'amusement-parks'=>array(
			'icon'=>'rollercoaster'
		),
		'barber-shops-and-beauty-parlors'=>array(
			'icon'=>'chair'
		),
		'beaches-and-docks'=>array(
			'icon'=>'beach'
		),
		'bowling-alleys-and-skating-rinks'=>array(
			'icon'=>'bowling'
		),
		'country-clubs-and-golf-courses'=>array(
			'icon'=>'golf'
		),
		'farms-and-country-homes'=>array(
			'icon'=>'farm'
		),
		'garages-and-service-stations'=>array(
			'icon'=>'gas-pump'
		),
		'hotels-and-tourist-homes'=>array(
			'icon'=>'service-bell'
		),
		'lagoons-lakes-ponds-and-swimming-holes'=>array(
			'icon'=>'buoy'
		),
		'miscellaneous-services'=>array(
			'icon'=>'book'
		),
		'music-clubs-and-night-clubs'=>array(
			'icon'=>'saxophone'
		),
		'picnic-groves'=>array(
			'icon'=>'picnic-table'
		),
		'ranches-and-riding-clubs'=>array(
			'icon'=>'cowboy-hat'
		),
		'regional-parks'=>array(
			'icon'=>'park'
		),
		'resorts'=>array(
			'icon'=>'hotel'
		),
		'restaurants-and-taverns'=>array(
			'icon'=>'utensils'
		),
		'summer-camps'=>array(
			'icon'=>'campground'
		),
		'swimming-pools'=>array(
			'icon'=>'swimming'
		),
		'theaters'=>array(
			'icon'=>'theater'
		),
		'_default'=>array(
			'icon'=>'book'
		),
	);
	if(!array_key_exists($term, $slugs)){
		$term = '_default';
	}
	return $slugs[$term][$prop];
}

// main list of location types with svg sprite icons
function gbc_terms_list($html=null){
	$terms = get_terms(array(
		'taxonomy' => 'location_types',
		'hide_empty'=>true,
	));
	$html .= '<ul id="terms-menu" class="gbc-side-menu">';
	foreach($terms as $term){
		if($term->slug == 'all-green-book-locations'){
			continue;
		}
		$html .= '<li class="'.$term->slug.'" id="term_'.$term->term_id.'">';
			$html .= '<a href="/location-type/'.$term->slug.'">';
				$html .= gbc_sprite(gbc_term_props($term->slug)).$term->name;
			$html .= '</a>';
		$html .= '</li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gbc_underscores_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on GBC Underscores, use a find and replace
		* to change 'gbc-underscores' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'gbc-underscores', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'gbc-underscores' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'gbc_underscores_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'gbc_underscores_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gbc_underscores_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gbc_underscores_content_width', 640 );
}
add_action( 'after_setup_theme', 'gbc_underscores_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gbc_underscores_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'gbc-underscores' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'gbc-underscores' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'gbc_underscores_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gbc_underscores_scripts() {
	wp_enqueue_style( 'gbc-underscores-style', get_stylesheet_uri(), array(), _GBC_VERSION );
	wp_style_add_data( 'gbc-underscores-style', 'rtl', 'replace' );

	wp_enqueue_script( 'gbc-underscores-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _GBC_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gbc_underscores_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

