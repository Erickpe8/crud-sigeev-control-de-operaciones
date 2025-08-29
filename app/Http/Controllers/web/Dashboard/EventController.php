<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Si usas spatie/permissions:
        // $this->middleware('role:admin|superadmin');
    }

    public function index(Request $request)
    {
        $q = trim($request->input('search', ''));

        $events = Event::when($q, function ($qr) use ($q) {
                $qr->where(function ($x) use ($q) {
                    $x->where('title', 'like', "%{$q}%")
                      ->orWhere('location', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('start_at')
            ->paginate(10)
            ->withQueryString();

        return view('dashboards.event.event', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:180'],
            'description' => ['nullable','string'],
            'start_at'    => ['nullable','date'],
            'end_at'      => ['nullable','date','after_or_equal:start_at'],
            'location'    => ['nullable','string','max:180'],
            'capacity'    => ['nullable','integer','min:1'],
            'status'      => ['nullable','string','in:activo,inactivo'],
        ]);

        Event::create($data + ['status' => $data['status'] ?? 'activo']);

        return back()->with('success', 'Evento creado');
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:180'],
            'description' => ['nullable','string'],
            'start_at'    => ['nullable','date'],
            'end_at'      => ['nullable','date','after_or_equal:start_at'],
            'location'    => ['nullable','string','max:180'],
            'capacity'    => ['nullable','integer','min:1'],
            'status'      => ['nullable','string','in:activo,inactivo'],
        ]);

        $event->update($data);

        return back()->with('success', 'Evento actualizado');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Evento eliminado');
    }
}
