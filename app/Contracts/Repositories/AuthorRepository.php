<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Contracts\Interfaces\AuthorInterface;
use App\Enums\UserStatusEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorRepository extends BaseRepository implements AuthorInterface
{
    public function __construct(Author $author)
    {
        $this->model = $author;
    }

    public function getAllWithUser()
    {
        return $this->model->query()
            ->get();
    }

    public function whereEmail($authorId): mixed
    {
        $author = $this->model->with('user')->findOrFail($authorId);
        return $author->user->email;
    }

    public function whereIn(mixed $data, mixed $banned, Request $request): mixed
    {
        return $this->model->query()
            ->where('status', $data)
            ->where('banned', $banned)
            ->when($request->search, function ($query) use ($request) {
                $query->join('users', 'authors.user_id', '=', 'users.id')
                    ->where('users.name', 'LIKE', '%' . $request->search . '%');
            })->when($request->status, function ($query) use ($request) {
                $query->where('status', 'LIKE', '%' . $request->status . '%');
            })->when($request->user_id, function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->paginate(5);
    }

    public function where($user): mixed
    {
        return $this->model->query()
            ->where('user_id', $user->id)
            ->first();
    }

    public function search(Request $request): mixed
    {
        return $this->model->query()
            // ->where('status', $data)
            ->when($request->search, function ($query) use ($request) {
                $query->join('users', 'authors.user_id', '=', 'users.id')
                    ->where('users.name', 'LIKE', '%' . $request->search . '%');
            })->when($request->status, function ($query) use ($request) {
                $query->where('status', 'LIKE', '%' . $request->status . '%');
            })->when($request->user_id, function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->paginate(5);
    }

    public function paginate(): mixed
    {
        return $this->model->query()
            ->latest()
            ->paginate(5);
    }

    /**
     * Handle show method and delete data instantly from models.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id->id)
            ->delete();
    }

    /**
     * Handle get the specified data by id from models.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id);
    }

    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->get();
    }

    /**
     * Handle store data event to models.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()
            ->create($data);
    }

    public function updateOrCreate($userId, array $data): mixed
    {
        return $this->model->query()
            ->updateOrCreate(['user_id' => $userId], $data);
    }

    /**
     * Handle show method and update data instantly from models.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()
            ->findOrFail($id)
            ->update($data);
    }

    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('status', UserStatusEnum::PANDING->value)
            ->when($request->author, function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->author . '%');
                });
            })
            ->fastPaginate($pagination);
    }


    public function customPaginate2(Request $request, int $pagination = 10): LengthAwarePaginator
    {
            return $this->model->query()
            ->where('status', '!=', UserStatusEnum::PANDING->value)
            ->when($request->name, function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->when($request->banned, function ($query) use ($request) {
                $query->where('status', 'LIKE', '%'.$request->banned.'%');
            })
            ->fastPaginate($pagination);
    }

    public function showWhithCount(): mixed
    {
        return DB::table('authors')
            ->join('news', 'authors.user_id', '=', 'news.user_id')
            ->join('users', 'authors.user_id', '=', 'users.id')
            ->leftJoin('followers', 'authors.id', '=', 'followers.author_id')
            ->leftJoin('news_has_likes', 'news.id', '=', 'news_has_likes.news_id')
            ->where('authors.status', "approved")
            ->select('authors.id', 'users.name', 'users.photo', DB::raw('COUNT(news.user_id) as count'), DB::raw('COUNT(news_has_likes.news_id) as count_like'), DB::raw('COUNT(followers.author_id) as follow_id'))
            ->orderBy('count', 'desc')
            ->groupBy('authors.id', 'users.name', 'users.photo')
            ->get();
    }

    public function showWhithCountSearch(Request $request): mixed
    {
        $currentUserId = Auth::check() ? auth()->user()->id : null;

        return $this->model->query()
            ->where('authors.status', 'approved')
            ->where('authors.banned', '0')
            ->where('authors.user_id', '!=', $currentUserId)
            ->withCount('followers')
            ->leftJoin('users', 'users.id', '=', 'authors.user_id')
            ->when($request->input('name'), function($query) use ($request) {
                $query->where('users.name', 'LIKE', '%'.$request->input('name').'%');
            })
            ->selectRaw('(SELECT COUNT(*) FROM news WHERE news.user_id = authors.user_id AND news.status = "active") as count')
            ->selectRaw('(SELECT COUNT(*) FROM news_has_likes
                            INNER JOIN news ON news_has_likes.news_id = news.id
                            WHERE news.user_id = authors.user_id) as count_like')
            ->paginate(16);
    }
}
