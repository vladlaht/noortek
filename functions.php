<?php

include 'themeClass/RoomBooking.php';
include 'translations/NnkTranslations.php';

$theme = new NoortekWPTheme();

class NoortekWPTheme {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'after_setup_theme', [ $this, 'add_support' ] );
		add_theme_support( "post-thumbnails" );
		$this->enableFeatures();
		NnkTranslations::register_strings();
	}

	function add_support() {
		add_theme_support( 'post-formats', [
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		] );
	}

	function register_styles() {
		wp_enqueue_style( 'bootstrap', get_theme_file_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap-grid', get_theme_file_uri() . '/css/bootstrap-grid.min.css' );
		wp_enqueue_style( 'datepicker', get_theme_file_uri() . '/css/datepicker.min.css' );
		wp_enqueue_style( 'bootstrap-timepicker', get_theme_file_uri() . '/css/bootstrap-timepicker.min.css' );
		wp_enqueue_style( 'bootstrap-reboot', get_theme_file_uri() . '/css/bootstrap-reboot.min.css' );
		wp_enqueue_style( 'smart_wizard', get_theme_file_uri() . '/css/smart_wizard.min.css' );
		wp_enqueue_style( 'smart_wizard_theme_arrows', get_theme_file_uri() . '/css/smart_wizard_theme_arrows.min.css' );
		wp_enqueue_style( 'font-awesome', get_theme_file_uri() . '/css/fontawesome/css/all.min.css' );
		wp_enqueue_style( 'fullcalendar', get_theme_file_uri() . '/css/fullcalendar.min.css' );
		wp_enqueue_style( 'fullcalendarscheduler', get_theme_file_uri() . '/css/scheduler.min.css' );
		wp_enqueue_style( 'style', get_theme_file_uri() . './style.css' );
	}

	function register_scripts() {
		wp_enqueue_script( 'jQuery', get_theme_file_uri() . '/js/import/jquery-3.3.1.min.js', false, 1, true );
		wp_enqueue_script( 'bootstrap.bundle', get_theme_file_uri() . '/js/import/bootstrap.bundle.min.js', false, 1, true );
		wp_enqueue_script( 'bootstrap', get_theme_file_uri() . '/js/import/bootstrap.min.js', false, 1, true );
		wp_enqueue_script( 'datepicker', get_theme_file_uri() . '/js/import/datepicker.min.js', false, 1, true );
		wp_enqueue_script( 'datepicker-en', get_theme_file_uri() . '/js/import/datepicker.languages.js', false, 1, true );
		wp_enqueue_script( 'bootstrap-timepicker', get_theme_file_uri() . '/js/import/bootstrap-timepicker.min.js', false, 1, true );
		wp_enqueue_script( 'smart_wizard', get_theme_file_uri() . '/js/import/jquery.smartWizard.min.js', false, 1, true );
		wp_enqueue_script( 'masonry', get_theme_file_uri() . '/js/import/masonry.pkgd.min.js', false, 1, true );
		wp_enqueue_script( 'jquery.validate', get_theme_file_uri() . '/js/import/jquery.validate.min.js', false, 1, true );
		wp_enqueue_script( 'moment', get_theme_file_uri() . '/js/import/moment-with-locale.js', false, 1, true );
		wp_enqueue_script( 'fullcalendar', get_theme_file_uri() . '/js/import/fullcalendar.min.js', false, 1, true );
		wp_enqueue_script( 'fullcalendarscheduler', get_theme_file_uri() . '/js/import/scheduler.min.js', false, 1, true );
		wp_enqueue_script( 'mask', get_theme_file_uri() . '/js/import/jquery.mask.min.js', false, 1, true );

		if ( true ) {
			wp_enqueue_script( 'index-page', get_theme_file_uri() . './js/index.js', false, 1, true );
		}
	}

	function enableFeatures() {
		new RoomBooking();
	}

	public static function register_custom_post_type( $slug, $singular, $plural ) {
		$theme = 'noortek-theme';

		$labels = array(
			'name'               => _x( $plural, 'Post Type General Name', $theme ),
			'singular_name'      => _x( $singular, 'Post Type Singular Name', $theme ),
			'menu_name'          => __( $plural, $theme ),
			'all_items'          => __( 'Kõik ' . $plural, $theme ),
			'view_item'          => __( 'Kuva ' . $singular, $theme ),
			'add_new_item'       => __( 'Lisa uus ' . $singular, $theme ),
			'add_new'            => __( 'Lisa uus', $theme ),
			'edit_item'          => __( 'Muuda ' . $singular, $theme ),
			'update_item'        => __( 'Uuenda ' . $singular, $theme ),
			'search_items'       => __( 'Otsi ' . $singular, $theme ),
			'not_found'          => __( 'Not Found', $theme ),
			'not_found_in_trash' => __( 'Not found in Trash', $theme ),
		);

		$args = array(
			'label'               => __( $plural, $theme ),
			'description'         => __( $singular . 'ute loetelu', $theme ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'custom-fields' ),
			'taxonomies'          => array( 'genres' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		);
		register_post_type( $slug, $args );
	}
}

