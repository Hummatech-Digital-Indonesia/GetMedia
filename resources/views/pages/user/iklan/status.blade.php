@extends('layouts.user.sidebar')

@section('content')
<div class="card shadow-sm position-relative overflow-hidden"  style="background-color: #175A95;">
    <div class="card-body px-4 py-4">
      <div class="row justify-content-between">
        <div class="col-8 text-white">
          <h4 class="fw-semibold mb-3 mt-2 text-white">Status Iklan</h4>
            <p>Layanan pengiklanan di getmedia.id</p>
        </div>
        <div class="col-3">
          <div class="text-center mb-n4">
            <img src="{{asset('assets/img/bg-ajuan.svg')}}" width="250px" alt="" >
          </div>
        </div>
      </div>
    </div>
</div>

<div class="gap-2 ">
    <form class="d-flex gap-2">
        <div class="input-group" style="width: 300px;">
            <input type="text" name="search" class="form-control search-chat py-2 px-5 ps-5"
                placeholder="Search">
            {{-- <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i> --}}
            <svg class="position-absolute top-50 translate-middle-y ms-3" xmlns="http://www.w3.org/2000/svg"
                width="25" height="25" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5q0-2.725 1.888-4.612T9.5 3q2.725 0 4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5q0-1.875-1.312-3.187T9.5 5Q7.625 5 6.313 6.313T5 9.5q0 1.875 1.313 3.188T9.5 14" />
            </svg>
            <button type="submit" class="btn btn-outline-primary px-4">Cari</button>
        </div>

        <div class="d-flex gap-2">
            <select name="status" class="form-select" id="search-status">
                <option value="">Pending</option>
                <option value="true">Blokir</option>
                <option value="false">Aktif</option>
            </select>
        </div>
    </form>
</div>


@forelse ($advertisements as $advertisement)
    <div class="card shadow-sm p-4 mt-4">
        <div class="row">
            <div class="col-md-12 col-lg-3">
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $advertisement->photo) }}" alt="" width="290px" height="180px" class="w-100" style="width: 100%; object-fit:cover;">
                </div>
            </div>
            <div class="row col-md-12 col-lg-6">
                <div class="row col-lg-6">
                    <div class="col-lg-6 mb-3">
                        <div class="fs-4 text-black">
                            Jenis Iklan:
                        </div>
                        <div class="fs-4 mt-2">{{ $advertisement->type }}</div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="fs-4 text-black">
                            Tanggal Awal:
                        </div>
                        <div class="fs-4 mt-2">{{ $advertisement->start_date }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fs-4 text-black">
                            Halaman:
                        </div>
                        <div class="fs-4 mt-2">{{ $advertisement->page }}</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fs-4 text-black">
                            Tanggal Akhir:
                        </div>
                        <div class="fs-4 mt-2">{{ $advertisement->end_date }}</div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="col-lg-12">
                        <div class="fs-4 text-black">
                            URL:
                        </div>
                        <div class="fs-4 mt-2">{{ $advertisement->url }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">

                <div class="d-flex justify-content-end gap-2">

                    @if ($advertisement->status === "reject")
                        <a href="" class="btn btn-sm m-0" style="background-color: #5D87FF;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512">
                                <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 0 0-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 0 0 0-17.47C428.89 172.28 347.8 112 255.66 112"/><circle cx="256" cy="256" r="80" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="32"/>
                            </svg>
                        </a>
                    @else
                        <div class="d-flex justify-content-end">
                            <div class="text-md-right">
                                <span class="badge bg-light-danger text-danger fs-4 px-3 py-2">
                                    Belum Dibayar
                                </span>
                            </div>
                        </div>
                    @endif

                    @if ($advertisement->status === "pending")
                        <div class="d-flex justify-content-end">
                            <div class="text-md-right">
                                <span class="badge bg-light-warning text-warning fs-4 px-3 py-2">
                                    Pending
                                </span>
                            </div>
                        </div>
                    @elseif ($advertisement->status === "reject")
                        <div class="d-flex justify-content-end">
                            <div class="text-md-right">
                                <span class="badge bg-light-danger text-danger fs-4 px-3 py-2">
                                    Ditolak
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-end">
                            <div class="text-md-right">
                                <span class="badge bg-light-success text-success fs-4 px-3 py-2">
                                    Ditolak
                                </span>
                            </div>
                        </div>
                    @endif
                </div>


                <div class="mt-5 d-flex justify-content-end">
                    <a href="{{route('status.detail.iklan')}}" class="btn btn-sm m-1 mt-5" style="background-color: #5D87FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512">
                            <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 0 0-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 0 0 0-17.47C428.89 172.28 347.8 112 255.66 112"/><circle cx="256" cy="256" r="80" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="32"/>
                        </svg>
                    </a>
                    <button class="btn btn-sm m-1 mt-5" style="background-color: #FFD643;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><path fill="#ffffff" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4q0 .375-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
                    </button>

                    <form action="{{ route('destroy.iklan' , ['id' => $advertisement->id]) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-sm m-1 mt-5" style="background-color: #C94F4F;"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512"><path d="M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z" fill="#ffffff"/></svg></button>
                    </form>
                </div>
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
            <h4>Tidak ada data</h4>
        </div>
    @endforelse


{{-- <div class="card p-4">
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <div class="">
                <img src="{{asset('assets/img/about/about-img-1.webp')}}" alt="" width="290px" height="180px" class="w-100" style="width: 100%; object-fit:cover;">
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <h4 class="mb-3">Jiraiya Banks Wants To Teach You How To Build...</h4>
            <p>Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print, graphic or web desi Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print…</p>

        </div>


        <div class="col-md-12 col-lg-3">

            <div class="d-flex justify-content-end">
                <div class="text-md-right">
                    <span class="badge bg-light-warning text-warning fs-4 px-3 py-2">
                        Pending
                    </span>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z" fill="#0f4d89"/>
                </svg>
                <p class="ms-2"> Apr 25, 2023</p>
            </div>

            <div class="mt-2 d-flex justify-content-end">
                <a href="" class="btn btn-sm m-1" style="background-color: #5D87FF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512">
                        <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 0 0-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 0 0 0-17.47C428.89 172.28 347.8 112 255.66 112"/><circle cx="256" cy="256" r="80" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="32"/>
                    </svg>
                </a>
                <button class="btn btn-sm m-1" style="background-color: #FFD643;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><path fill="#ffffff" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4q0 .375-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
                </button>

                <form action="" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm m-1" style="background-color: #C94F4F;"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512"><path d="M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z" fill="#ffffff"/></svg></button>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="card p-4">
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <div class="">
                <img src="{{asset('assets/img/about/about-img-1.webp')}}" alt="" width="290px" height="180px" class="w-100" style="width: 100%; object-fit:cover;">
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <h4 class="mb-3">Jiraiya Banks Wants To Teach You How To Build...</h4>
            <p>Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print, graphic or web desi Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print…</p>

        </div>


        <div class="col-md-12 col-lg-3">

            <div class="d-flex justify-content-end">
                <div class="text-md-right">
                    <a href="" class="btn btn-sm mb-1 me-1" style="background-color: #5D87FF;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="#ffffff" d="M12 3C6.5 3 2 6.58 2 11a7.218 7.218 0 0 0 2.75 5.5c0 .6-.42 2.17-2.75 4.5c2.37-.11 4.64-1 6.47-2.5c1.14.33 2.34.5 3.53.5c5.5 0 10-3.58 10-8s-4.5-8-10-8m0 14c-4.42 0-8-2.69-8-6s3.58-6 8-6s8 2.69 8 6s-3.58 6-8 6m5-5v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z"/></svg>
                    </a>

                    <span class="badge bg-light-danger text-danger fs-4 px-3 py-2">
                        Ditolak
                    </span>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z" fill="#0f4d89"/>
                </svg>
                <p class="ms-2"> Apr 25, 2023</p>
            </div>

            <div class="mt-2 d-flex justify-content-end">
                <a href="" class="btn btn-sm m-1" style="background-color: #5D87FF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512">
                        <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 0 0-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 0 0 0-17.47C428.89 172.28 347.8 112 255.66 112"/><circle cx="256" cy="256" r="80" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="32"/>
                    </svg>
                </a>
                <button class="btn btn-sm m-1" style="background-color: #FFD643;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><path fill="#ffffff" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4q0 .375-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
                </button>

                <form action="" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm m-1" style="background-color: #C94F4F;"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512"><path d="M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z" fill="#ffffff"/></svg></button>
                </form>
            </div>

        </div>

    </div>

</div>

<div class="card p-4">
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <div class="">
                <img src="{{asset('assets/img/about/about-img-1.webp')}}" alt="" width="290px" height="180px" class="w-100" style="width: 100%; object-fit:cover;">
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <h4 class="mb-3">Jiraiya Banks Wants To Teach You How To Build...</h4>
            <p>Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print, graphic or web desi Lorem ipsum or lipsum as it is sometmes known is dum text used in laying print…</p>

        </div>


        <div class="col-md-12 col-lg-3">

            <div class="d-flex justify-content-end">
                <div class="text-md-right">
                    <span class="badge bg-light-success text-success fs-4 px-3 py-2">
                        Diterima
                    </span>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z" fill="#0f4d89"/>
                </svg>
                <p class="ms-2"> Apr 25, 2023</p>
            </div>

            <div class="mt-2 d-flex justify-content-end">
                <a href="" class="btn btn-sm m-1" style="background-color: #5D87FF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="30" viewBox="0 0 512 512">
                        <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 0 0-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 0 0 0-17.47C428.89 172.28 347.8 112 255.66 112"/><circle cx="256" cy="256" r="80" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="32"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>

</div> --}}
@endsection
