<?php
if(!empty($article))
{
    $card ='';
    foreach ($article as $articles) {
        $card .= '
        <div class="card article-lists" id="'.$articles->id.'" data-id="'. $articles->id .'" onclick="chooseTrendingArticle(this)">
            <div class="card-body">
                <div class="d-flex justify-content-between ">
                    <div class="img d-flex" ">
                        <img src="' . Storage::url($articles->gambar) . '" style="border-radius:5px; width:85px; height:70px; object-fit: cover;">
                        <p style="margin-left: 30px;margin-top:20px;">' . $articles->judul . '</p>
                        </div>
                    <div class="wdx">
                        
                    </div>
                </div>    
            </div>
        </div>
        ';
    }

    echo $card;
} else {
    echo 'We Not Found Any Data';
}
?>