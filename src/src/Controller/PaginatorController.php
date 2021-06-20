<?php

namespace App\Controller;

use App\Utils\SimplePaginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reusable paginator controller with it's own template
 */
class PaginatorController extends AbstractController
{
    /**
     * @param SimplePaginator $paginator
     * @param mixed $filter filtering params for pager links if needed
     *
     * @return Response
     */
    public function indexAction(SimplePaginator $paginator, array $filter = null): Response
    {
        $pageRange = $this->getParameter('app.paginator.page_range');
        $pageRangeMin = $paginator->getPage() - $pageRange;
        $pageRangeMax = $paginator->getPage() + $pageRange;
        $separator = ' ... ';

        return $this->render('paginator/index.html.twig', [
            'paginator' => $paginator,
            'filter' => $filter,
            'separator' => $separator,
            'pageRangeMax' => $pageRangeMax,
            'pageRangeMin' => $pageRangeMin,
        ]);
    }
}
