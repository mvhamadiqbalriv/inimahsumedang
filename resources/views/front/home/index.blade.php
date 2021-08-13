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

				<!-- featured post large -->
				<div class="post featured-post-lg">
					<div class="details clearfix">
						<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
							@csrf
							<input type="hidden" name="kategori" value="{{ $feature_post->category }}">
							<button type="submit" class="category-badge" style="border: none;">{{ $feature_post->categories->nama }}</button>
						</form>
						<h2 class="post-title"><a href="{{ route('artikel.show', $feature_post->slug)}}">{{ $feature_post->judul }}</a></h2>
						<ul class="meta list-inline mb-0">
							<li class="list-inline-item"><a href="#">{{ ucfirst(trans($feature_post->creators->name)) }}</a></li>
							<li class="list-inline-item">{{ $feature_post->updated_at->format('d M Y')}}</li>
						</ul>
					</div>
					<a href="{{ route('artikel.show', $feature_post->slug)}}">
						<div class="thumb rounded">
							<div class="inner data-bg-image"
								data-bg-image=" @if(!empty($feature_post))  {{ Storage::url($feature_post->gambar) }} @else {{ asset('assets/back/not-found.png') }} @endif">
							</div>
						</div>
					</a>
				</div>

			</div>

			<div class="col-lg-4">

				<!-- post tabs -->
				<div class="post-tabs rounded bordered">
					<!-- tab navs -->
					<ul class="nav nav-tabs nav-pills nav-fill" id="postsTab" role="tablist">
						<li class="nav-item" role="presentation"><button aria-controls="recent" aria-selected="false"
								class="nav-link" data-bs-target="#recent" data-bs-toggle="tab" id="recent-tab"
								role="tab" type="button">Recent</button>
						</li>
						<li class="nav-item" role="presentation"><button aria-controls="popular" aria-selected="true"
								class="nav-link active" data-bs-target="#popular" data-bs-toggle="tab" id="popular-tab"
								role="tab" type="button">Popular</button>
						</li>
					</ul>
					<!-- tab contents -->
					<div class="tab-content" id="postsTabContent">
						<!-- loader -->
						<div class="lds-dual-ring"></div>
						<!-- recent posts -->


						<div aria-labelledby="recent-tab" class="tab-pane fade show" id="recent" role="tabpanel">
							<!-- post -->
							@foreach ($recent_article as $recent_articles)
							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="{{ route('artikel.show', $recent_articles->id) }}">
										<div class="inner">
											<img src="{{ Storage::url($recent_articles->gambar) }}" alt="post-title"
												style="width:60px; height:60px; object-fit:cover;" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a
											href="{{ route('artikel.show', $recent_articles->slug) }}">{{ $recent_articles->judul }}</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $recent_articles->updated_at->format('d M y')}}
										</li>
									</ul>
								</div>
							</div>
							@endforeach
						</div>

						<!-- popular posts -->
						<div aria-labelledby="popular-tab" class="tab-pane fade show active" id="popular"
							role="tabpanel">
							<!-- post -->
							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/tabs-2.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">An Incredibly Easy
											Method That Works For All</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/tabs-1.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">3 Easy Ways To Make
											Your iPhone Faster</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/tabs-4.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">15 Unheard Ways To
											Achieve Greater Walker</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm circle">
								<div class="thumb circle">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/tabs-3.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">10 Ways To
											Immediately Start Selling Furniture</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
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
					<h3 class="section-title">Editor’s Pick</h3>
					<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
				</div>

				<div class="padding-30 rounded bordered">
					<div class="row gy-5">
						<div class="col-sm-6">
							<!-- post -->
							<div class="post">
								<div class="thumb rounded">
									<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
										@csrf
										<input type="hidden" name="kategori" value="{{ $editors_pick_1->category }}">
										<button type="submit" class="category-badge position-absolute" style="border: none;">{{ $editors_pick_1->categories->nama }}</button>
									</form>
									<span class="post-format">
										<i class="icon-picture"></i>
									</span>
									<a href="{{ route('artikel.show', $editors_pick_1->slug) }}">
										<div class="inner">
											@if (!empty($editors_pick_1))
											<img src="{{ Storage::url($editors_pick_1->gambar) }}" alt="post-title" />
											@else
											<img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
											@endif
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a href="{{ route('users.show', $editors_pick_1->creator) }}"><img
												src="{{ Storage::url($editors_pick_1->creators->photo) }}" style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;"
												class="author" alt="author" />{{ ucfirst(trans($editors_pick_1->creators->name)) }}</a></li>
									<li class="list-inline-item">{{ $editors_pick_1->updated_at->format('d M Y')}}</li>
								</ul>
								@if (!empty($editors_pick_1))
								<h5 class="post-title mb-3 mt-3"><a href="{{ route('artikel.show', $editors_pick_1->id) }}">{{ $editors_pick_1->judul }}</a></h5>
								<p class="excerpt mb-0">{!! $editors_pick_1->konten !!}</p>
								@else

								@endif
							</div>
						</div>
						<div class="col-sm-6">
							<!-- post -->
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a href="{{ route('artikel.show', $editors_pick_2->slug) }}">
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
									@if (!empty($editors_pick_2))
									<h6 class="post-title my-0"><a href="{{ route('artikel.show', $editors_pick_2->slug) }}">{{ $editors_pick_2->judul }}</a></h6>
									@else

									@endif
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $editors_pick_2->updated_at->format('d M Y')}}</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a href="{{ route('artikel.show', $editors_pick_3->slug) }}">
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
									<h6 class="post-title my-0"><a href="{{ route('artikel.show', $editors_pick_3->slug) }}">{{ $editors_pick_3->judul }}</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $editors_pick_3->updated_at->format('d M Y')}}</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a href="{{ route('artikel.show', $editors_pick_4->slug) }}">
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
									<h6 class="post-title my-0"><a href="{{ route('artikel.show', $editors_pick_4->slug) }}">{{ $editors_pick_4->judul }}</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $editors_pick_4->updated_at->format('d M Y') }}</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm square">
								<div class="thumb rounded">
									<a href="{{ route('artikel.show', $editors_pick_5->slug) }}">
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
									<h6 class="post-title my-0"><a href="{{ route('artikel.show', $editors_pick_5->slug) }}">{{ $editors_pick_5->judul }}</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">{{ $editors_pick_4->updated_at->format('d M Y') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="spacer" data-height="50"></div>

				<!-- horizontal ads -->
				<div class="ads-horizontal text-md-center">
					<span class="ads-title">- Sponsored Ad -</span>
					<a href="#">
						<img src="{{ asset('assets/front/images/ads/ad-750.png') }}" alt="Advertisement" />
					</a>
				</div>

				<div class="spacer" data-height="50"></div>

				<!-- section header -->
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
									<a href="category.html" class="category-badge position-absolute">Culture</a>
									<span class="post-format">
										<i class="icon-picture"></i>
									</span>
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-lg-1.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a href="#"><img
												src="{{ asset('assets/front/images/other/author-sm.png') }}"
												class="author" alt="author" />Katen Doe</a></li>
									<li class="list-inline-item">29 March 2021</li>
								</ul>
								<h5 class="post-title mb-3 mt-3"><a href="blog-single.html">Facts About Business
										That Will Help You Success</a></h5>
								<p class="excerpt mb-0">A wonderful serenity has taken possession of my entire
									soul, like these sweet mornings of spring which I enjoy</p>
							</div>
							<!-- post -->
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-sm-1.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">3 Easy Ways To Make
											Your iPhone Faster</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-sm-2.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">An Incredibly Easy
											Method That Works For All</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<!-- post large -->
							<div class="post">
								<div class="thumb rounded">
									<a href="category.html" class="category-badge position-absolute">Inspiration</a>
									<span class="post-format">
										<i class="icon-earphones"></i>
									</span>
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-lg-2.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<ul class="meta list-inline mt-4 mb-0">
									<li class="list-inline-item"><a href="#"><img
												src="{{ asset('assets/front/images/other/author-sm.png') }}"
												class="author" alt="author" />Katen Doe</a></li>
									<li class="list-inline-item">29 March 2021</li>
								</ul>
								<h5 class="post-title mb-3 mt-3"><a href="blog-single.html">5 Easy Ways You Can
										Turn Future Into Success</a></h5>
								<p class="excerpt mb-0">A wonderful serenity has taken possession of my entire
									soul, like these sweet mornings of spring which I enjoy</p>
							</div>
							<!-- post -->
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-sm-3.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">Here Are 8 Ways To
											Success Faster</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
							<!-- post -->
							<div class="post post-list-sm square before-seperator">
								<div class="thumb rounded">
									<a href="blog-single.html">
										<div class="inner">
											<img src="{{ asset('assets/front/images/posts/trending-sm-4.jpg') }}"
												alt="post-title" />
										</div>
									</a>
								</div>
								<div class="details clearfix">
									<h6 class="post-title my-0"><a href="blog-single.html">Master The Art Of
											Nature With These 7 Tips</a></h6>
									<ul class="meta list-inline mt-1 mb-0">
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="spacer" data-height="50"></div>

				<!-- section header -->
				<div class="section-header">
					<h3 class="section-title">Inspiration</h3>
					<img src="images/wave.svg" class="wave" alt="wave" />
					<div class="slick-arrows-top">
						<button type="button" data-role="none" class="carousel-topNav-prev slick-custom-buttons"
							aria-label="Previous"><i class="icon-arrow-left"></i></button>
						<button type="button" data-role="none" class="carousel-topNav-next slick-custom-buttons"
							aria-label="Next"><i class="icon-arrow-right"></i></button>
					</div>
				</div>

				<div class="row post-carousel-twoCol post-carousel">
					<!-- post -->
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
								@csrf
								<input type="hidden" name="kategori" value="{{ $selected_category_post_1->category }}">
								<button type="submit" class="category-badge" style="border: none;">{{ $selected_category_post_1->categories->nama }}</button>
							</form>
							<h4 class="post-title"><a href="{{ route('artikel.show', $selected_category_post_1->slug) }}">{{ $selected_category_post_1->judul }}</a></h4>
							<ul class="meta list-inline mb-0">
								<li class="list-inline-item"><a href="#">{{ ucfirst(trans($selected_category_post_1->creators->name)) }}</a></li>
								<li class="list-inline-item">{{ $selected_category_post_1->updated_at->format('d M Y') }}</li>
							</ul>
						</div>
						<a href="{{ route('artikel.show', $selected_category_post_1->slug) }}">
							<div class="thumb rounded">
								<div class="inner">
									<img src="{{ Storage::url($selected_category_post_1->gambar) }}" style="width: 580px; height: 484px; object-fit: cover;" alt="thumb" />
								</div>
							</div>
						</a>
					</div>
					<!-- post -->
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							<form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;">
								@csrf
								<input type="hidden" name="kategori" value="{{ $selected_category_post_2->category }}">
								<button type="submit" class="category-badge" style="border: none;">{{ $selected_category_post_2->categories->nama }}</button>
							</form>
							<h4 class="post-title"><a href="{{ route('artikel.show', $selected_category_post_2->slug) }}">{{ $selected_category_post_2->judul }}</a></h4>
							<ul class="meta list-inline mb-0">
								<li class="list-inline-item"><a href="#">{{ ucfirst(trans($selected_category_post_2->creators->name)) }}</a></li>
								<li class="list-inline-item">{{ $selected_category_post_2->updated_at->format('d M Y') }}</li>
							</ul>
						</div>
						<a href="{{ route('artikel.show', $selected_category_post_2->slug) }}">
							<div class="thumb rounded">
								<div class="inner">
									<img src="{{ Storage::url($selected_category_post_2->gambar) }}" style="width: 580px; height: 484px; object-fit: cover;" alt="thumb" />
								</div>
							</div>
						</a>
					</div>
					<!-- post -->
					<div class="post post-over-content col-md-6">
						<div class="details clearfix">
							<a href="category.html" class="category-badge">Inspiration</a>
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
							<p class="mb-4">{{ $web->description }}</p>
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

					<!-- widget categories -->
					<div class="widget rounded">
						<div class="widget-header text-center">
							<h3 class="widget-title">Explore Topics</h3>
							<img src="images/wave.svg" class="wave" alt="wave" />
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

					<!-- widget newsletter -->
					<!-- <div class="widget rounded">
							<div class="widget-header text-center">
								<h3 class="widget-title">Newsletter</h3>
								<img src="images/wave.svg" class="wave" alt="wave" />
							</div>
							<div class="widget-content">
								<span class="newsletter-headline text-center mb-3">Join 70,000 subscribers!</span>
								<form>
									<div class="mb-2">
										<input class="form-control w-100 text-center" placeholder="Email address…" type="email">
									</div>
									<button class="btn btn-default btn-full" type="submit">Sign Up</button>
								</form>
								<span class="newsletter-privacy text-center mt-3">By signing up, you agree to our <a href="#">Privacy Policy</a></span>
							</div>		
						</div> -->

					<!-- widget post carousel -->
					<div class="widget rounded">
						<div class="widget-header text-center">
							<h3 class="widget-title">Celebration</h3>
							<img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
						</div>
						<div class="widget-content">
							<div class="post-carousel-widget">
								<!-- post -->
								<div class="post post-carousel">
									<div class="thumb rounded">
										<a href="category.html" class="category-badge position-absolute">How
											to</a>
										<a href="blog-single.html">
											<div class="inner">
												<img src="{{ asset('assets/front/images/widgets/widget-carousel-1.jpg') }}"
													alt="post-title" />
											</div>
										</a>
									</div>
									<h5 class="post-title mb-0 mt-4"><a href="blog-single.html">5 Easy Ways You
											Can Turn Future Into Success</a></h5>
									<ul class="meta list-inline mt-2 mb-0">
										<li class="list-inline-item"><a href="#">Katen Doe</a></li>
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
								<!-- post -->
								<div class="post post-carousel">
									<div class="thumb rounded">
										<a href="category.html" class="category-badge position-absolute">Trending</a>
										<a href="blog-single.html">
											<div class="inner">
												<img src="{{ asset('assets/front/images/widgets/widget-carousel-2.jpg') }}"
													alt="post-title" />
											</div>
										</a>
									</div>
									<h5 class="post-title mb-0 mt-4"><a href="blog-single.html">Master The Art
											Of Nature With These 7 Tips</a></h5>
									<ul class="meta list-inline mt-2 mb-0">
										<li class="list-inline-item"><a href="#">Katen Doe</a></li>
										<li class="list-inline-item">29 March 2021</li>
									</ul>
								</div>
								<!-- post -->
								<div class="post post-carousel">
									<div class="thumb rounded">
										<a href="category.html" class="category-badge position-absolute">How
											to</a>
										<a href="blog-single.html">
											<div class="inner">
												<img src="{{ asset('assets/front/images/widgets/widget-carousel-1.jpg') }}"
													alt="post-title" />
											</div>
										</a>
									</div>
									<h5 class="post-title mb-0 mt-4"><a href="blog-single.html">5 Easy Ways You
											Can Turn Future Into Success</a></h5>
									<ul class="meta list-inline mt-2 mb-0">
										<li class="list-inline-item"><a href="#">Katen Doe</a></li>
										<li class="list-inline-item">29 March 2021</li>
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