@extends('layouts.front')
@section('title')
Beranda
@endsection
@section('css')

@endsection
@section('content')
<section class="page-header">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="mt-0 mb-2">{{ $title_upper }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- section main content -->
<section class="main-content">
    <div class="container-xl">

        <div class="row gy-4">

            <div class="col-lg-8">
                @isset ($category_select_button)
                <form action="{{ route('artikel.kategori') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="kategori" class="form-control" onchange="this.form.submit()"
                            style="cursor: pointer;">
                            <option value="semua">Pilih Kategori</option>
                            @php
                            $khusuKategori = \App\Models\Category_article::all();
                            @endphp
                            @foreach ($khusuKategori as $category)
                            <option value="{{ $category->id }}" @isset($kategori)
                                {{ ($kategori == $category->id) ? 'selected' : null }} @endisset>{{ $category->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                @endif
                <div class="row gy-4">
                    @isset($peringatan)
                    <p class="text-center">{{ $peringatan }}</p>
                    @endisset

                    @foreach ($article as $articles)

                    <div class="col-sm-6 d-flex align-items-stretch">
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
                                            href="{{route('users.show', $articles->creator)}}"><img
                                                src="{{ asset('default.jpg')}}" class="author" width="35" height="35"
                                                alt="author" /> {{ ucfirst(trans($articles->creators->name)) }}</a></li>
                                    <li class="list-inline-item">{{ $articles->updated_at->format('d M Y')}}</li>
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


                </div>
                <div class="spacer" data-height="50"></div>

                <div class="d-flex justify-content-center">
                    {{ $article->links('vendor.pagination.custom_front') }}
                </div>

                <div class="spacer" data-height="50"></div>

                <div class="text-md-center">
					<span class="ads-title">- Sponsored Ad -</span>
					
					@if (!empty($horizontal_ads))
						<a href="{{$horizontal_ads->tautan}}">
							<img src="{{ Storage::url($horizontal_ads->gambar) }}" style="width: 736px; height: 126px; object-fit: cover; border-radius: 10px;" alt="post-title" />
						</a>
					@else 
						<a href="#">
							<img src="{{ asset('assets/front/images/ads736x126.png') }}"
								style="width: 736px; height: 126px; object-fit: cover; border-radius: 10px;"
								alt="Advertisement" />
						</a>
					@endif
				</div>

            </div>
            <div class="col-lg-4">

                <div class="sidebar">

					<div class="widget rounded">
						<div class="widget-header text-center">
							<h3 class="widget-title">Kategori</h3>
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

					<div class="widget no-container rounded text-md-center">
						<span class="ads-title">- Sponsored Ad -</span>
						@if (!empty($widget_ads))
							<a href="{{$widget_ads->tautan}}" class="widget-content">
								<img src="{{ Storage::url($widget_ads->gambar) }}" style="width: 356px; height: 361px; object-fit: cover; border-radius: 10px;" alt="post-title" />
							</a>
						@else
							<a href="#">
								<img src="{{ asset('assets/front/images/ads356x361.png') }}"
									style="width: 356px; height: 361px; object-fit: cover; border-radius: 10px;"
									alt="Advertisement" />
							</a>
						@endif
					</div>
					
					


					<div class="widget rounded">
						<div class="widget-header text-center">
							<h3 class="widget-title">Event</h3>
							<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
						</div>
						<div class="widget-content">
							<div class="post-carousel-widget">

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
										<button type="button" class="category-badge position-absolute"
											style="border: none;">Belum ada
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
										<li class="list-inline-item"><a href="@if(isset($event_1)){{ route('artikel.author', $event_1->creators->username) }}@endif">@if(isset($event_1))
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
										<button type="button" class="category-badge position-absolute"
											style="border: none;">Belum ada
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
										<li class="list-inline-item"><a href="@if(isset($event_2)){{ route('artikel.author', $event_2->creators->username) }}@endif">@if(isset($event_2))
												{{ ucfirst(trans($event_2->creators->name)) }} @else Nama penulis
												@endif</a></li>
										<li class="list-inline-item">@if(isset($event_2))
											{{ $event_2->updated_at->format('d M Y') }} @else Tanggal terbit @endif</li>
									</ul>
								</div>


							</div>
							<div class="slick-arrows-bot">
								<button type="button" data-role="none" class="carousel-botNav-prev slick-custom-buttons"
									aria-label="Previous"><i class="icon-arrow-left"></i></button>
								<button type="button" data-role="none" class="carousel-botNav-next slick-custom-buttons"
									aria-label="Next"><i class="icon-arrow-right"></i></button>
							</div>
						</div>
					</div>

					<div class="widget rounded">
						<div class="widget-header text-center">
							<h3 class="widget-title">Tag</h3>
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
@section('js')
<script>
    function categoryWidgetSubmit(element)
    {
        var category = $(element).attr('data-category');
        $("#categoryWidget").val(category);
        $("#categoryWidgetForm").submit();
    }
</script>
@endsection