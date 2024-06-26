<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Enums\NewsStatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRequest;
use App\Services\UserPhotoService;;

use Illuminate\Support\Facades\Mail;
use App\Services\AuthorBannedService;
use App\Http\Requests\UserPhotoRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Contracts\Interfaces\NewsInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\SendMessageInterface;
use App\Http\Resources\UserResource;
use App\Models\Author;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private UserInterface $user;
    private NewsInterface $news;
    private UserPhotoService $userPhoto;
    private AuthorBannedService $authorBannedService;
    private SendMessageInterface $sendMessage;

    public function __construct(UserInterface $user, UserPhotoService $userPhoto, NewsInterface $news, SendMessageInterface $sendMessage, AuthorBannedService $authorBannedService)
    {
        $this->user = $user;
        $this->userPhoto = $userPhoto;
        $this->sendMessage = $sendMessage;
        $this->news = $news;
        $this->authorBannedService = $authorBannedService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendMessage = $this->sendMessage->get('0');
        $sendMessage2 = $this->sendMessage->get('0');

        $sendDelete = $this->sendMessage->get('1');
        $sendDelete2 = $this->sendMessage->get('1');

        return view('pages.user.inbox.index', compact('sendMessage', 'sendMessage2', 'sendDelete', 'sendDelete2'));
    }

    public function countMessage()
    {
        $countMassage = $this->sendMessage->count('unread');
        return response()->json(['count' => $countMassage]);
    }

    public function countMessage2()
    {
        $countMassage = $this->sendMessage->count('unread');
        return response()->json(['countTotal' => $countMassage]);
    }

    public function accountUserList(Request $request)
    {
        if ($request->has('page')) {
            $user = $this->user->customPaginate2($request, 10);
            $data['paginate'] = [
                'current_page' => $user->currentPage(),
                'last_page' => $user->lastPage(),
            ];
            $data['data'] = UserResource::collection($user);
        } else {
            $users = $this->user->search($request);
            $data = UserResource::collection($users);
        }
        return ResponseHelper::success($data);
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
    public function store(UserPhotoRequest $request, User $user)
    {
        $data = $this->userPhoto->store($request, $user);
        $this->user->update($user->id, $data);
        return back()->with('success', 'Berhasil memperbarui foto profile');
    }

    public function storeByAdmin(UserRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $slug = Str::slug($data['name']);
        $data['slug'] = $slug;
        $user = $this->user->store($data);
        $user->assignRole('admin');

        return ResponseHelper::success(null, trans('alert.add_success'));
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
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $slug = Str::slug($data['name']);
        $data['slug'] = $slug;
        $this->user->update($user->id, $data);

        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->permissions()->detach();

        $userId = $user->id;
        $this->user->delete($userId);

        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    public function banned($id)
    {
        $user = $this->user->show($id);
        $data['status'] = NewsStatusEnum::NONACTIVE->value;

        if (!$user->status_banned) {
            $this->authorBannedService->banned($user);
            $this->news->StatusBanned($user->id);

            $email = $user->email;
            $subject = 'Pemberitahuan: Anda telah dibanned';
            $message = 'Anda telah dibanned dari sistem kami. Mohon untuk hubungi kami jika ingin Tidak di Ban';
            Mail::raw($message, function ($message) use ($email, $subject) {
                $message->to($email)
                ->subject($subject);
            });
        } else {
            $this->authorBannedService->unBanned($user);
        }

        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
