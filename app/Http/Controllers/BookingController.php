<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
      // ✅ Public booking creation (no auth)
public function store(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string',
        'email' => 'required|email', // ✅ Removed uniqueness constraint
        'from_date' => 'required|date|after_or_equal:today',
        'to_date' => 'required|date|after_or_equal:from_date',
        'service_ids' => 'required|array|min:1',
        'service_ids.*' => 'exists:services,service_id',
    ]);

    $booking = Booking::create([
        'full_name' => $validated['full_name'],
        'email' => $validated['email'],
        'from_date' => $validated['from_date'],
        'to_date' => $validated['to_date'],
        'status' => 'pending',
    ]);

    $booking->services()->attach($validated['service_ids']);

    $totalNights = Carbon::parse($booking->from_date)->diffInDays(Carbon::parse($booking->to_date));

    return response()->json([
        'message' => 'Booking successfully submitted',
        'booking_reference' => $booking->booking_reference,
        'booking' => [
            'booking_id' => $booking->booking_id,
            'full_name' => $booking->full_name,
            'email' => $booking->email,
            'status' => $booking->status,
            'booking_reference' => $booking->booking_reference,
            'from_date' => $booking->from_date,
            'to_date' => $booking->to_date,
            'total_nights' => $totalNights,
            'services' => $booking->services->map(function ($service) {
                return [
                    'service_id' => $service->service_id,
                    'name' => $service->name
                ];
            })
        ]
    ]);
}

    // ✅ Public booking search by email (no auth)
   public function searchByEmail($email)
{
    $bookings = Booking::where('email', $email)
        ->with('services')
        ->get();

    if ($bookings->isEmpty()) {
        return response()->json([
            'message' => 'No bookings found for this email.'
        ], 404);
    }

    $formattedBookings = $bookings->map(function ($booking) {
        $totalNights = Carbon::parse($booking->from_date)->diffInDays(Carbon::parse($booking->to_date));

        return [
            'booking_id' => $booking->booking_id,
            'full_name' => $booking->full_name,
            'email' => $booking->email,
            'status' => $booking->status,
            'booking_reference' => $booking->booking_reference,
            'from_date' => $booking->from_date,
            'to_date' => $booking->to_date,
            'total_nights' => $totalNights,
            'services' => $booking->services->map(function ($service) {
                return [
                    'service_id' => $service->service_id,
                    'name' => $service->name
                ];
            })
        ];
    });

    return response()->json([
        'message' => 'Bookings retrieved successfully',
        'bookings' => $formattedBookings
    ]);
}

// 🔐 List all bookings
public function adminIndex()
{
    return response()->json([
        'message' => 'All bookings retrieved successfully',
        'bookings' => Booking::with('services')->get()
    ]);
}

// 🔐 List bookings by status
public function listByStatus($status)
{
    $validStatuses = ['pending', 'approved', 'declined'];

    if (!in_array($status, $validStatuses)) {
        return response()->json([
            'message' => 'Invalid status type'
        ], 400);
    }

    $bookings = Booking::with('services')->where('status', $status)->get();

    return response()->json([
        'message' => ucfirst($status) . ' bookings retrieved successfully',
        'bookings' => $bookings
    ]);
}

// 🔐 Approve booking
public function approveBooking($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'approved';
    $booking->save();

    return response()->json([
        'message' => 'Booking approved successfully',
        'booking' => $booking
    ]);
}

// 🔐 Decline booking
public function declineBooking($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'declined';
    $booking->save();

    return response()->json([
        'message' => 'Booking declined successfully',
        'booking' => $booking
    ]);
}

// 🔐 Get active bookings (currently: approved)
public function listActiveBookings()
{
    $bookings = Booking::with('services')
        ->where('status', 'approved')
        ->get();

    return response()->json([
        'message' => 'Active bookings retrieved successfully',
        'bookings' => $bookings
    ]);
}


}
