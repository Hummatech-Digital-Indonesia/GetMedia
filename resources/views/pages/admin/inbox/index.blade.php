@extends('layouts.admin.app')

@section('style')
    <style>
        .card-profile {
            box-shadow: 0 5px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid #f4f4f4;
            padding: 30px;
            border-radius: 10px;
            /* width: 400px;
                height: 130px; */
        }
    </style>
@endsection

<head>
    <title>Admin | Inbox</title>
</head>

@section('content')
    <div class="">
        <div class="container-fluid">
            <div class="card bg-light-info shadow-sm position-relative overflow-hidden">
                <div class="card-body px-4 py-4">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h4 class="fw-semibold mb-8">Inbox Application</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                            href="index-2.html">Dashboard</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Inbox</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-3">
                            <div class="text-center mb-n5">
                                <img src="{{ asset('assets/img/em.png') }}" alt="" class="img-fluid mb-n4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card overflow-hidden chat-application">
                <div class="d-flex align-items-center justify-content-between gap-3 m-3 d-lg-none">
                    <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#chat-sidebar" aria-controls="chat-sidebar">
                        <i class="ti ti-menu-2 fs-5"></i>
                    </button>
                    <form class="position-relative w-100">
                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                            placeholder="Search Contact">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="d-flex w-100">
                    <div class="left-part border-end w-20 flex-shrink-0 d-none d-lg-block">
                        <div class="px-9 pt-4 pb-3">
                            <h4>Kotak Surat</h4>
                        </div>
                        <ul class="list-group" style="height: calc(100vh - 400px)" data-simplebar>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-inbox fs-5"></i>Pesan</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-flag fs-5"></i>Laporan</a>
                            </li>
                            {{-- <li class="list-group-item border-0 p-0 mx-9">
                  <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                    href="javascript:void(0)"><i class="ti ti-file-text fs-5"></i>Draft</a>
                </li>
                <li class="list-group-item border-0 p-0 mx-9">
                  <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                    href="javascript:void(0)"><i class="ti ti-inbox fs-5"></i>Spam</a>
                </li> --}}
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-trash fs-5"></i>Sampah</a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex w-100">
                        <div class="min-width-340">
                            <div class="border-end user-chat-box h-100">
                                <div class="px-4 pt-9 pb-6 d-none d-lg-block">
                                    <form class="position-relative">
                                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                            placeholder="Cari" />
                                        <i
                                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                                    </form>
                                </div>
                                <div class="app-chat">
                                    <ul class="chat-users" style="height: calc(100vh - 400px)" data-simplebar>
                                        @forelse ($contactUs as $contact)
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="px-4 py-3 bg-hover-light-black d-flex align-items-start chat-user bg-light"
                                                    id="chat_user_0" data-user-id="1">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                    <div class="position-relative w-100 ms-2">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <h6 class="mb-0 fw-semibold">{{ $contact->user->name }}</h6>
                                                            <span class="badge fs-2 rounded-4 py-1 px-4"
                                                                style="background-color: #175A95;">Pesan</span>
                                                        </div>
                                                        <h6 class="text-dark">{{ $contact->message }}</h6>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 fs-2 text-muted">{{ $contact->created_at }}
                                                                </p>
                                                            </div>
                                                            {{-- <p class="mb-0 fs-2 text-muted">04:00pm</p> --}}
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse

                                        @forelse ($contactDelete as $contactDelete)
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="px-4 py-3 bg-hover-light-black d-flex align-items-start chat-user bg-light"
                                                    id="chat_user_0" data-user-id="1">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                    <div class="position-relative w-100 ms-2">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <h6 class="mb-0 fw-semibold">{{ $contactDelete->user->name }}
                                                            </h6>
                                                            <span class="badge fs-2 rounded-4 py-1 px-4"
                                                                style="background-color: #175A95;">Sampah</span>
                                                        </div>
                                                        <h6 class="text-dark">{{ $contactDelete->message }}</h6>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 fs-2 text-muted">
                                                                    {{ $contactDelete->created_at }}</p>
                                                            </div>
                                                            {{-- <p class="mb-0 fs-2 text-muted">04:00pm</p> --}}
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse

                                        @forelse ($reports as $report)
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user"
                                                    id="chat_user_88" data-user-id="88">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                    <div class="position-relative w-100 ms-2">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">
                                                            <h6 class="mb-0 fw-semibold">{{ $report->user->name }}</h6>
                                                            <span class="badge fs-2 rounded-4 py-1 px-3"
                                                                style="background-color: #FA896B;">Laporan</span>
                                                        </div>
                                                        <h6 class="text-dark">{{ $report->message }}</h6>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 fs-2 text-muted">{{ $report->created_at }}
                                                                </p>
                                                            </div>
                                                            <p class="mb-0 fs-2 text-muted">04:00pm</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse

                                        @forelse ($reportsDelete as $reportDelete)
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user"
                                                    id="chat_user_88" data-user-id="88">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                    <div class="position-relative w-100 ms-2">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">
                                                            <h6 class="mb-0 fw-semibold">{{ $reportDelete->user->name }}
                                                            </h6>
                                                            <span class="badge fs-2 rounded-4 py-1 px-3"
                                                                style="background-color: #FA896B;">Sampah</span>
                                                        </div>
                                                        <h6 class="text-dark">{{ $reportDelete->message }}</h6>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 fs-2 text-muted">
                                                                    {{ $reportDelete->created_at }}</p>
                                                            </div>
                                                            <p class="mb-0 fs-2 text-muted">04:00pm</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="w-100">
                            <div class="chat-container h-100 w-100">
                                <div class="chat-box-inner-part h-100">
                                    <div class="chatting-box app-email-chatting-box">
                                        @forelse ($contactUs2 as $contactUs)
                                            <div class="p-9 py-3 border-bottom chat-meta-user">
                                                <h5>Detail Pesan</h5>
                                            </div>
                                            <div class="position-relative overflow-hidden">
                                                <div class="position-relative">
                                                    <div class="chat-box p-9" style="height: calc(100vh - 428px)"
                                                        data-simplebar>
                                                        <div class="chat-list chat active-chat" data-user-id="1">
                                                            <div
                                                                class="hstack align-items-start mb-7 pb-1 align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img src="{{ asset('assets/img/usr1.svg') }}"
                                                                        alt="user8" width="48" height="48"
                                                                        class="rounded-circle" />
                                                                    <div>
                                                                        <h6 class="fw-semibold mb-0">
                                                                            {{ $contactUs->user->name }}</h6>
                                                                        <p class="mb-0">{{ $contactUs->user->email }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <span class="badge fs-2 rounded-4 py-1 px-4"
                                                                    style="background-color: #175A95;">Pesan</span>
                                                            </div>
                                                            <div class="border-bottom pb-7 mb-7">
                                                                <h4 class="fw-semibold text-dark mb-3">Silakan periksa
                                                                    pembaruan terbaru ini</h4>
                                                                <p class="mb-3 text-dark">Hello {{ Auth::user()->name }},
                                                                </p>
                                                                <p class="mb-3 text-dark">
                                                                    {{ $contactUs->message }}
                                                                </p>
                                                                {{-- <p class="mb-3 text-dark">Ut id ornare metus, sed auctor enim. Pellentesque nisi
                                    magna, laoreet a augue eget, tempor volutpat diam.</p> --}}
                                                                <p class="mb-0 text-dark">Regards,</p>
                                                                <h6 class="fw-semibold mb-0 text-dark pb-1">
                                                                    {{ $contactUs->user->name }}</h6>
                                                            </div>
                                                            {{-- <div class="mb-3">
                                  <h6 class="fw-semibold mb-0 text-dark mb-3">Attachments</h6>
                                  <div class="d-block d-sm-flex align-items-center gap-4">
                                    <a href="javascript:void(0)" class="hstack gap-3 mb-2 mb-sm-0">
                                      <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-1 bg-light p-6">
                                          <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/chat/icon-adobe.svg" alt="" width="24" height="24">
                                        </div>
                                        <div>
                                          <h6 class="fw-semibold">service-task.pdf</h6>
                                          <div class="d-flex align-items-center gap-3 fs-2 text-muted"><span>2
                                              MB</span><span>2 Dec 2023</span></div>
                                        </div>
                                      </div>
                                    </a>
                                    <a href="javascript:void(0)" class="hstack gap-3 file-chat-hover">
                                      <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-1 bg-light p-6">
                                          <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/chat/icon-zip-folder.svg" alt="" width="24"
                                            height="24">
                                        </div>
                                        <div>
                                          <h6 class="fw-semibold">work-project.zip</h6>
                                          <div class="d-flex align-items-center gap-3 fs-2 text-muted"><span>2
                                              MB</span><span>2 Dec 2023</span></div>
                                        </div>
                                      </div>
                                    </a>
                                  </div>
                                </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="px-9 py-3 border-top chat-send-message-footer">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul
                                                                class="list-unstyledn mb-0 d-flex align-items-center gap-7">
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-arrow-back-up fs-5"></i>
                                                                        Balas
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-delete-contactus"
                                                                        data-id="{{ $contactUs->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse

                                        @forelse ($contactDelete2 as $contactDelete2)
                                            <div class="p-9 py-3 border-bottom chat-meta-user">
                                                <h5>Detail Pesan</h5>
                                            </div>
                                            <div class="position-relative overflow-hidden">
                                                <div class="position-relative">
                                                    <div class="chat-box p-9" style="height: calc(100vh - 428px)"
                                                        data-simplebar>
                                                        <div class="chat-list chat active-chat" data-user-id="1">
                                                            <div
                                                                class="hstack align-items-start mb-7 pb-1 align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img src="{{ asset('assets/img/usr1.svg') }}"
                                                                        alt="user8" width="48" height="48"
                                                                        class="rounded-circle" />
                                                                    <div>
                                                                        <h6 class="fw-semibold mb-0">
                                                                            {{ $contactDelete2->user->name }}</h6>
                                                                        <p class="mb-0">
                                                                            {{ $contactDelete2->user->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <span class="badge fs-2 rounded-4 py-1 px-4"
                                                                    style="background-color: #175A95;">Sampah</span>
                                                            </div>
                                                            <div class="border-bottom pb-7 mb-7">
                                                                <h4 class="fw-semibold text-dark mb-3">Silakan periksa
                                                                    pembaruan terbaru ini</h4>
                                                                <p class="mb-3 text-dark">Hello {{ Auth::user()->name }},
                                                                </p>
                                                                <p class="mb-3 text-dark">
                                                                    {{ $contactDelete2->message }}
                                                                </p>
                                                                {{-- <p class="mb-3 text-dark">Ut id ornare metus, sed auctor enim. Pellentesque nisi
                                    magna, laoreet a augue eget, tempor volutpat diam.</p> --}}
                                                                <p class="mb-0 text-dark">Regards,</p>
                                                                <h6 class="fw-semibold mb-0 text-dark pb-1">
                                                                    {{ $contactDelete2->user->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-9 py-3 border-top chat-send-message-footer">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul
                                                                class="list-unstyledn mb-0 d-flex align-items-center gap-7">
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-arrow-back-up fs-5"></i>
                                                                        Balas
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-recovery-contactus"
                                                                        data-id="{{ $contactDelete2->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Pulihkan
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-release-contactus"
                                                                        data-id="{{ $contactDelete2->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse


                                        @forelse ($reports2 as $report2)
                                            <div class="p-9 py-3 border-bottom chat-meta-user">
                                                <h5>Detail Laporan</h5>
                                            </div>
                                            <div class="position-relative overflow-hidden">
                                                <div class="position-relative">
                                                    <div class="chat-list chat" data-user-id="88">
                                                        <div
                                                            class="hstack align-items-start mb-7 pb-1 align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img src="{{ asset('assets/img/usr1.svg') }}"
                                                                    alt="user8" width="48" height="48"
                                                                    class="rounded-circle" />
                                                                <div>
                                                                    <h6 class="fw-semibold mb-0">
                                                                        {{ $report2->user->name }}</h6>
                                                                    <p class="mb-0">{{ $report2->user->email }}</p>
                                                                </div>
                                                            </div>
                                                            <span class="badge fs-2 rounded-4 py-1 px-3"
                                                                style="background-color: #FA896B;">Laporan</span>
                                                        </div>
                                                        <div class="border-bottom pb-7 mb-7">
                                                            <div class="d-flex">
                                                                <div class="col-3">
                                                                    <p class="text-dark">Judul Berita</p>
                                                                    <b
                                                                        style="fw-semibold mb-0">{{ $report2->news->name }}</b>
                                                                </div>
                                                                <div class="col-3">
                                                                    <p class="text-dark">Penulis</p>
                                                                    <b
                                                                        style="fw-semibold mb-0">{{ $report->user->name }}</b>
                                                                </div>
                                                            </div>

                                                            <div class="mt-5">
                                                                <p class="text-dark">Isi Laporan</p>
                                                                <b style="fw-semibold mb-0">{{ $report2->message }}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-9 py-3 border-top chat-send-message-footer">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul
                                                                class="list-unstyledn mb-0 d-flex align-items-center gap-7">
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-arrow-back-up fs-5"></i>
                                                                        Balas
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-delete-report"
                                                                        data-id="{{ $report2->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse


                                        @forelse ($reportsDelete2 as $reportDelete2)
                                            <div class="p-9 py-3 border-bottom chat-meta-user">
                                                <h5>Detail Laporan</h5>
                                            </div>
                                            <div class="position-relative overflow-hidden">
                                                <div class="position-relative">
                                                    <div class="chat-list chat" data-user-id="88">
                                                        <div
                                                            class="hstack align-items-start mb-7 pb-1 align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img src="{{ asset('assets/img/usr1.svg') }}"
                                                                    alt="user8" width="48" height="48"
                                                                    class="rounded-circle" />
                                                                <div>
                                                                    <h6 class="fw-semibold mb-0">
                                                                        {{ $reportDelete2->user->name }}</h6>
                                                                    <p class="mb-0">{{ $reportDelete2->user->email }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <span class="badge fs-2 rounded-4 py-1 px-3"
                                                                style="background-color: #FA896B;">Sampah</span>
                                                        </div>
                                                        <div class="border-bottom pb-7 mb-7">
                                                            <div class="d-flex">
                                                                <div class="col-3">
                                                                    <p class="text-dark">Judul Berita</p>
                                                                    <b
                                                                        style="fw-semibold mb-0">{{ $reportDelete2->news->name }}</b>
                                                                </div>
                                                                <div class="col-3">
                                                                    <p class="text-dark">Penulis</p>
                                                                    <b
                                                                        style="fw-semibold mb-0">{{ $reportDelete2->user->name }}</b>
                                                                </div>
                                                            </div>

                                                            <div class="mt-5">
                                                                <p class="text-dark">Isi Laporan</p>
                                                                <b
                                                                    style="fw-semibold mb-0">{{ $reportDelete2->message }}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-9 py-3 border-top chat-send-message-footer">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul
                                                                class="list-unstyledn mb-0 d-flex align-items-center gap-7">
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-arrow-back-up fs-5"></i>
                                                                        Balas
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-recovery-report"
                                                                        data-id="{{ $reportDelete2->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Pulihkan
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-dark bg-hover-primary d-flex align-items-center gap-1 btn-release-report"
                                                                        data-id="{{ $reportDelete2->id }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="ti ti-trash fs-5"></i>
                                                                        Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-start user-chat-box" tabindex="-1" id="chat-sidebar"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel"> Email </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="px-9 pt-4 pb-3">
                            <button class="btn btn-primary fw-semibold py-8 w-100">Compose</button>
                        </div>
                        <ul class="list-group" style="height: calc(100vh - 150px)" data-simplebar>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-inbox fs-5"></i>Inbox</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-brand-telegram fs-5"></i>Sent</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-file-text fs-5"></i>Draft</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-inbox fs-5"></i>Spam</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-trash fs-5"></i>Trash</a>
                            </li>
                            <li class="border-bottom my-3"></li>
                            <li class="fw-semibold text-dark text-uppercase mx-9 my-2 px-3 fs-2">IMPORTANT</li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-star fs-5"></i>Starred</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)" class="d-block "><i
                                        class="ti ti-badge fs-5"></i>Important</a>
                            </li>
                            <li class="border-bottom my-3"></li>
                            <li class="fw-semibold text-dark text-uppercase mx-9 my-2 px-3 fs-2">LABELS</li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i
                                        class="ti ti-bookmark fs-5 text-primary"></i>Promotional</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-bookmark fs-5 text-warning"></i>Social</a>
                            </li>
                            <li class="list-group-item border-0 p-0 mx-9">
                                <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1"
                                    href="javascript:void(0)"><i class="ti ti-bookmark fs-5 text-success"></i>Health</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal-component />
@endsection

@section('script')
    <script src="{{ asset('admin/dist/js/apps/chat.js') }}"></script>

    <script>
        $('.btn-delete-contactus').click(function() {
            id = $(this).data('id')
            var actionUrl = `/contact/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>

    <script>
        $('.btn-recovery-contactus').click(function() {
            id = $(this).data('id')
            var actionUrl = `/contact-recovery/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>

    <script>
        $('.btn-release-contactus').click(function() {
            id = $(this).data('id')
            var actionUrl = `/contact-delete/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>

    <script>
        $('.btn-delete-report').click(function() {
            id = $(this).data('id')
            var actionUrl = `/report/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>

    <script>
        $('.btn-recovery-report').click(function() {
            id = $(this).data('id')
            var actionUrl = `/report-recovery/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>

    <script>
        $('.btn-release-report').click(function() {
            id = $(this).data('id')
            var actionUrl = `/report-delete/${id}`;
            $('#form-delete').attr('action', actionUrl);
            $('#modal-delete').modal('show')
        })
    </script>
@endsection
