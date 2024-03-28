<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Services\AuthorService;
use App\Http\Requests\AuthorRequest;
use App\Contracts\Interfaces\AuthorInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Enums\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\AuthorsRequest;
use App\Http\Resources\AuthorResource;
use App\Models\User;
use App\Services\Auth\RegisterService;
use App\Services\AuthorBannedService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\alert;

class AuthorController extends Controller
{
    private AuthorInterface $author;
    private RegisterInterface $register;

    private AuthorService $authorService;
    private RegisterService $serviceregister;
    private $authorBannedService;


    public function __construct(AuthorInterface $author, AuthorService $authorService, RegisterService $serviceregister, RegisterInterface $register, AuthorBannedService $authorBannedService)
    {
        $this->author = $author;
        $this->register = $register;

        $this->authorService = $authorService;
        $this->authorBannedService = $authorBannedService;
        $this->serviceregister = $serviceregister;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Author $author)
    {
        $request->merge([
            'user_id' => $author->id
        ]);

        $search = $request->input('search');
        $status = $request->input('status');
        $searchTerm = $request->input('search', '');

        $authors = $this->author->whereIn("panding", false, $request);
        $authors->appends(['search' => $searchTerm]);

        return view('pages.admin.user.index', compact('authors', 'search', 'status'));
    }

    public function listauthor(Request $request, Author $author) : JsonResponse
    {
     
        if ($request->has('page')) {
            $author = $this->author->customPaginate($request, 10);
            $data['paginate'] = [
                'current_page' => $author->currentPage(),
                'last_page' => $author->lastPage(),
            ];
            $data['data'] = AuthorResource::collection($author);
        }else{
            $data = $this->author->get();
        }
        return ResponseHelper::success($data);
    }

    public function listbanned(Request $request, Author $author)
    {
        $request->merge([
            'user_id' => $author->id
        ]);

        $search = $request->input('search');
        $status = $request->input('status');
        $searchTerm = $request->input('search', '');

        $authors = $this->author->whereIn("reject", true, $request);
        $authors->appends(['search' => $searchTerm]);

        // $authors = $this->author->search($request)->where('status', 'reject')->where('banned', true);
        return view('pages.admin.user.author-ban', compact('authors', 'search', 'status'));
    }

    public function approved(Author $author, $authorId)
    {
        $data['status'] = UserStatusEnum::APPROVED->value;
        $author = Author::find($authorId);

        if ($author) {
            $author->update($data);

            $user = $author->user;
            $authorRole = Role::where('name', 'author')->first();

        if ($user && $authorRole) {
            $user->roles()->sync([$authorRole->id]);
        }
    }

    return back();
    }

    public function reject(Author $author, $authorId)
    {
        $data['status'] = UserStatusEnum::REJECT->value;
        $this->author->update($authorId, $data);
        return back();
    }

    public function banned(Author $author)
    {
        if (!$author->banned) {
            $this->authorBannedService->banned($author);
        } else {
            $this->authorBannedService->unBanned($author);
        }

        return ResponseHelper::success(null, trans('alert.update_success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RegisterRequest $request, User $user)
    {
        $data = $this->authorService->store($request, $user);
        $this->author->store($data);

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $data = $this->serviceregister->registerWithAdmin($request);
        $user = $this->register->store($data);
        $userId = $user->assignRole(RoleEnum::AUTHOR)->id;

        $img = $data['cv'];
        $this->author->store([
            'user_id' => $userId,
            'cv' => $img,
            'status' => "approved"
        ]);

        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    public function createauthor ()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $data = $this->authorService->update($request, $author);
        $this->author->update($author->id, $data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
