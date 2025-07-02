<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Branch;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with('branch')->get();
        $branches = Branch::all();
        return view('tests.manage', compact('tests', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'branch_id' => 'required|exists:branches,id',
            'type' => 'required|in:physical,online',
        ]);

        Test::create($request->all());

        return back()->with('success', 'Test added successfully!');
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'branch_id' => 'required|exists:branches,id',
            'type' => 'required|in:physical,online',
        ]);

        $test->update($request->all());

        return back()->with('success', 'Test updated successfully!');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return back()->with('success', 'Test deleted successfully!');
    }
    public function success()
{
    // Save booking if needed or show success message
    return view('patients.test-success');
}

}
