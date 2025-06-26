@extends('layouts.branch-master')

@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center text-primary fw-bold">Add New Rider</h3>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="riderForm" action="{{ route('branchadmin.riders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Vehicle Type</label>
                                <input type="text" name="vehicle_type" class="form-control" required value="{{ old('vehicle_type') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" name="vehicle_number" class="form-control" required value="{{ old('vehicle_number') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">CNIC</label>
                                <input type="text" name="cnic" id="cnic" class="form-control" required value="{{ old('cnic') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary px-4 py-2">Register Rider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- jQuery & Select2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select Status",
            allowClear: true,
            width: '100%'
        });

        // Form Validation
        $('#riderForm').on('submit', function (e) {
            let form = $(this);
            let isValid = true;

            form.find('input, select, textarea').removeClass('is-invalid');

            // Required field check
            form.find('[required]').each(function () {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });

            // Email validation
            let email = form.find('input[name="email"]').val();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                form.find('input[name="email"]').addClass('is-invalid');
                isValid = false;
            }

            // Phone format
            let phone = form.find('input[name="phone"]').val();
            if (phone && !/^[0-9+\-\s]{7,15}$/.test(phone)) {
                form.find('input[name="phone"]').addClass('is-invalid');
                isValid = false;
            }

            // Password match
            let pass = form.find('input[name="password"]').val();
            let confirm = form.find('input[name="password_confirmation"]').val();
            if (pass && confirm && pass !== confirm) {
                form.find('input[name="password"], input[name="password_confirmation"]').addClass('is-invalid');
                alert("Passwords do not match.");
                isValid = false;
            }

            // CNIC pattern
            let cnic = $('#cnic').val().trim();
            let cnicRegex = /^\d{5}-\d{7}-\d{1}$/;
            if (!cnicRegex.test(cnic)) {
                $('#cnic').addClass('is-invalid');
                alert("CNIC must be in format 35202-1234567-1");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert("Please fix the highlighted fields.");
            }
        });

        // Auto-format CNIC as you type
        $('#cnic').on('input', function () {
            let val = $(this).val().replace(/\D/g, '').slice(0,13);
            let formatted = '';
            if (val.length > 5) {
                formatted += val.substr(0, 5) + '-';
                if (val.length > 12) {
                    formatted += val.substr(5, 7) + '-' + val.substr(12, 1);
                } else if (val.length > 5) {
                    formatted += val.substr(5);
                }
            } else {
                formatted = val;
            }
            $(this).val(formatted);
        });
    });
</script>
@endpush
