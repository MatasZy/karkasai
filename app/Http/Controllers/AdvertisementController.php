<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'title' => 'required',
            'description' => 'required',
        ]);

        $advertisement = Advertisement::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement created successfully.');
    }

    /**
     * Show the form for editing the specified advertisement.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\View\View
     */
    public function edit(Advertisement $advertisement)
    {
        // Patikriname, ar prisijungęs vartotojas yra skelbimo savininkas
        if (Auth::id() !== $advertisement->user_id) {
            abort(403); // Uždraudžiame prieigą, jei vartotojas nėra skelbimo savininkas
        }

        return view('advertisements.edit', compact('advertisement'));
    }

    /**
     * Update the specified advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        // Patikriname, ar prisijungęs vartotojas yra skelbimo savininkas
        if (Auth::id() !== $advertisement->user_id) {
            abort(403); // Uždraudžiame prieigą, jei vartotojas nėra skelbimo savininkas
        }

        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $advertisement->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    /**
     * Remove the specified advertisement from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Advertisement $advertisement)
    {
        // Patikriname, ar prisijungęs vartotojas yra skelbimo savininkas
        if (Auth::id() !== $advertisement->user_id) {
            abort(403); // Uždraudžiame prieigą, jei vartotojas nėra skelbimo savininkas
        }

        $advertisement->delete();

        return redirect()->route('advertisements.index')->with('success', 'Advertisement deleted successfully.');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
