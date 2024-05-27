@extends('layouts.user.app')

@section('style')
    <style>
        .news-card-post {
            box-shadow: 0 5px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid #f4f4f4;
            padding: 2%;
            border-radius: 10px;
        }

        .card-category {
            box-shadow: 0 5px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid #f4f4f4;
            padding: 4%;
            border-radius: 10px;
        }
        .btn-outline-primary {
            --bs-btn-color: #175A95 d;
            --bs-btn-border-color: #175A95;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #175A95;
            --bs-btn-hover-border-color: #175A95;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #175A95;
            --bs-btn-active-border-color: #175A95;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #175A95;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #175A95fd;
            --bs-gradient: none;
        }
    </style>
@endsection

@section('content')


    <div class="">
        <div class="sports-wrap ptb-100">
            <div class="container">
                <div class="row gx-55 gx-5">
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h4 class="mb-3" style="border-bottom: 5px solid #175A95;display:inline-block">Hasil Pencarian "{{ $query }}"</h4>
                            </div>
                            <div class="">
                                <form class="d-flex gap-2">
                                    <div class="d-flex gap-2" style="height: 40px">
                                        <select class="form-select" name="opsi" style="width: 200px">
                                            <option value="terbaru">Terbaru</option>
                                            <option value="terlama">Terlama</option>
                                        </select>
                                        
                                    </div>
                                    <div> 
                                        <button class="btn btn-outline-primary" id="signInBtn" type="submit">
                                            Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <p>Menampilkan {{ $newsByDate->count() }} Hasil</p>
                        <div class="row">
                            @forelse ($newsByDate as $item)
                                @php
                                    $dateParts = date_parse($item->upload_date);
                                @endphp
                                <div class="col-md-6">
                                    <div class="news-card-six">
                                        <div class="news-card-img">
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->photo }}"
                                                width="400px" height="250" style="width: 100%;object-fit:cover;">
                                            @foreach ($subCategories as $subCategory)
                                                <p class="tag">
                                                    <a href="{{ route('categories.show.user', ['category' => $item->newsCategories[0]->category->slug]) }}"
                                                        class="news-cat">{{ $item->newsCategories[0]->category->name }}</a>
                                                </p>
                                            @endforeach
                                        </div>
                                        <div class="news-card-info">
                                            <div class="news-author">
                                                <div class="news-author-img">
                                                    <img src="{{ asset($item->user->photo ? 'storage/' . $item->user->photo : 'default.png') }}"
                                                        alt="Image" width="40px" height="40px"
                                                        style="border-radius: 50%; object-fit:cover;" />
                                                </div>
                                                <h5>By <a
                                                        href="{{ route('author.detail', ['id' => $item->user->slug]) }}">{{ $item->user->name }}</a>
                                                </h5>
                                            </div>
                                            <h3><a
                                                    href="{{ route('news.user', ['news' => $item->slug, 'year' => $dateParts['year'], 'month' => $dateParts['month'], 'day' => $dateParts['day']]) }}">{!! Illuminate\Support\Str::limit(strip_tags($item->name), 50, '...') !!}</a>
                                            </h3>
                                            <ul class="news-metainfo list-style">
                                                <li><i class="fi fi-rr-calendar-minus"></i><a
                                                        href="javascript:void(0)">{{ \Carbon\Carbon::parse($item->upload_date)->translatedFormat('d F Y') }}</a>
                                                </li>
                                                <li><i class="fi fi-rr-eye"></i>{{ $item->views->count() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <img src="{{ asset('assets/img/no-data.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h4>Pencarian kosong</h4>
                                </div>
                            @endforelse
                        </div>
                        <ul class="page-nav list-style text-center mt-5 mb-5">
                            <li><a href="{{ $newsByDate->previousPageUrl() }}"><i class="flaticon-arrow-left"></i></a></li>
                            @for ($i = 1; $i <= $newsByDate->lastPage(); $i++)
                                <li><a href="{{ $newsByDate->url($i) }}"
                                        class="btn btn-black {{ $newsByDate->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li><a href="{{ $newsByDate->nextPageUrl() }}"><i class="flaticon-arrow-right"></i></a></li>
                        </ul>

                        <div class="text-center item-center d-flex justify-content-center"
                            style="background-color:#F6F6F6; width:100%;height:200px;">
                            <h5 class="mt-5">Iklan</h5>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">Kategori</h3>
                                <ul class="category-widget list-style">
                                    @foreach ($totalCategories as $category)
                                        <li><a href="{{ route('categories.show.user', ['category' => $category->slug]) }}"><img
                                                    src="{{ asset('assets/img/icons/arrow-right.svg') }}"
                                                    alt="Image">{{ $category->name }}
                                                <span>({{ $category->news_categories_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="sidebar-widget">
                                <h3 class="sidebar-widget-title">Berita Popular</h3>
                                <div class="pp-post-wrap">
                                    @forelse ($populars as $popular)
                                        @php
                                            $dateParts = date_parse($popular->upload_date);
                                        @endphp
                                        <div class="news-card-one">
                                            <div class="news-card-img">
                                                <img src="{{ asset('storage/' . $popular->photo) }}" alt="Image"
                                                    width="100%" style="object-fit: cover;" height="80">
                                            </div>
                                            <div class="news-card-info">
                                                <h3><a
                                                        href="{{ route('news.user', ['news' => $popular->slug, 'year' => $dateParts['year'], 'month' => $dateParts['month'], 'day' => $dateParts['day']]) }}">{!! Illuminate\Support\Str::limit($popular->name, $limit = 40, $end = '...') !!}</a>
                                                </h3>
                                                <ul class="news-metainfo list-style">
                                                    <li><i class="fi fi-rr-calendar-minus"></i><a
                                                            href="javascript:void(0)">{{ \Carbon\Carbon::parse($popular->upload_date)->translatedFormat('d F Y') }}</a>
                                                    </li>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24">
                                                        <path fill="#e93314"
                                                            d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                                    </svg>
                                                    </i><a href="javascript:void(0)">{{ $popular->views->count() }}</a>
                                                    </li>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="sidebar-widget" style="height: 700px">
                                <h3 class="sidebar-widget-title">iklan</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
