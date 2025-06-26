@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class=" ">
        <i class="bi bi-tags-fill me-2"></i>
        Inventory Categories
    </h3>
    <div class="">
        <form method="POST" action="{{ route('inventory-category.store') }}" class="d-flex gap-2 align-items-center">
            @csrf
            <label class="mb-0">
                <input type="text" name="name" class="form-control" placeholder="Enter New Category" required>
            </label>
            <button class="btn btn-primary" type="submit">Add</button>
        </form>
    </div>
    
    {{-- <div class="row  mt-3">
        <div class="col-lg-10 col-md-12"> --}}
            <div class="card  mt-4 border-0">
                <div class="card-body p-4 ">

                   

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                  
                  

                    {{-- Categories Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary text-dark">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Category Name</th>
                                    <th>Created At</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td>{{ $category->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('inventory-category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
