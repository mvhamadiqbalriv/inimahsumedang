@extends('layouts.front_author')
@section('content')
<!-- section main content -->
<section class="main-content mt-5">
    <div class="container-xl">

        <div class="row gy-4">

            <div class="col-lg-8">

                <div class="row gy-4">
                    @foreach ($author as $authors)
                    @php
                    $author_article = \App\Models\Article::where('creator', '=', $authors->id)->paginate(8);
                    $popular_article = \App\Models\Article::join("visitors", "visitors.article", "=", "articles.id")
                    ->groupBy("articles.id")
                    ->orderBy(DB::raw('COUNT(articles.id)'), 'desc')
                    ->limit(3)
                    ->get([DB::raw('COUNT(articles.id) as total_views'), 'articles.*']);
                    @endphp
                    @foreach ($author_article as $articles)
                    <div class="col-sm-6">
                        <!-- post -->
                        <div class="post post-grid rounded bordered">
                            <div class="thumb top-rounded">
                                <form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="kategori" value="{{ $articles->category }}">
                                    <button type="submit" class="category-badge position-absolute"
                                        style="border: none;">{{ $articles->categories->nama }}</button>
                                </form>
                                <span class="post-format">
                                    <i class="{{ $articles->categories->category_icon }}"></i>
                                </span>
                                <a href="{{ route('artikel.show', $articles->slug) }}">
                                    <div class="inner">
                                        <img src="{{ Storage::url($articles->gambar) }}" alt="post-title"
                                            style="width:356px; height:237px; object-fit:cover;" />
                                    </div>
                                </a>
                            </div>
                            <div class="details">
                                <ul class="meta list-inline mb-0">
                                    <li class="list-inline-item"><a
                                            href="{{ route('artikel.author', $articles->creators->username) }}"><img
                                                src="{{ asset('default.jpg')}}" class="author" width="35" height="35"
                                                alt="author" />{{ ucfirst(trans($articles->creators->name)) }}</a></li>
                                    <li class="list-inline-item">{{ $articles->created_at->format('d M Y') }}</li>
                                </ul>
                                <h5 class="post-title mb-3 mt-3"><a
                                        href="{{ route('artikel.show', $articles->slug) }}">{{ Str::limit($articles->judul, 43) }}</a>
                                </h5>
                                <p class="excerpt mb-0">{{ strip_tags(Str::limit($articles->konten, 93)) }}</p>
                            </div>
                            <div class="post-bottom clearfix d-flex align-items-center">
                                <div class="social-share me-auto">
                                    <button class="toggle-button icon-share"></button>
                                    <ul class="icons list-unstyled list-inline mb-0">
                                        <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                        <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                        <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a>
                                        </li>
                                        <li class="list-inline-item"><a href="#"><i
                                                    class="fab fa-telegram-plane"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="far fa-envelope"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="more-button float-end">
                                    <a href="{{ route('artikel.show', $articles->slug) }}"><span
                                            class="icon-options"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $author_article->links('vendor.pagination.custom_front') }}
                </div>

            </div>
            <div class="col-lg-4">

                <!-- sidebar -->
                <div class="sidebar">
                    <!-- widget about -->
                    <div class="widget rounded">
                        <div class="widget-about data-bg-image text-center"
                            data-bg-image="{{ asset('assets/front/images/map-bg.png') }}">
                            <img src="{{ asset('assets/front/images/logo.svg') }}" alt="logo" class="mb-4" />
                            <p class="mb-4">Hello, We’re content writer who is fascinated by content fashion, celebrity
                                and lifestyle. We helps clients bring the right content to the right people.</p>
                            <ul class="social-icons list-unstyled list-inline mb-0">
                                <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- widget popular posts -->
                    <div class="widget rounded">
                        <div class="widget-header text-center">
                            <h3 class="widget-title">Popular Posts</h3>
                            <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                        </div>
                        <div class="widget-content">
                            @php
								$increment = 1;
							@endphp
                            @foreach($popular_article as $popular)
                            <!-- post -->
                            <div class="post post-list-sm circle">
                                <div class="thumb circle">
                                    <span class="number">{{ $increment++ }}</span>
                                    <a href="{{ route('artikel.show', $popular->slug) }}">
                                        <div class="inner">
                                            <img src="{{ Storage::url($popular->gambar) }}"
                                                style="width:60px; height:58px; object-fit:cover;" alt="post-title" />
                                        </div>
                                    </a>
                                </div>
                                <div class="details clearfix">
                                    <h6 class="post-title my-0"><a href="{{ route('artikel.show', $popular->slug)}}">{{ $popular->judul }}</a>
                                    </h6>
                                    <ul class="meta list-inline mt-1 mb-0">
                                        <li class="list-inline-item">{{ $popular->created_at->format('d M Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- widget categories -->
                    <div class="widget rounded">
                        <div class="widget-header text-center">
                            <h3 class="widget-title">Explore Topics</h3>
                            <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                        </div>
                        <div class="widget-content">
                            <ul class="list">
                                @php
								$category = \App\Models\Category_article::all();
								@endphp
								@foreach ($category as $categories)
								<li>
									<form action="{{ route('artikel.kategori') }}" method="post"
										style="display: inline;" id="categoryWidgetForm">
										@csrf
										<input type="hidden" name="kategori" id="categoryWidget">
										<a href="javascript:void(0)" data-category="{{ $categories->id }}"
											onclick="categoryWidgetSubmit(this)">{{ $categories->nama }}</a>
										@php
										$countCategory = \App\Models\Article::where('category',
										$categories->id)->count();
										@endphp
										<span>{{ $countCategory }}</span>
									</form>
								</li>
								@endforeach
                            </ul>
                        </div>

                    </div>

                    {{-- <!-- widget newsletter -->
                    <div class="widget rounded">
                        <div class="widget-header text-center">
                            <h3 class="widget-title">Newsletter</h3>
                            <img src="images/wave.svg" class="wave" alt="wave" />
                        </div>
                        <div class="widget-content">
                            <span class="newsletter-headline text-center mb-3">Join 70,000 subscribers!</span>
                            <form>
                                <div class="mb-2">
                                    <input class="form-control w-100 text-center" placeholder="Email address…"
                                        type="email">
                                </div>
                                <button class="btn btn-default btn-full" type="submit">Sign Up</button>
                            </form>
                            <span class="newsletter-privacy text-center mt-3">By signing up, you agree to our <a
                                    href="#">Privacy Policy</a></span>
                        </div>
                    </div> --}}

                    <!-- widget post carousel -->
                    <div class="widget rounded">
                        <div class="widget-header text-center">
                            <h3 class="widget-title">Event</h3>
                            <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                        </div>
                        <div class="widget-content">
                            <div class="post-carousel-widget">
                                <!-- post -->
                                <div class="post post-carousel">
									<div class="thumb rounded">
										@if(isset($event_1))
										<form action="{{ route('artikel.kategori') }}" method="post"
											style="display: inline;">
											@csrf
											<input type="hidden" name="kategori" value="{{ $event_1->category }}">
											<button type="submit" class="category-badge position-absolute"
												style="border: none;">{{ $event_1->categories->nama }}</button>
										</form>
										@else
										<button type="button" class="category-badge position-absolute" style="border: none;">Belum ada
											kategori</button>
										@endif
										<a
											href="@if(isset($event_1)) {{ route('artikel.show', $event_1->slug)}} @endif">
											<div class="inner">
												@if (!empty($event_1))
												<img src="{{ Storage::url($event_1->gambar) }}" alt="post-title" />
												@else
												<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
												@endif
											</div>
										</a>
									</div>
									<h5 class="post-title mb-0 mt-4"><a
											href="@if(isset($event_1)) {{ route('artikel.show', $event_1->slug)}} @endif">@if(isset($event_1))
											{{ $event_1->judul }} @else Judul artikel @endif</a>
									</h5>
									<ul class="meta list-inline mt-2 mb-0">
										<li class="list-inline-item"><a href="#">@if(isset($event_1))
												{{ ucfirst(trans($event_1->creators->name)) }} @else Nama penulis
												@endif</a></li>
										<li class="list-inline-item">@if(isset($event_1))
											{{ $event_1->updated_at->format('d M Y') }} @else Tanggal Terbit @endif</li>
									</ul>
								</div>

								<div class="post post-carousel">
									<div class="thumb rounded">
										@if(isset($event_2))
										<form action="{{ route('artikel.kategori') }}" method="post"
											style="display: inline;">
											@csrf
											<input type="hidden" name="kategori" value="{{ $event_2->category }}">
											<button type="submit" class="category-badge position-absolute"
												style="border: none;">{{ $event_2->categories->nama }}</button>
										</form>
										@else
										<button type="button" class="category-badge position-absolute" style="border: none;">Belum ada
											kategori</button>
										@endif
										<a
											href="@if(isset($event_2)) {{ route('artikel.show', $event_2->slug)}} @endif">
											<div class="inner">
												@if (!empty($event_2))
												<img src="{{ Storage::url($event_2->gambar) }}" alt="post-title" />
												@else
												<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
												@endif
											</div>
										</a>
									</div>
									<h5 class="post-title mb-0 mt-4"><a
											href="@if(isset($event_2)) {{ route('artikel.show', $event_2->slug)}} @endif">@if(isset($event_2))
											{{ $event_2->judul }} @else Judul artikel @endif</a>
									</h5>
									<ul class="meta list-inline mt-2 mb-0">
										<li class="list-inline-item"><a href="#">@if(isset($event_2))
												{{ ucfirst(trans($event_2->creators->name)) }} @else Nama penulis
												@endif</a></li>
										<li class="list-inline-item">@if(isset($event_2))
											{{ $event_2->updated_at->format('d M Y') }} @else Tanggal terbit @endif</li>
									</ul>
								</div>
                            </div>
                            <!-- carousel arrows -->
                            <div class="slick-arrows-bot">
                                <button type="button" data-role="none" class="carousel-botNav-prev slick-custom-buttons"
                                    aria-label="Previous"><i class="icon-arrow-left"></i></button>
                                <button type="button" data-role="none" class="carousel-botNav-next slick-custom-buttons"
                                    aria-label="Next"><i class="icon-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- widget advertisement -->
                    <div class="widget no-container rounded text-md-center">
                        <span class="ads-title">- Sponsored Ad -</span>
                        <a href="#" class="widget-ads">
                            <img src="{{ asset('assets/front/images/ads/ad-360.png') }}" alt="Advertisement" />
                        </a>
                    </div>

                    <!-- widget tags -->
                    <div class="widget rounded">
                        <div class="widget-header text-center">
                            <h3 class="widget-title">Tag Clouds</h3>
                            <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                        </div>
                        <div class="widget-content">
                            <a href="#" class="tag">#Trending</a>
                            <a href="#" class="tag">#Video</a>
                            <a href="#" class="tag">#Featured</a>
                            <a href="#" class="tag">#Gallery</a>
                            <a href="#" class="tag">#Celebrities</a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>
@endsection