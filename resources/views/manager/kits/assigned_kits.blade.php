@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-black fw-bold rounded-top-4">
            🗃️ Assigned Kits to Riders
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rider Name</th>
                        <th>Kit Name</th>
                        <th>Quantity Assigned</th>
                        <th>Assigned On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignedKits as $kit)
                        <tr>
                            <td>{{ $kit->rider->name ?? 'N/A' }}</td>
                            <td>{{ $kit->inventoryItem->item_name ?? 'N/A' }}</td>
                            <td>{{ $kit->quantity_assigned ?? '0' }}</td>
                            <td>{{ optional($kit->assigned_at)->format('d-M-Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No kits assigned yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection
