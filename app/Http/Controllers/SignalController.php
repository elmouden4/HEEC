<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignalController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'type_id' => 'required|exists:incident_types,id',
        'description' => 'required|string',
        'photo' => 'nullable|image|max:2048', // 2MB max
    ]);

    $path = $request->hasFile('photo')
        ? $request->file('photo')->store('incident_photos', 'public')
        : null;

    Incident::create([
        'citizen_id' => auth()->id(), // if authenticated
        'type_id' => $request->type_id,
        'location_id' => 1, // placeholder - you might use actual input
        'description' => $request->description,
        'photo_url' => $path,
        'status' => 'pending',
    ]);

    return redirect()->route('incidents.index')->with('success', 'Incident envoyé.');
}

}
