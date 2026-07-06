<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteLog;
use App\Models\User;
use Illuminate\Http\Request;

class RouteLogController extends Controller
{
    public function index(Request $request)
    {
        $query = RouteLog::with('user')->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $logs  = $query->paginate(25)->withQueryString();
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.logger', compact('logs', 'users'));
    }
}