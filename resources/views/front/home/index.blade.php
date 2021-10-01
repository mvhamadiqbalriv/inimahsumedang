@extends('layouts.front')
@section('title')
Beranda
@endsection
@section('content')
<!-- hero section -->
<section id="hero">

	<div class="container-xl">

		<div class="row gy-4">

			<div class="col-lg-8">
			<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
				<div class="carousel-inner" style="border-radius: 10px;">
					<div class="carousel-item active">
						<div class="post featured-post-lg">
								<div class="details clearfix">
									@if(isset($feature_post))
									<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $feature_post->category }}">
										<button type="submit" class="category-badge"
											style="border: none;">{{ $feature_post->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge" style="border: none;">Belum ada kategori</button>
									@endif
									<h2 class="post-title"><a
											href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">@if(isset($feature_post))
											{{ $feature_post->judul }} @else Judul artikel @endif</a>
									</h2>
									<ul class="meta list-inline mb-0">
										<li class="list-inline-item"><a href="@if(isset($feature_post)) {{ route('artikel.author', $feature_post->creators->username) }} @endif">@if(isset($feature_post))
												{{ ucfirst(trans($feature_post->creators->name)) }} @else Nama penulis @endif</a>
										</li>
										<li class="list-inline-item">@if(isset($feature_post))
											{{ $feature_post->updated_at->format('d M Y')}} @else Tanggal terbit @endif</li>
									</ul>
								</div>
								<a href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">
									<div class="thumb rounded">
										<div class="inner data-bg-image"
											data-bg-image=" @if(!empty($feature_post))  {{ Storage::url($feature_post->gambar) }} @else https://images.unsplash.com/photo-1512314889357-e157c22f938d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=751&q=80 @endif">
										</div>
									</div>
								</a>
							</div>
					</div>
					<div class="carousel-item">
						<div class="post featured-post-lg">
								<div class="details clearfix">
									@if(isset($feature_post))
									<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $feature_post->category }}">
										<button type="submit" class="category-badge"
											style="border: none;">{{ $feature_post->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge" style="border: none;">Belum ada kategori</button>
									@endif
									<h2 class="post-title"><a
											href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">@if(isset($feature_post))
											{{ $feature_post->judul }} @else Judul artikel @endif</a>
									</h2>
									<ul class="meta list-inline mb-0">
										<li class="list-inline-item"><a href="@if(isset($feature_post)) {{ route('artikel.author', $feature_post->creators->username) }} @endif">@if(isset($feature_post))
												{{ ucfirst(trans($feature_post->creators->name)) }} @else Nama penulis @endif</a>
										</li>
										<li class="list-inline-item">@if(isset($feature_post))
											{{ $feature_post->updated_at->format('d M Y')}} @else Tanggal terbit @endif</li>
									</ul>
								</div>
								<a href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">
									<div class="thumb rounded">
										<div class="inner data-bg-image"
											data-bg-image=" @if(!empty($feature_post))  {{ Storage::url($feature_post->gambar) }} @else {{ asset('assets/back/not-found.png') }} @endif">
										</div>
									</div>
								</a>
							</div>
					</div>
					<div class="carousel-item">
						<div class="post featured-post-lg">
								<div class="details clearfix">
									@if(isset($feature_post))
									<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $feature_post->category }}">
										<button type="submit" class="category-badge"
											style="border: none;">{{ $feature_post->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge" style="border: none;">Belum ada kategori</button>
									@endif
									<h2 class="post-title"><a
											href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">@if(isset($feature_post))
											{{ $feature_post->judul }} @else Judul artikel @endif</a>
									</h2>
									<ul class="meta list-inline mb-0">
										<li class="list-inline-item"><a href="@if(isset($feature_post)) {{ route('artikel.author', $feature_post->creators->username) }} @endif">@if(isset($feature_post))
												{{ ucfirst(trans($feature_post->creators->name)) }} @else Nama penulis @endif</a>
										</li>
										<li class="list-inline-item">@if(isset($feature_post))
											{{ $feature_post->updated_at->format('d M Y')}} @else Tanggal terbit @endif</li>
									</ul>
								</div>
								<a href="@if(isset($feature_post)) {{ route('artikel.show', $feature_post->slug)}} @endif">
									<div class="thumb rounded">
										<div class="inner data-bg-image"
											data-bg-image=" @if(!empty($feature_post))  {{ Storage::url($feature_post->gambar) }} @else {{ asset('assets/back/not-found.png') }} @endif">
										</div>
									</div>
								</a>
							</div>
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
				
			</div>

			<div class="col-lg-4">

				<!-- post tabs -->
				<div class="post-tabs rounded bordered">
					<!-- tab navs -->
					<ul class="nav nav-tabs nav-pills nav-fill" id="postsTab" role="tablist">
						<li class="nav-item" role="presentation"><button aria-controls="recent" aria-selected="false"
								class="nav-link" data-bs-target="#recent" data-bs-toggle="tab" id="recent-tab"
								role="tab" type="button">Terbaru</button>
						</li>
						<li class="nav-item" role="presentation"><button aria-controls="popular" aria-selected="true"
								class="nav-link active" data-bs-target="#popular" data-bs-toggle="tab" id="popular-tab"
								role="tab" type="button">Populer</button>
						</li>
					</ul>
					<!-- tab contents -->
					<div class="tab-content" id="postsTabContent">
						<!-- loader -->
						<div class="lds-dual-ring"></div>
						<!-- recent posts -->


						<div aria-labelledby="recent-tab" class="tab-pane fade show" id="recent" role="tabpanel">
							
							@if ($recent_article->isNotEmpty())
								@foreach ($recent_article as $recent_articles)
								<div class="post post-list-sm circle">
									<div class="thumb circle">
										<a href="{{ route('artikel.show', $recent_articles->id) }}">
											<div class="inner">
												<img src="{{ Storage::url($recent_articles->gambar) }}" alt="post-title"
													style="width:60px; height:58px; object-fit:cover;" />
											</div>
										</a>
									</div>
									<div class="details clearfix">
										<h6 class="post-title my-0"><a
												href="{{ route('artikel.show', $recent_articles->slug) }}">{{ $recent_articles->judul }}</a>
										</h6>
										<ul class="meta list-inline mt-1 mb-0">
											<li class="list-inline-item">{{ $recent_articles->updated_at->format('d M y')}}
											</li>
										</ul>
									</div>
								</div>
								@endforeach
							@else 
								<i>Belum ada data</i>
							@endif
						</div>

						<!-- popular posts -->
						<div aria-labelledby="popular-tab" class="tab-pane fade show active" id="popular"
							role="tabpanel">
							
							@if ($popular->isNotEmpty())
							@foreach ($popular as $popular_article)

							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="{{ route('artikel.show', $popular_article->slug) }}">
										<div class="inner">
											<img src="{{ Storage::url($popular_article->gambar) }}" alt="post-title"
												style="width:60px; height:58px; object-fit:cover;" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="{{ route('artikel.show', $popular_article->slug) }}">{{ $popular_article->judul }}</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $popular_article->created_at->format('d M Y') }}
										</li>
									</ul>
								</div>
							</div>
							@endforeach
							@else
								<i>Belum ada data</i>
							@endif
							
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</section>

<!-- section main content -->
<section class="main-content">
	<div class="container-xl">

		<div class="row gy-4">

			<div class="col-lg-8">

				<!-- section header -->
				<div class="section-header">
					<h3 class="section-title">Artikel Pilihan</h3>
					<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
				</div>

				<div class="padding-30 rounded bordered">
					<div class="row gy-5">
						<div class="col-sm-6">
							
							<div class="post">
								<div class="thumb rounded">
									@if(isset($editors_pick_1))
									<form action="{{ route('artikel.kategori') }}" method="post"
										style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $editors_pick_1->category }}">
										<button type="submit" class="category-badge position-absolute"
											style="border: none;">{{ $editors_pick_1->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge position-absolute"
										style="border: none;">Belum ada
										kategori</button>
									@endif
									<span class="post-format">
										<i
											class="@if(isset($editors_pick_1)) {{ $editors_pick_1->categories->category_icon }} @endif"></i>
									</span>
									<a
										href="@if(isset($editors_pick_1)) {{ route('artikel.show', $editors_pick_1->slug) }} @endif">
										<div class="inner">
											@if (!empty($editors_pick_1))
											<img src="{{ Storage::url($editors_pick_1->gambar) }}" alt="post-title"
												style="width: 350px; height: 325px; object-fit: cover;" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a
											href="@if(isset($editors_pick_1)) {{ route('artikel.author', $editors_pick_1->creators->username) }} @endif">
											@if(isset($editors_pick_1))<img
												src="{{ Storage::url($editors_pick_1->creators->photo) }}"
												style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;"
												class="author" alt="author" /> @endif @if(isset($editors_pick_1))
											{{ ucfirst(trans($editors_pick_1->creators->name)) }} @else Nama penulis
											@endif</a>
									</li>
									<li class="list-inline-item">@if(isset($editors_pick_1))
										{{ $editors_pick_1->updated_at->format('d M Y')}} @else Tanggal terbit @endif
									</li>
								</ul>

								<h5 class="post-title mb-3 mt-3"><a
										href="@if(isset($editors_pick_1)) {{ route('artikel.show', $editors_pick_1->slug) }} @endif">@if(isset($editors_pick_1))
										{{ $editors_pick_1->judul }} @else Judul artikel @endif</a>
								</h5>
								<p class="excerpt mb-0">@if(isset($editors_pick_1)) {!!
									Str::limit($editors_pick_1->konten, 90) !!}
									@else Konten artikel @endif</p>

							</div>
						</div>
						<div class="col-sm-6">
							
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a
										href="@if(isset($editors_pick_2)) {{ route('artikel.show', $editors_pick_2->slug) }} @endif">
										<div class="inner">
											@if (!empty($editors_pick_2))
											<img src="{{ Storage::url($editors_pick_2->gambar) }}" alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($editors_pick_2)) {{ route('artikel.show', $editors_pick_2->slug) }} @endif">@if(isset($editors_pick_2))
											{{ $editors_pick_2->judul }} @else Judul artikel @endif</a>
									</h6>

									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($editors_pick_2))
											{{ $editors_pick_2->updated_at->format('d M Y')}} @else Tanggal terbit
											@endif</li>
									</ul>
								</div>
							</div>
							
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a
										href="@if(isset($editors_pick_3)) {{ route('artikel.show', $editors_pick_3->slug) }} @endif">
										<div class="inner">
											@if (!empty($editors_pick_3))
											<img src="{{ Storage::url($editors_pick_3->gambar) }}" alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($editors_pick_3)) {{ route('artikel.show', $editors_pick_3->slug) }} @endif">@if(isset($editors_pick_3))
											{{ $editors_pick_3->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($editors_pick_3))
											{{ $editors_pick_3->updated_at->format('d M Y')}} @else Tanggal terbit
											@endif</li>
									</ul>
								</div>
							</div>
							
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a
										href="@if(isset($editors_pick_4)) {{ route('artikel.show', $editors_pick_4->slug) }} @endif">
										<div class="inner">
											@if (!empty($editors_pick_4))
											<img src="{{ Storage::url($editors_pick_4->gambar) }}" alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($editors_pick_4)) {{ route('artikel.show', $editors_pick_4->slug) }} @endif">@if(isset($editors_pick_4))
											{{ $editors_pick_4->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($editors_pick_4))
											{{ $editors_pick_4->updated_at->format('d M Y') }} @else Tanggal terbit
											@endif</li>
									</ul>
								</div>
							</div>
							
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a
										href="@if(isset($editors_pick_5)) {{ route('artikel.show', $editors_pick_5->slug) }} @endif">
										<div class="inner">
											@if (!empty($editors_pick_5))
											<img src="{{ Storage::url($editors_pick_5->gambar) }}" alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($editors_pick_5)) {{ route('artikel.show', $editors_pick_5->slug) }} @endif">@if(isset($editors_pick_5))
											{{ $editors_pick_5->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($editors_pick_5))
											{{ $editors_pick_5->updated_at->format('d M Y') }} @else Tanggal terbit
											@endif</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
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

				<div class="spacer" data-height="50"></div>
				
				<div class="section-header">
					<h3 class="section-title">Trending</h3>
					<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
				</div>

				<div class="padding-30 rounded bordered">
					<div class="row gy-5">
						<div class="col-sm-6">
							<!-- post large -->
							<div class="post">
								<div class="thumb rounded">
									@if(isset($trending_1))
									<form action="{{ route('artikel.kategori') }}" method="post"
										style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $trending_1->category }}">
										<button type="submit" class="category-badge position-absolute"
											style="border: none;">{{ $trending_1->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge position-absolute"
										style="border: none;">Belum ada
										kategori</button>
									@endif
									<span class="post-format">
										<i
											class="@if(isset($trending_1)) {{ $trending_1->categories->category_icon }} @endif"></i>
									</span>
									<a
										href="@if(isset($trending_1)) {{ route('artikel.show', $trending_1->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_1))
											<img src="{{ Storage::url($trending_1->gambar) }}"
												style="width: 350px; height: 325px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a href="@if(isset($trending_1)){{ route('artikel.author', $trending_1->creators->username) }}@endif">
											@if(isset($trending_1))
											<img src="{{ Storage::url($trending_1->creators->photo) }}"
												style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;"
												class="author" alt="author" />
											@endif @if(isset($trending_1))
											{{ ucfirst(trans($trending_1->creators->name)) }} @else Nama penulis
											@endif</a>
									</li>
									<li class="list-inline-item">@if(isset($trending_1))
										{{ $trending_1->created_at->format('d M Y') }} @else Tanggal terbit @endif</li>
								</ul>
								<h5 class="post-title mb-3 mt-3"><a
										href="@if(isset($trending_1)) {{ route('artikel.show', $trending_1->slug) }} @endif">@if(isset($trending_1))
										{{ $trending_1->judul }} @else Judul artikel @endif</a>
								</h5>
								<p class="excerpt mb-0">@if(isset($trending_1)) {!! Str::limit($trending_1->konten, 50)
									!!} @else Konten artikel @endif</p>
							</div>
							
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a
										href="@if(isset($trending_3)) {{ route('artikel.show', $trending_3->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_3))
											<img src="{{ Storage::url($trending_3->gambar) }}"
												style="width: 110px; height: 80px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($trending_3)) {{ route('artikel.show', $trending_3->slug) }} @endif">@if(isset($trending_3))
											{{ $trending_3->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($trending_3))
											{{ $trending_3->created_at->format('d M Y') }} @else Tanggal terbit @endif
										</li>
									</ul>
								</div>
							</div>
							
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a
										href="@if(isset($trending_5)) {{ route('artikel.show', $trending_5->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_5))
											<img src="{{ Storage::url($trending_5->gambar) }}"
												style="width: 110px; height: 80px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($trending_5)) {{ route('artikel.show', $trending_5->slug) }} @endif">@if(isset($trending_5))
											{{ $trending_5->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($trending_5))
											{{ $trending_5->created_at->format('d M Y') }} @else Tanggal terbit @endif
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="post">
								<div class="thumb rounded">
									@if(isset($trending_2))
									<form action="{{ route('artikel.kategori') }}" method="post"
										style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $trending_2->category }}">
										<button type="submit" class="category-badge position-absolute"
											style="border: none;">{{ $trending_2->categories->nama }}</button>
									</form>
									@else
									<button type="button" class="category-badge position-absolute"
										style="border: none;">Belum ada
										kategori</button>
									@endif
									<span class="post-format">
										<i
											class="@if(isset($trending_2)) {{ $trending_2->categories->category_icon }} @endif"></i>
									</span>
									<a
										href="@if(isset($trending_2)) {{ route('artikel.show', $trending_2->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_2))
											<img src="{{ Storage::url($trending_2->gambar) }}"
												style="width: 350px; height: 325px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a href="@if(isset($trending_2)){{ route('artikel.author', $trending_2->creators->username) }}@endif">@if(isset($trending_2))<img
												src="{{ Storage::url($trending_2->creators->photo) }}"
												style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;"
												class="author" alt="author" /> @endif @if(isset($trending_2))
											{{ ucfirst(trans($trending_2->creators->name)) }} @else Nama penerbit
											@endif</a>
									</li>
									<li class="list-inline-item">@if(isset($trending_2))
										{{ $trending_2->created_at->format('d M Y') }} @else Tanggal terbit @endif</li>
								</ul>
								<h5 class="post-title mb-3 mt-3"><a
										href="@if(isset($trending_2)) {{ route('artikel.show', $trending_2->slug) }} @endif">@if(isset($trending_2))
										{{ $trending_2->judul }} @else Judul artikel @endif</a>
								</h5>
								<p class="excerpt mb-0">@if(isset($trending_2)) {!! Str::limit($trending_2->konten, 50)
									!!} @else Konten
									artikel @endif</p>
							</div>
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a
										href="@if(isset($trending_4)) {{ route('artikel.show', $trending_4->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_4))
											<img src="{{ Storage::url($trending_4->gambar) }}"
												style="width: 110px; height: 80px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($trending_4)) {{ route('artikel.show', $trending_4->slug) }} @endif">@if(isset($trending_4))
											{{ $trending_4->judul }} @else Judul artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($trending_4))
											{{ $trending_4->created_at->format('d M Y') }} @else Tanggal terbit @endif
										</li>
									</ul>
								</div>
							</div>
							
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a
										href="@if(isset($trending_6)) {{ route('artikel.show', $trending_6->slug) }} @endif">
										<div class="inner">
											@if (!empty($trending_6))
											<img src="{{ Storage::url($trending_6->gambar) }}"
												style="width: 110px; height: 80px; object-fit: cover;"
												alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="@if(isset($trending_6)) {{ route('artikel.show', $trending_6->slug) }} @endif">@if(isset($trending_6))
											{{ $trending_6->judul }} @else Judu artikel @endif</a>
									</h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">@if(isset($trending_6))
											{{ $trending_6->created_at->format('d M Y') }} @else Tanggal terbit @endif
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="spacer" data-height="50"></div>

				<!-- section header -->
				<div class="section-header">
					<h3 class="section-title">Inspirasi</h3>
					<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
					<div class="slick-arrows-top">
						<button type="button" data-role="none" class="carousel-topNav-prev slick-custom-buttons"
							aria-label="Previous"><i class="icon-arrow-left"></i></button>
						<button type="button" data-role="none" class="carousel-topNav-next slick-custom-buttons"
							aria-label="Next"><i class="icon-arrow-right"></i></button>
					</div>
				</div>

				<div class="row post-carousel-twoCol post-carousel">
					
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							@if(isset($selected_category_post_1))
							<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
								@csrf
								<input type="hidden" name="kategori" value="{{ $selected_category_post_1->category }}">
								<button type="submit" class="category-badge"
									style="border: none;">{{ $selected_category_post_1->categories->nama }}</button>
							</form>
							@else
							<button type="button" class="category-badge" style="border: none;">Belum ada
								kategori</button>
							@endif
							<h4 class="post-title"><a
									href="@if(isset($selected_category_post_1)) {{ route('artikel.show', $selected_category_post_1->slug) }} @endif">@if(isset($selected_category_post_1))
									{{ $selected_category_post_1->judul }} @else Judul artikel @endif</a>
							</h4>
							<ul class="meta list-inline mb-0">
								<li class="list-inline-item"><a href="@if(isset($selected_category_post_1)){{ route('artikel.author', $selected_category_post_1->creators->username) }}@endif">@if(isset($selected_category_post_1))
										{{ ucfirst(trans($selected_category_post_1->creators->name)) }} @else Nama
										penulis @endif</a>
								</li>
								<li class="list-inline-item">
									@if(isset($selected_category_post_1))
									{{ $selected_category_post_1->updated_at->format('d M Y') }} @else Tanggal terbit
									@endif</li>
							</ul>
						</div>
						<a
							href="@if(isset($selected_category_post_1)) {{ route('artikel.show', $selected_category_post_1->slug) }} @endif">
							<div class="thumb rounded">
								<div class="inner">
									@if (!empty($selected_category_post_1))
									<img src="{{ Storage::url($selected_category_post_1->gambar) }}"
										style="width: 580px; height: 356px; object-fit: cover;" alt="post-title" />
									@else
									<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
									@endif
								</div>
							</div>
						</a>
					</div>
					
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							@if(isset($selected_category_post_2))
							<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
								@csrf
								<input type="hidden" name="kategori" value="{{ $selected_category_post_2->category }}">
								<button type="submit" class="category-badge"
									style="border: none;">{{ $selected_category_post_2->categories->nama }}</button>
							</form>
							@else
							<button type="button" class="category-badge" style="border: none;">Belum ada
								kategori</button>
							@endif
							<h4 class="post-title"><a
									href=" @if(isset($selected_category_post_2)){{ route('artikel.show', $selected_category_post_2->slug) }} @endif">@if(isset($selected_category_post_2))
									{{ $selected_category_post_2->judul }} @else Judul artikel @endif</a>
							</h4>
							<ul class="meta list-inline mb-0">
								<li class="list-inline-item"><a href="@if(isset($selected_category_post_2)){{ route('artikel.author', $selected_category_post_2->creators->username) }}@endif">@if(isset($selected_category_post_2))
										{{ ucfirst(trans($selected_category_post_2->creators->name)) }} @else Nama
										penulis @endif</a>
								</li>
								<li class="list-inline-item">
									@if(isset($selected_category_post_2))
									{{ $selected_category_post_2->updated_at->format('d M Y') }} @else Tanggal terbit
									@endif</li>
							</ul>
						</div>
						<a
							href="@if(isset($selected_category_post_2)) {{ route('artikel.show', $selected_category_post_2->slug) }} @endif">
							<div class="thumb rounded">
								<div class="inner">
									@if (!empty($selected_category_post_2))
									<img src="{{ Storage::url($selected_category_post_2->gambar) }}"
										style="width: 580px; height: 356px; object-fit: cover;" alt="post-title" />
									@else
									<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
									@endif
								</div>
							</div>
						</a>
					</div>
					
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							<a href="category.html" class="category-badge">Inspirasi</a>
							<h4 class="post-title"><a href="blog-single.html">Your Light Is About To Stop Being
									Relevant</a></h4>
							<ul class="meta list-inline mb-0">
								<li class="list-inline-item"><a href="#">Katen Doe</a></li>
								<li class="list-inline-item">29 March 2021</li>
							</ul>
						</div>
						<a href="blog-single.html">
							<div class="thumb rounded">
								<div class="inner">
									<img src="{{ asset('assets/front/images/posts/inspiration-3.jpg') }}" alt="thumb" />
								</div>
							</div>
						</a>
					</div>
				</div>

				<div class="spacer" data-height="50"></div>

			</div>
			<div class="col-lg-4">

				<!-- sidebar -->
				<div class="sidebar">
					<!-- widget about -->
					<div class="widget rounded">
						<div class="widget-about data-bg-image text-center" data-bg-image="images/map-bg.png">
							<img src="{{ asset('assets/front/logo_inimahsumedang_500x.png') }}" style="width: 100px;"
								alt="logo" class="mb-4" />
							<p class="mb-4">@if(isset($web)) {{ $web->description }} @else Deskripsi web belum tersedia
								@endif</p>
							<ul class="social-icons list-unstyled list-inline mb-0">
								<li class="list-inline-item"><a href="https://www.facebook.com/inimahsumedangcom/"><i
											class="fab fa-facebook-f"></i></a></li>
								<li class="list-inline-item"><a href="https://twitter.com/inimahsumedang"><i
											class="fab fa-twitter"></i></a></li>
								<li class="list-inline-item"><a href="https://www.instagram.com/inimahsumedang/"><i
											class="fab fa-instagram"></i></a></li>
								<li class="list-inline-item"><a href="https://www.youtube.com/c/inimahsumedangTV"><i
											class="fab fa-youtube"></i></a></li>
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