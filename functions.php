<?php
/**
 * Kanso functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kanso
 * @since Kanso 1.0
 */

if ( ! function_exists( 'kanso_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Kanso 1.0
	 *
	 * @return void
	 */
	function kanso_setup() {

		// Remove theme support for the core and featured patterns coming from the WordPress.org pattern directory (for now).
		remove_theme_support( 'core-block-patterns' );
	}

endif;

add_action( 'after_setup_theme', 'kanso_setup' );

if ( ! function_exists( 'kanso_styles' ) ) :
	/**
	 * Enqueue main stylesheet.
	 *
	 * @since Kanso 1.0
	 *
	 * @return void
	 */
	function kanso_styles() {

		$theme_version  = wp_get_theme()->get( 'Version' );
		$version_string = is_string( $theme_version ) ? $theme_version : false;

		// Register theme stylesheet.
		wp_register_style(
			'kanso-style',
			get_stylesheet_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'kanso-style' );
	}

endif;

add_action( 'wp_enqueue_scripts', 'kanso_styles' );

if ( ! function_exists( 'kanso_editor_styles' ) ) :
	/**
	 * Enqueue style.css into the editor.
	 *
	 * @since Kanso 1.0
	 *
	 * @return void
	 */
	function kanso_editor_styles() {

		// Enqueue theme stylesheet there are custom styles.
		add_editor_style( 'style.css' );
	}

endif;

add_action( 'admin_init', 'kanso_editor_styles' );

if ( ! function_exists( 'kanso_register_pattern_categories' ) ) :

	/**
	 * Register pattern categories.
	 *
	 * @since Kanso 1.0
	 *
	 * @return void
	 */
	function kanso_register_pattern_categories() {
		register_block_pattern_category(
			'newsletter',
			array( 'label' => __( 'Newsletter', 'kanso' ) )
		);
		register_block_pattern_category(
			'blog',
			array( 'label' => __( 'Blog', 'kanso' ) )
		);
	}

endif;

add_action( 'init', 'kanso_register_pattern_categories' );

/**
 * Enqueue button block styles when read-more block is present
 */
function kanso_enqueue_read_more_button_styles() {
	if ( is_admin() || ! is_singular() ) {
		return;
	}

	global $post;
	
	// Check if post content contains read-more block
	if ( has_block( 'core/read-more', $post ) ) {
		// Enqueue the button block styles
		wp_enqueue_style( 'wp-block-button' );
	}
}
add_action( 'wp_enqueue_scripts', 'kanso_enqueue_read_more_button_styles' );

/**
 * Register read-more button style variation
 */
function kanso_register_read_more_button_style() {
	register_block_style(
		'core/read-more',
		array(
			'name'  => 'button',
			'label' => __( 'Button', 'kanso' ),
		)
	);
	register_block_style(
		'core/read-more',
		array(
			'name'  => 'button-outline',
			'label' => __( 'Button Outline', 'kanso' ),
		)
	);
}
add_action( 'init', 'kanso_register_read_more_button_style' );