@extends('layouts.front')
@section('title')
{{ $article->judul }}
@endsection
@section('css')
<style>
    label.error {
        color: #f1556c;
        font-size: 14px !important;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 10px;
        margin-left: 5px;
        padding: 0;
        font-family: 'Poppins', sans-serif !important;
    }

    .msg-reply-captcha-error {
        color: #f1556c;
        font-size: 14px !important;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 10px;
        margin-left: 5px;
        padding: 0;
        font-family: 'Poppins', sans-serif !important;
    }

    .msg-comment-captcha-error {
        color: #f1556c;
        font-size: 14px !important;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 10px;
        margin-left: 5px;
        padding: 0;
        font-family: 'Poppins', sans-serif !important;
    }

    .captchaValidation {
        color: #f1556c;
        font-size: 14px !important;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 10px;
        margin-left: 5px;
        padding: 0;
        font-family: 'Poppins', sans-serif !important;
    }

    input.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }

    textarea.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }

    @media screen and (max-width: 455px) {

        #rc-imageselect,
        .g-recaptcha {
            transform: scale(0.50);
            -webkit-transform: scale(0.50);
            transform-origin: 0 0;
            -webkit-transform-origin: 0 0;

        }
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
                            <li class="list-inline-item"><a
                                    href="{{ route('artikel.author', $article->creators->username) }}">
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
                                <form action="{{ route('artikel.tag') }}" method="post" id="tagForm"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="tagValue" id="tagValue">
                                    <a href="javascript:void(0)" class="tag" data-tag="{{ $a }}"
                                        onclick="tagSubmit(this)">#{{ $a }}</a>
                                </form>
                                @endforeach
                                @endif

                            </div>
                            <div class="col-md-6 col-12">
                                <!-- social icons -->
                                <ul class="social-icons list-unstyled list-inline mb-0 float-md-end">
                                    <li class="list-inline-item"><a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li class="list-inline-item"><a href="https://twitter.com/intent/tweet?text={{$article->judul}}&amp;url={{url()->current()}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li class="list-inline-item"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;title={{$article->judul}}&amp;url={{url()->current()}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="list-inline-item"><a href="https://t.me/share/url?url={{url()->current()}}&text={{$article->judul}}" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                                    </li>
                                    <li class="list-inline-item"><a href="https://wa.me/?text={{url()->current()}}"><i class="fab fa-whatsapp" target="_blank"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="spacer" data-height="50"></div>
                <div class="text-md-center">
                    <span class="ads-title">- Sponsored Ad -</span>

                    @if (!empty($horizontal_ads))
                    <a href="{{$horizontal_ads->tautan}}">
                        <img src="{{ Storage::url($horizontal_ads->gambar) }}"
                            style="width: 736px; height: 126px; object-fit: cover; border-radius: 10px;"
                            alt="post-title" />
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

                <div class="about-author padding-30 rounded">
                    <div class="thumb">
                        <img src="{{ $path }}" alt="Katen Doe" />
                    </div>
                    <div class="details">
                        <h4 class="name"><a
                                href="{{ route('users.show', $article->creator) }}">{{ ucfirst(trans($article->creators->name)) }}</a>
                        </h4>
                        <p>{{$article->creators->tentang}}</p>
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
                    @php
                    $articleId = $article->id;
                    @endphp
                    @if(!$article->comments()->exists())
                    <p class="d-flex justify-content-center">Belum ada komentar.</p>
                    @endif
                    <ul class="comments">
                        <!-- comment item -->
                        @php
                        $comment = \App\Models\Comment::where('article', '=', $article->id)->get();
                        $increment = 1;
                        @endphp
                        @foreach($comment as $comments)

                        <li class="comment rounded">
                            <div class="thumb mb-5">
                                <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                    style="width: 80px; height: 80px;" />
                            </div>
                            <div class="details comment-detail">
                                <h4 class="name">{{ $comments->nama }}</h4>
                                <span class="date">{{ $comments->updated_at->format('M d, Y') }}
                                    {{ date("H:i", strtotime($comments->updated_at)) }}</span>
                                <p>{{ $comments->comment }}</p>
                                <button type="button" class="btn btn-default btn-sm reply-button"
                                    id="replyButton{{ $comments->id }}" data-id="{{ $comments->id }}"
                                    onclick="replyTrigger(this)">Reply</button>
                                <button type="button" class="btn btn-default btn-sm cancel-button"
                                    onclick="cancelReply(this)" id="cancelButton{{ $comments->id }}"
                                    style="display:none;" data-id="{{ $comments->id }}">Cancel</button>

                                <div class="replybox" id="{{ $comments->id }}" style="display: none;">

                                    <div class="comment-form rounded bordered padding-30 mt-3">
                                        <form action="{{ route('artikel.reply') }}" id="replyForm{{ $comments->id }}"
                                            method="post" class="replyForm">
                                            @csrf
                                            <input type="hidden" name="comment_id" value="{{ $comments->id }}">
                                            <div class="row">
                                                <div class="column col-md-12">
                                                    <!-- Comment textarea -->
                                                    <div class="form-group">
                                                        <textarea name="reply" id="reply" class="form-control" rows="4"
                                                            placeholder="Komentar anda..."></textarea>
                                                    </div>
                                                </div>

                                                <div class="column col-md-6">
                                                    <!-- Email input -->
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            placeholder="Alamat email">
                                                    </div>
                                                </div>

                                                <div class="column col-md-6">
                                                    <!-- Name input -->
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="web" id="web"
                                                            placeholder="Website">
                                                    </div>
                                                </div>

                                                <div class="column col-md-12">
                                                    <!-- Email input -->
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="nama" name="nama"
                                                            placeholder="Nama anda">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="g-recaptcha"
                                                        data-sitekey="6Lf4Xw4cAAAAALsFjTBwl_UoAbwy-udJLnzpfkjI"
                                                        id="replyRecaptchaField"></div>
                                                    <input type="hidden" class="hiddenRecaptchaReply"
                                                        name="reply_recaptcha" id="reply_recaptcha{{ $increment++ }}">
                                                </div>

                                            </div>

                                            <button type="submit" name="submit" id="btnReplySubmit" value="Submit"
                                                class="btn btn-default" onclick="replyValidation(this)"
                                                data-id="{{ $comments->id }}">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="">
                        </li>
                        @php
                        $comment_replies = \App\Models\Reply::where('comment', '=', $comments->id)->get();
                        @endphp
                        @foreach ($comment_replies as $replies)

                        <li class="comment child rounded">
                            <div class="thumb">
                                <img src="{{ asset('assets/front/images/posts/default.jpg') }}" alt="John Doe"
                                    style="width: 70px; height: 70px; object-fit: cover;" />
                            </div>
                            <div class="details">
                                <h4 class="name"><a href="#">{{ $replies->nama }}</a></h4>
                                <span class="date">{{ $replies->updated_at->format('M d, Y') }}
                                    {{ date("H:i", strtotime($replies->updated_at)) }}</span>
                                <p>{{ $replies->reply }}</p>
                            </div>

                        </li>

                        @endforeach

                        @endforeach
                        <!-- comment item -->

                        <!-- comment item -->

                    </ul>
                </div>

                <div class="spacer" data-height="50"></div>
                <div id="commentBox">

                    <!-- section header -->
                    <div class="section-header">
                        <h3 class="section-title">Leave Comment</h3>
                        <img src="{{ asset('assets/front/images/wave.svg') }}" class="wave" alt="wave" />
                    </div>
                    <!-- comment form -->
                    <div class="comment-form rounded bordered padding-30">

                        <form action="{{ route('artikel.komentar') }}" id="commentForm" class="comment-form"
                            method="post">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">

                            <div class="row">

                                <div class="column col-md-12">
                                    <!-- Comment textarea -->
                                    <div class="form-group">
                                        <textarea name="comment" id="comment" class="form-control" rows="4"
                                            placeholder="Komentar anda..." required="required"
                                            required>{{ old('comment') }}</textarea>
                                    </div>
                                </div>

                                <div class="column col-md-6">
                                    <!-- Email input -->
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Alamat email">
                                    </div>
                                </div>

                                <div class="column col-md-6">
                                    <!-- Name input -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="web" id="web"
                                            placeholder="Website" value="{{ old('web') }}">
                                    </div>
                                </div>

                                <div class="column col-md-12">
                                    <!-- Email input -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama anda" required="required" value="{{ old('nama') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="g-recaptcha-qoute"
                                        data-sitekey="6Lf4Xw4cAAAAALsFjTBwl_UoAbwy-udJLnzpfkjI"
                                        id="commentRecaptchaField"></div>
                                    <input type="hidden" class="hiddenRecaptcha" name="comment_recaptcha"
                                        id="comment_recaptcha">
                                </div>




                            </div>

                            <button type="submit" name="submit" id="btnCommentSubmit" value="Submit"
                                class="btn btn-default">Submit</button><!-- Submit Button -->

                        </form>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">

                <!-- sidebar -->
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
{{-- Google captcha --}}
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback2&render=explicit"></script>
<script>
</script>
<script type="text/javascript">
    var CaptchaCallback = function() {
        var widgetId1;
        widgetId1 = grecaptcha.render('commentRecaptchaField', {'sitekey' : '6Lf4Xw4cAAAAALsFjTBwl_UoAbwy-udJLnzpfkjI', 'callback' : commentRecaptcha});    
    };
    
    var CaptchaCallback2 = function() {
        $('.g-recaptcha').html('');

        $('.g-recaptcha').each(function (i, captcha) {
            $("#cheko").html(i++);
            grecaptcha.render(captcha, {
                'sitekey' : '6Lf4Xw4cAAAAALsFjTBwl_UoAbwy-udJLnzpfkjI',
                'callback' : function(response) {
                    $("#reply_recaptcha" + i++).val(response);
                }
            });
        });
    };

    var commentRecaptcha = function(response) {
        $("#comment_recaptcha").val(response);
    }; 
</script>


<script>
    function categoryWidgetSubmit(element)
    {
        var category = $(element).attr('data-category');
        $("#categoryWidget").val(category);
        $("#categoryWidgetForm").submit();
    }
</script>
<script>
    function tagSubmit (element) {
        var tagValue = $(element).attr('data-tag');
        $("#tagValue").val(tagValue);
        $("#tagForm").submit();
    }
</script>
{{-- Jquery Comment Validation --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#commentForm").validate({
                ignore: [],
                rules: {
                    comment_recaptcha: { 
                        required: true, 
                    },
                    comment:{
                        required: true,
                        minlength: 3,
                        maxlength: 1000,
                    },
                    email:{
                        required: true,
                        minlength: 8,
                        maxlength: 255,
                    },
                    nama:{
                        required: true,
                        minlength: 3,
                        maxlength: 80,
                    },
                },
                messages: {
                    comment_recaptcha: {
                        required: "Harap lengkapi kolom captcha",
                    },
                    comment: {
                        required: "Komentar harus di isi",
                        minlength: "Komentar tidak boleh kurang dari 3 karakter",
                        maxlength: "Komentar tidak boleh lebih dari 1000 karakter",
                    },
                    email: {
                        required: "Email harus di isi",
                        email: "Masukkan alamat email yang valid.",
                        minlength: "Email tidak boleh kurang dari 3 karakter",
                        maxlength: "Email tidak boleh lebih dari 30 karakter",
                    },
                    nama: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter",
                    },
                },
            });
        });

       
</script>
<script>
    function replyValidation(validation)
    {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var id = $(validation).data('id');
            $("#replyForm" + id).validate({
                ignore: [],
                rules: {
                    reply_recaptcha: { 
                        required: true, 
                    },
                    reply:{
                        required: true,
                        minlength: 3,
                        maxlength: 1000,
                    },
                    email:{
                        required: true,
                        minlength: 8,
                        maxlength: 255,
                    },
                    nama:{
                        required: true,
                        minlength: 3,
                        maxlength: 80,
                    },
                },
                messages: {
                    reply_recaptcha: {
                        required: "Harap lengkapi kolom captcha",
                    },
                    reply: {
                        required: "Balasan harus di isi",
                        minlength: "Balasan tidak boleh kurang dari 3 karakter",
                        maxlength: "Balasan tidak boleh lebih dari 1000 karakter",
                    },
                    email: {
                        required: "Email harus di isi",
                        email: "Masukkan alamat email yang valid.",
                        minlength: "Email tidak boleh kurang dari 3 karakter",
                        maxlength: "Email tidak boleh lebih dari 30 karakter",
                    },
                    nama: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter",
                    },
                },
               
            });             
    }

    
</script>
<script>
    function replyTrigger(replyAttr)
    {
        $(replyAttr).css('display', 'none');
        $('.cancel-button').css('display', 'none');
        var buttonId= $(replyAttr).attr('data-id');
        $('#cancelButton' + buttonId).css('display', 'block');
        
        $('.replybox').hide();
        var commentboxId= $(replyAttr).attr('data-id');
        $('#'+commentboxId).toggle();
        $('#commentBox').hide();
    }

    function cancelReply(element)
    {   
        $(element).css('display', 'none');
        var buttonId = $(element).attr('data-id');
        $('#replyButton' + buttonId).css('display', 'block');
        $('.replybox').hide();
        $('#commentBox').show();
    }

    $(document).ready(function(){
        $('#kategori').click(function(){
            $("#kategoriForm").submit();
        });
    });
</script>
@endsection