<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function formatAmount($amount)
{
    return number_format($amount, 2) . ' PKR';
}

function formatDate($date)
{
    return Carbon::parse($date)->format('d M, Y');
}

function fullName($first, $last)
{
    return ucfirst($first) . ' ' . ucfirst($last);
}

function riderPhoto($photo)
{
    return asset('uploads/riders/' . $photo);
}

function isManager()
{
    return Auth::guard('manager')->check();
}
