@extends('layouts.master')

@section('title', 'Add Department')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card  rounded-4 border-0">
                <div class="card-body p-4">

                    <h3 class="mb-4 fw-bold text-center text-primary">
                        <i class="bi bi-building-add me-2"></i> Add New Department
                    </h3>

                    {{-- Success / Error --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
                    @endif

                    {{-- Form Start --}}
                    <form action="{{ route('departments.store') }}" method="POST">
                        @csrf

                        {{-- Department Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Department Name</label>
                            <select name="role_id" class="form-select shadow-sm select2 @error('role_id') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Manager Selection --}}
                        <div class="mb-3">
                            <label for="manager_id" class="form-label fw-semibold">Department Manager</label>
                            <select name="manager_id" class="form-select shadow-sm select2 @error('manager_id') is-invalid @enderror" required>
                                <option value="">-- Select Manager --</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('manager_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description (Optional)</label>
                            <textarea name="description" rows="3" class="form-control shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn btn-success px-4 fw-semibold">
                                <i class="bi bi-check-circle me-1"></i> Create
                            </button>
                            <a href="{{ route('departments.index') }}" class="btn btn-secondary px-4 fw-semibold">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                        </div>

                    </form>
                    {{-- Form End --}}
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "-- Select Manager --",
            allowClear: true,
            width: '100%'
        });
    });

    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "-- Select Role --",
            width: '100%',
            allowClear: true
        });
    });
</script>
@endpush


@endsection
