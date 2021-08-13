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
                    <li class="breadcrumb-item"><a href="{{ route('beranda.index') }}">Beranda</a></li>
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
                                            href="{{route('users.show', $articles->creator)}}"><img
                                                src="{{ asset('default.jpg')}}" class="author" width="35" height="35"
                                                alt="author" /> {{ ucfirst(trans($articles->creators->name)) }}</a></li>
                                    <li class="list-inline-item">{{ $articles->updated_at->format('d M Y')}}</li>
                                </ul>
                                <h5 class="post-title mb-3 mt-3"><a
                                        href="{{ route('artikel.show', $articles->slug) }}">{{ $articles->judul }}</a>
                                </h5>
                                <p class="excerpt mb-0">{{ strip_tags(Str::limit($articles->konten, 200)) }}</p>
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

                <div class="d-flex justify-content-center">
                    {{ $article->links('vendor.pagination.custom_front') }}
                </div>

            </div>
            <div class="col-lg-4">

                <!-- sidebar -->
                <div class="sidebar">
                    <!-- widget about -->
                    <div class="widget rounded">
                        <div class="widget-about data-bg-image text-center"
                            data-bg-image="{{ asset('assets/front/images/map-bg.png') }}">
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
                                        <a href="category.html" class="category-badge position-absolute">How to</a>
                                        <a href="blog-single.html">
                                            <div class="inner">
                                                <img src="{{ asset('assets/front/images/widgets/widget-carousel-1.jpg') }}"
                                                    alt="post-title" />
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="post-title mb-0 mt-4"><a href="blog-single.html">5 Easy Ways You Can Turn
                                            Future Into Success</a></h5>
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
                                    <h5 class="post-title mb-0 mt-4"><a href="blog-single.html">Master The Art Of Nature
                                            With These 7 Tips</a></h5>
                                    <ul class="meta list-inline mt-2 mb-0">
                                        <li class="list-inline-item"><a href="#">Katen Doe</a></li>
                                        <li class="list-inline-item">29 March 2021</li>
                                    </ul>
                                </div>
                                <!-- post -->
                                <div class="post post-carousel">
                                    <div class="thumb rounded">
                                        <a href="category.html" class="category-badge position-absolute">How to</a>
                                        <a href="blog-single.html">
                                            <div class="inner">
                                                <img src="{{ asset('assets/front/images/widgets/widget-carousel-1.jpg') }}"
                                                    alt="post-title" />
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="post-title mb-0 mt-4"><a href="blog-single.html">5 Easy Ways You Can Turn
                                            Future Into Success</a></h5>
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