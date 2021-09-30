@extends('layouts.back')
@section('title')
Comment
@endsection

@section('css')
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

    textarea.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }

    .btn-action {
        border: none;
        background: none;
    }

    .btn-action:focus {
        outline: none;
    }

    .btn-action:hover {
        color: #142533 !important;
    }

    .filterReply {
        border: none;
        background: none;
    }

    .filterReply:focus {
        outline: none;
    }

    #dropdownMenuButton {
        display: none;
    }

    @media (max-width: 767px) {
        .repliesActions {
            display: block !important;
        }

        .cardAction {
            display: none !important;
        }

        #dropdownMenuButton {
            display: block;
        }
    }

    @media screen and (max-width: 455px) {
        .judul-artikel {
            width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
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
                    <li class="breadcrumb-item active" aria-current="page">Comment</li>
                </ol>
            </nav>
            <h3>Komentar</h3>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                @php
                $jumlahSemuaKomentar = \App\Models\Comment::all()->count();
                @endphp
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#all" role="tab" aria-controls="home"
                    aria-selected="true">All ({{$jumlahSemuaKomentar}})</a>
            </li>
            <li class="nav-item" role="presentation">
                @php
                $jumlahTrash = \App\Models\Comment::onlyTrashed()->count();
                @endphp
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#trash" role="tab" aria-controls="profile"
                    aria-selected="false">Trash ({{$jumlahTrash}})</a>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
        @foreach ($comment as $comments)
        <div class="card" id="hoverAction" data-id="{{ $comments->id }}" onmouseover="hoverActionIn(this)"
            onmouseout="hoverActionOut(this)">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                style="width: 50px; height: 50px; object-fit: cover; margin-bottom: 20px;" />
                            <div class="d-block">
                                <b class="text-dark ml-4">{{ $comments->nama }}
                                </b>
                                <p class="text-dark ml-4">{{ $comments->email }}</p>
                                @if($comments->web)
                                <p class="text-dark ml-4">{{ $comments->web }}</p>
                                @endif
                            </div>

                        </div>


                    </div>
                    <div class="col-sm-6">
                        <p class="text-dark ml-2">{{ $comments->comment }}
                            <div class="dropdown">
                                <button class="btn-action ml-1 text-primary" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    style="font-size: 12px;"><i class="fas fa-ellipsis-h"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item" data-toggle="modal" data-target="#replyCommentModal"
                                        onclick="replyCommentModal({{$comments}})">Reply</button>
                                    <button class="dropdown-item" onclick="hapusCommentModal({{$comments}})"
                                        data-toggle="modal" data-target="#hapusCommentModal">Hapus</button>
                                </div>
                            </div>
                        </p>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark ml-2 text-sm-right judul-artikel"><a
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ Str::limit($comments->articless->judul, 35) }}</a>
                            </p>
                            <p class="text-dark ml-2 text-sm-right">{{ $comments->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div style="display: none; margin-left:66px;" class="cardAction"
                            id="cardAction{{ $comments->id }}">
                           
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#replyCommentModal"
                                onclick="replyCommentModal({{$comments}})">Reply</button><span class="pl-2">|</span>
                            <button type="button" class="btn-action" onclick="hapusCommentModal({{$comments}})"
                                data-toggle="modal" data-target="#hapusCommentModal"
                                style="color: #023b68;">Hapus</button>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        @php
                        $jumlahReply = \App\Models\Reply::where('comment', '=', $comments->id)->count();
                        
                        @endphp
                        <p class="text-dark ml-2" style="cursor: pointer; display: inline;" id="showReply"
                            data-id="{{ $comments->id }}" onclick="showReply(this)" onselectstart="return false">
                            Lihat balasan ({{ $jumlahReply }}) <i id="iconChange{{$comments->id}}"
                                class="fas fa-sort-down"></i>
                        </p>
                    </div>
                </div>
                <div class="row justify-content-end all mt-2" id="reply{{ $comments->id }}" style="display: none;">
                    <div class="col-sm-6">
                        @foreach ($comments->replies as $replies)
                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-5 ml-4 repliesActions"
                                id="repliesAction{{$replies->id}}">
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $comment->appends(['all' => $comment->currentPage()])->links('vendor.pagination.custom')}}
        </div>
    </div>
    <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="profile-tab">
        @foreach ($comment_trash as $comments)
        <div class="card" id="hoverAction" data-id="{{ $comments->id }}" onmouseover="hoverActionIn(this)"
            onmouseout="hoverActionOut(this)">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                style="width: 50px; height: 50px; object-fit: cover; margin-bottom: 20px;" />
                            <div class="d-block">
                                <p class="text-dark ml-4">{{ $comments->nama }}
                                </p>
                                <p class="text-dark ml-4">{{ $comments->email }}</p>
                                @if($comments->web)
                                <p class="text-dark ml-4">{{ $comments->web }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-dark ml-2">{{ $comments->comment }}
                            <div class="dropdown">
                                <button class="btn-action ml-1 text-primary" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    style="font-size: 12px;"><i class="fas fa-ellipsis-h"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="button" class="btn-action dropdown-item" style="color: #023b68;"
                                        data-toggle="modal" data-target="#restoreCommentModal"
                                        onclick="restoreCommentModal({{$comments->id}})">Pulihkan</button>
                                </div>
                            </div>
                        </p>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark ml-2 text-sm-right"><a
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ Str::limit($comments->articless->judul, 35) }}</a>
                            </p>
                            <p class="text-dark ml-2 text-sm-right">{{ $comments->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div style="display: none; margin-left:66px;" class="cardAction"
                            id="cardAction3{{ $comments->id }}">
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#restoreCommentModal"
                                onclick="restoreComment({{$comments->id}})">Pulihkan</button>
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#deleteCommentPermanentlyModal"
                                onclick="deleteCommentPermanently({{$comments->id}})">Hapus Permanen</button>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        @php
                        $jumlahReply = \App\Models\Reply::where('comment', '=', $comments->id)->count();
                        @endphp
                        <p class="text-dark ml-2" style="cursor: pointer;" id="showReply" data-id="{{ $comments->id }}"
                            onclick="showReply3(this)" onselectstart="return false">
                            Lihat balasan ({{ $jumlahReply }}) <i id="iconChange3{{$comments->id}}"
                                class="fas fa-sort-down"></i></p>
                    </div>
                </div>
                <div class="row justify-content-end" id="reply3{{ $comments->id }}" style="display: none;">
                    <div class="col-sm-6">

                        @foreach ($comments->replies as $replies)
                        <div>
                            <div class="d-flex">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $comment_trash->appends(['trash' => $comment_trash->currentPage()])->links('vendor.pagination.custom')}}
        </div>
    </div>
</div>



<!-- Modal Reply -->
<div class="modal fade" id="replyCommentModal" tabindex="-1" role="dialog" aria-labelledby="replyCommentModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalTitle">Balas Komentar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.reply')}}" method="post" id="replyForm">
                @csrf
                <input type="hidden" name="comment_id" id="commentId">
                <div class="modal-body">
                    <p id="commentText"></p>
                    <textarea name="reply" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Submit</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Kembali
                    </button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Comment -->
<div class="modal fade" id="hapusCommentModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusCommentModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.destroy', '')}}" data-action="{{ route('comments.destroy', '')}}"
                method="post" id="hapusCommentForm">
                @csrf
                @method('delete')
                <div class="modal-body">
                    Apakah anda yakin akan <b>menghapus</b> komentar ini ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ya</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Kembali
                    </button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>


{{-- REPLIES COMMENT SECTION --}}


<!-- Modal Delete Reply -->
<div class="modal fade" id="hapusReplyCommentModal" tabindex="-1" role="dialog" aria-labelledby="hapusReplyCommentModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusReplyCommentModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('replies.destroy', '')}}" data-action="{{ route('replies.destroy', '')}}"
                method="post" id="hapusReplyCommentForm">
                @csrf
                <div class="modal-body">
                    Apakah anda yakin akan <b>menghapus</b> komentar ini ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ya</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Kembali
                    </button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>


{{-- TRASH COMMENT SECTION --}}
<div class="modal fade" id="restoreCommentModal" tabindex="-1" role="dialog" aria-labelledby="restoreCommentModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreCommentModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.restore', '')}}" method="post" id="restoreCommentForm">
                @csrf
                <div class="modal-body">
                    Apakah anda yakin akan <b>memulihkan</b> komentar ini berserta balasan nya ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ya</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Kembali
                    </button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCommentPermanentlyModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteCommentPermanentlyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCommentPermanentlyModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.destroy_permanently', '')}}" method="post"
                id="deletePermanentlyCommentForm">
                @csrf
                <div class="modal-body">
                    Apakah anda yakin akan <b>menghapus</b> secara <b>permanen</b> komentar ini berserta balasan nya ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Ya</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Kembali
                    </button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#replyForm").validate({
                rules: {
                    reply:{
                        required: true,
                        minlength: 3,
                        maxlength: 1000,
                    },
                },
                messages: {
                    reply: {
                        required: "Balasan harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 1000 karakter",
                    },
                }
            });
        });
</script>

<script>
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if (isMobile) {
    $('.iniaja').css('display', 'none');
    $('.dropdown').css('display', 'block');
    $('.statusAndDate').css('font-size', '11px');
    }
</script>

{{-- hapusReplyCommentModal --}}
<script>
    function hapusReplyCommentModal(replies) {
        $('#hapusReplyCommentForm').attr('action',  '');

        const replyDeleteId = $("#hapusReplyCommentForm").attr('data-action');
        $("#hapusReplyCommentForm").attr('action', `${replyDeleteId}/${replies.id}`);
    }
</script>


{{-- hoverRepliesAction --}}
<script>
    function hoverRepliesActionIn(replies)
    {
        var id = $(replies).attr('data-id');
        $("#repliesAction" + id).css('display', 'block');
        $("#repliesAction2" + id).css('display', 'block');
        $("#repliesAction3" + id).css('display', 'block');
        $("#repliesActionPending" + id).css('display', 'block');
        $("#repliesActionPending2" + id).css('display', 'block');
        $("#repliesActionPending3" + id).css('display', 'block');
        $("#repliesActionApproved" + id).css('display', 'block');
        $("#repliesActionApproved2" + id).css('display', 'block');
        $("#repliesActionApproved3" + id).css('display', 'block');
    }

    function hoverRepliesActionOut(replies)
    {
        var id = $(replies).attr('data-id');
        $("#repliesAction" + id).css({'cssText': 'display: none !important;'});
        $("#repliesAction2" + id).css({'cssText': 'display: none !important;'});
        $("#repliesAction3" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionPending" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionPending2" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionPending3" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionApproved" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionApproved2" + id).css({'cssText': 'display: none !important;'});
        $("#repliesActionApproved3" + id).css({'cssText': 'display: none !important;'});
    }

</script>
{{-- DeleteCommentPermanentlyModal --}}
<script>
    function deleteCommentPermanently(element)
    {
        const deletePermanentlyId = $("#deletePermanentlyCommentForm").attr('action');
        $("#deletePermanentlyCommentForm").attr('action', `${deletePermanentlyId}/${element}`);
    }
</script>
{{-- RestoreCommentModal --}}
<script>
    function restoreComment(restore)
    {
        const restoreId = $("#restoreCommentForm").attr('action');
        $("#restoreCommentForm").attr('action', `${restoreId}/${restore}`);
    }
</script>
{{-- HapusCommentModal --}}
<script>
    function hapusCommentModal(comment)
    {
        $('#hapusCommentForm').attr('action',  '');
        
        const deleteId = $("#hapusCommentForm").attr('data-action');
        $("#hapusCommentForm").attr('action', `${deleteId}/${comment.id}`);
    }
</script>
{{-- ReplyModal --}}
<script>
    function replyCommentModal(comment)
    {
        $("#commentId").val(comment.id);
        $("#commentText").text(comment.comment);
    }
</script>
{{-- CommentModal --}}
<script>
    const updateId = $("#commentForm").attr('action');
    function commentModal(id, text, status)
    {
        $("#commentForm").attr('action', `${updateId}/${id}`);
        $("#statusComment").val(status);
        $("#modalText").html(text);
    }
</script>
{{-- Hover on card --}}
<script>
    function hoverActionIn(element)
    {
        var id = $(element).attr('data-id');
        $("#cardAction" + id).css('display', 'block');
        $("#cardAction2" + id).css('display', 'block');
        $("#cardAction3" + id).css('display', 'block');
    }

    function hoverActionOut(element)
    {
        var id = $(element).attr('data-id');
        $("#cardAction" + id).css({'cssText': 'display: none !important;margin-left:66px;'});
        $("#cardAction2" + id).css({'cssText': 'display: none !important;margin-left:66px;'});
        $("#cardAction3" + id).css({'cssText': 'display: none !important;margin-left:66px;'});
    }
</script>
{{-- Keep tab active on reload --}}
<script>
    $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
<script>
    function showReply(element) {
        var id = $(element).attr('data-id');

        $("#reply" + id).toggle();
        if ( $("#iconChange" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showReply2(element) {
        var id = $(element).attr('data-id');


        $("#reply2" + id).toggle();
        if ( $("#iconChange2" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange2" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange2" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showReply3(element) {
        var id = $(element).attr('data-id');

        $("#reply3" + id).toggle();
        if ( $("#iconChange3" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange3" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange3" + id).attr('class', 'fas fa-sort-down')
        }
    };


  

</script>
@endsection