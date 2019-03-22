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
            $post_Id = wp_insert_post([
                'post_title' => "Broneering",
                'post_type' => 'booking',
                'post_status' => 'publish'
            ]);

            add_post_meta($post_Id, 'room', $bookingForm->getRoom()->ID);
            $selected_date = $bookingForm->getDate();
            $new_date = date('Ymd', strtotime($selected_date));
            add_post_meta($post_Id, 'date', $new_date);
            $field_date = get_field_object('date', $post_Id);
            add_post_meta($post_Id, '_date', $field_date['key']);
            add_post_meta($post_Id, 'time_from', $bookingForm->getTimeFrom());
            add_post_meta($post_Id, 'time_until', $bookingForm->getTimeUntil());
            add_post_meta($post_Id, 'participants_num', $bookingForm->getParticipants());
            add_post_meta($post_Id, 'purpose', $bookingForm->getPurpose());
            $equipment = $bookingForm->getResources();
            $field = get_field_object('resources', $post_Id);
            if (!empty($equipment)) {
                add_post_meta($post_Id, 'resources', count($equipment));
                add_post_meta($post_Id, '_resources', $field['key']);
                foreach ($equipment as $key => $equipmentId) {
                    $metaKey = 'resources_' . $key . '_vahend';
                    add_post_meta($post_Id, $metaKey, $equipmentId);
                    add_post_meta($post_Id, "_" . $metaKey, 'field_5c7591d790f76');
                }
            }
            add_post_meta($post_Id, 'info', $bookingForm->getInfo());
            add_post_meta($post_Id, 'firstname', $bookingForm->getFirstName());
            add_post_meta($post_Id, 'lastname', $bookingForm->getLastName());
            add_post_meta($post_Id, 'address', $bookingForm->getAddress());
            add_post_meta($post_Id, 'phone', $bookingForm->getPhone());
            add_post_meta($post_Id, 'email', $bookingForm->getEmail());
            add_post_meta($post_Id, 'summa', $bookingForm->getTotalAmount());

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
            ->setPhone((int)($_POST['form']['phone']))
            ->setEmail(sanitize_email($_POST['form']['email']))
            ->setAddress(sanitize_text_field($_POST['form']['address']));
        return $bookingForm;
    }


}