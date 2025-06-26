@extends('layouts.branch-master')

@section('content')
<div class="container py-5">
    {{-- ✅ Heading stays same as you requested --}}
    <h3 class="mb-4 fw-bold text-primary">
        <i class="bi bi-exclamation-circle text-primary me-2"></i> My Low Stock Reports
    </h3>
    

    <div class="card">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table  align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Item Name</th>
                            <th>Branch</th>
                            <th>Quantity</th>
                            <th>Submitted On</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr class="text-center">
                                <td>{{ $report->item->item_name ?? 'N/A' }}</td>
                                <td>{{ $report->branch->name ?? 'N/A' }}</td>
                                <td>{{ $report->quantity_reported }}</td>
                                <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($report->status == 'pending') bg-warning 
                                        @elseif($report->status == 'confirmed') bg-success 
                                        @elseif($report->status == 'rejected') bg-danger 
                                        @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No low stock reports submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
