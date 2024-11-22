@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>List of Participants</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="participants-table">
                <!-- Data will be populated here via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Toast Container (For success/error messages) -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <!-- Toasts will be inserted dynamically -->
    </div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Display session flash messages as toasts
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @elseif(session('error'))
                showToast('{{ session('error') }}', 'danger');
            @endif

            function fetchParticipants() {
                $.ajax({
                    url: "{{ route('participent.index') }}",
                    method: "GET",
                    success: function(response) {
                        let participants = response.data;
                        let tableBody = $('#participants-table');
                        tableBody.empty();

                        if (participants.length > 0) {
                            $.each(participants, function(index, participant) {
                                tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${participant.name}</td>
                                        <td>${participant.email}</td>
                                        <td>${participant.mobile}</td>
                                        <td>${participant.address ? participant.address.address : 'N/A'}</td>
                                        <td>${participant.address && participant.address.state ? participant.address.state.name : 'N/A'}</td>
                                        <td>${participant.address && participant.address.city ? participant.address.city.name : 'N/A'}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" data-id="${participant.id}" ${participant.is_active == 1 ? 'checked' : ''}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="/participent/${participant.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${participant.id}">Delete</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="9" class="text-center">No participants found.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching participants:', error);
                        alert('Failed to fetch participants. Please try again later.');
                    }
                });
            }

            fetchParticipants();

            $(document).on('click', '.delete-btn', function() {
                let participantId = $(this).data('id');
                if (confirm('Are you sure you want to delete this participant?')) {
                    $.ajax({
                        url: `/participent/${participantId}`,
                        method: "post",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showToast('Participant deleted successfully!', 'success');
                            fetchParticipants();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting participant:', error);
                            showToast('Failed to delete participant. Please try again later.', 'danger');
                        }
                    });
                }
            });

            $(document).on('change', '.status-toggle', function() {
                let participantId = $(this).data('id');
                let isActive = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: `/participent/${participantId}/status`,
                    method: "PATCH",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        is_active: isActive
                    },
                    success: function(response) {
                        showToast('Status updated successfully!', 'success');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status:', error);
                        showToast('Failed to update status. Please try again later.', 'danger');
                    }
                });
            });

            function showToast(message, type) {
                let toastHTML = `
                    <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;
                $('.toast-container').append(toastHTML);
                let toast = new bootstrap.Toast($('.toast-container .toast').last()[0]);
                toast.show();
            }
        });
    </script>
@endpush
@endsection
