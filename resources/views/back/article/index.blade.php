@extends('layouts.back')
@section('title')
Article
@endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
    .shadow-nones:hover {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    input[type='checkbox'] {
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Article</li>
                </ol>
            </nav>
            <h3>Article</h3>
        </div>
    </div>
</div>

<div class="row justify-content-between" id="one">
    <div class="col-6">
        <div class="dropdown">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="outline: ">
                Semua ({{ $count_all }})
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="">Semua ({{ $count_all }})</a>
                <a class="dropdown-item" href="#">Dipublikasikan ({{ $count_published }})</a>
                <a class="dropdown-item" href="#">Draft ({{ $count_draft }})</a>
            </div>
        </div>
    </div>
    <div class="col-6 d-flex justify-content-end" id="two">
        <input type="checkbox" id="checkAll" autocomplete="off">
        <label class="mt-2 mr-4" id="checkDelete">
            <a href="#" data-toggle="modal" id="checkboxDelete"
                style="font-size: 14px; color: rgba(159, 159, 159, 0.54); pointer-events: none;"
                data-target="#confirmDeleteAllModal"><i class="fas fa-trash" data-toggle="tooltip"
                    data-placement="bottom" data-original-title="Hapus article yang dipilih"></i></a></label>
        <label class="mt-2 mr-4" id="checkPublish">
            <a href="#" data-toggle="modal" id="checkboxPublish"
                style="font-size: 14px; color: rgba(159, 159, 159, 0.54); pointer-events: none;"
                data-target="#confirmDeleteAllModal" onclick="return setData()"><i class="fas fa-arrow-circle-right"
                    data-toggle="tooltip" data-placement="bottom" data-original-title="Publikasikan"></i></a></label>
        <button class="btn btn-light text-right" id="kelola" @if($count_all < 1) disabled @endif>Kelola</button>
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
                <a href="{{ route('articles.edit', $articles->id) }}" class="articleCard">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="left d-flex">
                                <object style="margin-top: 22px;"><a href="javascript:void(0);"><input name='id[]'
                                            type="checkbox" id="checkbox" value="{{ $articles->id }}"
                                            autocomplete="off"></object>

                                <div id="firstLetter"
                                    style="border: 1px solid rgba(230, 229, 229, 0.87); border-radius:5px; width:60px; height:65px; text-align:center; font-size:40px; text-transform:capitalize;">
                                    @if(!empty($articles->judul))
                                    {{ substr($articles->judul, 0, 1) }}
                                    @else
                                    T
                                    @endif
                                </div>
                                <div class="ml-3">
                                    @if(empty($articles->judul))
                                    <p class="text-muted">(Tanpa Judul)</p>
                                    @else
                                    <p class="text-muted" id="judul">{{ $articles->judul }}</p>
                                    @endif
                                    @php
                                    $month = 8;
                                    @endphp
                                    <style>
                                        .draft {
                                            color: rgb(250, 149, 33);
                                        }
                                    </style>
                                    <p>
                                        @if($articles->is_publish == '0')
                                        <span class="draft">Draft</span> .
                                        @else
                                        <span class="published">Telah dipublish .</span>
                                        @endif
                                        {{ $articles->created_at->format('d M') }}</p>
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
                                    <object id="icon" class="icon" style="padding: 0 6px;" data-toggle="tooltip"
                                        data-placement="bottom" data-original-title="Kembalikan ke draf"><a href=""
                                            data-toggle="modal" data-target="#confirmIsPublishModal"
                                            onclick="return setData({{$articles}}, 0, 'apakah anda yakin untuk mengembalikan <b>article</b> ini sebagai draft ? ', 'Ya, Kembalikan !')"><i
                                                class="fas fa-chevron-circle-right"
                                                style="font-size: 14px;"></i></object>
                                    @else
                                    <form action="" method="post">
                                        <object id="icon" class="icon" style="padding: 0 6px;" data-toggle="tooltip"
                                            data-placement="bottom" data-original-title="Publikasikan"><a href="#"
                                                data-toggle="modal" data-target="#confirmIsPublishModal"
                                                onclick="return setData({{$articles}}, 1, 'apakah anda yakin untuk mempublish <b>article</b> ini ? ', 'Ya, Publish !')"><i
                                                    class="fas fa-arrow-circle-right"
                                                    style="font-size: 14px;"></i></a></object>
                                    </form>
                                    @endif
                                    <object id="icon" class="icon" style="padding: 0 6px;" data-toggle="tooltip"
                                        data-placement="bottom" data-original-title="Tag"><a href="" data-toggle="modal"
                                            data-target="#tagModal" onclick="return setData3({{$articles}}')"><i
                                                class="fas fa-tag" style="font-size: 14px;"></i></object>
                                    <object id="icon" class="icon" style="padding: 0 6px;" data-toggle="tooltip"
                                        data-placement="bottom" data-original-title="Hapus"><a href="#"
                                            data-toggle="modal" data-target="#confirmDeleteModal"
                                            onclick="return setData2({{$articles}})"><i class="fas fa-trash"
                                                style="font-size: 14px;"></i></a></object>
                                    <object id="icon" class="icon" style="padding: 0 6px;" data-toggle="tooltip"
                                        data-placement="bottom" data-original-title="Preview"><a href=""><i
                                                class="far fa-eye" style="font-size: 14px;"></i></a></object>
                                    <p style="padding-left: 6px;">{{ ucfirst(trans(Auth::user()->name)) }}</p>
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

<!-- Modal add -->
<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModalTitle">Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form id="tagForm">
                <div class="modal-body">
                    <select class="tag form-control" name="tag" name="tag[]" multiple="multiple" id="tag" tabindex="-1" style="width: 100%;">
                        <option value="" selected="selected">d</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>



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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(".tag").select2({
        placeholder: 'Pilih Tag',
        tags: true,
        tokenSeparators: [',', ' ']
    });
</script>
<script>
    $(".wrapIcon").css("width", "150px");
$(".articleCard").hover(function(){
    $(".icon").css("display", "block");
    $(".unique").css("margin-right", "150px");
},function(){
    $(".icon").css("display", "none");
    $("form #ones #twos #threes .articleCard .card-body .d-flex .right .wrapIcon").css("width", "");
});
</script>
<script>
    $(document).ready(function(){
    $("#delete").click(function () {
        console.log("Checkbox is s.");
        $('#checkboxDeleteForm').submit();
	});
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
$('#checkPublish').css('display', 'none');

    $("#kelola").click(function () {
				$('input:checkbox').not(this).toggle();
                $('#checkDelete').toggle();
                $('#checkPublish').toggle();
                $('input:checkbox').not(this).css('margin-right', '22px');
			});
            $("#checkAll").click(function () {
				$('input:checkbox').not(this).prop('checked', this.checked);
			});
</script>
<script>
    const updateLink = $('#confirmIsPublishForm').attr('action');
    var isPublishValue = $('#drafValue').data('publish');
    function setData(articles, value, modalBody, buttonPublish) {
        $('#confirmIsPublishForm').attr('action',  `${updateLink}/${articles.id}`);
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