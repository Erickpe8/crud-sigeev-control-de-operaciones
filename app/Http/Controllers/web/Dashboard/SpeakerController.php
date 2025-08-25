<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Si usas spatie/permissions: $this->middleware('role:admin|superadmin');
    }

    public function index(Request $request)
    {
        $q = trim($request->input('search', ''));
        $speakers = Speaker::when($q, function ($qr) use ($q) {
                $qr->where(function ($x) use ($q) {
                    $x->where('full_name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('company', 'like', "%{$q}%");
                });
            })
            ->orderBy('full_name')
            ->paginate(10)
            ->withQueryString();

        // Vista única (lista + crear/editar en la misma página)
        return view('dashboards.speaker.speaker', compact('speakers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','max:180'],
            'email'     => ['nullable','email','max:120','unique:speakers,email'],
            'phone'     => ['nullable','string','max:40'],
            'company'   => ['nullable','string','max:120'],
            'role'      => ['nullable','string','max:120'],
            'bio'       => ['nullable','string'],
            'status'    => ['required','in:activo,inactivo'],
        ]);

        Speaker::create($data);
        return redirect()->route('speakers.index')->with('ok','Ponente creado');
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'full_name' => ['required','string','max:180'],
            'email'     => ['nullable','email','max:120','unique:speakers,email,'.$speaker->id],
            'phone'     => ['nullable','string','max:40'],
            'company'   => ['nullable','string','max:120'],
            'role'      => ['nullable','string','max:120'],
            'bio'       => ['nullable','string'],
            'status'    => ['required','in:activo,inactivo'],
        ]);

        $speaker->update($data);
        return redirect()->route('speakers.index')->with('ok','Ponente actualizado');
    }

    public function destroy(Speaker $speaker)
    {
        $speaker->delete();
        return back()->with('ok','Ponente eliminado');
    }
}
