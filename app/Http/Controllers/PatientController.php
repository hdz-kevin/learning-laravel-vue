<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index()
    {
        return Inertia::render('patients/Index', [
            'patients' => Patient::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return Inertia::render('patients/Create');
    }

    /**
     * Store a newly created patient in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'sex' => 'required|in:male,female',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index');
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        return Inertia::render('patients/Edit', [
            'patient' => $patient,
        ]);
    }

    /**
     * Update the specified patient in database.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'sex' => 'required|in:male,female',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified patient from database.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index');
    }
}
