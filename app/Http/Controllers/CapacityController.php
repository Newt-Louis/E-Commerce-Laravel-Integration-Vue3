<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public function index()
    {
        $capacities = Capacity::all();
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
              'volume.required' => 'Must have measurement unit',
            ]
        );
        if ($validated) {
            Capacity::create($validated);
            return $this->index();
        }
    }
}
