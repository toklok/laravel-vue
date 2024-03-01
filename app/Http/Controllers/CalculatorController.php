<?php

namespace App\Http\Controllers;

use App\Models\SavedCalculations;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalculatorController extends Controller
{
    public function index()
    {
        $calculations = SavedCalculations::all();

        return Inertia::render('Homepage/Index', ['calculations' => $calculations->toArray()]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        SavedCalculations::where('id', $id)->delete();
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'input' => ['required', 'min:1'],
        ]);

        $calculation = SavedCalculations::create([
            'actual_calculation' => $validatedData['input'],
            'name' => 'calc_' . uniqid(),
            'inputs' => json_encode([]),
        ]);

        return response()->json([
            'message' => 'Calculation created successfully!',
            'data' => $calculation,
        ], 201);
    }
}
