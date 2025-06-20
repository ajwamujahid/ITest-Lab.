@extends('layouts.patient-master') {{-- Change this to your actual layout --}}

@section('content')
<div class="container py-4">

    <h2 class="mb-4">All Appointments</h2>

    <!-- Filter Form -->
    <form method="GET" class="mb-4 flex flex-wrap gap-2">
        <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-2 py-1">
        <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-2 py-1">
        
        <select name="status" class="border rounded px-2 py-1">
            <option value="">All Status</option>
            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
        </select>

        <input type="text" name="test_type" placeholder="Test Type" value="{{ request('test_type') }}" class="border rounded px-2 py-1">

        <button type="submit" class="bg-blue-500 text-black px-4 py-1 rounded">Filter</button>
    </form>

    <!-- Appointments Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Test Type</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Branch</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                <tr>
                    <td class="p-2 border">{{ $appt->appointment_date->format('d M Y, h:i A') }}</td>
                    <td class="p-2 border">{{ $appt->test_type }}</td>
                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded text-white text-sm
                            @if($appt->status == 'scheduled') bg-yellow-500
                            @elseif($appt->status == 'completed') bg-green-500
                            @elseif($appt->status == 'cancelled') bg-red-500
                            @else bg-blue-500
                            @endif">
                            {{ ucfirst($appt->status) }}
                        </span>
                    </td>
                    <td class="p-2 border">{{ $appt->branch->name }}</td>
                    <td class="p-2 border space-x-1">
                        @if($appt->status === 'scheduled')
                            <a href="{{ route('appointments.reschedule', $appt->id) }}" class="text-blue-600 hover:underline">Reschedule</a>
                            <a href="{{ route('appointments.cancel', $appt->id) }}" class="text-red-600 hover:underline">Cancel</a>
                        @endif

                        @if($appt->invoice_url)
                            <a href="{{ $appt->invoice_url }}" class="text-green-600 hover:underline" target="_blank">View Invoice</a>
                            <a href="{{ route('appointments.download', $appt->id) }}" class="text-purple-600 hover:underline">Download</a>
                        @endif

                        <a href="https://maps.google.com/?q={{ $appt->branch->location }}" class="text-gray-700 hover:underline" target="_blank">Map</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>

</div>
@endsection
