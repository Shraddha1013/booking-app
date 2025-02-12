<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

class BookingController extends Controller
{
    public function store(BookingRequest $request) : RedirectResponse
    {
        $validatedData = $request->validated();

        if ($this->isDuplicateBooking($validatedData)) {
            return redirect()->back()->withErrors(['duplicate' => 'This booking conflicts with an existing booking.'])->withInput();
        }

        Booking::create($validatedData);

        return redirect()->route('booking')->with('success', 'Booking created successfully.');
    }

    private function isDuplicateBooking(array $validatedData) : bool
    {
        $bookingDate = $validatedData['booking_date'];
        $bookingType = $validatedData['booking_type'];
        $bookingSlot = $validatedData['booking_slot'] ?? null;
        $bookingFromTime = isset($validatedData['booking_from_time']) ? new DateTime($validatedData['booking_from_time']) : null;
        $bookingToTime = isset($validatedData['booking_to_time']) ? new DateTime($validatedData['booking_to_time']) : null;

        $existingBookings = Booking::where('booking_date', $bookingDate)->get();

        foreach ($existingBookings as $booking) {
            $existingType = $booking->booking_type;
            $existingSlot = $booking->booking_slot;
            $existingFromTime = $booking->booking_from_time ? new DateTime($booking->booking_from_time) : null;
            $existingToTime = $booking->booking_to_time ? new DateTime($booking->booking_to_time) : null;

            if ($existingType === 'Full Day' || $bookingType === 'Full Day') {
                return true;
            }

            if ($existingType === 'Half Day' && $bookingType === 'Half Day' && $existingSlot === $bookingSlot) {
                return true;
            }

            if ($existingType === 'Half Day' && $bookingType === 'Custom') {
                if ($existingSlot === 'First Half' && ($bookingFromTime < $existingToTime || $bookingFromTime < new DateTime('12:00'))) {
                    return true;
                }

                if ($existingSlot === 'Second Half' && $bookingToTime > $existingFromTime) {
                    return true;
                }
            }

            if ($existingType === 'Custom' && $bookingType === 'Half Day') {
                if ($bookingSlot === 'First Half' && ($existingToTime > $bookingFromTime || $existingFromTime < new DateTime('12:00'))) {
                    return true;
                }

                if ($bookingSlot === 'Second Half' && $existingFromTime < $bookingToTime) {
                    return true;
                }
            }

            if ($existingType === 'Custom' && $bookingType === 'Custom') {
                if ($this->isTimeOverlap($existingFromTime, $existingToTime, $bookingFromTime, $bookingToTime)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isTimeOverlap(?DateTimeInterface $existingFrom, ?DateTimeInterface $existingTo, ?DateTimeInterface $newFrom, ?DateTimeInterface $newTo): bool
    {
        if (!$existingFrom || !$existingTo || !$newFrom || !$newTo) {
            return false;
        }

        if ($existingFrom >= $existingTo || $newFrom >= $newTo) {
            throw new InvalidArgumentException('Start time must be before end time.');
        }

        return $newFrom < $existingTo && $existingFrom < $newTo;
    }
}

