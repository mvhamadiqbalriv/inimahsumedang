@extends('layouts.back')
@section('title')
Page
@endsection

@section('css')
<style>
    .article-lists {
        cursor: pointer !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Page</li>
                </ol>
            </nav>
            <h3>Page</h3>
        </div>
    </div>
</div>

<style>
    .wrap-category-images {
        border: 1px dashed #e7e7e7;
        border-radius: 20px !important;
        pointer-events: none;
    }

    .wrap-editors-pick-images {
        border: 1px dashed #e7e7e7;
        border-radius: 20px !important;
        pointer-events: none;
    }

    .wrap-trending-images {
        border: 1px dashed #e7e7e7;
        border-radius: 20px !important;
        pointer-events: none;
    }

    .wrap-event-images {
        border: 1px dashed #e7e7e7;
        border-radius: 20px !important;
        pointer-events: none;
    }

    .imageCategory {
        width: 510px;
        height: 300px;
        object-fit: cover;
        padding: 10px;
        border-radius: 20px !important;
    }

    .wrap-image {
        border: 1px dashed #e7e7e7;
        border-radius: 20px !important;
    }

    .image {
        width: 480px;
        height: 300px;
        object-fit: cover;
        padding: 10px;
        border-radius: 20px !important;
    }

    .editors-pick-default-image {
        width: 510px;
        height: 300px;
        object-fit: cover;
        padding: 10px;
        border-radius: 20px !important;
    }

    .trending-default-image {
        width: 510px;
        height: 300px;
        object-fit: cover;
        padding: 10px;
        border-radius: 20px !important;
    }

    .event-default-image {
        width: 510px;
        height: 300px;
        object-fit: cover;
        padding: 10px;
        border-radius: 20px !important;
    }

    .btn-secondary {
        background-color: #f2f2f2 !important;
    }
</style>
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
       
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-feature-post-tab" data-toggle="pill" href="#pills-feature-post" role="tab"
                    aria-controls="pills-feature-post" aria-selected="true">Feature Post</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-ads-tab" data-toggle="pill" href="#pills-ads" role="tab"
                    aria-controls="pills-ads" aria-selected="false">Ads</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-editors-pick-tab" data-toggle="pill" href="#pills-editors-pick" role="tab"
                    aria-controls="pills-editors-pick" aria-selected="false">Editor's Pick</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-trending-tab" data-toggle="pill" href="#pills-trending" role="tab"
                    aria-controls="pills-trending" aria-selected="false">Trending</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-event-tab" data-toggle="pill" href="#pills-event" role="tab"
                    aria-controls="pills-event" aria-selected="false">Event</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-category-post-tab" data-toggle="pill" href="#pills-category-post" role="tab"
                    aria-controls="pills-category-post" aria-selected="false">Category Post</a>
            </li>
        </ul>
                 
    </div>
</div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-feature-post" role="tabpanel" aria-labelledby="pills-feature-post-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>Feature Post</h4>
                            <button class="btn btn-sm btn-secondary" data-toggle="modal" @if(empty($article))
                                data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                data-status="feature_post" data-title="Feature Post" onclick="featurePost(this)"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <div class="title mt-3">
                            <p class="text-center">@if(isset($feature_post)) {{ $feature_post->judul }} @else Judul
                                artikel @endif</p>
                        </div>
                        <div class="wrap-image mb-1 d-flex justify-content-center">
                            @if (!empty($feature_post))
                            <img src="{{ Storage::url($feature_post->gambar) }}" style="object-fit: cover; width: 100%;"
                                class="img-fluid image " alt="post-title" />
                            @else
                            <img src="{{ asset('assets/back/not-found.png') }}" style="object-fit: cover; width: 100%;"
                                class="img-fluid image " alt="post-title" />
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-ads" role="tabpanel" aria-labelledby="pills-ads-tab">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card p-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4>Horizontal Ads</h4>
                                    <button class="btn btn-sm btn-secondary" data-toggle="modal" @if(empty($article))
                                        data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif data-status="ads"
                                        data-title="Ads" onclick="ads(this)"><i class="fas fa-plus"></i></button>
                                </div>
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($ads)) {{ $ads->judul }} @else Judul artikel @endif</p>
                                </div>
                                <div class="wrap-image">
                                    @if (!empty($ads))
                                    <img src="{{ Storage::url($ads->gambar) }}" class="img-fluid image " alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid image " alt="post-title" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card p-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4>Widget Ads</h4>
                                    <button class="btn btn-sm btn-secondary" data-toggle="modal" @if(empty($article))
                                        data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif data-status="ads_2"
                                        data-title="Ads" onclick="ads(this)"><i class="fas fa-plus"></i></button>
                                </div>
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($ads_2)) {{ $ads_2->judul }} @else Judul artikel @endif</p>
                                </div>
                                <div class="wrap-image">
                                    @if (!empty($ads_2))
                                    <img src="{{ Storage::url($ads_2->gambar) }}" class="img-fluid image " alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid image " alt="post-title" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-editors-pick" role="tabpanel" aria-labelledby="pills-editors-pick-tab">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <h4>Editor's Pick</h4>
                            <button class="btn btn-sm btn-secondary" onclick="editorsPick(this)"><i class="fas fa-plus"
                                    id="iconChangeOnEditorsPick"></i></button>
                        </div>
                        <div class="title mt-3">
                            <p class="text-center">@if(isset($editors_pick_1)) {{ $editors_pick_1->judul }} @else Judul
                                artikel
                                @endif</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div class="wrap-editors-pick-images mt-2" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="editors_pick_1" data-title="Editors Pick"
                                    onclick="editorsPickValue(this)">
                                    @if (!empty($editors_pick_1))
                                    <img src="{{ Storage::url($editors_pick_1->gambar) }}" class="img-fluid image"
                                        style="width: 510px; width:100%; object-fit: cover;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}"
                                        class="img-fluid editors-pick-default-image" alt="post-title"
                                        style="width: 100%; object-fit: contain;" />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between mt-4">
                            <div class="col-sm-6 mt-2">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($editors_pick_2)) {{ $editors_pick_2->judul }}
                                        @else Judul
                                        artikel @endif</p>
                                </div>
                                <div class="wrap-editors-pick-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="editors_pick_2" data-title="Editors Pick"
                                    onclick="editorsPickValue(this)">
                                    @if (!empty($editors_pick_2))
                                    <img src="{{ Storage::url($editors_pick_2->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}"
                                        class="img-fluid editors-pick-default-image" alt="post-title" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($editors_pick_3)) {{ $editors_pick_3->judul }}
                                        @else Judul
                                        artikel @endif</p>
                                </div>
                                <div class="wrap-editors-pick-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="editors_pick_3" data-title="Editors Pick"
                                    onclick="editorsPickValue(this)">
                                    @if (!empty($editors_pick_3))
                                    <img src="{{ Storage::url($editors_pick_3->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}"
                                        class="img-fluid editors-pick-default-image" alt="post-title" />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between mt-4">
                            <div class="col-sm-6 mt-2">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($editors_pick_4)) {{ $editors_pick_4->judul }}
                                        @else Judul
                                        artikel @endif</p>
                                </div>
                                <div class="wrap-editors-pick-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="editors_pick_4" data-title="Editors Pick"
                                    onclick="editorsPickValue(this)">
                                    @if (!empty($editors_pick_4))
                                    <img src="{{ Storage::url($editors_pick_4->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}"
                                        class="img-fluid editors-pick-default-image" alt="post-title" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($editors_pick_5)) {{ $editors_pick_5->judul }}
                                        @else Judul
                                        artikel @endif</p>
                                </div>
                                <div class="wrap-editors-pick-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="editors_pick_5" data-title="Editors Pick"
                                    onclick="editorsPickValue(this)">
                                    @if (!empty($editors_pick_5))
                                    <img src="{{ Storage::url($editors_pick_5->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}"
                                        class="img-fluid editors-pick-default-image" alt="post-title" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4>Trending</h4>
                                    <button class="btn btn-sm btn-secondary" onclick="trending(this)"><i class="fas fa-plus"
                                            id="iconChangeOnTrending"></i></button>
                                </div>
                                <div class="row justify-content-center mt-4">
                                    <div class="col-sm-6">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_1)) {{ $trending_1->judul }} @else Judul artikel
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_1" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_1))
                                            <img src="{{ Storage::url($trending_1->gambar) }}" class="img-fluid image"
                                                style="width: 510px; width:100%; object-fit: cover;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_2)) {{ $trending_2->judul }} @else Judul artikel
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_2" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_2))
                                            <img src="{{ Storage::url($trending_2->gambar) }}" class="img-fluid image"
                                                style="width: 510px; width:100%; object-fit: cover;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-4">
                                    <div class="col-sm-6 mt-2">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_3)) {{ $trending_3->judul }} @else Judul artikel
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_3" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_3))
                                            <img src="{{ Storage::url($trending_3->gambar) }}" class="img-fluid image"
                                                style="width: 510px;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_4)) {{ $trending_4->judul }} @else Judul Artikle
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_4" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_4))
                                            <img src="{{ Storage::url($trending_4->gambar) }}" class="img-fluid image"
                                                style="width: 510px;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-4">
                                    <div class="col-sm-6 mt-2">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_5)) {{ $trending_5->judul }} @else Judul artikel
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_5" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_5))
                                            <img src="{{ Storage::url($trending_5->gambar) }}" class="img-fluid image"
                                                style="width: 510px;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($trending_6)) {{ $trending_6->judul }} @else Judul artikel
                                                @endif</p>
                                        </div>
                                        <div class="wrap-trending-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="trending_6" data-title="Trending" onclick="trendingValue(this)">
                                            @if (!empty($trending_6))
                                            <img src="{{ Storage::url($trending_6->gambar) }}" class="img-fluid image"
                                                style="width: 510px;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <div class="title mt-3">
                            <p class="text-center">{{ $trending_4->judul }}</p>
                        </div>
                        <div class="wrap-trending-images mt-4"  data-toggle="modal" data-target="#selectedArticleModal" data-status="trending_4" data-title="Trending" onclick="trendingValue(this)">
                            @if (!empty($trending_4))
                            <img src="{{ Storage::url($trending_4->gambar) }}" class="img-fluid image" style="width: 510px;" alt="post-title" />
                            @else
                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                alt="post-title" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between mt-4">
                    <div class="col-sm-6 mt-2">
                        <div class="title mt-3">
                            <p class="text-center">{{ $trending_5->judul }}</p>
                        </div>
                        <div class="wrap-trending-images mt-4" data-toggle="modal" data-target="#selectedArticleModal" data-status="trending_5" data-title="Trending" onclick="trendingValue(this)">
                            @if (!empty($trending_5))
                            <img src="{{ Storage::url($trending_5->gambar) }}" class="img-fluid image" style="width: 510px;" alt="post-title" />
                            @else
                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                alt="post-title" />
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <div class="title mt-3">
                            <p class="text-center">{{ $trending_6->judul }}</p>
                        </div>
                        <div class="wrap-trending-images mt-4" data-toggle="modal" data-target="#selectedArticleModal" data-status="trending_6" data-title="Trending" onclick="trendingValue(this)">
                            @if (!empty($trending_6))
                            <img src="{{ Storage::url($trending_6->gambar) }}" class="img-fluid image" style="width: 510px;" alt="post-title" />
                            @else
                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid trending-default-image"
                                alt="post-title" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card p-2">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4>Event</h4>
                    <button class="btn btn-sm btn-secondary" onclick="eventButton(this)"><i class="fas fa-plus" id="iconChangeOnEvent"></i></button>
                </div>
                
            </div>
            <div class="tab-pane fade" id="pills-event" role="tabpanel" aria-labelledby="pills-event-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4>Event</h4>
                                    <button class="btn btn-sm btn-secondary" onclick="eventButton(this)"><i class="fas fa-plus"
                                            id="iconChangeOnEvent"></i></button>
                                </div>
                                <div class="row justify-content-center mt-4">
                                    <div class="col-sm-6">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($event_1)) {{ $event_1->judul }} @else Judul artikel @endif
                                            </p>
                                        </div>
                                        <div class="wrap-event-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="event_1" data-title="Event" onclick="eventValue(this)">
                                            @if (!empty($event_1))
                                            <img src="{{ Storage::url($event_1->gambar) }}" class="img-fluid image"
                                                style="width: 510px; width:100%; object-fit: cover;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid event-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title mt-3">
                                            <p class="text-center">@if(isset($event_2)) {{ $event_2->judul }} @else Judul artikel @endif
                                            </p>
                                        </div>
                                        <div class="wrap-event-images mt-4" data-toggle="modal" @if(empty($article))
                                            data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                            data-status="event_2" data-title="Event" onclick="eventValue(this)">
                                            @if (!empty($event_2))
                                            <img src="{{ Storage::url($event_2->gambar) }}" class="img-fluid image"
                                                style="width: 510px; width:100%; object-fit: cover;" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid event-default-image"
                                                alt="post-title" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-category-post" role="tabpanel" aria-labelledby="pills-category-post-tab">
                <div class="card p-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>Category Post</h4>
                            <button class="btn btn-sm btn-secondary" onclick="selectedCategory(this)"><i class="fas fa-plus"
                                    id="iconChange"></i></button>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($selected_category_post_1)) {{ $selected_category_post_1->judul }}
                                        @else Judul artikel @endif</p>
                                </div>
                                <div class="wrap-category-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="selected_category_post_1" data-title="Selected Category Posts"
                                    onclick="selectedCategoryValue(this)">
                                    @if (!empty($selected_category_post_1))
                                    <img src="{{ Storage::url($selected_category_post_1->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid image" style="width: 510px;"
                                        alt="post-title" />
                                    @endif
                                </div>
                            </div>
                            <div div class="col-sm-6">
                                <div class="title mt-3">
                                    <p class="text-center">@if(isset($selected_category_post_2)) {{ $selected_category_post_2->judul }}
                                        @else Judul artikel @endif</p>
                                </div>
                                <div class="wrap-category-images mt-4" data-toggle="modal" @if(empty($article))
                                    data-target="#ifArticleEmpty" @else data-target="#selectedArticleModal" @endif
                                    data-status="selected_category_post_2" data-title="Selected Category Posts"
                                    onclick="selectedCategoryValue(this)">
                                    @if (!empty($selected_category_post_2))
                                    <img src="{{ Storage::url($selected_category_post_2->gambar) }}" class="img-fluid image"
                                        style="width: 510px;" alt="post-title" />
                                    @else
                                    <img src="{{ asset('assets/back/not-found.png') }}" class="img-fluid image" style="width: 510px;"
                                        alt="post-title" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>






@foreach ($article as $articles)

<!-- Modal Publish -->
<div class="modal fade" id="selectedArticleModal" tabindex="-1" role="dialog" aria-labelledby="selectedArticleModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectedArticleModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('articles.selectedContent', '') }}"
                data-action="{{ route('articles.selectedContent', '') }}" method="post" id="selectedContentForm"
                autocomplete="off">
                @csrf
                <input type="hidden" name="selected_article" id="selected_article">
                <div class="modal-body" id="modal-body-publish">
                    <input type="text" class="form-control" id="searchtxt" placeholder="Cari artikel..."
                        onkeyup="modalButtonDisable()">
                    <br>
                    <div id="Hintdate">

                    </div>
                </div>
                <div class="modal-footer">'
                    <button type="submit" class="btn btn-sm btn-primary" disabled style="pointer-events: none;"
                        id="applyButton">Terapkan</button>
                    <button type="button" class="btn btn-sm btn-secondary" class="close"
                        data-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

<!-- Modal Publish -->
<div class="modal fade" id="ifArticleEmpty" tabindex="-1" role="dialog" aria-labelledby="ifArticleEmpty"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ifArticleEmptyModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4><b>Artikel</b> belum tersedia!</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" class="close"
                    data-dismiss="modal">Kembali</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
{{-- Keep tab active on reload --}}
<script>
    $(document).ready(function(){
    $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#pills-tab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
<i class="fas fa-minus"></i>
<script>
    // FEATURE POST JS
    function featurePost(element)
    {
        var status = $(element).attr('data-status');
        var title = $(element).attr('data-title');
        $("#selected_article").val(status);
        $("#selectedArticleModalTitle").html(title);
    }

    // ADS JS
    function ads(element)
    {
        var status = $(element).attr('data-status');
        var title = $(element).attr('data-title');
        $("#selected_article").val(status);
        $("#selectedArticleModalTitle").html(title);
    }

    // EDITORS PICK
    function editorsPick(element)
    {
        if ( $("#iconChangeOnEditorsPick").attr('class') == 'fas fa-plus' ) {
            var iconClass = $("#iconChangeOnEditorsPick").attr('class');
            $(".wrap-editors-pick-images").css('pointer-events', 'auto');
            $(".wrap-editors-pick-images").css('border', '1px dashed #c0bebe');
            $(".wrap-editors-pick-images").hover(function(){   
                $(this).css("transform", "translateY(-10px)");
                $(this).css("pointer-events", "auto");
                $(this).css("cursor", "pointer");
                }, function(){
                $(this).css("transform", "initial");
            });
            $("#iconChangeOnEditorsPick").attr('class', 'fas fa-minus');
        } else {
            $("#iconChangeOnEditorsPick").attr('class', 'fas fa-plus');
            $(".wrap-editors-pick-images").css('pointer-events', 'none');
            $(".wrap-editors-pick-images").css("border", "1px dashed #e7e7e7");
        }  
    }

    function editorsPickValue(element)
    {
        var status = $(element).attr('data-status');
        $("#selected_article").val(status);
        console.log(status);
        var modalTitle = $(element).attr('data-title');
        $("#selectedArticleModalTitle").html(modalTitle);
    }

    // TRENDING
    function trending(element)
    {
        if ( $("#iconChangeOnTrending").attr('class') == 'fas fa-plus' ) {
            var iconClass = $("#iconChangeOnTrending").attr('class');
            $(".wrap-trending-images").css('pointer-events', 'auto');
            $(".wrap-trending-images").css('border', '1px dashed #c0bebe');
            $(".wrap-trending-images").hover(function(){   
                $(this).css("transform", "translateY(-10px)");
                $(this).css("pointer-events", "auto");
                $(this).css("cursor", "pointer");
                }, function(){
                $(this).css("transform", "initial");
            });
            $("#iconChangeOnTrending").attr('class', 'fas fa-minus');
        } else {
            $("#iconChangeOnTrending").attr('class', 'fas fa-plus');
            $(".wrap-trending-images").css('pointer-events', 'none');
            $(".wrap-trending-images").css("border", "1px dashed #e7e7e7");
        }  
    }

    function trendingValue(element)
    {
        var status = $(element).attr('data-status');
        $("#selected_article").val(status);
        console.log(status);
        var modalTitle = $(element).attr('data-title');
        $("#selectedArticleModalTitle").html(modalTitle);
    }
     
     // EVENT
    function eventButton(element)
    {
        if ( $("#iconChangeOnEvent").attr('class') == 'fas fa-plus' ) {
            var iconClass = $("#iconChangeOnEvent").attr('class');
            $(".wrap-event-images").css('pointer-events', 'auto');
            $(".wrap-event-images").css('border', '1px dashed #c0bebe');
            $(".wrap-event-images").hover(function(){   
                $(this).css("transform", "translateY(-10px)");
                $(this).css("pointer-events", "auto");
                $(this).css("cursor", "pointer");
                }, function(){
                $(this).css("transform", "initial");
            });
            $("#iconChangeOnEvent").attr('class', 'fas fa-minus');
        } else {
            $("#iconChangeOnEvent").attr('class', 'fas fa-plus');
            $(".wrap-event-images").css('pointer-events', 'none');
            $(".wrap-event-images").css("border", "1px dashed #e7e7e7");
        }  
    }

    function eventValue(element)
    {
        var status = $(element).attr('data-status');
        $("#selected_article").val(status);
        console.log(status);
        var modalTitle = $(element).attr('data-title');
        $("#selectedArticleModalTitle").html(modalTitle);
    }

    // SELECTED CATEGORY POSTS JS
    function selectedCategory(element)
    {
        if ( $("#iconChange").attr('class') == 'fas fa-plus' ) {
            var iconClass = $("#iconChange").attr('class');
            $(".wrap-category-images").css('pointer-events', 'auto');
            $(".wrap-category-images").css('border', '1px dashed #c0bebe');
            $(".wrap-category-images").hover(function(){   
                $(this).css("transform", "translateY(-10px)");
                }, function(){
                $(this).css("transform", "initial");
            });
            $("#iconChange").attr('class', 'fas fa-minus');
        } else {
            $("#iconChange").attr('class', 'fas fa-plus');
            $(".wrap-category-images").css('pointer-events', 'none');
            $(".wrap-category-images").css("border", "1px dashed #e7e7e7");

        }  
    }

    function selectedCategoryValue(element)
    {
        var status = $(element).attr('data-status');
        $("#selected_article").val(status);
        
        var modalTitle = $(element).attr('data-title');
        $("#selectedArticleModalTitle").html(modalTitle);
    }
</script>

<script>
    // MODAL SETTING
    function chooseArticle(element)
    {
        $("#applyButton").css('pointer-events', 'auto');
        $("#applyButton").prop("disabled", false);
        $('#selectedContentForm').attr('action',  '');

        $('.article-lists').css('background-color', 'initial');
        var cardId = $(element).attr('data-id');
        $('#'+cardId).css('background-color', '#f2f7ff');

         //  passing id to the modal form 
        const updateLink = $('#selectedContentForm').attr('data-action');
        $('#selectedContentForm').attr('action',  `${updateLink}/${element.id}`);
    }

    function modalButtonDisable()
    {
        $("#applyButton").css('pointer-events', 'none');
        $("#applyButton").prop("disabled", true);
        var selectedArticle =  $("#selected_article").val();
        var searchtxt =  $("#searchtxt").val();
        console.log(searchtxt);
        if (selectedArticle == "" && searchtxt == ""){
           $("#applyButton").css('pointer-events', 'none');
           $("#applyButton").prop("disabled", true);
       } 
    }

    $(document).ready(function(){
    $("#searchtxt").keyup(function(){
        var str=  $("#searchtxt").val();
        if(str == "") {
            $( "#Hintdate" ).html("");
        }else {
            $.get( "{{ url('demos/searchlive?id=') }}"+str, function( data ) {
                $( "#Hintdate" ).html( data );
            });
        }
    });
});
</script>
@endsection