<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Stationfive
 * @since Stationfive 1.0
 */

if ( ! function_exists( 'stationfive_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Stationfive 1.0
	 *
	 * @return void
	 */
	function stationfive_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Stationfive, use a find and replace
		 * to change 'stationfive' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'stationfive', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', 'stationfive' ),
				'footer'  => __( 'Footer menu', 'stationfive' ),
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', 'stationfive' ),
					'shortName' => esc_html_x( 'XS', 'Font size', 'stationfive' ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', 'stationfive' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'stationfive' ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'stationfive' ),
					'shortName' => esc_html_x( 'M', 'Font size', 'stationfive' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'stationfive' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'stationfive' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'stationfive' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'stationfive' ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'stationfive' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'stationfive' ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'stationfive' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'stationfive' ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

	}
}
add_action( 'after_setup_theme', 'stationfive_setup' );

/**
 * Enqueue scripts and styles.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
function stationfive_scripts() {
	// Register main style.
	wp_enqueue_style( 'stationfive-style', get_template_directory_uri() . '/assets/public/css/main.bundle.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600&family=Montserrat:wght@300;400;500;600;700;800&display=swap', false );

	wp_enqueue_script( 'jquery' );

	// Register the vendor script.
	wp_register_script(
		'stationfive-vendor',
		get_template_directory_uri() . '/assets/public/js/vendor.bundle.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Register the vendor script.
	wp_register_script(
		'stationfive-script',
		get_template_directory_uri() . '/assets/public/js/main.bundle.js',
		array( 'jquery', 'stationfive-vendor' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script( 'stationfive-script' );
	wp_enqueue_script( 'stationfive-vendor' );
}
add_action( 'wp_enqueue_scripts', 'stationfive_scripts' );

/**
 * Hide admin bar.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
function hide_admin_bar() { 
	return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar' );

/**
 * Remove block editor.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_deregister_script( 'wp-embed' );
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/**
 * Remove emoji.
 *
 * @since Stationfive 1.0
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_filter('use_block_editor_for_post', '__return_false', 10);

function hide_editor() {
    remove_post_type_support( 'page', 'editor' );
    remove_post_type_support( 'donations', 'editor' );
}
add_action( 'admin_init', 'hide_editor' );

/**
 * Add SVG support.
 *
 * @since Stationfive 1.0
 *
 * @param mixed $mimes list of allowed upload types.
 * @return mixed $mimes
 */
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Add custom settings.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
add_action(
	'init',
	function() {
		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page(
				array(
					'page_title' => 'Theme Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
					'position'   => '2',
					'icon_url'   => 'dashicons-admin-appearance',
				)
			);
		}
	}
);

/**
 * Register the new post type: donations.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
function create_posttype() {
 
    register_post_type(
		'donations',
    	// CPT Options
        array(
            'labels'       => array(
                'name' => __( 'Donations' ),
                'singular_name' => __( 'Donation' )
            ),
            'public'       => true,
            'has_archive'  => false,
            'rewrite'      => array('slug' => 'donations'),
            'show_in_rest' => true,
			'menu_icon'    => 'dashicons-heart',
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/**
 * Save custom form.
 *
 * @since Stationfive 1.0
 *
 * @return void
 */
function my_save_custom_form() {
    global $wpdb;

    $first_name    = $_POST['first_name'];
    $last_name     = $_POST['last_name'];
    $email_address = $_POST['email_address'];
    $phone_number  = $_POST['phone_number'];
    $method        = $_POST['donation_method'];
	$amount        = $_POST['donation_amount'];
	$nonce         = $_POST['nonce'];

	// Verfiy nonce.
	if ( wp_verify_nonce( $nonce, 'donation-form' ) ) {
		
		// Gather post data.
		$post_args = array(
			'post_title'  => $first_name . ' ' . $last_name . ' - ' . $amount,
			'post_status' => 'publish',
			'post_type'   => 'donations',
			'post_author' => 1,
		);

		// Insert the post into the database.
		$post_id = wp_insert_post( $post_args );

		if ( $post_id ) {
			update_field( 'first_name', $first_name, $post_id );
			update_field( 'last_name', $last_name, $post_id );
			update_field( 'email_address', $email_address, $post_id );
			update_field( 'phone', $phone_number, $post_id );
			update_field( 'amount', $amount, $post_id );
			update_field( 'method', $method, $post_id );

			wp_safe_redirect( home_url( '/?success=1' ) ); // <-- here goes address of site that user should be redirected after submitting that form
			exit;
		}
	}

	wp_safe_redirect( home_url( '/?error=1' ) ); // <-- here goes address of site that user should be redirected after submitting that form
    exit;
}
add_action( 'admin_post_nopriv_save_my_custom_form', 'my_save_custom_form' );
add_action( 'admin_post_save_my_custom_form', 'my_save_custom_form' );
