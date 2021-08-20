@extends('layouts.front')
@section('title')
{{ $article->judul }}
@endsection
@section('css')
<style>
    body {
        pointer-events: none;
        -webkit-user-select: none;
        /* Safari */
        -moz-user-select: none;
        /* Firefox */
        -ms-user-select: none;
        /* IE10+/Edge */
        user-select: none;
        /* Standard */
    }
</style>
@endsection
@section('content')
<section class="main-content mt-3">
    <div class="container-xl">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('artikel.index') }}">Artikel</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $article->judul }}</li>
            </ol>
        </nav>

        <div class="row gy-4">

            <div class="col-lg-8">
                <!-- post single -->
                <div class="post post-single">
                    <!-- post header -->
                    <div class="post-header">
                        <h1 class="title mt-0 mb-3">{{ $article->judul }}</h1>
                        <ul class="meta list-inline mb-0">
                            <li class="list-inline-item"><a href="{{ route('users.show', $article->creator) }}">
                                    @php
                                    $path = asset('assets/back/images/avatars/default_user.png');
                                    if ($article->creators->photo) {
                                    $path = Storage::url($article->creators->photo);
                                    }
                                    @endphp
                                    <img src="{{$path}}" class="author"
                                        style="border-radius: 50%; width: 32px; height:32px; object-fit: cover;"
                                        alt="author" />{{ ucfirst(trans($article->creators->name)) }}</a></li>
                            <form action="{{ route('artikel.kategori') }}" method="POST" style="display: none;"
                                id="kategoriForm">
                                @csrf
                                <input type="hidden" name="kategori" value="{{ $article->category }}">
                            </form>
                            <li class="list-inline-item"><a href="javascript:void(0)"
                                    id="kategori">{{ $article->categories->nama }}</a>
                            </li>
                            <li class="list-inline-item">{{ $article->updated_at->format('Y-m-d') }}</li>
                        </ul>
                    </div>
                    <!-- featured image -->
                    <div class="featured-image">
                        <img src="{{ Storage::url($article->gambar) }}" alt="post-title" />
                    </div>
                    <!-- post content -->
                    <div class="post-content clearfix">
                        {!! $article->konten !!}
                    </div>
                    <!-- post bottom section -->
                    <div class="post-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 col-12 text-center text-md-start">
                                <!-- tags -->
                                @if(!empty($article->tag))
                                @foreach (explode(",",$article->tag) as $a)
                                <a href="#" class="tag">#{{ $a }}</a>
                                @endforeach
                                @endif

                            </div>
                            <div class="col-md-6 col-12">
                                <!-- social icons -->
                                <ul class="social-icons list-unstyled list-inline mb-0 float-md-end">
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-telegram-plane"></i></a>
                                    </li>
                                    <li class="list-inline-item"><a href="#"><i class="far fa-envelope"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="spacer" data-height="50"></div>

                <div class="about-author padding-30 rounded">
                    <div class="thumb">
                        <img src="{{ $path }}" alt="Katen Doe" />
                    </div>
                    <div class="details">
                        <h4 class="name"><a href="#">{{ ucfirst(trans($article->creators->name)) }}</a></h4>
                        <p>Hello, I’m a content writer who is fascinated by content fashion, celebrity and lifestyle.
                            She helps clients bring the right content to the right people.</p>
                        <!-- social icons -->
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

                <div class="spacer" data-height="50"></div>

                <!-- section header -->
                <div class="section-header">
                    <h3 class="section-title">Comments</h3>
                    <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                </div>
                <!-- post comments -->
                <div class="comments bordered padding-30 rounded">
                    <p class="d-flex justify-content-center">Belum ada komentar.</p>
                    {{-- <ul class="comments">
                       
                        <!-- comment item -->
                        <li class="comment rounded">
                            <div class="thumb">
                                <img src="{{ asset('assets/front/images/other/comment-1.png') }}" alt="John Doe" />
                </div>
                <div class="details">
                    <h4 class="name"><a href="#">John Doe</a></h4>
                    <span class="date">Jan 08, 2021 14:41 pm</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae odio ut tortor
                        fringilla cursus sed quis odio.</p>
                    <a href="#" class="btn btn-default btn-sm">Reply</a>
                </div>
                </li>
                <!-- comment item -->
                <li class="comment child rounded">
                    <div class="thumb">
                        <img src="{{ asset('assets/front/images/other/comment-2.png') }}" alt="John Doe" />
                    </div>
                    <div class="details">
                        <h4 class="name"><a href="#">Helen Doe</a></h4>
                        <span class="date">Jan 08, 2021 14:41 pm</span>
                        <p>Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet
                            adipiscing sem neque sed ipsum.</p>
                        <a href="#" class="btn btn-default btn-sm">Reply</a>
                    </div>
                </li>
                <!-- comment item -->
                <li class="comment rounded">
                    <div class="thumb">
                        <img src="{{ asset('assets/front/images/other/comment-3.png') }}" alt="John Doe" />
                    </div>
                    <div class="details">
                        <h4 class="name"><a href="#">Anna Doe</a></h4>
                        <span class="date">Jan 08, 2021 14:41 pm</span>
                        <p>Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in
                            faucibus orci luctus et ultrices posuere cubilia.</p>
                        <a href="#" class="btn btn-default btn-sm">Reply</a>
                    </div>
                </li>
                </ul> --}}
            </div>

            <div class="spacer" data-height="50"></div>

            <!-- section header -->
            <div class="section-header">
                <h3 class="section-title">Leave Comment</h3>
                <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
            </div>
            <!-- comment form -->
            <div class="comment-form rounded bordered padding-30">

                <form id="comment-form" class="comment-form" method="post">

                    <div class="messages"></div>

                    <div class="row">

                        <div class="column col-md-12">
                            <!-- Comment textarea -->
                            <div class="form-group">
                                <textarea name="InputComment" id="InputComment" class="form-control" rows="4"
                                    placeholder="Your comment here..." required="required"></textarea>
                            </div>
                        </div>

                        <div class="column col-md-6">
                            <!-- Email input -->
                            <div class="form-group">
                                <input type="email" class="form-control" id="InputEmail" name="InputEmail"
                                    placeholder="Email address" required="required">
                            </div>
                        </div>

                        <div class="column col-md-6">
                            <!-- Name input -->
                            <div class="form-group">
                                <input type="text" class="form-control" name="InputWeb" id="InputWeb"
                                    placeholder="Website" required="required">
                            </div>
                        </div>

                        <div class="column col-md-12">
                            <!-- Email input -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="InputName" name="InputName"
                                    placeholder="Your name" required="required">
                            </div>
                        </div>

                    </div>

                    <button type="submit" name="submit" id="submit" value="Submit"
                        class="btn btn-default">Submit</button><!-- Submit Button -->

                </form>
            </div>
        </div>

        <div class="col-lg-4">

            <!-- sidebar -->
            <div class="sidebar">
                <!-- widget about -->
                <div class="widget rounded">
                    <div class="widget-about data-bg-image text-center" data-bg-image="images/map-bg.png">
                        <img src="{{ asset('assets/front/images/assets/logo_inimahsumedang_500x.png') }}"
                            style="width: 100px;" alt="logo" class="mb-4" />
                        <p class="mb-4">{{ $web->description }}</p>
                        <ul class="social-icons list-unstyled list-inline mb-0">
                            <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
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
                                <form action="{{ route('artikel.kategori') }}" method="post" style="display: inline;"
                                    id="categoryWidgetForm">
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
                                            style="border: none;">{{ ucfirst(trans($event_1->categories->nama))  }}</button>
                                    </form>
                                    @else 
                                    <button type="submit" class="category-badge position-absolute"
                                    style="border: none;">Belum ada kategori</button>
                                    @endif
                                    <a href="@if(isset($event_1)) {{ route('artikel.show', $event_1->slug)}} @endif">
                                        <div class="inner">
                                            @if (!empty($event_1))
                                            <img src="{{ Storage::url($event_1->gambar) }}" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <h5 class="post-title mb-0 mt-4"><a href="@if(isset($event_1)) {{ route('artikel.show', $event_1->slug)}} @endif">@if(isset($event_1)) {{ $event_1->judul }} @else Judul artikel @endif</a></h5>
                                <ul class="meta list-inline mt-2 mb-0">
                                    <li class="list-inline-item"><a
                                        href="#">@if(isset($event_1)) {{ ucfirst(trans($event_1->creators->name)) }} @else Nama penulis @endif</a></li>
                                    <li class="list-inline-item">@if(isset($event_1)) {{ $event_1->updated_at->format('d M Y') }} @else Tanggal terbit @endif</li>
                                </ul>
                            </div>
                            
                            <!-- post -->
                            <div class="post post-carousel">
                                <div class="thumb rounded">
                                    @if(isset($event_1))
                                    <form action="{{ route('artikel.kategori') }}" method="post"
                                        style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="kategori" value="{{ $event_2->category }}">
                                        <button type="submit" class="category-badge position-absolute"
                                            style="border: none;">{{ ucfirst(trans($event_2->categories->nama))  }}</button>
                                    </form>
                                    @else 
                                    <button type="submit" class="category-badge position-absolute"
                                    style="border: none;">Belum ada kategori</button>
                                    @endif
                                    <a href="@if(isset($event_2)) {{ route('artikel.show', $event_2->slug)}} @endif">
                                        <div class="inner">
                                            @if (!empty($event_2))
                                            <img src="{{ Storage::url($event_2->gambar) }}" alt="post-title" />
                                            @else
                                            <img src="{{ asset('assets/back/not-found.png') }}" alt="post-title" />
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <h5 class="post-title mb-0 mt-4"><a href="@if(isset($event_2)) {{ route('artikel.show', $event_2->slug)}} @endif">@if(isset($event_2)) {{ $event_2->judul }} @else Judul artikel @endif</a></h5>
                                <ul class="meta list-inline mt-2 mb-0">
                                    <li class="list-inline-item"><a
                                        href="#">@if(isset($event_2)){{ ucfirst(trans($event_2->creators->name)) }} @else Nama penulis @endif</a></li>
                                <li class="list-inline-item">@if(isset($event_2)) {{ $event_2->updated_at->format('d M Y') }} @else Tanggal terbit @endif</li></ul>
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
                        @if (!empty($widget_ads))
							<img src="{{ Storage::url($widget_ads->gambar) }}" style="width: 356px; height: 361px; object-fit: cover; border-radius: 10px;" alt="post-title" />
							@else
							<img src="{{ asset('assets/back/not-found.png') }}"
								style="width: 356px; height: 361px; object-fit: cover; border-radius: 10px;"
								alt="Advertisement" />
							@endif
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
    $(document).ready(function(){
    $('#kategori').click(function(){
        $("#kategoriForm").submit();
    });
});
</script>
@endsection