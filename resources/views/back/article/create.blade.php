@extends('layouts.back')
@section('title')
Tambah Artikel
@endsection
@section('content')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
    integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropify-wrapper {
        border: 1px solid #e2e7f1 !important;
        border-radius: .3rem !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/articles') }}">Artikel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
            <h3>Tambah Artikel</h3>
        </div>
    </div>
</div>
<style>
    .cke_chrome {
        border: 1px solid #e9e9e9;
        border-width: thin;
    }
</style>
<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data"
                    style="width: 100%;" id="articleForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul"
                            value="{{ old('judul') }}">
                        @error('judul')
                        <style>
                            #judul {
                                border: 1px solid #dc3545 !important;
                            }
                        </style>
                        <div class="mt-1">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <textarea name="konten" id="konten"
                                    class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                                @error('konten')
                                <style>
                                    .cke_chrome {
                                        border: 1px solid #dc3545 !important;
                                        border-width: thin;
                                    }
                                </style>
                                <div class="mt-1">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <input type="file" class="form-control dropify mt-5" name="gambar" id="gambar"
                                    data-allowed-file-extensions="png jpg jpeg">
                            </div>
                        </div>

                    </div>
                    <div class="form-group @error('category') has-error @enderror">
                        <select class="category form-control" name="category" id="category"></select>
                        @error('category')
                        <style>
                            .has-error .select2-selection {
                                border: 1px solid #dc3545 !important;
                            }
                        </style>
                        <div class="mt-1">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group @error('tag') has-error @enderror">
                        <select class="tag form-control" name="tag" name="tag[]" multiple="multiple" id="tag"
                            tabindex="-1"></select>
                        @error('tag')
                        <style>
                            .has-error .select2-selection {
                                border: 1px solid #dc3545 !important;
                            }
                        </style>
                        <div class="mt-1">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col text-sm-left">
                            <button type="submit" class="btn btn-lg btn-primary" id="buttonSubmit"><i
                                    class="fa fa-plus-circle"></i>
                                Submit</button>

                        </div>
                        <div class="col text-right">
                            <button type="button" data-toggle="modal" data-target="#confirmDeleteModal"
                                class="btn btn-lg btn-secondary"><i class="fa fa-back"></i>
                                Kembali</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Peringatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('articles.draf') }}" method="POST" enctype="multipart/form-data" id="drafForm">
                    @csrf
                    <input type="hidden" name="judul" id="judulDraf">
                    <input type="hidden" name="slug" id="slugDraf">
                    <input type="hidden" name="gambar" id="gambarDraf">
                    <input type="hidden" name="konten" id="kontenDraf">
                    <input type="hidden" name="category" id="categoryDraf">
                    <input type="hidden" name="tag" id="tagDraf">
                </form>
                apakah anda akan memasukan postingan ini ke draf <b id="namaItemModal"></b> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="submitForm" onclick="submitForm()">Ya, Masukkan
                    !</button>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Tidak</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
    integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.dropify').dropify();
</script>
<script>
    $('#articleForm').submit(function(){
    $("#buttonSubmit", this)
      .html("Please Wait...")
      .attr('disabled', 'disabled');
    return true;
});
    $(document).ready(function() {
        $("#submitForm").click(function() {
            var judul = $("#judul").val();
            $("#judulDraf").val(judul);

            var slug = $("#slug").val();
            $("#slugDraf").val(slug);

            var gambar = $("#gambar").val();
            $("#gambarDraf").val(gambar);

            var konten = CKEDITOR.instances['konten'].getData();
            $("#kontenDraf").val(konten);

            var category = $("#category").val();
            $("#categoryDraf").val(category);
            
            var tag = $("#tag").val();
            $("#tagDraf").val(tag);

            $("#drafForm").submit();
        });
      });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(".tag").select2({
        placeholder: 'Pilih Tag',
        tags: true,
        tokenSeparators: [',', ' ']
    });
</script>

<script type="text/javascript">
    $('.category').select2({
        placeholder: 'Cari Kategori',
        ajax: {
            url: '/ajax-autocomplete-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>

<script>
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
</script>
<script>
    CKEDITOR.replace('konten', options);
</script>



@endsection