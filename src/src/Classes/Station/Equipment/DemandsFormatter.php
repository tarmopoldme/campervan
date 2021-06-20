<?php
namespace App\Classes\Station\Equipment;

use App\Entity\StationEquipmentDemand;

/**
 * Simple formatter to convert array collection to something else (currently contains to array conversion)
 */
class DemandsFormatter
{
    /**
     * @var StationEquipmentDemand[]
     */
    private array $demands;
    private array $formattedDemands;

    public function __construct(array $demands)
    {
        $this->demands = $demands;
        $this->formattedDemands = [];
    }

    public function toArray(): self
    {
        // NOTE: do not forget to eager load data beforehand
        // otherwise each equipment and station "getter" will execute separate query here
        foreach ($this->demands as $demand) {
            $this->formattedDemands[] = [
                'date' => $demand->getDate()->format('Y-m-d'),
                'station' => $demand->getStation()->getName(),
                'equipment' => $demand->getEquipment()->getName(),
                'booked_count' => $demand->getBookedCount(),
                'available_count' => $demand->getAvailableCount(),
            ];
        }
        return $this;
    }

    public function getFormattedDemands(): array
    {
        return $this->formattedDemands;
    }

}
