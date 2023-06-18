<?php

namespace App\Controller;

use App\Repository\AnalyticsDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface  $entityManager,
        private AnalyticsDataRepository $analyticsDataRepository,
    )
    {
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $data = $this->analyticsDataRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('admin/index.html.twig', [
            'data' => $data
        ]);
    }

    #[Route('/admin/chart', name: 'app_chart')]
    public function chart(Request $request): Response
    {
        $data = $this->analyticsDataRepository->find($request->get('id'));
        if (!$data) {
            return $this->redirectToRoute('app_admin');
        }

        $datas = $this->analyticsDataRepository->findBy(['ip' => $data->getIp()], ['createdAt' => 'ASC']);
        return $this->render('admin/chart.html.twig', [
            'data' => $datas,
            'orgData'=> $data
        ]);
    }

}
