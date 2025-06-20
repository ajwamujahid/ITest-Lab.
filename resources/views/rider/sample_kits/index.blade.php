@extends('layouts.rider-master')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">🧪 Assigned Sample Kits</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($kits->isEmpty())
                <p class="text-muted">No sample kits assigned yet.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Kit Name</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kits as $kit)
                            <tr>
                                <td>{{ $kit->item_name ?? 'N/A' }}</td>
                                <td>{{ $kit->quantity_assigned ?? '-' }}</td>

                                
                                <td>
                                    <span class="badge bg-{{ $kit->kit_status == 'used' ? 'success' : 'warning' }}">
                                        {{ ucfirst($kit->kit_status ?? 'unused') }}
                                    </span>
                                    
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('rider.samplekits.update', $kit->assigned_id) }}">

                                    @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="unused" {{ $kit->kit_status == 'unused' ? 'selected' : '' }}>Unused</option>
                                            <option value="used" {{ $kit->kit_status == 'used' ? 'selected' : '' }}>Used</option>
                                        </select>
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
