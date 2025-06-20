@extends('layouts.branch-master')

@section('content')
    <h1>Branch Admin Reports Dashboard</h1>
    <ul>
        <li><a href="{{ route('branchadmin.report.profitLoss') }}">Profit & Loss Report</a></li>
        <li><a href="{{ route('branchadmin.report.income') }}">Income Report</a></li>
        <li><a href="{{ route('branchadmin.report.expenses') }}">Expenses Report</a></li>
        <li><a href="{{ route('branchadmin.report.appointments') }}">Appointments Report</a></li>
    </ul>
@endsection
