@foreach($artikelAjax as $articles)
<div class="card article-lists" id="{{ $articles->id }}" data-id="{{ $articles->id }}"
    onclick="chooseTrendingArticle(this)">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="img d-flex">
                    <img src="{{ Storage::url($articles->gambar) }}"
                        style="border-radius:5px; width:85px; height:70px; object-fit: cover;">
                    <p style="margin-left: 30px;margin-top:20px;">{{ $articles->judul }}</p>
                </div>
            </div>
            <div class="col-sm-6 text-sm-right">
                <span class="badge badge-light text-sm-right">{{ $articles->getArticleCountAttribute() }} Pembaca</span>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="d-flex justify-content-center">
    {!! $artikelAjax->render('vendor.pagination.custom') !!}
</div>