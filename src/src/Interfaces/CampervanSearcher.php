<?php
namespace App\Interfaces;

/**
 * Generic interface for all searcher objects which use pager and filtering
 */
interface CampervanSearcher
{
    /**
     * Generic public search method definition
     *
     * @param int $page
     * @param int $itemsPerPage
     * @param array|null $filter
     * @return array
     */
    public function search(int $page, int $itemsPerPage, array $filter = null): array;
}