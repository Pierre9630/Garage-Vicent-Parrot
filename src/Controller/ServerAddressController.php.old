<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ServerAddressController
{
    #[Route('/serveraddress', name: 'app_serveraddress_index', methods: ['GET','POST'])]
    public function getServerAddress(Request $request): JsonResponse
    {
        $serverAddress = $request->getSchemeAndHttpHost();

        return new JsonResponse(['serverAddress' => $serverAddress]);
    }
}