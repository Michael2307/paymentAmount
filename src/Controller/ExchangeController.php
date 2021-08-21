<?php

namespace App\Controller;

use App\Services\OpenExchangeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
{
    /**
     * @Route("/", name="paymentAmount")
     * @param Request $request
     * @param OpenExchangeService $openExchangeService
     * @return JsonResponse
     */
    public function getPaymentAmount(Request $request, OpenExchangeService $openExchangeService): JsonResponse
    {
        $openExchangeService->getPaymentAmount($request->getContent());
        if (! empty($openExchangeService->getMessage())) {
            return $this->json($openExchangeService->getMessage());
        }
        return $this->json($openExchangeService->getData());
    }
}
