<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
}
