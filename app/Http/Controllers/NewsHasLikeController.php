<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\NewsHasLikeInterface;
use App\Contracts\Interfaces\NewsInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\NewsLikeRequest;
use App\Models\Author;
use App\Models\News;
use App\Models\NewsHasLike;
use App\Services\NewsHasLikeService;
use Illuminate\Http\Request;

class NewsHasLikeController extends Controller
{

    private NewsHasLikeInterface $newsHasLike;
    private NewsInterface $news;
    private NewsHasLikeService $newsHasLikeService;


    public function __construct(NewsInterface $news,NewsHasLikeInterface $newsHasLike, NewsHasLikeService $newsHasLikeService)
    {
        $this->news = $news;
        $this->newsHasLike = $newsHasLike;
        $this->newsHasLikeService = $newsHasLikeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $news = $this->news->newsLiked($id, $request);
        return view('pages.author.news.newsliked', compact('news'));
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
    public function store(News $news)
    {
        $data =$this->newsHasLikeService->store(auth()->user()->id, $news);
        $this->newsHasLike->store($data);

        return ResponseHelper::success();
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsHasLike $newsHasLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsHasLike $newsHasLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsHasLike $newsHasLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($newsId)
    {
        $this->newsHasLike->deleteLike(auth()->user()->id,$newsId);
        return ResponseHelper::success();
    }
}
