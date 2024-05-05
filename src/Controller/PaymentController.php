<?php

// src/Controller/PaymentController.php

namespace App\Controller;

use App\Service\PayPalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function makePayment(PayPalService $paypalService): Response
    {
        $accessToken = $paypalService->getAccessToken();

        if (!$accessToken) {
            throw new \Exception('Failed to obtain access token.');
        }

        // Implement payment logic using PayPal API (e.g., create order, capture payment)

        return $this->render('payment/success.html.twig', [
            'message' => 'Payment successful!',
        ]);
    }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }
}
