@extends('layouts.admin.app')

@section('style')
    <style>
        .table-border{
            border: 1px solid #DADADA;
            border-radius: 5px;
            /* padding: 25px; */
        }
    </style>
@endsection

@section('content')
<div class="">
    <div class="d-flex gap-2 mb-3 mt-2">
        <form class="d-flex gap-2">
            <div>
                <div class="position-relative d-flex">
                    <div class="">
                        <input type="text" name="search"
                            class="form-control search-chat py-2 ps-5" style="width: 200px" id="search-name" placeholder="Search">
                        <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                    </div>
                </div>
            </div>

            <div>
                <div class="d-flex gap-2">
                    <select class="form-select" id="opsi-latest" style="width: 200px">
                        <option value="">Tampilkan semua</option>
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                </div>
            </div>

            <div>
                <div class="d-flex gap-2">
                    <select class="form-select" name="perpage" id="opsi-perpage" style="width: 200px">
                        <option selected value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

        <div class="table-responsive rounded-2 mt-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="background-color: #D9D9D9; border-radius: 5px 0 0 5px;">No</th>
                        <th style="background-color: #D9D9D9;">Penulis</th>
                        <th style="background-color: #D9D9D9;">Email</th>
                        <th style="background-color: #D9D9D9;">Judul berita</th>
                        <th style="background-color: #D9D9D9;">Tanggal Upload</th>
                        <th style="background-color: #D9D9D9; border-radius: 0 5px 5px 0;">Option</th>
                    </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
        <div id="loading"></div>
        <div class="d-flex mt-4 justify-content-end">
            <nav id="pagination">
            </nav>
        </div>

        <x-delete-modal-component />
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pzjw8V+VbWFr6J3QKZZxCpZ8F+3t4zH1t03eNV6zEYl5S+XnvLx6D5IT00jM2JpL" crossorigin="anonymous">
</script>

<script>
    $(document).ready(function() {
        $('#synopsis').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    get(1)
        let debounceTimer;

        $('#search-name').keyup(function() {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(function() {
                get(1)
            }, 500);
        });

        $('#opsi-latest').change(function() {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(function() {
                get(1)
            }, 500);
        });

        $('#opsi-perpage').change(function() {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(function() {
                get(1)
            }, 500);
        });

        
        function splitDate(dateString) {
            const months = {
                "Januari": 1,
                "Februari": 2,
                "Maret": 3,
                "April": 4,
                "Mei": 5,
                "Juni": 6,
                "Juli": 7,
                "Agustus": 8,
                "September": 9,
                "Oktober": 10,
                "November": 11,
                "Desember": 12
            };

            const dateParts = dateString.split(' ');

            const day = parseInt(dateParts[0]);
            const month = months[dateParts[1]];
            const year = parseInt(dateParts[2]);

            return {
                day,
                month,
                year
            };
        }

        function get(page) {
            $.ajax({
                url: "{{ route('list.approved.index') }}?page=" + page,
                method: 'Get',
                dataType: "JSON",
                data:{
                    category:$('#search-name').val(),
                    latest:$('#opsi-latest').val(),
                    perpage:$('#opsi-perpage').val()
                },
                beforeSend: function() {
                    $('#data').html("")
                    $('#loading').html(showLoading())
                    $('#pagination').html('')
                },
                success: function(response) {
                    var category = response.data.data
                    var latest = response.data.data
                    var perpage = response.data.data
                    $('#loading').html("")
                    if (response.data.data.length > 0) {
                        $.each(response.data.data, function(index, data) {
                            $('#data').append(rowNewsApproved(index, data))
                        })
                        $('#pagination').html(handlePaginate(response.data.paginate))


                        $('.btn-edit').click(function() {
                            var CategoryId = $(this).data('id');
                            var data = category.find(category => category.id === CategoryId)

                            setFormValues('form-update', data)
                            $('#form-update').data('id', data['id'])

                            $('#modal-update').modal('show')
                        })

                        $('.btn-delete').click(function() {
                            $('#form-delete').data('id', $(this).data('id'))
                            $('#modal-delete').modal('show')
                        })
                    } else {
                        $('#loading').html(showNoData('Tidak ada data'))
                    }
                }
            })
        }

        function rowNewsApproved(index, data) {
            function limitString(str, maxLength) {
                return str.length > maxLength ? str.substring(0, maxLength) + '...' : str;
            }
            let pinned;
            if (data.pin == 1) {
                pinned=` <a class="" data-bs-toggle="tooltip" title="Berita di Pin">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24"><path fill="#000" d="M16 3a1 1 0 0 1 .117 1.993L16 5v4.764l1.894 3.789a1 1 0 0 1 .1.331L18 14v2a1 1 0 0 1-.883.993L17 17h-4v4a1 1 0 0 1-1.993.117L11 21v-4H7a1 1 0 0 1-.993-.883L6 16v-2a1 1 0 0 1 .06-.34l.046-.107L8 9.762V5a1 1 0 0 1-.117-1.993L8 3z"/></svg>
        </a>`
            }else{
                pinned=``
            }
            dateParts = splitDate(data.upload_date)
            return `
            <tr>
                <td>${index + 1}</td>
                <td>${data.author_name}</td>
                <td>${data.email}</td>
                <td>${limitString(data.name, 25)}</td>
                <td>${data.upload_date}</td>
                <td>
                    <button data-id="${data.id}" type="submit" style="background-color: #EF6E6E"
                        class="btn btn-sm btn-delete text-white ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="#ffffff" d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5q0-.425.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5q0 .425-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-7 11q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8q-.425 0-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8q-.425 0-.712.288T13 9v7q0 .425.288.713T14 17M7 6v13z"/></svg>
                    </button>
                        <a href="${dateParts['year']}/${dateParts['month']}/${dateParts['day']}/${data.slug}" data-id="${data.id}" data-bs-toggle="tooltip" title="Detail" class="btn btn-sm btn-primary btn-detail" style="background-color: #0F4D8A;">
                            <i><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6.5a9.77 9.77 0 0 1 8.82 5.5c-1.65 3.37-5.02 5.5-8.82 5.5S4.83 15.37 3.18 12A9.77 9.77 0 0 1 12 6.5m0-2C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5m0 5a2.5 2.5 0 0 1 0 5a2.5 2.5 0 0 1 0-5m0-2c-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5s4.5-2.02 4.5-4.5s-2.02-4.5-4.5-4.5"/></svg></i>
                        </a>
                        ${pinned}
                </td>
            </tr>
        `
        }

        $('#form-delete').submit(function(e) {
            $('.preloader').show()
            e.preventDefault()
            const id = $(this).data('id')
            $.ajax({
                url: "delete-news-profile/" + id,
                type: 'POST',
                data:$(this).serialize(),
                success: function(response) {
                    $('.preloader').fadeOut()
                    get(1)
                    $('#modal-delete').modal('hide')
                    Swal.fire({
                        title: 'Berhasil!',
                        icon: 'success',
                        text: response.message
                    })
                },
                error: function(response) {
                    $('.preloader').fadeOut()
                }
            })
        })

        $('#form-update').submit(function(e) {
            $('.preloader').show()
            e.preventDefault()
            const id = $(this).data('id')
            $.ajax({
                url: "kategori/" + id,
                type: 'PUT',
                data:$(this).serialize(),
                success: function(response) {
                    $('.preloader').fadeOut()
                    get(1)
                    $('#modal-update').modal('hide')
                    Swal.fire({
                        title: 'Berhasil!',
                        icon: 'success',
                        text: response.message
                    })
                },
                error: function(response) {
                    $('.preloader').fadeOut()
                }
            })
        })

</script>
@endsection
