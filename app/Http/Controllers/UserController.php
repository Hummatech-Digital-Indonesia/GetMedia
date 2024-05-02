<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AuthorInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserStatusEnum;
use App\Http\Requests\UserRequest;
use App\Models\Author;
use App\Models\User;
use App\Services\UserPhotoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    private UserInterface $user;
    private UserPhotoService $userPhoto;

    public function __construct(UserInterface $user, UserPhotoService $userPhoto)
    {
        $this->user = $user;
        $this->userPhoto = $userPhoto;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(UserRequest $request, User $user)
    {
        $data = $this->userPhoto->store($request, $user);
        $this->user->update($user->id, $data);
        return back();
    }

    public function storeByAdmin(UserRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $user = $this->user->store($data);
        $user->assignRole($data['role']);

        return back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->where('id', $user)->delete();
        return back();
    }
}
