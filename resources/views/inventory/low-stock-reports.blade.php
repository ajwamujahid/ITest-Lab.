@extends('layouts.master')

@section('title', 'Low Stock Reports')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary m-0">
                    {{-- <i class="bi bi-exclamation-triangle-fill me-2"></i>  --}}
                    Low Stock Reports
                </h3>
                <div>
                    <a href="#" onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-printer me-1"></i> Print
                    </a>
                    {{-- Optional: Export to PDF/Excel --}}
                    {{-- <a href="{{ route('low.stock.export') }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a> --}}
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="lowStockTable">
                    <thead class="table-dark">
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
                        @forelse ($reports as $report)
                        <tr>
                            <td class="fw-semibold">{{ $report->item->item_name }}</td>
                            <td>{{ $report->branch->name }}</td>
                            <td>
                                @if($report->quantity_reported < 10)
                                    <span class="badge bg-danger">{{ $report->quantity_reported }} (Low)</span>
                                @else
                                    {{ $report->quantity_reported }}
                                @endif
                            </td>
                            <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="badge 
                                    @if($report->status == 'pending') bg-warning text-dark
                                    @elseif($report->status == 'confirmed') bg-success
                                    @elseif($report->status == 'rejected') bg-danger
                                    @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>
                                @if($report->status == 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('low.stock.report.update', $report->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" name="status" value="confirmed" class="btn btn-sm btn-success">
                                                Confirm
                                            </button>
                                        </form>
                                        <form action="{{ route('low.stock.report.update', $report->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No low stock reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#lowStockTable').DataTable({
            pageLength: 20,
            order: [[3, 'desc']], // sort by reported date
        });
    });
</script>
@endpush
