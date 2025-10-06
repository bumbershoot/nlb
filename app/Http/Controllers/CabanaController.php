<?php

namespace App\Http\Controllers;

use App\Models\Cabana;
use Illuminate\Http\Request;


class CabanaController extends Controller
{
    // Show home page with cabanas
    public function home()
    {
        // Fetch all cabanas from database
        $cabanas = Cabana::all();

        // Pass $cabanas to the home view
        return view('home', compact('cabanas'));
    }

    // Show all cabanas on dedicated cabanas page
    public function index()
    {
        // Fetch all cabanas from database
        $cabanas = Cabana::all();

        // Pass $cabanas to the cabanas index view
        return view('cabanas.index', compact('cabanas'));
    }

    // Show single cabana details
    public function show(Cabana $cabana)
    {
        return view('cabanas.show', compact('cabana'));
    }
}

