<?php
namespace App\Classes\Station\Equipment;

use App\Interfaces\CampervanSearcher;
use App\Traits\Paginator;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Search object to build data query for equipment demand listing
 * Applies filtering and pager
 */
class DemandSearcher implements CampervanSearcher
{
    use Paginator;

    private QueryBuilder $query;

    public function __construct(EntityRepository $repository)
    {
        $this->query = $repository->createQueryBuilder('ed');
    }

    public function search(int $page, int $itemsPerPage, array $filter = null): array
    {
        // eager load all related tables data here
        $this->query
            ->innerJoin('ed.equipment', 'e')
            ->innerJoin('ed.station', 's')
            ->orderBy('ed.date', 'ASC')
        ;

        return $this
            ->applyFilter($filter)
            ->applyPagination($this->query, $page, $itemsPerPage)
            ->getQuery()
            ->getResult()
        ;
    }

    private function applyFilter(array $filter = null): self
    {
        if (!isset($filter)) {
            $filter['dateFrom'] = (new DateTime())->format('Y-m-d');
            $filter['dateUntil'] = (new DateTime('last day of this month'))->format('Y-m-d');
        }

        if (!empty($filter['stationId'])) {
            $this->query
                ->where('ed.station=:stationId')
                ->setParameter('stationId', $filter['stationId'])
            ;
        }
        if (!empty($filter['dateFrom'])) {
            $this->query
                ->andWhere('ed.date >= :dateFrom')
                ->setParameter('dateFrom', $filter['dateFrom']);
        }

        if (!empty($filter['dateUntil'])) {
            $this->query
                ->andWhere('ed.date <= :dateUntil')
                ->setParameter('dateUntil', $filter['dateUntil']);
        }
        return $this;
    }
}
