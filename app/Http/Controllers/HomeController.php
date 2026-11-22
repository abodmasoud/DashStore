<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'featured' => Product::active()->featured()->with('category')->latest()->take(8)->get(),
        ]);
    }
}
