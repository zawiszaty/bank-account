<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    public function create(): Response
    {
        $account          = new Account();
        $account->balance = 200.0;
        $account->save();

        return Response::create('ok', Response::HTTP_OK);
    }

    public function addToBalance(Request $request, Account $account): JsonResponse
    {
        $amount           = $request->json('amount');
        $account->balance += $amount;
        $account->save();

        return JsonResponse::create('ok', Response::HTTP_OK);
    }

    public function withdraw(Request $request, Account $account): JsonResponse
    {
        $account->balance -= $request->json('amount');

        if ($account->balance < 0)
        {
            return JsonResponse::create('You dont have enough money', Response::HTTP_BAD_REQUEST);
        }
        $account->save();

        return JsonResponse::create('ok', Response::HTTP_OK);
    }

    public function getAccounts(): JsonResponse
    {
        $accounts = Account::all();

        return JsonResponse::create($accounts, Response::HTTP_OK);
    }

    public function getAccount(Account $account): JsonResponse
    {
        return JsonResponse::create($account, Response::HTTP_OK);
    }
}
