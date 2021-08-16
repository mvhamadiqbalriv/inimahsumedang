@extends('layouts.back')
@section('title')
Article
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
    .shadow-nones:hover {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    input[type='checkbox'] {
        cursor: pointer;
    }

    .status {
        border: 1px solid rgb(219, 219, 219);
        color: #37414d;
        border-radius: 5px;
        font-size: 13px;
        padding: 6px 6px;
        cursor: pointer;
    }

    .dropdown-item {
        color: rgb(2, 59, 104) !important;
    }

</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                </ol>
            </nav>
            <h3>Artikel</h3>
        </div>
    </div>
</div>


<div class="row justify-content-between" id="one">
    <div class="col-6">
        <form action="{{ route('articles.filterArticle') }}" method="post">
            @csrf
            <select name="status" class="status" onchange="this.form.submit()">
                <option value="all" @if($status=='all' ) selected @endif>Semua ({{ $count_all }})</option>
                <option value="0" @if($status=='0' ) selected @endif>Draft ({{ $count_draft }})</option>
                <option value="1" @if($status=='1' ) selected @endif>Dipublikasikan ({{ $count_published }})</option>
            </select>
        </form>
    </div>
    <div class="col-6 d-flex justify-content-end" id="two">
        <input type="checkbox" id="checkAll" autocomplete="off">
        <label class="mt-2 mr-4" id="checkDelete">
            <a href="#" data-toggle="modal" id="checkboxDelete"
                style="font-size: 14px; color: rgba(159, 159, 159, 0.54); pointer-events: none;"
                data-target="#confirmDeleteAllModal"><i class="fas fa-trash" data-toggle="tooltip"
                    data-placement="bottom" data-original-title="Hapus article yang dipilih"></i></a></label>
  
        <button class="btn btn-light text-right" id="kelola" @if($count_all < 1) disabled @endif><i
                class="fas fa-cog"></i></button>
    </div>
</div>
<br>

<div class="row justify-content-between">
    <div class="col-6">
        <a href="{{ route('articles.create') }}" class="btn btn-dark"> Postingan Baru</a>
    </div>
</div>
<br>

<form method="post" action="{{ route('articles.deleteAll') }}" id="checkboxDeleteForm">
    @csrf
    @foreach($article as $articles)
    <div class="row" id="ones">
        <div class="col-xl" id="twos">
            <div class="card shadow-nones" id="threes">
                <a href="{{ route('articles.edit', $articles->id) }}" class="articleCard" data-id="{{$articles->id}}" onmouseover="hoverArticleCardIn(this)" onmouseout="hoverArticleCardOut(this)">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="left d-flex">
                                <object style="margin-top: 22px;"><a href="javascript:void(0);"><input name='id[]'
                                            type="checkbox" id="checkbox" value="{{ $articles->id }}"
                                            autocomplete="off"></object>
                                @if ($articles->gambar)
                                <img src="{{ Storage::url($articles->gambar) }}"
                                    style="border-radius:5px; width:70px; height:65px; object-fit: cover;">
                                @else
                                <div id="firstLetter"
                                    style="border: 1px solid rgba(230, 229, 229, 0.87); border-radius:5px; width:60px; height:65px; text-align:center; font-size:40px; text-transform:capitalize; object-fit:cover;">
                                    @if(!empty($articles->judul))
                                    {{ substr($articles->judul, 0, 1) }}
                                    @else
                                    T
                                    @endif
                                </div>
                                @endif

                                <div class="ml-3">
                                    @if(empty($articles->judul))
                                    <p class="text-muted">(Tanpa Judul)</p>
                                    @else
                                    <p class="text-muted" id="judul">{{ Str::limit($articles->judul, 75) }}</p>
                                    @endif
                                    @php
                                    $month = 8;
                                    @endphp
                                    <style>
                                        .draft {
                                            color: rgb(250, 149, 33);
                                        }
                                    </style>
                                    <p class="statusAndDate">
                                        @if($articles->is_publish == '0')
                                        <span class="draft">Draft</span> .
                                        @else
                                        <span class="published">Telah dipublish .</span>
                                        @endif
                                        {{ $articles->updated_at->format('d M') }}</p>
                                </div>
                            </div>
                            <style>
                                #icon {
                                    display: none;
                                }

                                #icon a i {
                                    color: rgb(108, 117, 125) !important;
                                }

                                #icon:hover {
                                    transform: scale(1.1);
                                }
                            </style>
                          
                            <div class="right" id="what">
                                <div class="d-flex justify-content-end text-right">
                                    @if($articles->is_publish == '1')
                                    <object id="icon" class="icon{{$articles->id}}" style="padding: 0 6px;" 
                                        data-placement="bottom"
                                            data-toggle="modal" data-target="#confirmIsPublishModal"
                                            onclick="return setData({{$articles}}, 0, 'apakah anda yakin untuk mengembalikan <b>article</b> ini sebagai draft ? ', 'Ya, Kembalikan !')"><i
                                                class="fas fa-chevron-circle-right"
                                                style="font-size: 14px;"></i></object>
                                    @else
                                    <object style="padding: 0 6px;">
                                        <a href="#" id="icon" class="icon{{$articles->id}}" data-toggle="modal" @if (empty($articles->judul) || empty($articles->konten))
                                            data-target="#confirmIsPublishModalAlert{{ $articles->id }}"
                                            @else
                                            data-target="#confirmIsPublishModal"
                                            @endif
                                            onclick="return setData({{$articles}}, 1, 'apakah anda yakin untuk mempublish <b>article</b> ini ? ', 'Ya, Publish !')"><i
                                                class="fas fa-arrow-circle-right"
                                                style="font-size: 14px;"></i></a></object>
                                    @endif
                                    
                                    <object style="padding: 0 6px;">
                                        <a href="#" id="icon" class="icon{{$articles->id}}" 
                                            data-toggle="modal" data-target="#confirmDeleteModal" onclick="return setData2({{$articles}})">
                                            <i class="fas fa-trash" style="font-size: 14px;"></i>
                                        </a>
                                    </object>
                                    <object id="icon" class="icon{{$articles->id}}"style="padding: 0 6px;">
                                             <a href="{{ route('articles.preview', $articles->slug) }}" ><i class="far fa-eye" style="font-size: 14px;"></i></a>
                                    </object>
                                    
                                    <p style="padding-left: 6px;" class="iniaja">
                                        {{ ucfirst(trans(Auth::user()->name)) }}</p>
                                    <object>
                                        <div class="dropdown dropleft" style="display: none;">
                                            <button class="btn" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v" style="color:rgb(2, 59, 104);"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                                <a class="dropdown-item" href="#">Preview</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#confirmDeleteModal"
                                                    onclick="return setData2({{$articles}})">Hapus</a>
                                                <a class="dropdown-item" href="#">Label</a>
                                                @if($articles->is_publish == '1')
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#confirmIsPublishModal"
                                                    onclick="return setData({{$articles}}, 0, 'apakah anda yakin untuk mengembalikan <b>article</b> ini sebagai draft ? ', 'Ya, Kembalikan !')">Kembalikan
                                                    ke draf</a>
                                                @else
                                                <a class="dropdown-item" href="#" data-toggle="modal" @if (empty($articles->judul) ||
                                                    empty($articles->konten))
                                                    data-target="#confirmIsPublishModalAlert{{ $articles->id }}"
                                                    @else
                                                    data-target="#confirmIsPublishModal"
                                                    @endif
                                                    onclick="return setData({{$articles}}, 1, 'apakah anda yakin untuk mempublish <b>article</b> ini ? ', 'Ya, Publish !')">Publish</a>
                                                @endif
                                            </div>
                                        </div>
                                    </object>
                                </div>
                                <div class="icons d-flex justify-content-end">
                                    <object data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Jumlah Komentar"><a href="" class="mr-3">0 <i
                                                class="fa fa-comments"></i></a></object>
                                    <object data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Jumlah Pembaca"><a href="">0 <i
                                                class="fa fa-chart-bar"></i></a></object>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</form>
<div class="d-flex justify-content-center">
    {{ $article->links('vendor.pagination.custom')}}
</div>

@if(empty($article))
    <br>
    <h4 class="text-center"><b>Artikel</b> belum tersedia!</h4><br><br>
@endif
<!-- Modal isPublish Alert -->
@foreach ($article as $articles)
<div class="modal fade" id="confirmIsPublishModalAlert{{ $articles->id }}" tabindex="-1" role="dialog"
    aria-labelledby="confirmDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Edit Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <b>Judul</b> dan <b>konten</b> dari artikel ini tidak boleh kosong! apabila anda ingin mempublish
                artikel ini.
            </div>
            <div class="modal-footer">
                <a href="{{ route('articles.edit', $articles->id) }}" class="btn btn-dark">Edit</a>
                <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                    Kembali
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Publish -->
<div class="modal fade" id="confirmIsPublishModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Edit Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('articles.isPublish', '') }}" method="post" id="confirmIsPublishForm">
                @csrf
                <input type="hidden" name="is_publish" id="is_publish_value" value="">
                <div class="modal-body" id="modal-body-publish">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark" id="buttonPublish"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal delete all -->
<div class="modal fade" id="confirmDeleteAllModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Hapus article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                apakah anda yakin untuk menghapus semua <b id="namaItemModal">article</b> yang dipilih ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delete">Ya, Hapus !</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Hapus article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('articles.destroy', '') }}" method="post" id="confirmDeleteForm">
                @csrf
                @method('delete')
                <div class="modal-body">
                    apakah anda yakin untuk menghapus <b id="namaItemModal">article</b> ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya, Hapus !</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  $('.iniaja').css('display', 'none');
  $('.dropdown').css('display', 'block');
  $('.statusAndDate').css('font-size', '11px');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(".tag").select2({
        placeholder: 'Pilih Tag',
        tags: true,
        tokenSeparators: [',', ' ']
    });
</script>

<script>
    function hoverArticleCardIn(element)
    {
        var id = $(element).attr('data-id');
        $(".icon" + id).css("display", "block");
    }

    function hoverArticleCardOut(element)
    {
        var id = $(element).attr('data-id');
        $(".icon" + id).css("display", "none");
    }

    function previewForm(element)
    {
        var articleId = $(element).attr('data-id');
        $("#nomorArtikel").val(articleId);
        console.log(articleId);
        $("#previewForm").submit();
    }
</script>

<script>
$(document).ready(function(){
    $("#delete").click(function () {
        $('#checkboxDeleteForm').submit();
	});
 
    $('#checkAll').click(function(){
            if($(this).is(":checked")){
                console.log("Checkbox is checked.");
                $("#checkboxDelete").css("color", "rgb(2, 59, 104)");
                $("#checkboxDelete").css("pointer-events", "");
                $("#checkboxPublish").css("color", "rgb(2, 59, 104)");
                $("#checkboxPublish").css("pointer-events", "");
                $('#checkDelete').removeAttr('data-toggle');
                $('[data-toggle="tooltip"]').tooltip();
            }
            else if($(this).is(":not(:checked)")){
                console.log("Checkbox is unchecked.");
                $("#checkboxDelete").css("color", "rgba(159, 159, 159, 0.54)");
                $("#checkboxDelete").css("pointer-events", "none");
                $("#checkboxPublish").css("color", "rgba(159, 159, 159, 0.54)");
                $("#checkboxPublish").css("pointer-events", "none");
            }
        });

    $('input:checkbox').css('display', 'none');
    $('#checkDelete').css('display', 'none');
    $("#kelola").click(function () {
        $('input:checkbox').not(this).toggle();
        $('#checkDelete').toggle();
        $('input:checkbox').not(this).css('margin-right', '22px');
    });
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
});    
</script>
<script>
    const updateLink = $('#confirmIsPublishForm').attr('action');
    const editLink = $('#editLink').attr('href');
    var isPublishValue = $('#drafValue').data('publish');
    function setData(articles, value, modalBody, buttonPublish) {
        $('#confirmIsPublishForm').attr('action',  `${updateLink}/${articles.id}`);
        $('#editLink').attr('href',  `${editLink}/${articles.id}`);
        $('#is_publish_value').val(value);
        $('#modal-body-publish').html(modalBody);
        $('#buttonPublish').html(buttonPublish);
    }
</script>

<script>
    const updateLink2 = $('#confirmDeleteForm').attr('action');
    function setData2(articles) {
        $('#confirmDeleteForm').attr('action',  `${updateLink2}/${articles.id}`);
    }
</script>

<script>
    const updateLink3 = $('#tagForm').attr('action');
    function setData3(articles) {
        $('#tagForm').attr('action',  `${updateLink3}/${articles.id}`);
    }
</script>
@endsection