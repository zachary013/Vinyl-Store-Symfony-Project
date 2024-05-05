<?php
// src/Service/PayPalService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PayPalService
{
    private HttpClientInterface $httpClient;
    private string $clientId;
    private string $clientSecret;
    private string $apiUrl;

    public function __construct(HttpClientInterface $httpClient, string $clientId, string $clientSecret, string $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiUrl = $apiUrl;
    }

    public function getAccessToken(): ?string
    {
        $response = $this->httpClient->request('POST', $this->apiUrl . '/v1/oauth2/token', [
            'auth_basic' => [$this->clientId, $this->clientSecret],
            'body' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = $response->toArray();

        return $data['access_token'] ?? null;
    }
}
