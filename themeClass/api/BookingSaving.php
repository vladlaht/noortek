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
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'save_booking'],
            ),
            array(
                'methods' => 'GET',
                'callback' => [$this, 'get_invoice'],
            )
        ));
    }

    function save_booking(WP_REST_Request $request): void
    {
        $body = $request->get_body();
        $decoded_body = json_decode($body);

        try {
            $bookingForm = $this->mapBookingDTO($decoded_body);
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

            $summa_data = $bookingForm->getTotalAmount();
            error_log("Booking total price:" . $summa_data);

        } catch (Exception $exception) {
            log($exception->getMessage());
        }
    }

    public function mapBookingDTO($body): BookingDTO
    {
        $resourceItem = isset($body->resources) ? (array)$body->resources : array();
        $bookingForm = new BookingDTO();
        $bookingForm->setDate($body->date)
            ->setRoom($body->room)
            ->setTimeFrom($body->timeFrom)
            ->setTimeUntil($body->timeUntil)
            ->setResources($resourceItem)
            ->setParticipants($body->participants)
            ->setPurpose($body->purpose)
            ->setInfo($body->info)
            ->setFirstName($body->firstName)
            ->setLastName($body->lastName)
            ->setPhone($body->phone)
            ->setEmail($body->email)
            ->setAddress($body->address);
        return $bookingForm;
    }

    function get_invoice($request) {

        $body = $request->get_body();
        $decoded_body = json_decode($body);
        $bookingForm = $this->mapBookingDTO($decoded_body);
        $bookingForm->calculateAmount();
    }


}

