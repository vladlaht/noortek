<?php

class BookingSaving
{
    public function __construct()
    {
        $this->add_rest_route();
    }

    public function add_rest_route()
    {
        add_action('rest_api_init', [$this, 'register_rest_route']);
    }

    public function register_rest_route()
    {
        register_rest_route('noortek-booking/v1', '/save', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'save_booking'],
        ));
    }

    function save_booking()
    {
        try {
            $post_Id = wp_insert_post([
                'post_title' => 'Broneering',
                'post_type' => 'booking',
                'post_status' => 'publish'
            ]);
            add_post_meta($post_Id, 'room', 'bookingRoom');
            add_post_meta($post_Id, 'date', 'bookingDate');
            add_post_meta($post_Id, 'time_from', 'bookingTimeFrom');
            add_post_meta($post_Id, 'time_until', 'bookingTimeUntil');
            add_post_meta($post_Id, 'participants_num', 'bookingParticipantsNumber');
            add_post_meta($post_Id, 'purpose', 'bookingPurpose');
            add_post_meta($post_Id, 'info', 'bookingInfo');
            add_post_meta($post_Id, 'firstname', 'bookingFirstName');
            add_post_meta($post_Id, 'lastname', 'bookingLastName');
            add_post_meta($post_Id, 'address', 'bookingAddress');
            add_post_meta($post_Id, 'phone', 'bookingEmail');
            add_post_meta($post_Id, 'email', 'bookingEmail');
            add_post_meta($post_Id, 'summa', 'bookingSumma');
            add_post_meta($post_Id, 'status', 'bookkingStatus');
            add_post_meta($post_Id, 'booking_number', 'bookingNumber');


            /*
            $bookingsList = array();
            $bookings = get_posts(array('post_type' => 'booking',
            ));
            foreach ($bookings as $booking) {
            $room = get_the_title(get_post_meta($booking->ID, 'room', true));
            $date = get_post_meta($booking->ID, 'date', true);
            $time_from = get_post_meta($booking->ID, 'time_from', true);
            $time_until = get_post_meta($booking->ID, 'time_until', true);
            $participants_num = get_post_meta($booking->ID, 'participants_num', true);
            $purpose = get_post_meta($booking->ID, 'purpose', true);
            $resource = get_post_meta($booking->ID, 'resources', true);
            $info = get_post_meta($booking->ID, 'info', true);
            $firstname = get_post_meta($booking->ID, 'firstname', true);
            $lastname = get_post_meta($booking->ID, 'lastname', true);
            $address = get_post_meta($booking->ID, 'address', true);
            $phone = get_post_meta($booking->ID, 'phone', true);
            $email = get_post_meta($booking->ID, 'email', true);
            $summa = get_post_meta($booking->ID, 'summa', true);
            $status = get_post_meta($booking->ID, 'status', true);

            array_push($bookingsList, array(
                'room' => $room,
                'date' => $date,
                'time_from' => $time_from,
                'time_until' => $time_until,
                'participants_num' => $participants_num,
                'purpose' => $purpose,
                'resource' => $resource,
                'info' => $info,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'address' => $address,
                'phone' => $phone,
                'email' => $email,
                'summa' => $summa,
                'status' => $status,
            ));
        }
            return $bookingsList;
          */
        } catch (Exception $exception)
{
log($exception->getMessage());
}
}


}