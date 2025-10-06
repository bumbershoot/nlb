<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    /**
     * Display a listing of amenities.
     */
    public function index()
    {
        $amenities = Amenity::where('is_active', true)->get();
        return view('amenities.index', compact('amenities'));
    }

    /**
     * Display the specified amenity.
     */
    public function show(Amenity $amenity)
    {
        return view('amenities.show', compact('amenity'));
    }
}