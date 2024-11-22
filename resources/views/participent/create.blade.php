@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Participant</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="participentForm" action="{{ route('participent.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="name-error"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="password-error"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="password_confirmation-error"></div>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
                @error('mobile')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="mobile-error"></div>
            </div>

            <div class="form-group">
                <label for="state_id">State</label>
                <select class="form-control" id="state_id" name="state_id">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                </select>
                @error('state_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="state_id-error"></div>
            </div>

            <div class="form-group">
                <label for="city_id">City</label>
                <select class="form-control" id="city_id" name="city_id">
                    <option value="">Select City</option>
                    @if (old('state_id'))
                        <!-- Empty initially; cities will be loaded based on the selected state -->
                    @endif
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="city_id-error"></div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="address-error"></div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms"
                    {{ old('terms') ? 'checked' : '' }}>
                <label class="form-check-label" for="terms">I accept the terms and conditions</label>
                <div class="text-danger" id="terms-error"></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#state_id').on('change', function() {
                    let stateId = $(this).val();
                    if (stateId) {
                        $.ajax({
                            url: `/get-cities/${stateId}`,
                            method: 'GET',
                            success: function(data) {
                                let citySelect = $('#city_id');
                                citySelect.empty();
                                citySelect.append('<option value="">Select City</option>');

                                $.each(data.cities, function(index, city) {
                                    citySelect.append($('<option>', {
                                        value: city.id,
                                        text: city.name
                                    }));
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching cities:', error);
                            }
                        });
                    }
                });

                // Trigger city loading if a state is already selected
                let selectedState = $('#state_id').val();
                let selectedCity = $('#city_id').val();
                if (selectedState && !selectedCity) {
                    $('#state_id').trigger('change');
                }

                $('#participentForm').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: "#password"
                        },
                        mobile: {
                            required: true,
                            minlength: 10,
                            digits: true
                        },
                        state_id: {
                            required: true
                        },
                        city_id: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        terms: {
                            required: true
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter your name",
                            minlength: "Your name must be at least 3 characters long"
                        },
                        email: {
                            required: "Please enter a valid email address",
                            email: "Please enter a valid email address"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 6 characters long"
                        },
                        password_confirmation: {
                            required: "Please confirm your password",
                            equalTo: "Password confirmation does not match"
                        },
                        mobile: {
                            required: "Please enter your mobile number",
                            minlength: "Your mobile number must be at least 10 digits",
                            digits: "Please enter a valid mobile number"
                        },
                        state_id: {
                            required: "Please select a state"
                        },
                        city_id: {
                            required: "Please select a city"
                        },
                        address: {
                            required: "Please enter your address"
                        },
                        terms: {
                            required: "You must accept the terms and conditions"
                        }
                    },
                    errorPlacement: function(error, element) {
                        let id = element.attr('id');
                        error.appendTo('#' + id + '-error');
                    }
                });
            });
        </script>
    @endpush
@endsection
