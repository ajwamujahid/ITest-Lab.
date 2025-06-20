@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Performance Reviews</h4>

    {{-- Filters --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <select id="branchFilter" class="form-control">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="roleFilter" class="form-control">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" id="fromDate" class="form-control" placeholder="From">
        </div>
        <div class="col-md-3">
            <input type="date" id="toDate" class="form-control" placeholder="To">
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="reviewsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Role</th>
                        <th>Branch</th>
                        <th>Score</th>
                        <th>Reviewer</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- View Modal --}}
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Review Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="reviewDetails">
        <!-- Populated via AJAX -->
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    let table = $('#reviewsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("performance.reviews.data") }}',
            data: function (d) {
                d.branch_id = $('#branchFilter').val();
                d.role = $('#roleFilter').val();
                d.from = $('#fromDate').val();
                d.to = $('#toDate').val();
            }
        },
        columns: [
            { data: 'employee_name', name: 'employee_name' },
            { data: 'employee.role', name: 'employee.role' },
            { data: 'branch.name', name: 'branch.name' },
            { data: 'score', name: 'score' },
            { data: 'reviewer_name', name: 'reviewer_name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });

    $('#branchFilter, #roleFilter, #fromDate, #toDate').on('change', function () {
        table.draw();
    });

    // View modal AJAX
    $(document).on('click', '.view-review', function () {
        const id = $(this).data('id');
        $.get(`/performance-reviews/${id}`, function (data) {
            let html = `
                <p><strong>Employee:</strong> ${data.employee.name}</p>
                <p><strong>Role:</strong> ${data.employee.role}</p>
                <p><strong>Branch:</strong> ${data.branch.name}</p>
                <p><strong>Reviewer:</strong> ${data.reviewer.name}</p>
                <p><strong>Score:</strong> ${data.score}</p>
                <p><strong>Comments:</strong> ${data.comments}</p>
            `;
            $('#reviewDetails').html(html);
            $('#reviewModal').modal('show');
        });
    });
});
</script>
@endpush
