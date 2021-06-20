<?php
namespace App\Traits;

use App\Utils\SimplePaginator;
use Doctrine\ORM\QueryBuilder;

/**
 * Trait which could be used for pagination support
 */
trait Paginator
{
    private SimplePaginator $paginator;

    protected function applyPagination(QueryBuilder $query, int $page, int $itemsPerPage): SimplePaginator
    {
        $paginator = (new SimplePaginator($query, $page, $itemsPerPage))->init();
        $this->paginator = $paginator;
        return $paginator;
    }

    public function getPaginator(): SimplePaginator
    {
        return $this->paginator;
    }
}