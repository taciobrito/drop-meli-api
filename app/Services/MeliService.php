<?php

namespace App\Services;

class MeliService
{
    private $baseUrl;
    private $authUrl;
    private $redirectUri;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->baseUrl = env('MELI_BASE_URL');
        $this->authUrl = env('MELI_AUTH_URL');
        $this->redirectUri = env('MELI_REDIRECT_URI');
        $this->clientId = env('MELI_CLIENT_ID');
        $this->clientSecret = env('MELI_CLIENT_SECRET');
    }

    public function getAuthUrl()
    {
        return $this->authUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getClientId()
    {
        return $this->clientId;
    }
    
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getRedirectUri()
    {
        return url($this->redirectUri);
    }
}
