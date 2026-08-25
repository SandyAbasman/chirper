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

     
        ],
        [
            'message.required' => 'Please write something to post !',
            'message.max' => 'post  must be 255 characters or less.',
        ],
    );
        //create post with  the authenticated user
      auth()->user()->chirps()->create($validated);

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
            $this->authorize('update', $chirp);

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        // only authenticated users can update post
        $this->authorize('update', $chirp);
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
}
    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Chirp $chirp)
{

    $this->authorize('delete', $chirp);
    
    $chirp->delete();

    return redirect('/')->with('success', 'Chirp deleted!');
}
}
