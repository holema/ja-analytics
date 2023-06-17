<?php

namespace App\Controller;

use App\Repository\AnalyticsDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $data = $this->analyticsDataRepository->findBy([],['createdAt'=>'DESC']);
        return $this->render('admin/index.html.twig', [
            'data'=>$data
        ]);
    }
}
