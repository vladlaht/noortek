<?php
include 'dto/BookingDTO.php';

class RoomBooking
{

    public function __construct()
    {
        $this->add_post_types();
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
        add_action('wp_ajax_booking_submit', [$this, 'save_booking']);
        add_action('wp_ajax_nopriv_booking_submit', [$this, 'save_booking']);
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

        wp_send_json_success($result);

    }

    public function get_filled_user_form()
    {
        try {
            $bookingForm = $this->mapBookingDTO();
            $bookingForm->calculateAmount();

            $view = Timber::compile('/views/bookingConfirmation.twig', [
                    'bookingForm' => $bookingForm,
                ]
            );

            wp_mail('vlad.laht@mail.ru', "TEST EMAIL", $view, array('Content-Type: text/html; charset=UTF-8'));

            wp_send_json_success(['confirmationHTML' => $view]);

        } catch (Exception $exception) {
            log($exception->getMessage());
        }
    }

    public function save_booking(){
        //
        $bookingForm = $this->mapBookingDTO();
        $bookingForm->calculateAmount();
        $post_Id = wp_insert_post([
            'post_title' => "Broneering " . $bookingForm->getBookingNumber(),
            'post_type' => 'booking',
            'post_status' => 'publish'
        ]);

        add_post_meta($post_Id, 'room', $bookingForm->getRoom()->ID);
        // add other fileds

        // SEND EMAIL TO CUSTOMER


        // SEND RESPONSE TO AJAX
        wp_send_json_success(['html' => '']);
    }

    /**
     * @return BookingDTO
     */
    public function mapBookingDTO(): BookingDTO
    {
        $bookingForm = new BookingDTO();
        $bookingForm->setDate(sanitize_text_field($_POST['form']['date']))
            ->setRoom($_POST['form']['room'])
            ->setTimeFrom($_POST['form']['timeFrom'])
            ->setTimeUntil($_POST['form']['timeUntil'])
            ->setResources($_POST['form']['resources'])
            ->setParticipants($_POST['form']['participants'])
            ->setPurpose(sanitize_text_field($_POST['form']['purpose']))
            ->setInfo(sanitize_text_field($_POST['form']['info']))
            ->setFirstName(sanitize_text_field($_POST['form']['firstName']))
            ->setLastName(sanitize_text_field($_POST['form']['lastName']))
            ->setPhone($_POST['form']['phone'])
            ->setEmail(sanitize_email($_POST['form']['email']))
            ->setAddress(sanitize_text_field($_POST['form']['address']));
        return $bookingForm;
    }


}