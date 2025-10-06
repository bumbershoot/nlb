<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cabana;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['cabana', 'amenity', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the booking form
     */
    public function bookingForm()
    {
        $cabanas = \App\Models\Cabana::all(); // fetch all cabanas
        return view('pages.booking_form', compact('cabanas'));
    }

    /**
     * Show the amenity booking form
     */
    public function amenityBookingForm()
    {
        $amenities = Amenity::where('is_active', true)->get();
        return view('pages.amenity_booking_form', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Determine booking type and validate accordingly
        if ($request->has('cabana_id')) {
            $request->validate([
                'cabana_id' => 'required|exists:cabanas,id',
                'check_in'  => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in',
                'check_in_time' => 'nullable|date_format:H:i',
                'check_out_time' => 'nullable|date_format:H:i',
                'name'      => 'required|string|max:255',
                'phone'     => 'required|string|max:20',
                'email'     => 'required|email|max:255',
                'pax'       => 'required|integer|min:1',
            ]);

            $cabana = Cabana::findOrFail($request->cabana_id);
            $from = \Carbon\Carbon::parse($request->check_in);
            $to   = \Carbon\Carbon::parse($request->check_out);

            // Check availability
            $overlap = Booking::where('cabana_id', $cabana->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($from, $to) {
                    $q->whereBetween('date_from', [$from, $to])
                      ->orWhereBetween('date_to', [$from, $to])
                      ->orWhere(function ($qq) use ($from, $to) {
                          $qq->where('date_from', '<=', $from)
                             ->where('date_to', '>=', $to);
                      });
                })->exists();

            if ($overlap) {
                return back()->withErrors(['error' => 'Sorry, this cabana is not available on selected dates.']);
            }

            // Calculate total price
            $nights = $from->diffInDays($to);
            $total = $cabana->price_daily * $nights;

            $booking = Booking::create([
                'user_id' => Auth::id() ?? null, // Allow null for guest bookings
                'cabana_id' => $cabana->id,
                'booking_type' => 'cabana',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_from' => $from->toDateString(),
                'date_to' => $to->toDateString(),
                'check_in_time' => $request->check_in_time ?: '15:00:00',
                'check_out_time' => $request->check_out_time ?: '11:00:00',
                'pax' => $request->pax,
                'total_price' => $total,
                'status' => 'pending',
            ]);

        } elseif ($request->has('amenity_id')) {
            $request->validate([
                'amenity_id' => 'required|exists:amenities,id',
                'check_in'  => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in',
                'check_in_time' => 'nullable|date_format:H:i',
                'check_out_time' => 'nullable|date_format:H:i',
                'name'      => 'required|string|max:255',
                'phone'     => 'required|string|max:20',
                'email'     => 'required|email|max:255',
                'pax'       => 'required|integer|min:1',
            ]);

            $amenity = Amenity::findOrFail($request->amenity_id);
            $from = \Carbon\Carbon::parse($request->check_in);
            $to   = \Carbon\Carbon::parse($request->check_out);
            $checkInTime = \Carbon\Carbon::parse($request->check_in_time ?: '09:00');
            $checkOutTime = \Carbon\Carbon::parse($request->check_out_time ?: '17:00');

            // Check if booking time is within operating hours
            $operatingStart = \Carbon\Carbon::parse($amenity->operating_hours_start);
            $operatingEnd = \Carbon\Carbon::parse($amenity->operating_hours_end);
            
            if ($checkInTime->lt($operatingStart) || $checkInTime->gt($operatingEnd)) {
                return back()->withErrors(['error' => 'Check-in time must be within operating hours (' . $amenity->operating_hours_start . ' - ' . $amenity->operating_hours_end . ').']);
            }

            if ($checkOutTime->lt($operatingStart) || $checkOutTime->gt($operatingEnd)) {
                return back()->withErrors(['error' => 'Check-out time must be within operating hours (' . $amenity->operating_hours_start . ' - ' . $amenity->operating_hours_end . ').']);
            }

            // Check availability (for amenities, we check date range and time overlap)
            $overlap = Booking::where('amenity_id', $amenity->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($q) use ($from, $to, $checkInTime, $checkOutTime) {
                    $q->whereBetween('date_from', [$from, $to])
                      ->orWhereBetween('date_to', [$from, $to])
                      ->orWhere(function ($qq) use ($from, $to) {
                          $qq->where('date_from', '<=', $from)
                             ->where('date_to', '>=', $to);
                      });
                })->where(function ($q) use ($checkInTime, $checkOutTime) {
                    $q->whereBetween('check_in_time', [$checkInTime->format('H:i:s'), $checkOutTime->format('H:i:s')])
                      ->orWhereBetween('check_out_time', [$checkInTime->format('H:i:s'), $checkOutTime->format('H:i:s')])
                      ->orWhere(function ($qq) use ($checkInTime, $checkOutTime) {
                          $qq->where('check_in_time', '<=', $checkInTime->format('H:i:s'))
                             ->where('check_out_time', '>=', $checkOutTime->format('H:i:s'));
                      });
                })->exists();

            if ($overlap) {
                return back()->withErrors(['error' => 'Sorry, this amenity is not available on selected dates and times.']);
            }

            // Calculate total price based on duration
            $nights = $from->diffInDays($to);
            $total = $amenity->price_per_booking * ($nights + 1); // +1 to include both start and end days

            $booking = Booking::create([
                'user_id' => Auth::id() ?? null, // Allow null for guest bookings
                'amenity_id' => $amenity->id,
                'booking_type' => 'amenity',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_from' => $from->toDateString(),
                'date_to' => $to->toDateString(),
                'check_in_time' => $checkInTime->format('H:i:s'),
                'check_out_time' => $checkOutTime->format('H:i:s'),
                'pax' => $request->pax,
                'total_price' => $total,
                'status' => 'pending',
            ]);
        } else {
            return back()->withErrors(['error' => 'Invalid booking request.']);
        }

        return redirect()->route('bookings.show', $booking->id)
                         ->with('success', 'Booking created! Please complete payment.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
