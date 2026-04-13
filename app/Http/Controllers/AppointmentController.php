<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index()
    {
        return Inertia::render('appointments/Index', [
            'appointments' => Appointment::with('patient', 'services')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        return Inertia::render('appointments/Create', [
            'patients' => Patient::orderBy('name')->get(['id', 'name']),
            'services' => Service::orderBy('name')->get(['id', 'name', 'price']),
        ]);
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'  => ['required', 'integer', 'exists:patients,id'],
            'date'        => ['required', 'date'],
            'time'        => ['required', 'date_format:H:i'],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:services,id'],
        ]);

        $appointment = Appointment::create([
            'patient_id'  => $validated['patient_id'],
            'date'        => $validated['date'],
            'time'        => $validated['time'],
            'total_price' => 0, // is calculated after attaching services
        ]);

        $appointment->services()->attach($validated['service_ids']);

        // Calculate total price from selected services
        $total = Service::whereIn('id', $validated['service_ids'])->sum('price');
        $appointment->update(['total_price' => $total]);

        return redirect()->route('appointments.index');
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        return Inertia::render('appointments/Edit', [
            'appointment' => $appointment->load('services'),
            'patients' => Patient::orderBy('name')->get(['id', 'name']),
            'services' => Service::orderBy('name')->get(['id', 'name', 'price']),
        ]);
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id'  => ['required', 'integer', 'exists:patients,id'],
            'date'        => ['required', 'date'],
            'time'        => ['required', 'date_format:H:i'],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:services,id'],
        ]);

        $appointment->update([
            'patient_id'  => $validated['patient_id'],
            'date'        => $validated['date'],
            'time'        => $validated['time'],
        ]);

        $appointment->services()->sync($validated['service_ids']);

        // Calculate total price from selected services
        $total = Service::whereIn('id', $validated['service_ids'])->sum('price');
        $appointment->update(['total_price' => $total]);

        return redirect()->route('appointments.index');
    }
}

