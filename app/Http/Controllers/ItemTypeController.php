<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function index()
    {
        $categories = ItemType::all();
        return response()->json($categories);
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
            'name' => ['bail','required'],
        ],
            [
            'name.required' => 'Must have category name !',
        ]
        );
        if ($validated) {
            ItemType::create($validated);
            return $this->index();
        }
        return response()->json('message', 'Something wrong with server !');
    }
}
