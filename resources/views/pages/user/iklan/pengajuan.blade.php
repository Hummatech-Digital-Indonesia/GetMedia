@extends('layouts.user.sidebar')

@section('style')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/dist/imageuploadify.min.css') }}">
<style>
    .card.active {
        border: 1px solid #175A95;
        box-shadow: 0 1px 5px #175A95;
    }
    .selected-image {
        box-shadow: 0 1px 5px #175A95;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm position-relative overflow-hidden"  style="background-color: #175A95;">
    <div class="card-body px-4 py-4">
      <div class="row justify-content-between">
        <div class="col-8 text-white">
          <h4 class="fw-semibold mb-3 mt-2 text-white">Pengisian Iklan</h4>
            <p>Layanan pengiklanan di getmedia.id</p>
        </div>
        <div class="col-3">
          <div class="text-center mb-n4">
            <img src="{{asset('assets/img/bg-ajuan.svg')}}" width="250px" alt="">
          </div>
        </div>
      </div>
    </div>
</div>

<form action="{{route('advertisement.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="d-flex justify-content-between mb-3">
        <h5>Isi form dibawah ini untuk konten iklan</h5>
        <button type="submit" class="btn btn-md text-white" style="background-color: #175A95;">
            Upload
        </button>
    </div>

    <div class="card p-4 pb-5 shadow-sm">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <label class="form-label" for="page">Halaman</label>
                <select name="page" class="form-select" id="">
                    <option value="dashboard">Dashboard</option>
                    <option value="news_post">News Post</option>
                    <option value="sub_category">Sub Kategori</option>
                </select>
            </div>
            <div class="col-lg-6 mb-4">
                <label class="form-label" for="type">Jenis Iklan</label>
                <select name="type" class="form-select" id="">
                    <option value="foto">Foto</option>
                    <option value="vidio">Vidio</option>
                </select>
            </div>

            <div class="col-lg-12 mb-4">
                <label for="position" class="form-label">Posisi Iklan</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="inlineRadio1" value="full_horizontal">
                        <label class="form-check-label" for="inlineRadio1">
                            <p class="ms-2">Posisi Tengah Full (1770 x 166)</p>
                            <img src="{{asset('assets/img/full-horizontal.png')}}" width="300" height="200" alt="">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="inlineRadio2" value="horizontal">
                        <label class="form-check-label" for="inlineRadio2">
                            <p class="ms-2">Posisi Kanan (456 x 654)</p>
                            <img src="{{asset('assets/img/iklan-vertikal.svg')}}" width="300" height="200" alt="">
                        </label>
                    </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="inlineRadio3" value="vertikal">
                        <label class="form-check-label" for="inlineRadio3">
                            <p class="ms-2">Posisi Kiri (1245 x 295)</p>
                            <img src="{{asset('assets/img/iklan-horizontal.svg')}}" width="300" height="200" alt="">
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <label class="form-label" for="start_date">Tanggal Awal</label>
                <input type="date" id="start_date" name="start_date" placeholder=""
                    value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror">
                @error('start_date')
                    <span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-6 mb-4">
                <label class="form-label" for="end_date">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" placeholder=""
                    value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date')
                    <span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-12 mb-4">
                <label class="form-label" for="url">URL</label>
                <input type="text" id="url" name="url" placeholder="masukan url"
                    value="{{ old('url') }}" class="form-control @error('url') is-invalid @enderror">
                @error('url')
                    <span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-12 mb-4">
                <label class="form-label" for="photo">Kontent</label>
                <input type="file" id="photo" name="photo" onchange="previewImage(event)" placeholder=""
                    value="{{ old('photo') }}" class="form-control @error('photo') is-invalid @enderror">
                @error('photo')
                    <span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="gambar-iklan">
                <label class="form-label" for="preview">Preview</label>
                <div class="">
                    <img id="preview" style="object-fit: cover;" width="240" height="160" alt="">
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@section('script')

<script src="{{ asset('assets/dist/imageuploadify.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#image-uploadify').imageuploadify();
    })

    function selectCard(selectedCard) {
        var cards = document.querySelectorAll('.card-act');

        cards.forEach(function(card) {
            card.classList.remove('active');
        });

        selectedCard.classList.add('active');
    }


    function selectCard(card) {
        var radioButton = card.querySelector('input[type="radio"]');

        if (!radioButton.checked) {
            radioButton.checked = true;

            var cards = document.querySelectorAll('.card');
            cards.forEach(function(card) {
                card.classList.remove('border-blue');
            });

            card.classList.add('border-blue');
        }
    }

    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var imgElement = document.getElementById("preview");
            imgElement.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }

    document.addEventListener("DOMContentLoaded", function() {
        var radios = document.querySelectorAll('.form-check-input');

        function updateImageSelection() {
            // Hilangkan class selected dari semua gambar
            document.querySelectorAll('.selectable-image').forEach(img => {
                img.classList.remove('selected-image');
            });

            // Tambahkan class selected hanya pada gambar yang terkait dengan radio button yang dipilih
            radios.forEach(radio => {
                if (radio.checked) {
                    const img = radio.nextElementSibling.querySelector('img');
                    if (img) {
                        img.classList.add('selected-image');
                    }
                }
            });
        }

        // Tambahkan event listener untuk setiap radio button
        radios.forEach(radio => {
            radio.addEventListener('change', updateImageSelection);
        });

        // Update seleksi saat memuat halaman jika ada radio yang sudah dipilih
        updateImageSelection();
    });
</script>
@endsection
