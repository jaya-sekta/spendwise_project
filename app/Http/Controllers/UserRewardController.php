<?php
// app/Http/Controllers/UserRewardController.php

namespace App\Http\Controllers;

use App\Models\UserReward;
use Illuminate\Support\Facades\Auth;

class UserRewardController extends Controller
{
    public function index()
    {
        $userRewards = UserReward::with('reward')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user-rewards.index', compact('userRewards'));
    }
}