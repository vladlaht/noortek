<?php

class BookingRoomSearch
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
        register_rest_route('noortek-booking/v1', '/rooms', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_rooms']
        ));
    }

    function get_rooms()
    {
        $roomsList = array();
        $rooms = get_posts(array('post_type' => 'booking-room',
        ));

        foreach ($rooms as $room) {
            $roomID = $room->ID;
            $roomImg = get_the_post_thumbnail_url($room->ID, '');
            $roomName = $room->post_title;
            $roomPrice = get_post_meta($room->ID, 'price', true);

            array_push($roomsList, array(
                'id' => $roomID,
                'roomName' => $roomName,
                'roomPrice' => $roomPrice,
                'roomImg' => $roomImg
            ));
        }
        return $roomsList;
    }


}