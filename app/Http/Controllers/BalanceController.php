<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __invoke()
    {
    }

    public function show(Request $request)
    {
        $account_id = $request->input('account_id');

        $account = Account::findOrFail($account_id);

        return $account->balance;
    }
}
