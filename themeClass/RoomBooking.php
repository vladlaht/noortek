<?php
include 'dto/BookingDTO.php';

class RoomBooking
{
    public function __construct()
    {
        $this->add_post_types();
        $this->register_short_codes();
        $this->register_ajax_action();
        $this->add_meta_boxes();
        $this->add_posts_columns();
        $this->save_post();
    }

    private function add_post_types()
    {
        NoortekWPTheme::register_custom_post_type('booking', 'Broneering', 'Broneeringud');
        NoortekWPTheme::register_custom_post_type('booking-room', 'Ruum', 'Ruumid');
        NoortekWPTheme::register_custom_post_type('booking-equipment', 'Vahend', 'Vahendid');
    }

    private function register_short_codes()
    {
        add_shortcode('booking', [$this, 'register_booking_short_code']);
    }

    private function register_ajax_action()
    {
        add_action('wp_ajax_room_booking_time', [$this, 'get_available_times']);
        add_action('wp_ajax_nopriv_room_booking_time', [$this, 'get_available_times']);
        add_action('wp_ajax_filled_form', [$this, 'get_filled_user_form']);
        add_action('wp_ajax_nopriv_filled_form', [$this, 'get_filled_user_form']);
        add_action('wp_ajax_booking_submit', [$this, 'save_booking']);
        add_action('wp_ajax_nopriv_booking_submit', [$this, 'save_booking']);
    }

    private function save_post()
    {
        add_action('save_post', [$this, 'save_booking_data']);
    }

    private function add_meta_boxes()
    {
        add_action('add_meta_boxes', [$this, 'add_booking_meta_box']);
    }

    private function add_posts_columns()
    {
        add_filter('manage_booking_posts_columns', [$this, 'set_custom_booking_columns']);
        add_action('pre_get_posts', [$this, 'extend_admin_search']);
        add_action('manage_booking_posts_custom_column', [$this, 'custom_booking_column'], 10, 2);
    }

    function add_booking_meta_box()
    {
        add_meta_box('booking_metabox', 'Booking metabox', [$this, 'booking_callback'],
            'booking', 'normal', 'high');
    }

    function set_custom_booking_columns($columns)
    {
        unset($columns['date']);
        $columns['title'] = 'Nimetus';
        $columns['booking_number'] = 'Broneeringu nr.';
        $columns['booker_name'] = 'Broneerija nimi';
        $columns['room'] = 'Ruum';
        $columns['status'] = 'Staatus';
        $columns['date'] = 'Kuupäev';
        return $columns;
    }

    function custom_booking_column($column, $post_id)
    {
        switch ($column) {

            case 'booking_number':
                echo get_post_meta($post_id, 'booking_number', true);
                break;
            case 'booker_name':
                echo get_post_meta($post_id, 'firstname', true), ' ', get_post_meta($post_id, 'lastname', true);
                break;
            case 'room':
                echo get_the_title(get_post_meta($post_id, 'room', true));
                break;
            case 'status':
                echo $status = get_post_meta($post_id, 'status', true);
                break;
            case 'date':
                echo get_post_meta($post_id, 'date', true);
                break;;
        }
    }

    function extend_admin_search($query)
    {
        $post_type = 'booking';
        $custom_fields = array(
            'firstname',
            'lastname',
            'booking_number',
        );

        if (!is_admin())
            return;

        if ($query->query['post_type'] != $post_type)
            return;

        $search_term = $query->query_vars['s'];

        // Set to empty, otherwise it won't find anything
        $query->query_vars['s'] = '';

        if ($search_term != '') {
            $meta_query = array('relation' => 'OR');

            foreach ($custom_fields as $custom_field) {
                array_push($meta_query, array(
                    'key' => $custom_field,
                    'value' => $search_term,
                    'compare' => 'LIKE'
                ));
            }
            $query->set('meta_query', $meta_query);
        };
    }

    function booking_callback($post)
    {
        wp_nonce_field('save_booking_data', 'booking_meta_box_nonce');

        $room = get_post(get_post_meta($post->ID, 'room', true));
        $rooms = get_posts(['post_type' => 'booking-room']);
        $date = get_post_meta($post->ID, 'date', true);
        $time_from = get_post_meta($post->ID, 'time_from', true);
        $time_until = get_post_meta($post->ID, 'time_until', true);
        $participants_num = get_post_meta($post->ID, 'participants_num', true);
        $purpose = get_post_meta($post->ID, 'purpose', true);
        $resource = get_post_meta($post->ID, 'resources', true);
        $resources = get_posts(['post_type' => 'booking-equipment']);
        $info = get_post_meta($post->ID, 'info', true);
        $firstname = get_post_meta($post->ID, 'firstname', true);
        $lastname = get_post_meta($post->ID, 'lastname', true);
        $address = get_post_meta($post->ID, 'address', true);
        $phone = get_post_meta($post->ID, 'phone', true);
        $email = get_post_meta($post->ID, 'email', true);
        $summa = get_post_meta($post->ID, 'summa', true);
        $status = get_post_meta($post->ID, 'status', true);
        $statuses = BookingDTO::getStatuses();

        Timber::render('/views/customFields/bookingEditForm.twig', [
            'room' => $room,
            'rooms' => $rooms,
            'date' => $date,
            'time_from' => $time_from,
            'time_until' => $time_until,
            'participants_num' => $participants_num,
            'purpose' => $purpose,
            'resource' => $resource,
            'resources' => $resources,
            'info' => $info,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'summa' => $summa,
            'status' => $status,
            'statuses' => $statuses
        ]);
    }

    function save_booking_data($post_id)
    {
        if (!isset($_POST['booking_meta_box_nonce'])) {
            return $post_id;
        }
        if (!wp_verify_nonce($_POST['booking_meta_box_nonce'], 'save_booking_data')) {
            return $post_id;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        $room = (int)($_POST['room']);
        $date = sanitize_text_field($_POST['date']);
        $time_from = sanitize_text_field($_POST['time_from']);
        $time_until = sanitize_text_field($_POST['time_until']);
        $participants_num = (int)($_POST['participants_num']);
        $purpose = sanitize_text_field($_POST['purpose']);
        $resource = ($_POST['resources']);
        $info = sanitize_text_field($_POST['info']);
        $firstname = sanitize_text_field($_POST['firstname']);
        $lastname = sanitize_text_field($_POST['lastname']);
        $address = sanitize_text_field($_POST['address']);
        $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $summa = (int)($_POST['summa']);
        $status = sanitize_text_field($_POST['status']);

        update_post_meta($post_id, 'room', $room);
        update_post_meta($post_id, 'date', $date);
        update_post_meta($post_id, 'time_from', $time_from);
        update_post_meta($post_id, 'time_until', $time_until);
        update_post_meta($post_id, 'participants_num', $participants_num);
        update_post_meta($post_id, 'purpose', $purpose);
        update_post_meta($post_id, 'info', $info);
        update_post_meta($post_id, 'firstname', $firstname);
        update_post_meta($post_id, 'lastname', $lastname);
        update_post_meta($post_id, 'address', $address);
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'summa', $summa);
        update_post_meta($post_id, 'status', $status);
        if (!empty($resource)) {
            try {
                update_post_meta($post_id, "resources", $resource);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }

    public function register_booking_short_code()
    {
        $rooms = get_posts(['post_type' => 'booking-room']);
        $equipments = get_posts(['post_type' => 'booking-equipment']);
        $svg = get_template_directory_uri() . '/images/spinning-circles.svg';
        return Timber::compile('/views/booking.twig', [
            'rooms' => $rooms,
            'equipment' => $equipments,
            'svgPreloaderPath' => $svg
        ]);
    }

    public function get_available_times()
    {
        $date = DateTime::createFromFormat('d.m.Y', sanitize_text_field($_POST['date']));
        $args = [
            'post_type' => 'booking',
            'post_status' => 'publish',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'date',
                    'value' => $date->format('d.m.Y'),
                ],
                [
                    'key' => 'status',
                    'value' => BookingDTO::STATUS_CONFIRMED,
                ]
            ]
        ];
        $query = get_posts($args);
        $result = [];
        foreach ($query as $post) {
            $date = get_post_meta($post->ID, 'date', true);
            $timeFrom = get_post_meta($post->ID, 'time_from', true);
            $timeTo = get_post_meta($post->ID, 'time_until', true);
            $booking = new stdClass();
            $booking->title = "Broneeritud";
            $booking->from = DateTime::createFromFormat('d.m.Y H:i', "{$date} {$timeFrom}");
            $booking->to = DateTime::createFromFormat('d.m.Y H:i', "{$date} {$timeTo}");
            $result[] = $booking;
        }
        wp_send_json_success($result);
    }

    public function get_filled_user_form()
    {
        try {
            $bookingForm = $this->mapBookingDTO();
            $bookingForm->calculateAmount();
            $view = Timber::compile('/views/bookingConfirmation.twig', [
                    'bookingForm' => $bookingForm
                ]
            );
            wp_send_json_success(['confirmationHTML' => $view]);

        } catch (Exception $exception) {
            log($exception->getMessage());
        }
    }

    public function save_booking()
    {
        try {
            $bookingForm = $this->mapBookingDTO();
            $bookingForm->calculateAmount();
            $bookingForm->generateBookingNumber();
            $bookingForm->generateBookingStatus();
            $post_Id = wp_insert_post([
                'post_title' => 'Broneering',
                'post_type' => 'booking',
                'post_status' => 'publish'
            ]);
            add_post_meta($post_Id, 'room', $bookingForm->getRoom()->ID);
            add_post_meta($post_Id, 'date', $bookingForm->getDate());
            add_post_meta($post_Id, 'time_from', $bookingForm->getTimeFrom());
            add_post_meta($post_Id, 'time_until', $bookingForm->getTimeUntil());
            add_post_meta($post_Id, 'participants_num', $bookingForm->getParticipants());
            add_post_meta($post_Id, 'purpose', $bookingForm->getPurpose());
            $equipment = $bookingForm->getResources();
            if (!empty($equipment)) {
                add_post_meta($post_Id, "resources", $equipment);
            }
            add_post_meta($post_Id, 'info', $bookingForm->getInfo());
            add_post_meta($post_Id, 'firstname', $bookingForm->getFirstName());
            add_post_meta($post_Id, 'lastname', $bookingForm->getLastName());
            add_post_meta($post_Id, 'address', $bookingForm->getAddress());
            add_post_meta($post_Id, 'phone', $bookingForm->getPhone());
            add_post_meta($post_Id, 'email', $bookingForm->getEmail());
            add_post_meta($post_Id, 'summa', $bookingForm->getTotalAmount());
            add_post_meta($post_Id, 'status', $bookingForm->getStatus());
            add_post_meta($post_Id, 'booking_number', $bookingForm->getBookingNumber());


            $successView = Timber::compile('/views/bookingSubmitSuccess.twig', [
                    'bookingSubmit' => $bookingForm
                ]
            );

            $customerLetter = Timber::compile('/views/bookingCustomerLetter.twig', [
                    'bookingLetter' => $bookingForm,
                    'noortekLogo' => get_template_directory_uri() . '/images/logos/nnk-logo.png'
                ]
            );
            wp_mail($bookingForm->getEmail(), "Broneeringu andmed", $customerLetter, array('Content-Type: text/html; charset=UTF-8'));
            wp_send_json_success(['submitSucces' => $successView]);

        } catch (Exception $exception) {
            log($exception->getMessage());
        }
    }

    /**
     * @return BookingDTO
     */
    public function mapBookingDTO(): BookingDTO
    {
        $resourceItem = isset($_POST['form']['resources']) ? (array)$_POST['form']['resources'] : array();
        $bookingForm = new BookingDTO();

        $bookingForm->setDate(sanitize_text_field($_POST['form']['date']))
            ->setRoom((int)($_POST['form']['room']))
            ->setTimeFrom(sanitize_text_field($_POST['form']['timeFrom']))
            ->setTimeUntil(sanitize_text_field($_POST['form']['timeUntil']))
            ->setResources(array_map('sanitize_text_field', $resourceItem))
            ->setParticipants((int)($_POST['form']['participants']))
            ->setPurpose(sanitize_text_field($_POST['form']['purpose']))
            ->setInfo(sanitize_text_field($_POST['form']['info']))
            ->setFirstName(sanitize_text_field($_POST['form']['firstName']))
            ->setLastName(sanitize_text_field($_POST['form']['lastName']))
            ->setPhone(sanitize_text_field($_POST['form']['phone']))
            ->setEmail(sanitize_email($_POST['form']['email']))
            ->setAddress(sanitize_text_field($_POST['form']['address']));
        return $bookingForm;
    }


}