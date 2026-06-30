<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        
        // Asumsi platform revenue dari setting atau wallet khusus? 
        // Untuk sekarang kita hitung dari total pesanan (misal komisi 5%)
        // Tapi komisi bisa berubah-ubah, lebih baik jika kita simpan platform_fee di orders.
        // Karena belum ada, kita tampilkan estimasi atau hitung dari WalletTransaction yg masuk ke superadmin?
        // Untuk simpelnya, kita hitung total GTV (Gross Transaction Value)
        $totalGTV = Order::where('status', 'completed')->sum('total');

        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'totalGTV'));
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Cannot change superadmin status.');
        }

        $user->status = $user->status === 'active' ? 'blocked' : 'active';
        $user->save();

        return back()->with('success', "User status updated to {$user->status}.");
    }

    public function settings()
    {
        $commission = Setting::where('key', 'platform_commission')->first();
        return view('admin.settings.index', compact('commission'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'platform_commission' => 'required|numeric|min:0|max:100',
        ]);

        Setting::updateOrCreate(
            ['key' => 'platform_commission'],
            ['value' => $request->platform_commission]
        );

        return back()->with('success', 'Settings updated successfully.');
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function processWithdrawal(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal is already processed.');
        }

        DB::transaction(function () use ($request, $withdrawal) {
            $withdrawal->status = $request->status;
            $withdrawal->processed_at = now();
            $withdrawal->save();

            if ($request->status === 'rejected') {
                // Refund to wallet
                $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();
                $wallet->balance += $withdrawal->amount;
                $wallet->save();

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'credit',
                    'amount' => $withdrawal->amount,
                    'description' => 'Refund for rejected withdrawal',
                    'reference_id' => $withdrawal->id,
                ]);
            }
        });

        return back()->with('success', "Withdrawal has been {$request->status}.");
    }
}
