@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Low Stock Reports</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Branch</th>
                <th>Quantity Reported</th>
                <th>Reported At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report->item->item_name }}</td>
                <td>{{ $report->branch->name }}</td>
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
                <td>
                    @if($report->status == 'pending')
                    <form action="{{ route('low.stock.report.update', $report->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="status" value="confirmed" class="btn btn-success btn-sm">Confirm</button>
                    </form>
                    <form action="{{ route('low.stock.report.update', $report->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
