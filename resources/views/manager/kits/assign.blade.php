@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <h5 class="mb-0">Assign Kits to Rider</h5>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Start --}}
            <form action="{{ route('kits.store') }}" method="POST">
                @csrf

                {{-- Select Rider --}}
                <div class="mb-3">
                    <label for="rider_id" class="form-label">Select Rider</label>
                    <select name="rider_id" id="rider_id" class="form-select" required>
                        <option value="">-- Choose Rider --</option>
                        @foreach($riders as $rider)
                            <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kits Checklist --}}
                <div class="mb-3">
                    <label class="form-label">Select Kits</label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        @forelse($kits as $kit)
                        <div class="form-check mb-2 d-flex align-items-center gap-2">
                            <input 
                                class="form-check-input mt-0" 
                                type="checkbox" 
                                name="kit_ids[]" 
                                value="{{ $kit->id }}" 
                                id="kit-{{ $kit->id }}"
                            >
                    
                            <label class="form-check-label flex-grow-1" for="kit-{{ $kit->id }}">
                                {{ $kit->item_name }} 
                                <span class="text-muted">(Available: {{ $kit->quantity }})</span>
                            </label>
                    
                            {{-- Quantity input --}}
                            <input 
                                type="number" 
                                name="quantities[{{ $kit->id }}]" 
                                min="1" 
                                max="{{ $kit->quantity }}" 
                                class="form-control form-control-sm" 
                                style="width: 100px;" 
                                placeholder="Qty"
                            >
                        </div>
                    @empty
                        <p class="text-muted">No available kits found.</p>
                    @endforelse
                    
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-dark">
                        <i class="bx bx-package"></i> Assign Kits
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
