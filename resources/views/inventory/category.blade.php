@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-4 px-md-5">

                    <h3 class="mb-4 fw-bold text-center text-primary">
                        {{-- <i class="bi bi-tags-fill me-2"></i> --}}
                        Inventory Categories
                    </h3>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Add Category Form --}}
                    <form method="POST" action="{{ route('inventory-category.store') }}" class="mb-4">
                        @csrf
                        <div class="input-group shadow-sm">
                            <input type="text" name="name" class="form-control rounded-start" placeholder="Enter New Category Name" required>
                            <button class="btn btn-primary fw-semibold" type="submit">
                                <i class="bi bi-plus-circle me-1"></i> Add
                            </button>
                        </div>
                    </form>

                    {{-- Categories Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-striped table-hover">
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
