@extends('layouts.back')
@section('title')
Comment
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style>
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
                $jumlahPending = \App\Models\Comment::whereHas('replies', function($query) {
                $query->where('status', '=', 'pending');
                })->orWhere('status', '=', 'pending')->count();
                @endphp
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#pending" role="tab"
                    aria-controls="profile" aria-selected="false">Pending ({{$jumlahPending}})</a>
            </li>
            <li class="nav-item" role="presentation">
                @php
                $jumlahApprove = \App\Models\Comment::whereHas('replies', function($query) {
                    $query->where('status', '=', 'approved');
                })->orWhere('status', '=', 'approved')->count();
                @endphp
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#approved" role="tab"
                    aria-controls="profile" aria-selected="false">Approved ({{$jumlahApprove}})</a>
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
                                <p class="text-dark ml-4">{{ $comments->nama }}
                                    @if($comments->status && $comments->status == 'approved')
                                    <span class="badge badge-pill ml-1"
                                        style="background: #748fa4;color: #fff;">{{ ucfirst(trans($comments->status)) }}</span>
                                    @else
                                    <span
                                        class="badge badge-pill badge-secondary ml-1">{{ ucfirst(trans($comments->status)) }}</span>
                                    @endif


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
                                    @if($comments->status != 'approved')
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button>
                                    @else
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button>
                                    @endif
                                    <button class="dropdown-item" data-toggle="modal" data-target="#replyCommentModal"
                                        onclick="replyCommentModal({{$comments}})">Reply</button>
                                    <button class="dropdown-item" onclick="hapusCommentModal({{$comments}})"
                                        data-toggle="modal" data-target="#hapusCommentModal">Hapus</button>
                                </div>
                            </div>
                        </p>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark ml-2 text-sm-right"><a
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ $comments->articless->judul }}</a>
                            </p>
                            <p class="text-dark ml-2 text-sm-right">{{ $comments->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div style="display: none; margin-left:66px;" class="cardAction"
                            id="cardAction{{ $comments->id }}">
                            @if($comments->status != 'approved')
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button><span
                                class="pl-2">|</span>
                            @else
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button><span
                                class="pl-2">|</span>
                            @endif
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
                        $jumlahApproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status', '=',
                        'approved')->count();
                        $jumlahUnapproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->count();
                        @endphp
                        <p class="text-dark ml-2" style="cursor: pointer; display: inline;" id="showReply"
                            data-id="{{ $comments->id }}" onclick="showReply(this)" onselectstart="return false">
                            Lihat balasan ({{ $jumlahReply }}) <i id="iconChange{{$comments->id}}"
                                class="fas fa-sort-down"></i>
                        </p>
                        <button class="filterReply" data-id="{{ $comments->id }}" data-id="{{ $comments->id }}"
                            onclick="showFilteredReply(this)"><span class="badge badge-pill ml-1"
                                style="background: #748fa4;color: #fff;">Approved({{$jumlahApproved}})
                                <i id="filterIconChange{{$comments->id}}" class="fas fa-sort-down"></i></span></button>
                        <button class="filterReply" data-id="{{ $comments->id }}" onclick="showFilteredReplySame(this)"
                            id="showFilteredReply2"><span
                                class="badge badge-pill badge-secondary ml-1">Pending({{$jumlahUnapproved}})
                                <i id="filterIconChangeSame{{$comments->id}}" class="fas fa-sort-down"></i>
                            </span></button>
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
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesAction{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                {{-- Filtered Reply (Approved) --}}
                <div class="row justify-content-end approved" id="filteredReply{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyApproved = \App\Models\Reply::where('comment', '=',
                        $comments->id)->where('status', '=', 'approved')->get();
                        @endphp
                        @foreach ($filteredReplyApproved as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionApproved{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Filtered Reply (Pending) --}}
                <div class="row justify-content-end pending" id="filteredReplySame{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyPending = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->get();
                        @endphp
                        @foreach ($filteredReplyPending as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionPending{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
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
    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="profile-tab">

        @foreach ($comment_pending as $comments)
        <div class="card" id="hoverAction" data-id="{{ $comments->id }}" onmouseover="hoverActionIn(this)"
            onmouseout="hoverActionOut(this)">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                style="width: 50px; height: 50px; object-fit: cover; margin-bottom: 20px;" />
                            <div class="d-block">
                                <p class="text-dark ml-4">{{ $comments->nama }} @if($comments->status)<span
                                        class="badge badge-pill badge-secondary ml-1">{{ ucfirst(trans($comments->status)) }}</span>@endif


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
                                    @if($comments->status != 'approved')
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button>
                                    @else
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button>
                                    @endif
                                    <button class="dropdown-item" data-toggle="modal" data-target="#replyCommentModal"
                                        onclick="replyCommentModal({{$comments}})">Reply</button>
                                    <button class="dropdown-item" onclick="hapusCommentModal({{$comments}})"
                                        data-toggle="modal" data-target="#hapusCommentModal">Hapus</button>
                                </div>
                            </div>
                        </p>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark ml-2 text-sm-right"><a
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ $comments->articless->judul }}</a>
                            </p>
                            <p class="text-dark ml-2 text-sm-right">{{ $comments->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div style="display: none; margin-left:66px;" class="cardAction"
                            id="cardAction2{{ $comments->id }}">
                            @if($comments->status != 'approved')
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button><span
                                class="pl-2">|</span>
                            @else
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button><span
                                class="pl-2">|</span>
                            @endif
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
                        $jumlahApproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status', '=',
                        'approved')->count();
                        $jumlahUnapproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->count();
                        @endphp
                        <p class="text-dark ml-2" style="cursor: pointer; display: inline;" id="showReply"
                            data-id="{{ $comments->id }}" onclick="showReply2(this)" onselectstart="return false">
                            Lihat balasan ({{ $jumlahReply }}) <i id="iconChange2{{$comments->id}}"
                                class="fas fa-sort-down"></i>
                        </p>
                        <button class="filterReply" data-id="{{ $comments->id }}" data-id="{{ $comments->id }}"
                            onclick="showFilteredReply2(this)"><span class="badge badge-pill ml-1"
                                style="background: #748fa4;color: #fff;">Approved({{$jumlahApproved}})
                                <i id="filterIconChange2{{$comments->id}}" class="fas fa-sort-down"></i></span></button>
                        <button class="filterReply" data-id="{{ $comments->id }}" onclick="showFilteredReplySame2(this)"
                            id="showFilteredReply2"><span
                                class="badge badge-pill badge-secondary ml-1">Pending({{$jumlahUnapproved}})
                                <i id="filterIconChangeSame2{{$comments->id}}" class="fas fa-sort-down"></i>
                            </span></button>
                    </div>
                </div>
                <div class="row justify-content-end all2 mt-2" id="reply2{{ $comments->id }}" style="display: none;">
                    <div class="col-sm-6">

                        @foreach ($comments->replies as $replies)
                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesAction2{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Filtered Reply (Approved) --}}
                <div class="row justify-content-end approved2" id="filteredReply2{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyApproved = \App\Models\Reply::where('comment', '=',
                        $comments->id)->where('status', '=', 'approved')->get();
                        @endphp
                        @foreach ($filteredReplyApproved as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionApproved2{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Filtered Reply (Pending) --}}
                <div class="row justify-content-end pending2" id="filteredReplySame2{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyPending = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->get();
                        @endphp
                        @foreach ($filteredReplyPending as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionPending2{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
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
            {{ $comment_pending->appends(['pending' => $comment_pending->currentPage()])->links('vendor.pagination.custom')}}
        </div>
    </div>
    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="profile-tab">
        @foreach ($comment_approved as $comments)
        <div class="card" id="hoverAction" data-id="{{ $comments->id }}" onmouseover="hoverActionIn(this)"
            onmouseout="hoverActionOut(this)">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                style="width: 50px; height: 50px; object-fit: cover; margin-bottom: 20px;" />
                            <div class="d-block">
                                <p class="text-dark ml-4">{{ $comments->nama }} @if($comments->status)<span
                                        class="badge badge-pill badge-secondary ml-1">{{ ucfirst(trans($comments->status)) }}</span>@endif


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
                                    @if($comments->status != 'approved')
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button>
                                    @else
                                    <button class="dropdown-item" data-toggle="modal" data-target="#statusCommentModal"
                                        onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button>
                                    @endif
                                    <button class="dropdown-item" data-toggle="modal" data-target="#replyCommentModal"
                                        onclick="replyCommentModal({{$comments}})">Reply</button>
                                    <button class="dropdown-item" onclick="hapusCommentModal({{$comments}})"
                                        data-toggle="modal" data-target="#hapusCommentModal">Hapus</button>
                                </div>
                            </div>
                        </p>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark ml-2 text-sm-right"><a
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ $comments->articless->judul }}</a>
                            </p>
                            <p class="text-dark ml-2 text-sm-right">{{ $comments->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div style="display: none; margin-left:66px;" class="cardAction"
                            id="cardAction3{{ $comments->id }}">
                            @if($comments->status != 'approved')
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menampilkan', 'approved')">Approved</button><span
                                class="pl-2">|</span>
                            @else
                            <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                data-target="#statusCommentModal"
                                onclick="commentModal({{$comments->id}}, 'menunda', 'pending')">Unpproved</button><span
                                class="pl-2">|</span>
                            @endif
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
                        $jumlahApproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status', '=',
                        'approved')->count();
                        $jumlahUnapproved = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->count();
                        @endphp
                        <p class="text-dark ml-2" style="cursor: pointer; display: inline;" id="showReply"
                            data-id="{{ $comments->id }}" onclick="showReply3(this)" onselectstart="return false">
                            Lihat balasan ({{ $jumlahReply }}) <i id="iconChange3{{$comments->id}}"
                                class="fas fa-sort-down"></i>
                        </p>
                        <button class="filterReply" data-id="{{ $comments->id }}" data-id="{{ $comments->id }}"
                            onclick="showFilteredReply3(this)"><span class="badge badge-pill ml-1"
                                style="background: #748fa4;color: #fff;">Approved({{$jumlahApproved}})
                                <i id="filterIconChange3{{$comments->id}}" class="fas fa-sort-down"></i></span></button>
                        <button class="filterReply" data-id="{{ $comments->id }}" onclick="showFilteredReplySame3(this)"
                            id="showFilteredReply3"><span
                                class="badge badge-pill badge-secondary ml-1">Pending({{$jumlahUnapproved}})
                                <i id="filterIconChangeSame3{{$comments->id}}" class="fas fa-sort-down"></i>
                            </span></button>
                    </div>
                </div>
                <div class="row justify-content-end all3 mt-2" id="reply3{{ $comments->id }}" style="display: none;">
                    <div class="col-sm-6">

                        @foreach ($comments->replies as $replies)
                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesAction3{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                {{-- Filtered Reply (Approved) --}}
                <div class="row justify-content-end approved3" id="filteredReply3{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyApproved = \App\Models\Reply::where('comment', '=',
                        $comments->id)->where('status', '=', 'approved')->get();
                        @endphp
                        @foreach ($filteredReplyApproved as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionApproved3{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
                                <button type="button" class="btn-action" onclick="hapusReplyCommentModal({{$replies}})"
                                    data-toggle="modal" data-target="#hapusReplyCommentModal"
                                    style="color: #023b68;">Hapus</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Filtered Reply (Pending) --}}
                <div class="row justify-content-end pending3" id="filteredReplySame3{{ $comments->id }}"
                    style="display: none;">
                    <div class="col-sm-6">
                        @php
                        $filteredReplyPending = \App\Models\Reply::where('comment', '=', $comments->id)->where('status',
                        '=', 'pending')->get();
                        @endphp
                        @foreach ($filteredReplyPending as $replies)

                        <div data-id="{{ $replies->id }}" onmouseover="hoverRepliesActionIn(this)"
                            onmouseout="hoverRepliesActionOut(this)">
                            <div class="d-flex mt-2">
                                <p class="text-dark ml-2">{{ $replies->nama }}</p>
                                <p class="text-muted ml-2">{{ $replies->reply }}</p>
                            </div>
                            <div style="display: none;" class="mb-3 ml-5 repliesActions"
                                id="repliesActionPending3{{$replies->id}}">
                                @if($replies->status != 'approved')
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menampilkan', 'approved')">Approved</button><span
                                    class="pl-2">|</span>
                                @else
                                <button type="button" class="btn-action" style="color: #023b68;" data-toggle="modal"
                                    data-target="#replyCommentActionModal"
                                    onclick="replyCommentActionModal({{$replies}}, 'menunda', 'pending')">Unpproved</button><span
                                    class="pl-2">|</span>
                                @endif
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
            {{ $comment_approved->appends(['approved' => $comment_approved->currentPage()])->links('vendor.pagination.custom')}}
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
                                <p class="text-dark ml-4">{{ $comments->nama }} @if($comments->status)<span
                                        class="badge badge-pill badge-secondary ml-1">{{ ucfirst(trans($comments->status)) }}</span>@endif


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
                                    href="{{ route('artikel.show', $comments->articless->slug) }}">{{ $comments->articless->judul }}</a>
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
                                onclick="restoreCommentModal({{$comments->id}})">Pulihkan</button>
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

<!-- Modal Status Comment -->
<div class="modal fade" id="statusCommentModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.update', '')}}" method="post" id="commentForm">
                @method('PUT')
                @csrf
                <input type="hidden" name="status" id="statusComment">
                <div class="modal-body">
                    Apakah anda yakin akan <b id="modalText"></b> komentar ini ?
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
<!-- Modal Reply -->
<div class="modal fade" id="replyCommentActionModal" tabindex="-1" role="dialog"
    aria-labelledby="replyCommentActionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalTitle">Balas Komentar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('replies.update', '') }}" method="post" id="repliesForm">
                @csrf
                <input type="hidden" name="status" id="statusReply">
                <input type="hidden" name="comment_id" id="replyCommentId">
                <div class="modal-body">
                    Apakah anda yakin akan <b id="modalTextReply"></b> komentar ini ?
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

<!-- Modal Status Comment -->
<div class="modal fade" id="statusCommentModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('comments.update', '')}}" method="post" id="commentForm">
                @method('PUT')
                @csrf
                <input type="hidden" name="status" id="statusComment">
                <div class="modal-body">
                    Apakah anda yakin akan <b id="modalText"></b> komentar ini ?
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
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
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
    function replyCommentActionModal(replies, text, status)
    {
        const replyActionId = $("#repliesForm").attr('action')
        $("#repliesForm").attr('action', `${replyActionId}/${replies.id}`);
        $("#statusReply").val(status);
        $("#replyCommentId").val(replies.comment);
        $("#modalTextReply").html(text);
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
{{-- HapusCommentModal --}}
<script>
    function restoreCommentModal(restore)
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

        // approved
        $(".approved").css('display', 'none'); 
        $("#filterIconChange" + id).attr('class', 'fas fa-sort-down'); 

        // pending
        $(".pending").css('display', 'none'); 
        $("#filterIconChangeSame" + id).attr('class', 'fas fa-sort-down');  

        $("#reply" + id).toggle();
        if ( $("#iconChange" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReply(element) {
        var id = $(element).attr('data-id');
        
        // pending
        $(".pending").css('display', 'none'); 
        $("#filterIconChangeSame" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all").css('display', 'none'); 
        $("#iconChange" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReply" + id).toggle();
        if ( $("#filterIconChange" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChange" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChange" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReplySame(element) {
        var id = $(element).attr('data-id');

         // pending
        $(".approved").css('display', 'none'); 
        $("#filterIconChange" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all").css('display', 'none'); 
        $("#iconChange" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReplySame" + id).toggle();
        if ( $("#filterIconChangeSame" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChangeSame" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChangeSame" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showReply2(element) {
        var id = $(element).attr('data-id');

        // approved
        $(".approved2").css('display', 'none'); 
        $("#filterIconChange2" + id).attr('class', 'fas fa-sort-down'); 

        // pending
        $(".pending2").css('display', 'none'); 
        $("#filterIconChangeSame2" + id).attr('class', 'fas fa-sort-down');  

        $("#reply2" + id).toggle();
        if ( $("#iconChange2" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange2" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange2" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReply2(element) {
        var id = $(element).attr('data-id');
        
        // pending
        $(".pending2").css('display', 'none'); 
        $("#filterIconChangeSame2" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all2").css('display', 'none'); 
        $("#iconChange2" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReply2" + id).toggle();
        if ( $("#filterIconChange2" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChange2" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChange2" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReplySame2(element) {
        var id = $(element).attr('data-id');

         // pending
        $(".approved2").css('display', 'none'); 
        $("#filterIconChange2" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all2").css('display', 'none'); 
        $("#iconChange2" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReplySame2" + id).toggle();
        if ( $("#filterIconChangeSame2" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChangeSame2" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChangeSame2" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showReply3(element) {
        var id = $(element).attr('data-id');

        // approved
        $(".approved3").css('display', 'none'); 
        $("#filterIconChange3" + id).attr('class', 'fas fa-sort-down'); 

        // pending
        $(".pending3").css('display', 'none'); 
        $("#filterIconChangeSame3" + id).attr('class', 'fas fa-sort-down'); 

        $("#reply3" + id).toggle();
        if ( $("#iconChange3" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#iconChange3" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#iconChange3" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReply3(element) {
        var id = $(element).attr('data-id');
        
        // pending
        $(".pending3").css('display', 'none'); 
        $("#filterIconChangeSame3" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all3").css('display', 'none'); 
        $("#iconChange3" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReply3" + id).toggle();
        if ( $("#filterIconChange3" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChange3" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChange3" + id).attr('class', 'fas fa-sort-down')
        }
    };

    function showFilteredReplySame3(element) {
        var id = $(element).attr('data-id');

         // pending
        $(".approved3").css('display', 'none'); 
        $("#filterIconChange3" + id).attr('class', 'fas fa-sort-down'); 

        // all
        $(".all3").css('display', 'none'); 
        $("#iconChange3" + id).attr('class', 'fas fa-sort-down')

        $("#filteredReplySame3" + id).toggle();
        if ( $("#filterIconChangeSame3" + id).attr('class') == 'fas fa-sort-down' ) {
            $("#filterIconChangeSame3" + id).attr('class', 'fas fa-sort-up')
        } else {
            $("#filterIconChangeSame3" + id).attr('class', 'fas fa-sort-down')
        }
    };

</script>
@endsection