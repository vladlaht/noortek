<?php

class NnkTranslations
{

    const NAME = 'wp-noortek';

    public static function register_strings()
    {
        self::booking_wizard_strings();
    }

    private static function booking_wizard_strings()
    {
        $tabsGroup = 'bookingTabs';
        pll_register_string(self::NAME, 'bookingTabRoomAndDate', $tabsGroup);
        pll_register_string(self::NAME, 'bookingTabTimeAndEquipments', $tabsGroup);
        pll_register_string(self::NAME, 'bookingTabGoal', $tabsGroup);
        pll_register_string(self::NAME, 'bookingTabResponsible', $tabsGroup);
        pll_register_string(self::NAME, 'bookingTabRules', $tabsGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmation', $tabsGroup);

        $tabRoomAndDateGroup = "bookingTabRoomAndDate";
        pll_register_string(self::NAME, 'bookingTabRoomAndDateLabelDate', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'bookingTabRoomAndDateLabelRoom', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'bookingTabRoomAndDateLabelPrice', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'bookingTabRoomAndDatePriceUnit', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'bookingTabRoomAndDateLabelSelect', $tabRoomAndDateGroup);

        $tabTimeAndEquipmentsGroup = "bookingTabTimeAndEquipments";
        pll_register_string(self::NAME, 'bookingTabTimeAndEquipmentsLabelTimeFrom', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'bookingTabTimeAndEquipmentsLabelTimeUntil', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'bookingTabTimeAndEquipmentsLabelResources', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'bookingTabTimeAndEquipmentsPriceUnit', $tabTimeAndEquipmentsGroup);

        $tabGoalGroup = "bookingTabTimeAndResources";
        pll_register_string(self::NAME, 'bookingTabGoalLabelParticipants', $tabGoalGroup);
        pll_register_string(self::NAME, 'bookingTabGoalLabelParticipantsPlaceholder', $tabGoalGroup);
        pll_register_string(self::NAME, 'bookingTabGoalLabelGoal', $tabGoalGroup);
        pll_register_string(self::NAME, 'bookingTabGoalLabelGoalPlaceholder', $tabGoalGroup);
        pll_register_string(self::NAME, 'bookingTabGoalLabelInfo', $tabGoalGroup);
        pll_register_string(self::NAME, 'bookingTabGoalLabelInfoPlaceholder', $tabGoalGroup);

        $tabResponsibleGroup = "bookingTabResponsible";
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelText', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelFirstName', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelLastName', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelPhone', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelEmail', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelAddress', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'bookingTabResponsibleLabelAddressPlaceholder', $tabResponsibleGroup);

        $tabRulesGroup = "bookingTabRules";
        pll_register_string(self::NAME, 'bookingTabRulesLabelConfirm', $tabRulesGroup);


        $tabConfirmationGroup = "bookingTabConfirmation";
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelReview', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelMessage', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelBooker', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelDate', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelGoal', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelParticipants', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelInfo', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelRoomName', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelTime', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelItemPrice', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelItemTotalPrice', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelTimeUnit', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelTimeUnitsFirst', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelTimeUnitsSecond', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelTotalAmount', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'bookingTabConfirmationLabelSubmitButton', $tabConfirmationGroup);

    }
}