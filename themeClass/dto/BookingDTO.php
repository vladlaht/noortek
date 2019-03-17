<?php

class BookingDTO
{
    const KEY_PRICE = 'price';
    const KEY_HIND = 'hind';
    const TYPE_ROOM = 'room';
    const TYPE_EQUIPMENT = 'equipment';

    public $date;
    public $room;
    public $timeFrom;
    public $timeUntil;
    public $resources;
    public $participants;
    public $purpose;
    public $info;
    public $firstName;
    public $lastName;
    public $phone;
    public $email;
    public $address;
    public $invoiceRows;
    public $totalAmount;

    public function __construct()
    {
        $this->invoiceRows = [];
    }

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param mixed $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return WP_Post mixed
     */
    public function getRoom() : WP_Post
    {
        return $this->room;
    }

    /**
     * @param int $roomId
     * @return BookingDTO
     */
    public function setRoom($roomId)
    {
        $this->room = get_post($roomId);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeFrom()
    {
        return $this->timeFrom;
    }

    /**
     * @param mixed $timeFrom
     */
    public function setTimeFrom($timeFrom)
    {
        $this->timeFrom = $timeFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeUntil()
    {
        return $this->timeUntil;
    }

    /**
     * @param mixed $timeUntil
     */
    public function setTimeUntil($timeUntil)
    {
        $this->timeUntil = $timeUntil;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param mixed $resources
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @param mixed $purpose
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceRows()
    {
        return $this->invoiceRows;
    }

    /**
     * @param mixed $invoiceRows
     */
    public function setInvoiceRows($invoiceRows): void
    {
        $this->invoiceRows = $invoiceRows;
    }

    public function getBookingNumber(){
        return ""; // 20190313230145  new DateTime()
    }

    public function calculateAmount()
    {
        $roomTotalPrice = $this->getItemTotalPrice($this->getRoomPrice(), $this->getRoundedBookingTime());
        $this->addInvoiceItemRow($this->room->post_title, self::TYPE_ROOM, $this->getRoomPrice(), $this->getRoundedBookingTime(), $roomTotalPrice);
        $this->setTotalAmount(bcadd($roomTotalPrice, $this->getEquipmentsPrice(), 2));
    }

    private function getRoomPrice()
    {
        return get_post_meta($this->room->ID, self::KEY_PRICE, true);
    }

    private function getRoundedBookingTime()
    {
        $from = new DateTime($this->timeFrom);
        $until = $from->diff(new DateTime($this->timeUntil));
        $hours = $until->h;
        $minutes = $until->i;
        if ($minutes > 0) {
            $hours++;
        }
        return $hours;
    }

    private function getItemTotalPrice($itemPrice, $amount)
    {
        return bcmul($itemPrice, $amount, 2);
    }

    private function getEquipmentsPrice()
    {
        $summa = 0;
        foreach ($this->resources as $resourceId) {
            $price = get_post_meta($resourceId, self::KEY_HIND, true);
            $item = get_post($resourceId);
            $itemSumma = $this->getItemTotalPrice($price, $this->getRoundedBookingTime());
            $this->addInvoiceItemRow($item->post_title,self::TYPE_EQUIPMENT, $price, $this->getRoundedBookingTime(), $itemSumma);
            $summa = (int)bcadd($summa, $itemSumma, 2);
        }
        return $summa;
    }

    private function addInvoiceItemRow($name, $type, $price, $amount, $total)
    {
        $itemRow =
            [
                'name' => $name,
                'type' => $type,
                'price' => (int)$price,
                'amount' => $amount,
                'total' => (float)$total
            ];
        $this->invoiceRows[] = $itemRow;

    }


}