<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index(): Response
    {
        return Inertia::render('services/Index', [
            'services' => Service::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): Response
    {
        // In Inertia we only send the view to render, Vue handles the initial data
        return Inertia::render('services/Create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        Service::create($validated);

        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): Response
    {
        // Laravel automatically finds the service with the ID in the URL
        return Inertia::render('services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $service->update($validated);

        return redirect()->route('services.index');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index');
    }
}
