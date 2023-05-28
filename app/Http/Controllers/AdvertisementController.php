<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the advertisements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $advertisements = Advertisement::all();

        return view('advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new advertisement.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        Advertisement::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('advertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }

    /**
     * Display the specified advertisement.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\View\View
     */
    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', compact('advertisement'));
    }
}
