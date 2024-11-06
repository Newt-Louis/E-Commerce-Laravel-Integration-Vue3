<?php

namespace App\Http\Controllers;

use App\Models\Capacities;
use Illuminate\Http\Request;

class CapacitiesController extends Controller
{
    public function index()
    {
        $capacities = Capacities::all();
        return response()->json($capacities);
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
              'name' => 'bail|required',
              'volume' => 'required',
            ],
            [
              'name.required' => 'Capacity must have a name',
              'volume' => 'Must have measurement unit',
            ]
        );
        if ($validated) {
            Capacities::create($validated);
            return $this->index();
        }
    }
}
