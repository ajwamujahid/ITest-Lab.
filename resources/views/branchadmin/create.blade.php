@extends('layouts.master')

@section('content')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10  col-md-12" > {{-- Centered and narrower --}}
            <div class="card rounded-4 ">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center text-primary fw-bold">Add New User</h3>

                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Role Selection --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select select2" required>
                                <option value="">Select Role</option>
                                <option value="manager">Manager</option>
                                <option value="branch_admin">Branch Admin</option>
                            </select>
                            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Personal Info --}}
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="name" class="form-control" required placeholder="Enter Name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="email" type="email" class="form-control" placeholder="Enter Email" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone No
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="phone" class="form-control" placeholder="Enter Phone No" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Qualification</label>
                                <input name="qualification" class="form-control" placeholder="Enter Qualification" required>
                                @error('qualification') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Password Fields --}}
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="password" type="password" class="form-control" placeholder="Enter Password" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm  Password" required>
                            </div>
                        </div>

                        {{-- CNIC, Branch --}}
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CNIC 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="cnic" class="form-control" maxlength="15" placeholder="Enter CNIC" required>
                                @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                    <label for="branch_id" class="form-label">Select Branch</label>
                                    <select name="branch_id" class="form-control select2"  required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                              
                         
                                @error('branch_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Gender, University --}}
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">University</label>
                                <input name="university" class="form-control" placeholder="e.g. University of Lahore">
                                @error('university') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- DOB and Joining --}}
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input name="dob" type="date" class="form-control">
                                @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Joining Date 
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input name="joining_date" type="date" class="form-control" required>
                                @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Photo and Address --}}
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profile Picture</label>
                                <input name="photo" type="file" accept="image/*" class="form-control">
                                @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                                 Add User
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 {{-- jQuery (required for Select2) --}}
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 {{-- Select2 JS --}}
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <script>
     $(document).ready(function () {
         $('.select2').select2({
             placeholder: "Select Branch", "Select Role",
             allowClear: true,
             width: '100%'
         });
         
     });
     $(document).ready(function () {
         $('.select2').select2({
             placeholder: "Select Role",
             allowClear: true,
             width: '100%'
         });
         
     });
     
 </script>
 <script>
    $(document).ready(function () {
        // Initialize Select2s
        $('.select2').select2({
            placeholder: "Select Option",
            allowClear: true,
            width: '100%'
        });

        // Form validation
        $('form').on('submit', function (e) {
            let isValid = true;
            let form = $(this);

            // Clear previous error styles
            form.find('input, select, textarea').removeClass('is-invalid');

            // Required fields
            form.find('[required]').each(function () {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });

            // Email validation
            let emailField = form.find('input[name="email"]');
            let emailVal = emailField.val();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailVal && !emailRegex.test(emailVal)) {
                emailField.addClass('is-invalid');
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

            if (!isValid) {
                e.preventDefault(); // Stop form submission
                alert("Please fix the highlighted fields.");
            }
        });
    });
   
    $(document).ready(function () {

        // CNIC Validation on Submit
        $('form').on('submit', function (e) {
            const cnicInput = $('#cnic');
            const cnicValue = cnicInput.val().trim();
            const cnicPattern = /^\d{5}-\d{7}-\d{1}$/; // e.g., 35202-1234567-1

            // Remove previous error styling
            cnicInput.removeClass('is-invalid');

            if (!cnicPattern.test(cnicValue)) {
                cnicInput.addClass('is-invalid');
                alert('Please enter a valid CNIC in format 35202-1234567-1');
                e.preventDefault();
            }
        });

        // Optional: Auto-format CNIC as user types
        $('#cnic').on('input', function () {
            let val = $(this).val().replace(/\D/g, '').slice(0,13); // only digits
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