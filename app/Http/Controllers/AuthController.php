<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authorization()
    {
        $link = $this->authService->getAuthUrl() . '/authorization?'. http_build_query([
            'response_type' => 'code',
            'client_id' => $this->authService->getClientId(),
            'redirect_uri' => $this->authService->getRedirectUri()
        ]);

        return view('authorization', compact('link'));
    }

    public function redirect(Request $request)
    {
        dd($request->all());

        if (!$request->filled('code')) {
            abort(422, 'O parâmetro code é obrigatório!');
        }

        $this->authService->setCode($request->code);

        $this->initToken();
    }

    private function initToken()
    {
        if (!$this->hasToken() || !$this->tokenIsValid()) {
            $response = $this->authService->createAccessToken();
            $response->throw()->json();
            $this->storeToken($response['access_token']);
        }
    }

    private function storeToken($token) {
        Storage::disk('local')->put($this->authService->getPathAccessToken(), $token);
        $this->authService->setAccessToken($token);
    }

    private function hasToken() {
        if (Storage::disk('local')->exists($this->authService->getPathAccessToken())) {
            $this->authService->setAccessToken(Storage::disk('local')->get($this->authService->getPathAccessToken()));
            return true;
        }

        return false;
    }

    private function storeRefreshToken($token) {
        Storage::disk('local')->put($this->authService->getPathRefreshToken(), $token);
        $this->authService->setRefreshToken($token);
    }

    private function hasRefreshToken() {
        if (Storage::disk('local')->exists($this->authService->getPathRefreshToken())) {
            $this->authService->setRefreshToken(Storage::disk('local')->get($this->authService->getPathRefreshToken()));
            return true;
        }

        return false;
    }

    private function tokenIsValid() {
        $response = $this->authService->getCurrentUser();
        return $response->offsetExists('id');
    }
}
