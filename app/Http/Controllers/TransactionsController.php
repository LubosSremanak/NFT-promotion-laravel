<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    public function createTransaction(TransactionRequest $request): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    public function editTransaction(TransactionRequest $request): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

}
