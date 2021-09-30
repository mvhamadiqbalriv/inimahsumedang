@extends('layouts.back')
@section('title')
Instagram Feed
@endsection
@section('css')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<style>
    label.error {
        color: #f1556c;
        font-size: 13px;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 5px;
        padding: 0;
    }

    input.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }
</style>
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Instagram Feed</li>
                </ol>
            </nav>
            <h3>Instagram Feed</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-body">
                @if ($msg = Session::get('success'))
                <div class="alert alert-success">
                    {{$msg}}
                </div>
                @endif
                @if ($msg = Session::get('error'))
                <div class="alert alert-danger">
                    {{$msg}}
                </div>
                @endif
                <h5 class="card-title">Daftar Akun InstaFeed</h5>
                @if(count($instafeed))
                <button type="button" class="btn btn-info mb-1" disabled><i class="fa fa-plus-circle"></i> Tambah</button><br><br>
                @else
                <a href="{{route('users.create')}}" class="btn btn-info mb-1" data-toggle="modal"
                    data-target="#instaFeedTambah"><i class="fa fa-plus-circle"></i> Tambah</a><br><br>
                @endif
                <table id="instaFeedTable" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $increment = 1;
                        @endphp
                        @foreach($instafeed as $instafeeds)
                        <tr>
                            @php
                                $username = $instafeeds->username;
                            @endphp
                            <td>{{ $increment++ }}</td>
                            <td>{{ $instafeeds->username }}</td>
                            <td>
                                <div class="form-group">
                                    @php
                                    $feedToken = \App\Models\FeedToken::where('profile_id', $instafeeds->id)->first();
                                    @endphp
                                    @if($feedToken)
                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                        data-target="#instaFeedAmbil{{ $instafeeds->id }}">Refresh</button>
                                    @else
                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                        data-target="#instaFeedPerizinan{{ $instafeeds->id }}">Perizinan</button>
                                    @endif
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#confirmDeleteModal"
                                        onclick="getInstagramFeedId({{$instafeeds}})">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @php
        if (count(\Dymantic\InstagramFeed\Profile::all())) {
            $feed = \Dymantic\InstagramFeed\Profile::where('username', $username)->first()->feed();
        }
        @endphp
        @if(!empty($feed))
            @if(count($feed) >= 1)
            <div class="card">
                <div class="card-body">
                
                    @isset($feed)
                    <h5 class="card-title">Photo ({{ count($feed)}})</h5>
                    @foreach($feed as $post)
                    <img src="{{ $post['url']}}" class="img-fluid" width="100">
                    @endforeach
                    @endisset
                </div>
            </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="instaFeedTambah" tabindex="-1" role="dialog" aria-labelledby="instaFeedTambahTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instaFeedTambahTitle">Tambah Akun Instagram</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form class="form-horizontal" action="{{ route('instagram-feeds.store') }}" id="instaFeedTambahForm"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-12">
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan username instagram anda">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="tambahButton">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Perizinan -->
@foreach($instafeed as $instafeeds)
<div class="modal fade" id="instaFeedPerizinan{{ $instafeeds->id }}" tabindex="-1" role="dialog"
    aria-labelledby="instaFeedPerizinanTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instaFeedPerizinanTitle">Perizinan Akun Instagram</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            @php
            $perizinan = \Dymantic\InstagramFeed\Profile::where('username', $instafeeds->username)->first();
            $getPerizinanUrl = $perizinan->getInstagramAuthUrl();
            @endphp
            <div class="modal-body">
                <div class="row justify-content-between">
                    <div class="col-sm-12">
                        <p>Klik <b>Dapatkan izin instagram</b> untuk dialihkan kehalaman perizinan, pastikan untuk
                            mengeluarkan akun instagram terlebih dahulu (apabila ada) dan akun yang akan digunakan harus
                            sudah terdaftar di <b>instagram testers</b>.</p>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <a href="{{ $getPerizinanUrl }}" class="btn btn-primary" id="perizinanButton">Dapatkan
                    izin instagram</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Pengambilan -->
@foreach($instafeed as $instafeeds)
<div class="modal fade" id="instaFeedAmbil{{ $instafeeds->id }}" tabindex="-1" role="dialog"
    aria-labelledby="instaFeedAmbilTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instaFeedAmbilTitle">Ambil Feed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('instagram-feeds.getFeed') }}" method="post">
                @csrf
                <input type="hidden" name="username" value="{{ $instafeeds->username }}">
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-12">
                            <input type="number" class="form-control" min="0" name="limit" placeholder="Batas Feed" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ambilFeedButton">Refresh</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Hapus Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('instagram-feeds.destroy', '') }}" method="post" id="confirmDeleteForm">
                @csrf
                @method('delete')
                <div class="modal-body">
                    apakah anda yakin untuk menghapus <b> Username</b> ini ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="deleteButton">Ya, Hapus !</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@isset($was_successful)
@if($was_successful)
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Sekarang anda dapat menggunakan instafeed!',
    }).then(function(){
        window.location = "{{ route('instagram-feeds.index') }}";
    });
</script>
@else
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Gagal untuk mendapatkan izin instagram feed!',
        })
</script>
@endif
@endisset
@endsection
@section('js')

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('#instaFeedTable').DataTable( {
        responsive: true
    });
} );
</script>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#instaFeedTambahForm").validate({
                rules: {
                    username:{
                        required: true,
                        minlength: 1,
                        remote: {
                                url: "{{ route('instagram-feeds.checkUsername') }}",
                                type: "post",
                        }
                    },
                },
                messages: {
                    username: {
                        required: "Username harus di isi",
                        minlength: "Username tidak boleh kurang dari 1 karakter",
                        remote: "Username sudah digunakan"
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                    $('#tambahButton').prop('disabled', true);
                }
            });
        });

    function setPerizinanData(data) {
        alert(data);
    }

    const instaFeedFormUrl = $("#confirmDeleteForm").attr('action');
    function getInstagramFeedId(data) {
        $("#confirmDeleteForm").attr('action', `${instaFeedFormUrl}/${data.id}`);
    }

   
    // checks
    

</script>
@endsection