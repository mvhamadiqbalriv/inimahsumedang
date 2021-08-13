@extends('main')

@section('title','Ajax Live Search Table Generation using Laravel')

@section('content')

<!-- search box container starts  -->
<div class="search">
    <h3 class="text-center title-color">Ajax Live Search Table Generation using Laravel</h3>
    <p>Demo for Ajax Live Search Table Generation using Laravel. it will show you detail using ajax serch.</p>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon" style="color: white; background-color: rgb(125,78,254);">SEARCH
                    BLOG</span>
                <input type="text" autocomplete="off" id="searchtxt" class=" searchtxt form-control input-lg"
                    placeholder="Enter Blog Title">
            </div>
        </div>
    </div>
</div>
<!-- search box container ends  -->
<div id="Hintdate" class="title-color Hintdate " style="padding-top:50px; text-align:center;"><b>Blogs information will
        be listed here...</b></div>

@stop

@section('scripts')

<script>
    $(document).ready(function(){
    $("#searchtxt").keyup(function(){
        var str=  $("#searchtxt").val();
        if(str == "") {
            $( "#Hintdate" ).html("<b>Blogs information will be listed here...</b>");
        }else {
            $.get( "{{ url('demos/searchlive?id=') }}"+str, function( data ) {
                $( "#Hintdate" ).html( data );
            });
        }
    });
});
</script>

@stop