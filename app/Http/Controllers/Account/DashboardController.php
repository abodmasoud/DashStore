<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('account.index', [
            'user' => $request->user(),
            'orders' => $request->user()->orders()->withCount('items')->latest()->take(10)->get(),
        ]);
    }
}
