<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collection = Collection::all()->sortByDesc('id');
        return response()->json($collection);
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
            'name' => ['bail','required'],
        ],
            [
            'name' => 'Collection must have a name !!!',
        ]
        );
        if ($validated) {
            Collection::create([
              'name' => $request->input('name'),
              'start_at' => $request->input('startAt'),
              'end_at' => $request->input('endAt'),
            ]);
            return $this->index();
        }
    }
}
