<?php

namespace App\Utils;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Simple paginator logic to extend Doctrine Paginator
*/
class SimplePaginator extends Paginator
{
    private int $page;
    private int $resultsPerPage;

    public function __construct(QueryBuilder $query, int $page, int $resultsPerPage)
    {
        parent::__construct($query);

        $this->page = $page;
        $this->resultsPerPage = $resultsPerPage;
    }

    public function init(): self
    {
        $this
            ->getQuery()
            ->setFirstResult($this->resultsPerPage * ($this->page - 1))
            ->setMaxResults($this->resultsPerPage)
        ;
        return $this;
    }

    public function getFirstPage(): int
    {
        return 1;
    }

    public function getLastPage(): int
    {
        return (int)ceil($this->count() / $this->resultsPerPage);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function haveToPaginate(): bool
    {
        return $this->getFirstPage() !== $this->getLastPage();
    }
}
