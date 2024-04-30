<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav quick-links d-none d-lg-flex">
            <div class="d-flex">
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                </button>

                <a href="/" class="toggler" style="color: #000000">
                    <div class="d-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 19.923c-2.202-2.81-4.157-4.406-5.866-4.785c-1.709-.38-3.336-.436-4.88-.172V20L3 11.786L10.253 4v4.784C13.11 8.808 15.54 9.88 17.54 12s3.154 4.761 3.461 7.923"/></svg>
                    </div>
                </a>
            </div>
        </ul>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                    {{-- <li class="nav-item ">
                        <a style="font-size: 29px" class="nav-link notify-badge mr-5 nav-icon-hover" href="{{ route('cart') }}" aria-controls="offcanvasRight">
                            <i class="ti ti-basket"></i>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2">
                            <span class="text-dark fs-3 fw-semibold lh-1 mb-1 username"></span>
                            <span class="text-dark fs-3 fw-bold lh-1 role"></span>
                        </div>
                    </li>
                    <li class="nav item">
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center">
                            <span class="mt-2 fs-4 lh-1 text-end fw-semibold">{{ auth()->user()->name }}</span>
                            <span class="fs-4 text-end">{{ auth()->user()->email }}</span>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <img src="{{ asset( Auth::user()->photo ? 'storage/'.Auth::user()->photo : "default.png")  }}" class="rounded-circle user-profile"
                                        style="object-fit: cover" width="35" height="35" alt="" />
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                            aria-labelledby="drop1">
                            <div class="profile-dropdown position-relative" data-simplebar>
                                <div class="py-3 px-7 pb-0">
                                    <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                </div>
                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                    <img src="{{ asset( Auth::user()->photo ? 'storage/'.Auth::user()->photo : "default.png")  }}" class="rounded-circle user-profile" style="object-fit: cover"
                                        width="80" height="80" alt="" />
                                    <div class="ms-3">
                                        <h5 class="mb-1 fs-3 username">{{ auth()->user()->name }}</h5>
                                        <span class="mb-1 d-block text-dark role">{{ auth()->user()->roles->pluck('name')[0] }}</span>
                                        <p class="mb-0 d-flex text-dark align-items-center gap-2 email">
                                            <i class="ti ti-mail fs-4"></i>
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="message-body">
                                    <a class="py-8 px-7 mt-8 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-account.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                                            <span class="d-block text-dark">Account Settings</span>
                                        </div>
                                    </a>
                                    {{-- <a href="app-email.html" class="py-8 px-7 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-inbox.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold">My Inbox</h6>
                                            <span class="d-block text-dark">Messages & Emails</span>
                                        </div>
                                    </a>
                                    <a href="app-notes.html" class="py-8 px-7 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-tasks.svg"
                                                alt="" width="24" height="24">
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold">My Task</h6>
                                            <span class="d-block text-dark">To-do and Daily Tasks</span>
                                        </div>
                                    </a> --}}
                                </div>
                                {{-- {{ route('logout') }} --}}
                                <form action="" method="POST">
                                    @csrf
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <button class="btn btn-outline-primary" id="logoutBtn">Log Out</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
