@extends('layouts.master') {{-- Or your Super Admin layout --}}

@section('content')
<div class="container mt-4">
    <h3>Test Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('tests.store') }}" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Test Name" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-md-3">
                <select name="branch_id" class="form-control" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="description" class="form-control" placeholder="Optional Description">
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Price</th>
                <th>Branch</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($tests as $test)
                <tr>
                    <form method="POST" action="{{ route('tests.update', $test) }}">
                        @csrf
                        <td><input type="text" name="name" value="{{ $test->name }}" class="form-control" required></td>
                        <td><input type="number" step="0.01" name="price" value="{{ $test->price }}" class="form-control" required></td>
                        <td>
                            <select name="branch_id" class="form-control" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $test->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="description" value="{{ $test->description }}" class="form-control">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
            
                    <form method="POST" action="{{ route('tests.destroy', $test) }}" onsubmit="return confirm('Are you sure you want to delete this test?');" style="display:inline;">
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
