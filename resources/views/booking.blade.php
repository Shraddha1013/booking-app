<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @include('layouts.alerts')


                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                            <div>
                                <x-input-label for="customer_name" :value="__('Customer Name:')" />
                                <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name" :value="old('customer_name')" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="customer_email" :value="__('Customer Email:')" />
                                <x-text-input id="customer_email" class="block mt-1 w-full" type="email" name="customer_email" :value="old('customer_email')" required />
                                <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                            </div>
    
                            <div class="mt-4">
                                <x-input-label for="booking_date" :value="__('Booking Date:')" />
                                <x-text-input id="booking_date" class="block mt-1 w-full" type="text" name="booking_date" :value="old('booking_date')" min="{{ date('Y-m-d') }}" required />
                                <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                            </div>
    
                            <div class="mt-4">
                                <x-input-label for="booking_type" :value="__('Booking Type:')" />
                                <select id="booking_type" name="booking_type" class="block mt-1 w-full" required>
                                    <option value="Full Day">Full Day</option>
                                    <option value="Half Day">Half Day</option>
                                    <option value="Custom">Custom</option>
                                </select>
                                <x-input-error :messages="$errors->get('booking_type')" class="mt-2" />
                            </div>
    
                            <div id="booking_slot_container" class="mt-4" style="display: none;">
                                <x-input-label for="booking_slot" :value="__('Booking Slot:')" />
                                <select id="booking_slot" name="booking_slot" class="block mt-1 w-full">
                                    <option value="First Half">First Half</option>
                                    <option value="Second Half">Second Half</option>
                                </select>
                                <x-input-error :messages="$errors->get('booking_slot')" class="mt-2" />
                            </div>
    
                            <div id="booking_time_container" class="mt-4" style="display: none;">
                                <x-input-label for="booking_from_time" :value="__('Booking From Time:')" />
                                <x-text-input id="booking_from_time" class="block mt-1 w-full" type="time" name="booking_from_time" />
                                <x-input-error :messages="$errors->get('booking_from_time')" class="mt-2" />
    
                                <x-input-label for="booking_to_time" :value="__('Booking To Time:')" class="mt-4" />
                                <x-text-input id="booking_to_time" class="block mt-1 w-full" type="time" name="booking_to_time" />
                                <x-input-error :messages="$errors->get('booking_to_time')" class="mt-2" />
                            </div>
    
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Submit') }}
                                </x-primary-button>
                            </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(function() {
        $("#ui-datepicker-div").hide();
        if (!$("#booking_date").hasClass("hasDatepicker")) {
            
            $("#booking_date").datepicker({
                minDate: 0 // Disables past dates
            });
        }
    });

    document.getElementById('booking_type').addEventListener('change', function () {
        var bookingType = this.value;
        var slotContainer = document.getElementById('booking_slot_container');
        var timeContainer = document.getElementById('booking_time_container');

        if (bookingType === 'Half Day') {
            slotContainer.style.display = 'block';
            timeContainer.style.display = 'none';
        } else if (bookingType === 'Custom') {
            slotContainer.style.display = 'none';
            timeContainer.style.display = 'block';
        } else {
            slotContainer.style.display = 'none';
            timeContainer.style.display = 'none';
        }
    });
</script>
