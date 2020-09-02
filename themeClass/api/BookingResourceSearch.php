<?php

class BookingResourceSearch
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
        register_rest_route('noortek-booking/v1', '/resources', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_resources']
        ));
    }

    function get_resources()
    {
        $equipmentsList = array();
        $equipments = get_posts(array('post_type' => 'booking-equipment',
        ));

        foreach ($equipments as $equipment) {
            $equipmentID = $equipment->ID;
            $equipmentName = $equipment->post_title;
            $equipmentPrice = get_post_meta($equipment->ID, 'price', true);

            array_push($equipmentsList, array(
                'id' => $equipmentID,
                'equipmentName' => $equipmentName,
                'equipmentPrice' => $equipmentPrice
            ));
        }
        return $equipmentsList;
    }


}