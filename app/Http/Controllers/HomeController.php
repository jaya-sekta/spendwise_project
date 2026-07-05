<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.rewards.index');
        }

        return redirect()->route('dashboard');
    }
}