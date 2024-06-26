<?php

namespace App\Contracts\Repositories;

use App\Models\News;

use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Enums\NewsStatusEnum;
use App\Helpers\TenDaysHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Contracts\Interfaces\NewsInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsRepository extends BaseRepository implements NewsInterface
{
    public function __construct(News $news)
    {
        $this->model = $news;
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
            ->findOrFail($id)
            ->delete();
    }

    public function whereIn(mixed $data, mixed $banned, Request $request): mixed
    {
        return $this->model->query()
            // ->where('status', $data)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })->when($request->status, function ($query) use ($request) {
                $query->where('status', 'LIKE', '%' . $request->status . '%');
            })->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })->when($request->sub_category_id, function ($query) use ($request) {
                $query->where('sub_category_id', $request->sub_category_id);
            })->get();
    }

    public function search(Request $request): mixed
    {
        return $this->model->query()
            ->where('user_id', auth()->user()->id)
            ->where('status', "active")
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })->when($request->filter, function ($query) use ($request) {
                $query->when($request->filter === 'terbaru', function ($terbaru) {
                    $terbaru->latest()->get();
                });
                $query->when($request->filter === 'terlama', function ($terlama) {
                    $terlama->oldest()->get();
                });
            })
            ->withCount('views')
            ->orderByDesc('views_count')
            ->latest()
            ->take(6)
            ->get();
    }

    public function searchStatus(mixed $id, Request $request, int $pagination, $condition): LengthAwarePaginator
    {
        return $this->model->query()
            ->when($condition, function($query) use ($condition){
                $query->when($condition == "false", function($q){
                    $q->where('delete_at', null);
                });
                $query->when($condition == "true", function($q){
                    $q->where('delete_at', '!=', null);
                });
            })
            ->where('user_id', $id)
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->when($request->status === 'panding', function ($var) {
                    $var->where('status', 'panding');
                });
                $query->when($request->status === 'active', function ($var) {
                    $var->where('status', 'active');
                });
                $query->when($request->status === 'nonactive', function ($var) {
                    $var->where('status', 'nonactive');
                });
            })
            ->fastPaginate($pagination);
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
            ->where('slug', $id)
            ->with(['category', 'user'])
            ->firstOrFail();
    }

    public function manyNews($id): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('user_id', $id)
            ->get()
            ->count();
    }

    public function customPaginate2(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('status', "panding")
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' .  $request->name . '%');
            })
            ->when($request->latest, function ($query) use ($request) {
                $query->when($request->latest === 'terbaru', function ($terbaru) {
                    $terbaru->latest()->get();
                });

                $query->when($request->latest === 'terlama', function ($terlama) {
                    $terlama->oldest()->get();
                });
            })
            ->when($request->perpage, function ($query) use ($request) {
                $query->when($request->perpage === '10', function ($var) {
                    $var->take(10);
                });
                $query->when($request->perpage === '20', function ($var) {
                    $var->take(20);
                });
                $query->when($request->perpage === '50', function ($var) {
                    $var->take(50);
                });
                $query->when($request->perpage === '100', function ($var) {
                    $var->take(100);
                });
            })
            ->latest()
            ->fastPaginate($request->perpage);
    }

    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->when($request->category, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' .  $request->category . '%');
            })
            ->orderBy('is_primary', 'desc')
            ->when($request->latest, function ($query) use ($request) {
                $query->when($request->latest === 'terbaru', function ($terbaru) {
                    $terbaru->latest()->get();
                });
                $query->when($request->latest === 'terlama', function ($terlama) {
                    $terlama->oldest()->get();
                });
            })
            ->when($request->perpage, function ($query) use ($request) {
                $query->when($request->perpage === '10', function ($var) {
                    $var->take(10);
                });
                $query->when($request->perpage === '20', function ($var) {
                    $var->take(20);
                });
                $query->when($request->perpage === '50', function ($var) {
                    $var->take(50);
                });
                $query->when($request->perpage === '100', function ($var) {
                    $var->take(100);
                });
            })
            ->latest()
            ->fastPaginate($request->perpage);
    }

    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()
            ->where('slug', $slug)
            ->with(['category', 'user'])
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->firstOrFail();
    }

    public function newsPremium(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereRelation('user.roles', 'name', 'user')
            ->withCount('views')
            ->orderByDesc('views_count')
            ->take(6)
            ->get();
    }

    public function findBySlug($slug): mixed
    {
        return $this->model->query()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->withCount('views')
            ->orderBy('views_count', 'desc')
            ->get();
    }

    public function authorGetNews($user, Request $request): mixed
    {
        return $this->model->query()
            ->where('user_id', $user)
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->when($request->filter, function ($query) use ($request) {
                $query->when($request->filter === 'terbaru', function ($terbaru) {
                    $terbaru->latest()->get();
                });
                $query->when($request->filter === 'terlama', function ($terlama) {
                    $terlama->oldest()->get();
                });
            })
            ->when($request->input('name'), function($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->input('name').'%');
            })
            ->paginate(8);
    }

    public function getAll(): mixed
    {
        return $this->model->query()
            ->get();
    }

    public function getById($category_id): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereRelation('newsCategories', 'category_id', $category_id)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->take(6)
            ->get();
    }

    public function getAllNews(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->leftJoin('views', 'news.id', '=', 'views.news_id')
            ->select('news.id', 'news.name', 'news.photo', 'news.upload_date', DB::raw('COUNT(views.news_id) as views'), DB::raw('news.created_at as created_at_formatted'))
            ->orderBy('views', 'DESC')
            ->groupBy('news.id', 'news.name', 'news.photo', 'news.upload_date', 'news.created_at')
            ->take(6)
            ->get();
    }

    public function getByLeft(): mixed
    {
        $subquery = DB::table('news_categories')
            ->select('category_id', DB::raw('COUNT(*) as category_count'))
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()
            ->pluck('category_id');


        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereHas('newsCategories', function ($query) use ($subquery) {
                $query->whereIn('category_id', $subquery);
            })
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(4)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date']);
    }

    public function getByRight(): mixed
    {
        $subquery = DB::table('news_categories')
            ->select('category_id', DB::raw('COUNT(*) as category_count'))
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->skip(1)
            ->take(1)
            ->pluck('category_id');

        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereHas('newsCategories', function ($query) use ($subquery) {
                $query->whereIn('category_id', $subquery);
            })
            ->with(['newsCategories' => function ($query) {
                $query->with('category');
            }])
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(4)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date']);
    }

    public function getByMid(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('is_primary', NewsStatusEnum::PUBLISHED->value)
            ->with('newsCategories')
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(3)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date']);
    }

    public function getByPick(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('is_primary', NewsStatusEnum::PUBLISHED->value)
            ->with('newsCategories')
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(6)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date', 'user_id']);
    }

    public function getByGeneral(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->with('newsCategories')
            ->orderBy('created_at')
            ->take(6)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date', 'user_id']);
    }

    public function getByPopular($data): mixed
    {
        $startDate = Carbon::now()->subDays(10)->toDateString();
        $endDate = Carbon::now()->toDateString();
        $popularNews = $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->with('newsCategories')
            ->whereHas('views', function($query) use ($startDate, $endDate){
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withCount('views')
            ->orderByDesc('views_count')
            ->when($data == 'up', function ($query) {
                $query->take(6);
            })
            ->when($data == 'down', function ($query) {
                $query->take(3);
            })
            ->when($data == 'side', function ($query) {
                $query->take(4);
            })
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date', 'user_id']);

        return $popularNews;
    }

    public function latest(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->with('newsCategories')
            ->withCount('views')
            ->latest()
            ->take(13)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date', 'user_id']);
    }

    public function latest2(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->with('newsCategories')
            ->withCount('views')
            ->orderBy('views_count')
            ->latest()
            ->take(3)
            ->get(['id', 'slug', 'photo', 'name', 'created_at', 'upload_date', 'user_id']);
    }

    public function getPremium(Request $request): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('is_primary', NewsStatusEnum::PUBLISHED->value)
            ->when($request->input('opsi') === "terbaru", function ($query) {
                $query->latest()->get();
            })
            ->when($request->input('opsi') === "terlama", function ($query) {
                $query->oldest()->get();
            })
            ->withCount('views')
            ->orderByDesc('views_count')
            ->take(3)
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

    public function where(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id);
    }

    public function findUser(mixed $user_id): mixed
    {
        return $this->model->query()
            ->where('user_id', $user_id)
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->inRandomOrder()
            ->first();
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

    public function updateOrCreate(array $data): mixed
    {
        return $this->model->query()
            ->updateOrCreate($data);
    }

    public function showWhithCount(): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(3)
            ->get();
    }

    public function showWhithCountStat(): mixed
    {
        return $this->model->query()
            ->where('user_id', auth()->user()->id)
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->orderBy('created_at')
            ->take(3)
            ->get();
    }

    public function showNewsStatistic(): mixed
    {
        $result = $this->model->query()
            ->where('user_id', auth()->user()->id)
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->take(3)
            ->get();

        $monthlyData = [];
        $daysInMonth = date('w');
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $found = false;
            foreach ($result as $row) {
                if ($row->day == $i) {
                    $viewsCount = $row->views_count;
                    $monthlyData[] = $viewsCount;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $monthlyData[] = 0;
            }
        }

        return $monthlyData;
    }

    public function showCountMonth(): mixed
    {
        $year = date('Y');
        $result = $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('is_primary', NewsStatusEnum::DRAFT->value)
            ->select(DB::raw('MONTH(news.created_at) as month'), DB::raw('COUNT(news.id) as news_count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;
            foreach ($result as $row) {
                if ($row->month == $i) {
                    $newsCount = $row->news_count;
                    $monthlyData[] = $newsCount;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $monthlyData[] = 0;
            }
        }

        return $monthlyData;
    }

    public function showCountMonthPremium(): mixed
    {
        $year = date('Y');
        $result = $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->where('is_primary', NewsStatusEnum::PUBLISHED->value)
            ->select(DB::raw('MONTH(news.created_at) as month'), DB::raw('COUNT(news.id) as news_count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = false;
            foreach ($result as $row) {
                if ($row->month == $i) {
                    $newsCount = $row->news_count;
                    $monthlyData[] = $newsCount;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $monthlyData[] = 0;
            }
        }

        return $monthlyData;
    }


    public function StatusBanned($author): mixed
    {
        return $this->model->query()
            ->where('user_id', $author)->update(['status' => NewsStatusEnum::PANDING->value]);
    }

    public function whereDate($request, $data): mixed
    {
        return $this->model->query()
            ->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->q . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->q . '%');
                    });
            })
            ->when($request->opsi, function ($query) use ($request) {
                $query->when($request->opsi === "terbaru", function ($opsi) {
                    $opsi->latest();
                });
                $query->when($request->opsi === "terlama", function ($opsi) {
                    $opsi->oldest();
                });
            })
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereDate('upload_date', '<=', Carbon::now())
            ->withCount('views')
            ->latest()
            ->paginate(10);
    }

    public function searchAll(Request $request): mixed
    {
        return $this->model->query()

            ->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->search . '%');
                    });
            })
            ->get();
    }

    public function newsCategory($category): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereRelation('newsCategories', 'category_id', $category)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->get()
            ->take(1);
    }

    public function newsCategorySearch($category, $query, mixed $data, $hal): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->when($query, function ($search) use ($query) {
                $search->where('name', 'LIKE', '%' . $query . '%');
            })
            ->whereRelation('newsCategories', 'category_id', $category)
            ->when($data === "terbaru", function ($query) {
                $query->latest();
            })
            ->when($data === "trending", function ($query) {
                $query->withCount('newsHasLikes');
                $query->orderByDesc('news_has_likes_count');
            })
            ->withCount('views')
            ->paginate($hal);
    }

    public function newsLiked($id, Request $request)
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereRelation('newsHasLikes', 'user_id', $id)
            ->withCount('newsHasLikes')
            ->when($request->filter, function ($query) use ($request) {
                $query->when($request->filter === 'terbaru', function ($terbaru) {
                    $terbaru->latest()->get();
                });
                $query->when($request->filter === 'terlama', function ($terlama) {
                    $terlama->oldest()->get();
                });
            })
            ->paginate(6);
    }



    public function newsSubCategory($subCategory): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->whereRelation('newsSubCategories', 'sub_category_id', $subCategory)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->get()
            ->take(1);
    }

    public function newsSubCategorySearch($subCategory, $query, mixed $data, $hal): mixed
    {
        return $this->model->query()
            ->where('status', NewsStatusEnum::ACTIVE->value)
            ->when($query, function ($search) use ($query) {
                $search->where('name', 'LIKE', '%' . $query . '%');
            })
            ->whereRelation('newsSubCategories', 'sub_category_id', $subCategory)
            ->when($data === "terbaru", function ($query) {
                $query->latest();
            })
            ->when($data === "trending", function ($query) {
                $query->withCount('newsHasLikes');
                $query->orderByDesc('news_has_likes_count');
            })
            ->withCount('views')
            ->paginate($hal);
    }

    public function deleteByAuthor(Author $author): mixed
    {
        return $this->model->query()
            ->where('user_id', $author->user_id)
            ->delete();
    }

    public function softDelete($news): mixed
    {
        return $this->model->query()
            ->findOrFail($news->id)
            ->update(['delete_at'=> Carbon::now()]);
    }

    public function cleanupSoftDelete($news): mixed
    {
        return $this->model->query()
            ->findOrFail($news->id)
            ->whereNotNull('delete_at')
            ->where('delete_at', '>', Carbon::now()->subDays(30))
            ->pluck('id');
    }

    public function restore($news): mixed
    {
        return $this->model->query()
        ->findOrFail($news->id)
        ->update([
            'delete_at' => null,
            'status' => NewsStatusEnum::PANDING->value,
        ]);
    }

    public function getDelete($id,Request $request,int $pagination = 10,$condition):LengthAwarePaginator{
        return $this->model->query()
        ->when($request->name, function ($search) use ($request) {
            $search->where('name', 'LIKE', '%' . $request->name . '%');
        })
        ->where('user_id',$id)
        ->whereNotNull('delete_at')
        ->fastPaginate($pagination);
    }
}
