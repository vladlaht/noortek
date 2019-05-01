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
        $tabsGroup = 'bookingWizardTabs';
        pll_register_string(self::NAME, 'wizardTabRoomAndDate', $tabsGroup);
        pll_register_string(self::NAME, 'wizardTabTimeAndEquipments', $tabsGroup);
        pll_register_string(self::NAME, 'wizardTabGoal', $tabsGroup);
        pll_register_string(self::NAME, 'wizardTabResponsible', $tabsGroup);
        pll_register_string(self::NAME, 'wizardTabRules', $tabsGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmation', $tabsGroup);

        $tabRoomAndDateGroup = "bookingWizardTabRoomAndDate";
        pll_register_string(self::NAME, 'wizardTabRoomAndDateLabelDate', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'wizardTabRoomAndDateLabelRoom', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'wizardTabRoomAndDateLabelPrice', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'wizardTabRoomAndDatePriceUnit', $tabRoomAndDateGroup);
        pll_register_string(self::NAME, 'wizardTabRoomAndDateLabelSelect', $tabRoomAndDateGroup);

        $tabTimeAndEquipmentsGroup = "bookingWizardTabTimeAndEquipments";
        pll_register_string(self::NAME, 'wizardTabTimeAndEquipmentsLabelTimeFrom', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'wizardTabTimeAndEquipmentsLabelTimeUntil', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'wizardTabTimeAndEquipmentsLabelResources', $tabTimeAndEquipmentsGroup);
        pll_register_string(self::NAME, 'wizardTabTimeAndEquipmentsPriceUnit', $tabTimeAndEquipmentsGroup);

        $tabGoalGroup = "bookingWizardTabTimeAndResources";
        pll_register_string(self::NAME, 'wizardTabGoalLabelParticipants', $tabGoalGroup);
        pll_register_string(self::NAME, 'wizardTabGoalLabelParticipantsPlaceholder', $tabGoalGroup);
        pll_register_string(self::NAME, 'wizardTabGoalLabelGoal', $tabGoalGroup);
        pll_register_string(self::NAME, 'wizardTabGoalLabelGoalPlaceholder', $tabGoalGroup);
        pll_register_string(self::NAME, 'wizardTabGoalLabelInfo', $tabGoalGroup);
        pll_register_string(self::NAME, 'wizardTabGoalLabelInfoPlaceholder', $tabGoalGroup);

        $tabResponsibleGroup = "bookingWizardTabResponsible";
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelText', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelFirstName', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelLastName', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelPhone', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelEmail', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelAddress', $tabResponsibleGroup);
        pll_register_string(self::NAME, 'wizardTabResponsibleLabelAddressPlaceholder', $tabResponsibleGroup);

        $tabRulesGroup = "bookingWizardTabRules";
        pll_register_string(self::NAME, 'wizardTabRulesLabelConfirm', $tabRulesGroup);


        $tabConfirmationGroup = "bookingWizardTabConfirmation";
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelReview', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelMessage', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelBooker', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelDate', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelGoal', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelParticipants', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelInfo', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelRoomName', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelTime', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelHourPrice', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelItemSumma', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelTimeUnit', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelTimeUnitsFirst', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelTimeUnitsSecond', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelTotalAmount', $tabConfirmationGroup);
        pll_register_string(self::NAME, 'wizardTabConfirmationLabelSubmitButton', $tabConfirmationGroup);

    }
}