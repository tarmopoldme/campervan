<?php

namespace App\Controller;

use App\Classes\EquipmentDemandSearcher;
use App\Entity\StationEquipmentDemand;
use App\Form\Model\SearchModel;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
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

        $filter = $request->get('filter');
        $filterForm->handleRequest($request);

        $demands = (new EquipmentDemandSearcher(
            $this->getDoctrine()->getRepository(StationEquipmentDemand::class)
        ))->search($filter);

        return $this->render('index/demandDashboard.html.twig', [
            'form' => $filterForm->createView(),
            'demands' => $demands
        ]);
    }
}
