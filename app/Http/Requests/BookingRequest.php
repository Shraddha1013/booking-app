<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;


class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:Full Day,Half Day,Custom',
            'booking_slot' => 'nullable|in:First Half,Second Half',
            'booking_from_time' => 'nullable|date_format:H:i',
            'booking_to_time' => 'nullable|date_format:H:i|after:booking_from_time',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        if (isset($validated['booking_date'])) {
            $validated['booking_date'] = Carbon::createFromFormat('m/d/Y', $validated['booking_date'])->format('Y-m-d');
        }

        return $validated;
    }
    
}
