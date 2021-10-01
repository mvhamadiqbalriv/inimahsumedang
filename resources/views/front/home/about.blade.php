@extends('layouts.front')

@section('title')
    Tentang
@endsection

@section('content')
        <!-- page header -->
        <section class="page-header">
            <div class="container-xl">
                <div class="text-center">
                    <h1 class="mt-0 mb-2">Tentang</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tentang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
        <section class="main-content">
            <div class="container-xl">
    
                <div class="row">
                    
                    {!! $web->description !!}

                </div>
            </div>
        </section>
@endsection