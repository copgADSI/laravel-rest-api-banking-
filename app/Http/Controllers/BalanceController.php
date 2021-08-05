<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __invoke()
    {
    }

    public function store(Request $request)
    {
        if ($request->input('type') === 'deposit') {
            return $this->deposit(
                $request->input('destination'),
                $request->input('amount')
            );
        }
    }

    private function deposit($destination, $amount)
    {

        $account = Account::firstOrCreate([
            'id' => $destination
        ]);
        $account->balance += $amount;
        $account->save(); //UPDATE

        return response()->json([
            'destination' => [
                'id' => $account->id,
                'balance' =>  $account->balance,
            ]
        ]);
    }
    public function show(Request $request)
    {
        $account_id = $request->input('account_id');

        $account = Account::findOrFail($account_id);

        return $account->balance;
    }
}
