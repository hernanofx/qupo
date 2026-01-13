<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'starts_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $user = $request->user();
        $service = Service::findOrFail($data['service_id']);

        $starts = Carbon::createFromFormat('Y-m-d H:i:s', $data['starts_at']);
        $ends = $starts->copy()->addMinutes($service->duration_min);

        // Check overlapping bookings for same service
        $overlap = Booking::where('service_id', $service->id)
            ->where(function ($q) use ($starts, $ends) {
                $q->whereBetween('starts_at', [$starts, $ends])
                  ->orWhereBetween('ends_at', [$starts, $ends])
                  ->orWhere(function ($q2) use ($starts, $ends) {
                      $q2->where('starts_at', '<', $starts)->where('ends_at', '>', $ends);
                  });
            })->exists();

        if ($overlap) {
            return response()->json(['message' => 'Slot not available'], 409);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'merchant_id' => $service->merchant_id,
            'service_id' => $service->id,
            'starts_at' => $starts,
            'ends_at' => $ends,
            'status' => 'pending',
            'price_cents' => $service->price_cents,
        ]);

        return response()->json($booking, 201);
    }
}
