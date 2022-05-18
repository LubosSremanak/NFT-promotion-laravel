<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectRequest;
use App\Http\Requests\SignRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{

    public function logout(): Response|Application|ResponseFactory
    {
        $userModel = new User();
        $userModel->deleteUserToken();
        $response = [
            'message' => 'User logged out',
        ];

        return response($response, 201);
    }

    public function isConnected(): Response|Application|ResponseFactory
    {
        $userModel = new User();
        $state = $userModel->isConnected();
        $response = [
            'isConnected' => $state,
        ];

        return response($response, 201);
    }

    /**
     * @throws Exception
     */
    public function connect(ConnectRequest $request): Response|Application|ResponseFactory
    {
        $validatedRequest = $request->validated();
        $userModel = new User();
        $user = $userModel->findUserByKey($validatedRequest['address']);
        $nonce = $this->generateNonce();
        if ($user) {
            $nonce = $user->get('nonce')[0]['nonce'];
        } else {
            $userModel->createUser($nonce, $validatedRequest);
        }
        $response = [
            'message' => 'Sign request',
            'nonce' => $nonce,
        ];
        return response($response, 201);

    }

    /**
     * @throws Exception
     */
    public function disconnect(): Response|Application|ResponseFactory
    {
        $userModel = new User();
        $userModel->deleteUserToken();
        $response = [
            'message' => 'Sign out',
        ];
        return response($response, 201);

    }


    /**
     * @throws Exception
     */
    private function generateNonce(): string
    {
        $bytes = random_bytes(20);
        return bin2hex($bytes);
    }

    /**
     * @throws Exception
     */
    public function sign(SignRequest $request): Response|Application|ResponseFactory
    {
        $validatedRequest = $request->validated();
        $address = $validatedRequest['address'];
        $signature = $validatedRequest['signature'];
        $userModel = new User();
        $user = $userModel->findUserByKey($address);
        if (!$user) {
            return response([], 401);
        }
        $nonce = $user->get('nonce')[0]['nonce'];
        $valid = VerificationController::verifySignature($nonce, $signature, $address);
        if (!$valid) {
            return response([], 401);
        }
        $token = $user->createToken('jwttoken')->plainTextToken;
        $response = [
            'user' => $user['name'],
            'token' => $token,
            'message' => 'Success',
        ];
        $nonce = $this->generateNonce();
        $userModel->updateNonce($address, $nonce);
        return response($response, 201);
    }
}
