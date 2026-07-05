<?php
// app/Http/Controllers/RewardController.php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::where('stock', '>', 0)->paginate(10);

        return view('rewards.index', compact('rewards'));
    }

    public function redeem(Request $request, Reward $reward)
    {
        if ($reward->stock <= 0) {
            return back()->withErrors(['stock' => 'Stok reward habis.']);
        }

        // Cek apakah user sudah pernah redeem reward ini
        $alreadyRedeemed = UserReward::where('user_id', Auth::id())
            ->where('reward_id', $reward->id)
            ->exists();

        if ($alreadyRedeemed) {
            return back()->withErrors(['reward' => 'Anda sudah menukarkan reward ini.']);
        }

        // Buat user reward & kurangi stok
        UserReward::create([
            'user_id'         => Auth::id(),
            'reward_id'       => $reward->id,
            'redemption_date' => now(),
            'voucher_code'    => strtoupper(Str::random(10)),
        ]);

        $reward->decrement('stock');

        return redirect()->route('user-rewards.index')->with('success', 'Reward berhasil ditukarkan.');
    }
}