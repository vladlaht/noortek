<?php
include 'dto/BookingDTO.php';

class RoomBooking
{

    public function __construct()
    {
        $this->add_post_types();
        $this->register_short_codes();
        $this->register_short_codes();
        $this->register_ajax_action();
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
    }

    public function register_booking_short_code()
    {
        $rooms = get_posts(['post_type' => 'booking-room']);
        $equipments = get_posts(['post_type' => 'booking-equipment']);
        return Timber::compile('/views/booking.twig', [
            'rooms' => $rooms,
            'equipment' => $equipments
        ]);
    }

    public function get_available_times()
    {
        $room = (int)sanitize_text_field($_POST['room']);
        $date = DateTime::createFromFormat('d.m.Y', sanitize_text_field($_POST['date']));

        $args = [
            'post_type' => 'booking',
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => 'date',
                    'value' => $date->format('d.m.Y'),
                ]
            ]
        ];

        $query = get_posts($args);
        $result = [];

        foreach ($query as $post) {
            $date = get_post_meta($post->ID, 'date', true);
            $timeFrom = get_post_meta($post->ID, 'time_from', true);
            $timeTo = get_post_meta($post->ID, 'time_to', true);

            $booking = new stdClass();
            $booking->title = "Broneeritud";
            $booking->from = DateTime::createFromFormat('d.m.Y H:i', "{$date} {$timeFrom}");
            $booking->to = DateTime::createFromFormat('d.m.Y H:i', "{$date} {$timeTo}");

            $result[] = $booking;
        }

        wp_send_json_success(['result' => $result]);

    }

    public function get_filled_user_form()
    {
        try {
            $bookingForm = new BookingDTO();
            $bookingForm->setDate($_POST['form']['date']);
            $bookingForm->setRoom($_POST['form']['room']);
            $bookingForm->setTimeFrom($_POST['form']['timeFrom']);
            $bookingForm->setTimeUntil($_POST['form']['timeUntil']);
            $bookingForm->setResources($_POST['form']['resources']);
            $bookingForm->setParticipants($_POST['form']['participants']);
            $bookingForm->setPurpose($_POST['form']['purpose']);
            $bookingForm->setInfo($_POST['form']['info']);
            $bookingForm->setFirstName(($_POST['form']['firstName']));
            $bookingForm->setLastName($_POST['form']['lastName']);
            $bookingForm->setPhone($_POST['form']['phone']);
            $bookingForm->setEmail($_POST['form']['email']);
            $bookingForm->setAddress($_POST['form']['address']);
            $bookingForm->calculateAmount();

            wp_send_json_success(['result' => $bookingForm]);

        } catch (Exception $exception) {
            log($exception->getMessage());
        }
    }






}