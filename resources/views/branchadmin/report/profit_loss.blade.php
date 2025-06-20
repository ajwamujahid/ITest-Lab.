@extends('layouts.branch-master')

@section('content')
<div class="container">
    <h2>Profit & Loss Report</h2>

    {{-- Filter Form --}}
    <form method="GET" class="mb-4">
        <label>From:</label>
        <input type="date" name="from" value="{{ $from->toDateString() }}">
        <label>To:</label>
        <input type="date" name="to" value="{{ $to->toDateString() }}">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    {{-- Summary --}}
    <div class="mb-4">
        <h4>Total Income: Rs. {{ number_format($income) }}</h4>
        <h4>Total Expenses: Rs. {{ number_format($expenses) }}</h4>
        <h4>Net Profit: Rs. {{ number_format($profit) }}</h4>
        <p>Expense Percentage: {{ $expensePercentage }}%</p>
        <p>Profit Margin: {{ $profitMargin }}%</p>
    </div>

    {{-- Chart --}}
    <canvas id="profitChart" width="400" height="150"></canvas>

    {{-- Breakdown Tables --}}
    <h5 class="mt-5">Income Details</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomeList as $inv)
                <tr>
                    <td>{{ $inv->id }}</td>
                    <td>{{ $inv->created_at->toDateString() }}</td>
                    <td>Rs. {{ number_format($inv->amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="mt-5">Expenses Details</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Expense ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenseList as $exp)
                <tr>
                    <td>{{ $exp->id }}</td>
                    <td>{{ $exp->expense_date }}</td>
                    <td>Rs. {{ number_format($exp->amount) }}</td>
                    <td>{{ $exp->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Export & Print --}}
    <div class="mt-4">
        <a href="#" class="btn btn-primary">Export PDF</a>
        <a href="#" class="btn btn-success">Download Excel</a>
        <button onclick="window.print()" class="btn btn-secondary">Print</button>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('profitChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Income', 'Expenses', 'Profit'],
            datasets: [{
                label: 'Amount',
                data: [{{ $income }}, {{ $expenses }}, {{ $profit }}],
                backgroundColor: ['green', 'red', 'blue']
            }]
        }
    });
</script>
@endsection
