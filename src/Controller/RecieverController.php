<?php

namespace App\Controller;

use App\Entity\AnalyticsData;
use App\Repository\AnalyticsDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecieverController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface  $entityManager,
        private ParameterBagInterface   $parameterBag,
        private AnalyticsDataRepository $analyticsDataRepository,
    )
    {
    }

    #[Route('/analytics', name: 'app_reciever', methods: 'POST')]
    public function index(Request $request): Response
    {
        $data = $request->get('data');
        $dataEncodedd = json_decode($data,true);
        $ip = $request->getClientIp();
        $lastData = $this->analyticsDataRepository->findDataFromIPFromLastHour($ip);
        if (count($lastData) === 0 && $dataEncodedd['data']=== 'jitsi-admin') {
            $analytics = new AnalyticsData();
            $analytics->setData($data);
            $analytics->setIp($ip);
            $analytics->setCreatedAt(new \DateTime());
            $this->entityManager->persist($analytics);
            $this->entityManager->flush();
            return new JsonResponse(['error' => false]);
        }

        return new JsonResponse(['error' => true]);

    }
}
