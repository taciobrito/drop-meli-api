<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthService extends MeliService
{
    private $pathAccessToken;
    private $pathRefreshToken;
    private $code;
    private $accessToken;
    private $refreshToken;

    public function __construct()
    {
        parent::__construct();

        $this->pathAccessToken = env('MELI_PATH_ACCESS_TOKEN', '/token/accessToken.txt');
        $this->pathRefreshToken = env('MELI_PATH_REFRESH_TOKEN', '/token/refreshToken.txt');
    }

    public function createAccessToken()
    {
        if (empty($this->code)) {
            throw new \Exception('Code param is not defined! Get a new authorization code and try again.');
        }

        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->getBaseUrl()}/oauth/token", [
                'grant_type' => 'authorization_code',
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getClientSecret(),
                'code' => $this->code,
                'redirect_uri' => $this->getRedirectUri()
            ]);

        return $response;
    }

    public function refreshAccessToken()
    {
        if (empty($this->refreshToken)) {
            throw new \Exception('You can\'t refresh token! Get a new authorization code and try again.');
        }

        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->getBaseUrl()}/oauth/token", [
                'grant_type' => 'refresh_token',
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getClientSecret(),
                'refresh_token' => $this->refreshToken
            ]);

        return $response;
    }

    public function getPathAccessToken()
    {
        return $this->pathAccessToken;
    }

    public function getPathRefreshToken()
    {
        return $this->pathRefreshToken;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function getHeaders()
    {
        return [
            'accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
    }

    public function getHeadersWithToken()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. $this->accessToken
        ];
    }

    public function createTestUser()
    {
        return Http::withHeaders($this->getHeadersWithToken())
            ->post("{$this->getBaseUrl()}/users/test_user", [
                'site_id' => 'MLB'
            ]);
    }

    public function getCurrentUser()
    {
        return Http::withHeaders($this->getHeadersWithToken())
            ->get("{$this->getBaseUrl()}/users/me");
    }
}
