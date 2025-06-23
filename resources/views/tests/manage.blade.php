@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Test Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add Test Form --}}
    <form method="POST" action="{{ route('tests.store') }}" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-2">
                <input type="text" name="name" class="form-control" placeholder="Test Name" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-md-2">
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="physical">Physical</option>
                    <option value="online">Online</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="description" class="form-control" placeholder="Optional Description">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Add</button>
            </div>
        </div>
    </form>

    {{-- Tests Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Price</th>
                <th>Branch</th>
                <th>Description</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tests as $test)
            <tr>
                <form method="POST" action="{{ route('tests.update', $test) }}">
                    @csrf
                    @method('PUT')
                    <td>
                        <input type="text" name="name" value="{{ $test->name }}" class="form-control" disabled required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="price" value="{{ $test->price }}" class="form-control" disabled required>
                    </td>
                    <td>
                        <select name="branch_id" class="form-control" disabled required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $test->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="description" value="{{ $test->description }}" class="form-control" disabled>
                    </td>
                    <td>
                        <select name="type" class="form-control" disabled required>
                            <option value="physical" {{ $test->type == 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="online" {{ $test->type == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning edit-btn">Edit</button>
                        <button type="submit" class="btn btn-sm btn-success d-none save-btn">Update</button>
                </form>

                <form method="POST" action="{{ route('tests.destroy', $test) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('tr');
            row.querySelectorAll('input, select').forEach(input => input.removeAttribute('disabled'));
            row.querySelector('.save-btn').classList.remove('d-none');
            this.classList.add('d-none');
        });
    });
</script>
@endpush
