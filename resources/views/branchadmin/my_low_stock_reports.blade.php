@extends('layouts.branch-master')

@section('content')
<div class="container mt-4">
    <h2>📊 My Low Stock Reports</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Branch</th>
                <th>Quantity</th>
                <th>Submitted On</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr>
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
                <td colspan="5">No low stock reports submitted yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
