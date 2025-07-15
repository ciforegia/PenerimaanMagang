<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $direktorats = Direktorat::with(['subDirektorats.divisis'])->get();
        return view('home', compact('direktorats'));
    }

    /**
     * Display the about us page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the internship program page.
     */
    public function program()
    {
        $direktorats = Direktorat::with(['subDirektorats.divisis'])->get();
        return view('program', compact('direktorats'));
    }
}
