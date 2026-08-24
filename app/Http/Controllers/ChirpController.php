<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $chirps = Chirp::with('user')
    ->latest()
    ->take(50)
    ->get();

    return view('home', ['chirps' => $chirps]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the request
    $validated = $request->validate([
        'message' => 'required|string|max:255|',

                Rule::unique('chirps')->where(function ($query) use ($user) {
            return $query->where('user_id', $user->id);
            
            })
        ],
        [
            'message.required' => 'Please write something to post !',
            'message.max' => 'post  must be 255 characters or less.',
        ],
    );

     \App\Models\Chirp::create([
        'message' => $validated['message'],
    ]);

        // Redirect back to the feed
    return redirect('/')->with('success', 'Your post has been created !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Chirp $chirp)
    {
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
{
    // Validate
    $validated = $request->validate([
        'message' => 'required|string|max:255',
    ],
     [
            'message.required' => 'Please write something to post !',
            'message.max' => 'post  must be 255 characters or less.',
        ],);

    // Update
    $chirp->update($validated);

    return redirect('/')->with('success', 'Chirp updated!');
}
    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Chirp $chirp)
{
    $chirp->delete();

    return redirect('/')->with('success', 'Chirp deleted!');
}
}
