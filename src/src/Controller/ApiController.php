<?php

namespace App\Controller;

use App\Classes\Station\Equipment\DemandSearcher;
use App\Classes\Station\Equipment\DemandsFormatter;
use App\Entity\StationEquipmentDemand;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API controller to serve demands index API json response
 */
class ApiController extends AbstractController
{

    public function demandsAction(Request $request): Response
    {
        $filter = $request->get('filter');
        $page = $request->get('page') ?? 1;

        /** @var EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository(StationEquipmentDemand::class);
        $searcher = new DemandSearcher($repository);
        $demands = $searcher->search($page, $this->getParameter('app.paginator.items_per_page'), $filter);

        return new JsonResponse(
            (new DemandsFormatter($demands))->toArray()->getFormattedDemands(),
            Response::HTTP_OK
        );
    }
}
