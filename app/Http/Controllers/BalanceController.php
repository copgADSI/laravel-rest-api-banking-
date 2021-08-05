<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        } else if ($request->input('type') === 'withdraw') {
            return $this->withdraw(
                $request->input('origin'),
                $request->input('amount'),
            );
        } else if ($request->input('type') === 'transfer') {
            return $this->transfer(
                $request->input('origin'),
                $request->input('amount'),
                $request->input('destination'),
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
        ], 201);
    }

    private function withdraw(int $origin, int $mount)
    {

        $account = Account::findOrFail($origin);
        $account->balance -= $mount;
        $account->save(); //UPDATE

        return response()->json([
            'origin' => [
                'id' => $account->id,
                'balance' => $account->balance,
            ]
        ], 201);
    }

    private function transfer($origin, $amount, $destination)
    {
        $accountOrigin = Account::findOrFail($origin);
        $accountDestination = Account::firstOrCreate([
            'id' => $destination
        ]);

        DB::transaction(function () use ($accountOrigin, $amount, $accountDestination) {

            $accountOrigin->balance -= $amount;
            $accountDestination->balance += $amount;

            $accountOrigin->save();
            $accountDestination->save();
        });
        return response()->json([
            'Origin' => [
                'id' => $accountOrigin->id,
                'balance' =>  $accountOrigin->balance,
            ],
            'Destination' => [
                'id' => $accountDestination->id,
                'balance' => $accountDestination->balance,
            ]
        ], 201);
    }

    public function show(Request $request)
    {
        $account_id = $request->input('account_id');

        $account = Account::findOrFail($account_id);

        return $account->balance;
    }
}
