<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabana;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CabanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabanas = Cabana::withCount(['bookings'])
            ->orderBy('name')
            ->get();

        return view('admin.cabanas.index', compact('cabanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cabanas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cabanas,name',
            'description' => 'nullable|string',
            'price_daily' => 'required|numeric|min:0',
            'price_overnight' => 'nullable|numeric|min:0',
            'max_pax' => 'required|integer|min:1|max:50',
            'allow_overnight' => 'boolean',
            'features' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Generate slug from name
        $data['slug'] = Str::slug($request->name);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cabanas', 'public');
            $data['image'] = $imagePath;
        }

        // Convert features array to JSON
        if ($request->has('features')) {
            $data['features'] = json_encode($request->features);
        }

        // Convert boolean
        $data['allow_overnight'] = $request->has('allow_overnight');

        Cabana::create($data);

        return redirect()->route('admin.cabanas.index')
            ->with('success', 'Cabana created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabana $cabana)
    {
        $cabana->loadCount(['bookings']);
        return view('admin.cabanas.show', compact('cabana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabana $cabana)
    {
        return view('admin.cabanas.edit', compact('cabana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabana $cabana)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cabanas,name,' . $cabana->id,
            'description' => 'nullable|string',
            'price_daily' => 'required|numeric|min:0',
            'price_overnight' => 'nullable|numeric|min:0',
            'max_pax' => 'required|integer|min:1|max:50',
            'allow_overnight' => 'boolean',
            'features' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Generate slug from name
        $data['slug'] = Str::slug($request->name);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($cabana->image && Storage::disk('public')->exists($cabana->image)) {
                Storage::disk('public')->delete($cabana->image);
            }
            
            $imagePath = $request->file('image')->store('cabanas', 'public');
            $data['image'] = $imagePath;
        }

        // Convert features array to JSON
        if ($request->has('features')) {
            $data['features'] = json_encode($request->features);
        }

        // Convert boolean
        $data['allow_overnight'] = $request->has('allow_overnight');

        $cabana->update($data);

        return redirect()->route('admin.cabanas.index')
            ->with('success', 'Cabana updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabana $cabana)
    {
        // Check if cabana has bookings
        if ($cabana->bookings()->count() > 0) {
            return redirect()->route('admin.cabanas.index')
                ->with('error', 'Cannot delete cabana with existing bookings. Please cancel or complete all bookings first.');
        }

        // Delete image if exists
        if ($cabana->image && Storage::disk('public')->exists($cabana->image)) {
            Storage::disk('public')->delete($cabana->image);
        }

        $cabana->delete();

        return redirect()->route('admin.cabanas.index')
            ->with('success', 'Cabana deleted successfully!');
    }
}
