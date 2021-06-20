<?php

namespace App\Controller;

use App\Classes\Station\Equipment\DemandSearcher;
use App\Entity\StationEquipmentDemand;
use App\Form\Model\SearchModel;
use App\Form\SearchType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Home controller which serves demands dashboard at the moment
 */
class IndexController extends AbstractController
{

    public function indexAction(Request $request): Response
    {
        $filterForm = $this->createForm(
            SearchType::class,
            new SearchModel(),
            ['method' => 'GET']
        );

        $filterForm->handleRequest($request);
        $filter = $request->get('filter');
        $page = $request->get('page') ?? 1;

        /** @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository(StationEquipmentDemand::class);
        $searcher = new DemandSearcher($repository);

        return $this->render('index/demandDashboard.html.twig', [
            'filter' => $filter,
            'form' => $filterForm->createView(),
            'demands' => $searcher->search($page, $this->getParameter('app.paginator.items_per_page'), $filter),
            'paginator' => $searcher->getPaginator()
        ]);
    }
}
