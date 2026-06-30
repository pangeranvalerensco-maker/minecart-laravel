<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
                                         ->orderBy('created_at', 'desc')
                                         ->paginate(10, ['*'], 'tx_page');
                                         
        $withdrawals = Withdrawal::where('user_id', auth()->id())
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10, ['*'], 'wd_page');

        return view('seller.wallet.index', compact('wallet', 'transactions', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        DB::transaction(function () use ($request, $wallet) {
            $wallet->balance -= $request->amount;
            $wallet->save();

            $withdrawal = Withdrawal::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending',
            ]);

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $request->amount,
                'description' => 'Penarikan dana (Withdrawal)',
                'reference_id' => $withdrawal->id,
            ]);
        });

        return back()->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses.');
    }
}
