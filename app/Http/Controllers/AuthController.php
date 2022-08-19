<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    private $authService;
    private $userRepository;

    public function __construct(AuthService $authService, UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
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
        if (!$request->filled('code')) {
            $title = '422 - Campo(s) inválido(s)';
            $message = 'O parâmetro code é obrigatório!';

            return view('error', compact('title', 'message'));
        }

        $this->authService->setCode($request->code);

        $this->initToken();
        
        if ($this->userRepository->count() <= 0) {            
            $response = $this->authService->createTestUser();
            $response->throw()->json();
            
            $dataUser = [
                'meli_id' => $response['id'],
                'name' => $response['nickname'],
                'email' => $response['nickname'].'@meli.com',
                'password' => $response['password'],
                'meli_status' => $response['site_status']
            ];
            
            $user = $this->userRepository->create($dataUser);
        } else {
            $user = $this->userRepository->lastCreated();

            $dataUser = [
                'meli_id' => $user->meli_id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'meli_status' => $user->meli_status
            ];
        }

        return view('authorized', compact('dataUser'));
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
