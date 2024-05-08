<div class="responsive-navbar offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
    <div class="offcanvas-header">
        <a href="/" class="logo d-inline-block">
            <img class="logo-light" src="{{asset('assets/img/logo-getmedia.png')}}" alt="logo" />
            <img class="logo-dark" src="{{asset('assets/img/logo-getmedia.png')}}" alt="logo" />
        </a>

        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="navbarAccordion">
            @foreach ($categories as $category)
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{$loop->index}}" aria-expanded="false" aria-controls="collapse{{$loop->index}}">{{$categories[$loop->index]->name}}</button>
                        <div id="collapse{{$loop->index}}" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion{{$loop->index}}">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion{{$loop->index}}">
                                    @forelse ($categories[$loop->index]->subCategories as $subCategory)
                                        <div class="accordion-item">
                                            <a href="{{ route('subcategories.show.user', ['category' => $subCategory->category->slug,'subCategory' => $subCategory->slug]) }}" class="accordion-link">
                                                {{ $subCategory->name }}</a>
                                        </div>
                                    @empty
                                        <div class="accordion-item">
                                            <a href="{{ route('categories.show.user', ['category' => $category->slug]) }}" class="accordion-link">{{ $category->name }}</a>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
        <div class="offcanvas-contact-info">
            {{-- <div class="option-item">
                <a href="/login" class="btn-two">Login</a>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="option-item">
                    <button class="btn-two" id="logoutBtn">Log Out</button>
                </div>
            </form> --}}

            @auth
                <div class="ms-2">
                    <ul class="navbar-nav mx-auto">
                        <div class="news-card-img mb-2 ms-2" style="padding-right: 0px;">
                            @role('author')
                            <a href="{{ route('profile.index') }}">
                                <img src="{{ asset( Auth::user()->photo ? 'storage/'.Auth::user()->photo : "default.png")  }}" alt="Image" width="40px" height="40px" style="border-radius: 50%; object-fit:cover;"/>
                            </a>
                            @endrole
                            @role('user')
                            <a href="{{ route('profile.user') }}">
                                <img src="{{ asset( Auth::user()->photo ? 'storage/'.Auth::user()->photo : "default.png")  }}" alt="Image" width="40px" height="40px" style="border-radius: 50%; object-fit:cover;"/>
                            </a>
                            @endrole
                            @role('admin')
                            <a href="/dashboard">
                                <img src="{{ asset( Auth::user()->photo ? 'storage/'.Auth::user()->photo : "default.png")  }}" alt="Image" width="40px" height="40px" style="border-radius: 50%; object-fit:cover;"/>
                            </a>
                            @endrole
                        </div>

                    </ul>
                </div>
                @if (Auth::check() && Auth::user()->roles() == "author")
                @endif
                @else

                <div class="">
                    <div class="option-item">
                        <a href="/login" class="btn-two" id="signInBtn">Login</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
