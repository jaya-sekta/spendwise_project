<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    /**
     * Menampilkan daftar reward.
     */
    public function index()
    {
        $rewards = Reward::where('stock', '>', 0)
            ->paginate(10);

        return view('rewards.index', compact('rewards'));
    }

    /**
     * Menukarkan reward.
     */
    public function redeem(Request $request, Reward $reward)
    {
       /** @var \App\Models\User $user */
$user = Auth::user();
        // 1. Cek stok reward
        if ($reward->stock <= 0) {
            return back()->withErrors([
                'stock' => 'Stok reward habis.'
            ]);
        }

        // 2. Cek apakah user sudah pernah redeem reward ini
        $alreadyRedeemed = UserReward::where('user_id', $user->id)
            ->where('reward_id', $reward->id)
            ->exists();

        if ($alreadyRedeemed) {
            return back()->withErrors([
                'reward' => 'Anda sudah pernah menukarkan reward ini.'
            ]);
        }

        // 3. Cek apakah poin cukup
        if ($user->points < $reward->required_points) {
            return back()->withErrors([
                'points' => 'Poin kamu tidak cukup untuk menukarkan reward ini.'
            ]);
        }

        // 4. Kurangi poin user
        $user->decrement('points', $reward->required_points);

        // 5. Kurangi stok reward
        $reward->decrement('stock');

        // 6. Simpan riwayat penukaran
        UserReward::create([
            'user_id'         => $user->id,
            'reward_id'       => $reward->id,
            'redemption_date' => now(),
            'voucher_code'    => strtoupper(Str::random(10)),
        ]);

        // 7. Redirect ke halaman riwayat
        return redirect()
            ->route('user-rewards.index')
            ->with('success', 'Reward berhasil ditukarkan.');
    }
}
