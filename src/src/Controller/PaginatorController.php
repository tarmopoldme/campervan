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
    public function indexAction(SimplePaginator $paginator, string $routing = 'index', array $filter = null): Response
    {
        $pageRange = $this->getParameter('app.paginator.page_range');

        return $this->render('paginator/index.html.twig', [
            'paginator' => $paginator,
            'routing' => $routing,
            'filter' => $filter,
            'separator' => ' ... ',
            'pageRangeMin' => $paginator->getPage() - $pageRange,
            'pageRangeMax' => $paginator->getPage() + $pageRange
        ]);
    }
}
