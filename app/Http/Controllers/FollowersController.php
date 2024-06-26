<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\FollowerInterface;
use App\Models\Author;
use App\Models\Followers;
use Illuminate\Http\Request;

class FollowersController extends Controller
{

    private FollowerInterface $followers;

    public function __construct(FollowerInterface $followers)
    {
        $this->followers = $followers;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Author $author)
    {
        $data['user_id'] = auth()->user()->id;
        $data['author_id'] = $author->id;
        $this->followers->store($data);

        

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Followers $followers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Followers $followers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Followers $followers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Followers $followers, Author $author)
    {
        $this->followers->destroy($author->id, auth()->user()->id);
        return back();
    }
}
