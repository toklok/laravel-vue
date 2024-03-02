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
            'parsed' => ['required', 'string', 'min:1'],
            'input' => ['sometimes', 'string'],
        ]);

        // validation has passed
        $calculation = SavedCalculations::create([
            'actual_calculation' => $validatedData['parsed'],
            'name' => 'calc_'.uniqid(),
            'inputs' => $validatedData['input'] ?? 'N/A',
        ]);

        return response()->json([
            'message' => 'Calculation created successfully!',
            'data' => $calculation,
        ], 201);
    }
}
