<?php
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

$theme = new NoortekWPTheme();

class NoortekWPTheme
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_styles']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
        add_action('init', [$this, 'register_menu_spaces']);
        add_action('init', [$this, 'register_custom_post_types']);
        add_action('after_setup_theme', [$this, 'add_support']);
        add_theme_support("post-thumbnails");
        $this->register_short_codes();
        add_action('admin_post_nopriv_custom_action_hook', [$this, 'the_action_hook_callback']);
        add_action('admin_post_custom_action_hook', [$this, 'the_action_hook_callback']);
        add_action('admin_ajax_custom_action_hook', [$this, 'the_action_hook_callback']);
        add_action('admin_ajax_nopriv_custom_action_hook', [$this, 'the_action_hook_callback']);
    }

    function add_support()
    {
        add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat']);
    }

    function register_styles()
    {
        wp_enqueue_style('bootstrap', get_theme_file_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-grid', get_theme_file_uri() . '/css/bootstrap-grid.min.css');
        wp_enqueue_style('datepicker', get_theme_file_uri() . '/css/datepicker.min.css');
        wp_enqueue_style('bootstrap-timepicker', get_theme_file_uri() . '/css/bootstrap-timepicker.min.css');
        wp_enqueue_style('bootstrap-reboot', get_theme_file_uri() . '/css/bootstrap-reboot.min.css');
        wp_enqueue_style('smart_wizard', get_theme_file_uri() . '/css/smart_wizard.min.css');
        wp_enqueue_style('smart_wizard_theme_arrows', get_theme_file_uri() . '/css/smart_wizard_theme_arrows.min.css');
        wp_enqueue_style('font-awesome', get_theme_file_uri() . '/css/fontawesome/css/all.min.css');
        wp_enqueue_style('style', get_theme_file_uri() . '/style.css');

    }

    function register_scripts()
    {
        wp_enqueue_script('jQuery', get_theme_file_uri() . '/js/jquery-3.3.1.min.js', false, 1, true);
        wp_enqueue_script('bootstrap.bundle', get_theme_file_uri() . '/js/bootstrap.bundle.min.js', false, 1, true);
        wp_enqueue_script('bootstrap', get_theme_file_uri() . '/js/bootstrap.min.js', false, 1, true);
        wp_enqueue_script('datepicker', get_theme_file_uri() . '/js/datepicker.min.js', false, 1, true);
        wp_enqueue_script('bootstrap-timepicker', get_theme_file_uri() . '/js/bootstrap-timepicker.min.js', false, 1, true);
        wp_enqueue_script('smart_wizard', get_theme_file_uri() . '/js/jquery.smartWizard.min.js', false, 1, true);
        wp_enqueue_script('masonry', get_theme_file_uri() . '/js/masonry.pkgd.min.js', false, 1, true);
        wp_enqueue_script('jquery.validate', get_theme_file_uri() . '/js/jquery.validate.min.js', false, 1, true);

        if (true) {
            wp_enqueue_script('index-page', get_theme_file_uri() . '/js/pages/index.js', false, 1, true);
        }
    }

    function register_custom_post_types()
    {
        $this->register_custom_post_type('booking', 'Broneering', 'Broneeringud');
        $this->register_custom_post_type('booking-room', 'Ruum', 'Ruumid');
        $this->register_custom_post_type('booking-equipment', 'Vahend', 'Vahendid');
    }

    function register_menu_spaces()
    {
        register_nav_menus(
            array(
                'main-menu' => __('Main Menu'),
                'footer-menu' => __('Footer Menu')
            )
        );
    }

    function register_custom_post_type($slug, $singular, $plural)
    {
        $theme = 'noortek-theme';

        $labels = array(
            'name' => _x($plural, 'Post Type General Name', $theme),
            'singular_name' => _x($singular, 'Post Type Singular Name', $theme),
            'menu_name' => __($plural, $theme),
            'all_items' => __('Kõik ' . $plural, $theme),
            'view_item' => __('Kuva ' . $singular, $theme),
            'add_new_item' => __('Lisa uus ' . $singular, $theme),
            'add_new' => __('Lisa uus', $theme),
            'edit_item' => __('Muuda ' . $singular, $theme),
            'update_item' => __('Uuenda ' . $singular, $theme),
            'search_items' => __('Otsi ' . $singular, $theme),
            'not_found' => __('Not Found', $theme),
            'not_found_in_trash' => __('Not found in Trash', $theme),
        );

        $args = array(
            'label' => __($plural, $theme),
            'description' => __($singular . 'ute loetelu', $theme),
            'labels' => $labels,
            'supports' => array('title', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('genres'),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'page',
        );
        register_post_type($slug, $args);
    }

    function register_short_codes()
    {
        add_shortcode('booking', [$this, 'register_booking_short_code']);
    }

    function register_booking_short_code()
    {
        $rooms = ['post_type' => 'booking-room'];
        $equipment = ['post_type' => 'booking-equipment'];
        $get_rooms = get_posts($rooms);
        $get_equipments = get_posts($equipment);
        return Timber::compile('/views/booking.twig', [
            'rooms' => $get_rooms,
            'equipment' => $get_equipments
        ]);
    }

    function the_action_hook_callback()
    {

        try {
            $post_Id = wp_insert_post([
                'post_title' => "Broneering",
                'post_type' => 'booking',
                'post_status' => 'publish'
            ]);

            add_post_meta($post_Id, 'room', $_POST['room']);

            $selected_date = $_POST['date'];
            $new_date = date('Ymd', strtotime($selected_date));
            add_post_meta($post_Id, 'date', $new_date);
            $field_date = get_field_object('date', $post_Id);
            add_post_meta($post_Id, '_date', $field_date['key']);

            add_post_meta($post_Id, 'time_from', $_POST['time_from']);
            add_post_meta($post_Id, 'time_until', $_POST['time_until']);
            add_post_meta($post_Id, 'participants_num', $_POST['participants_num']);
            add_post_meta($post_Id, 'purpose', $_POST['purpose']);
            $equipment = $_POST['resources'];
            $field = get_field_object('resources', $post_Id);
            if (!empty($equipment)){
            add_post_meta($post_Id, 'resources', count($equipment));
            add_post_meta($post_Id, '_resources', $field['key']);
                foreach ($equipment as $key=> $equipmentId){
                    $metaKey = 'resources_'.$key.'_vahend';
                    add_post_meta($post_Id, $metaKey , $equipmentId) ;
                    add_post_meta($post_Id, "_".$metaKey, 'field_5c7591d790f76' );
                }
            }
            add_post_meta($post_Id, 'info', $_POST['info']);
            add_post_meta($post_Id, 'firstname', $_POST['firstname']);
            add_post_meta($post_Id, 'lastname', $_POST['lastname']);
            add_post_meta($post_Id, 'address', $_POST['address']);
            add_post_meta($post_Id, 'phone', $_POST['phone']);
            add_post_meta($post_Id, 'email', $_POST['email']);

            echo "Andmed salvestatud" . $post_Id;
        } catch (Exception $e) {

            wp_die('', '', 500);
        }


    }




}

