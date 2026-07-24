<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertController extends Controller
{
    public function index(Request $request)
    {
        $query = Concert::with('venue');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%")
                  ->orWhereHas('venue', function($q) use ($searchTerm) {
                      $q->where('city', 'like', "%{$searchTerm}%")
                        ->orWhere('name', 'like', "%{$searchTerm}%");
                  });
        }

        $concerts = $query->orderBy('date_time', 'asc')->get();

        return view('concerts.index', compact('concerts'));
    }

    public function show($id)
{
    $concert = Concert::with('venue')->findOrFail($id);
    return view('concerts.show', compact('concert'));
}
}