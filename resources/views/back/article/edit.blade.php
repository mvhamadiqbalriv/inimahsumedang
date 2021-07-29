@extends('layouts.back')
@section('title')
Edit Artikel
@endsection
@section('content')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/articles') }}">Artikel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h3>Edit Artikel</h3>
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
                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data"
                    style="width: 100%;" id="articleForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul"
                            value="{{ old('judul', $article->judul) }}">
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
                        <input type="hidden" name="gambar" id="gambar"
                            class="form-control @error('gambar') is-invalid @enderror"
                            value="{{ old('gambar',$article->gambar) }}">
                        @error('election')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="konten" id="konten"
                            class="form-control @error('konten') is-invalid @enderror">{{ old('konten',$article->konten) }}</textarea>
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
                    <div class="form-group @error('category') has-error @enderror">
                        <select class="category form-control @error('category') is-invalid @enderror" name="category"
                            id="category">
                            @if(!empty($article->category))
                            <option value="{{ $article->category }}">
                                {{ $article->categories->nama }}
                            </option>
                            @endif
                        </select>
                        @error('category')
                        <style>
                            .has-error .select2-selection {
                                border: 1px solid #dc3545 !important;
                            }
                        </style>
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group @error('tag') has-error @enderror">
                        <select class="tag form-control" name="tag" name="tag[]" multiple="multiple" id="tag"
                            tabindex="-1">
                            @if(!empty($article->tag))
                            <option value="{{ $article->tag }}">
                                {{ $article->tag }}
                            </option>
                            @endif
                        </select>

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
                            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i>
                                Submit</button>

                        </div>
                        <div class="col text-right">
                            <a href="{{ route('articles.index') }}" class="btn btn-lg btn-secondary"><i
                                    class="fa fa-back"></i>
                                Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>
    // passing data to select option tag
    $(".editButton").click(function() {
        var idAsValue = $(this).attr('data-role');
        $("#edit_role").val(idAsValue);
    });

</script>
<script>
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