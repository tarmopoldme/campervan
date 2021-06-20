<?php

namespace App\Form\Model;

use DateTime;

/**
 * Model representing search filter form fields
 */
class SearchModel
{
    public $stationId;

    public ?DateTime $dateFrom;

    public ?DateTime $dateUntil;

    /**
     * Used to set default model values
     */
    public function __construct()
    {
        $this->dateFrom = new DateTime();
        $this->dateUntil = (new DateTime())->modify('last day of this month');
    }
}
