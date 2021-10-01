@extends('layouts.front')

@section('title')
    Kontak
@endsection

@section('content')
        <!-- page header -->
        <section class="page-header">
            <div class="container-xl">
                <div class="text-center">
                    <h1 class="mt-0 mb-2">Kontak</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <section class="main-content">
            <div class="container-xl">
    
                <div class="row mb-1">
                            
                    <div class="col-md-4">
                        <a href="https://instagram.com/{{$web->instagram ?? '-'}}" target="_blank" style="all:unset;cursor:pointer">
                            <div class="contact-item bordered rounded d-flex align-items-center">
                                <span class="icon icon-social-instagram"></span>
                                <div class="details">
                                    <h3 class="mb-0 mt-0">Instagram</h3>
                                    <p class="mb-0">{{$web->instagram ?? '-'}}</p>
                                </div>
                            </div>
                        </a>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="https://twitter.com/{{$web->twitter ?? '-'}}" target="_blank" style="all:unset;cursor:pointer">
                            <div class="contact-item bordered rounded d-flex align-items-center">
                                <span class="icon icon-social-twitter"></span>
                                <div class="details">
                                    <h3 class="mb-0 mt-0">Twitter</h3>
                                    <p class="mb-0">{{$web->twtiter ?? '-'}}</p>
                                </div>
                            </div>
                        </a>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>

                    <div class="col-md-4">
                        <a href="mailto:{{$web->email ?? '-'}}" target="_blank" style="all:unset;cursor:pointer">
                            <div class="contact-item bordered rounded d-flex align-items-center">
                                <span class="icon icon-envelope-open"></span>
                                <div class="details">
                                    <h3 class="mb-0 mt-0">E-Mail</h3>
                                    <p class="mb-0">{{$web->email ?? '-'}}</p>
                                </div>
                            </div>
                        </a>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <a href="https://facebook.com/{{$web->facebook ?? '-'}}" target="_blank" style="all:unset;cursor:pointer">
                            <div class="contact-item bordered rounded d-flex align-items-center">
                                <span class="icon icon-social-facebook"></span>
                                <div class="details">
                                    <h3 class="mb-0 mt-0">Facebook</h3>
                                    <p class="mb-0">{{$web->facebook ?? '-'}}</p>
                                </div>
                            </div>
                        </a>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="contact-item bordered rounded d-flex align-items-center">
                            <span class="icon icon-map"></span>
                            <div class="details">
                                <h3 class="mb-0 mt-0">Alamat</h3>
                                <p class="mb-0">{{$web->alamat ?? '-'}}</p>
                            </div>
                        </div>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>
                    <div class="col-md-4">
                        <a href="https://wa.me/{{$web->whatsapp ?? '-'}}" target="_blank" style="all:unset;cursor:pointer">
                            <div class="contact-item bordered rounded d-flex align-items-center">
                                <span class="fab fa-whatsapp fa-3x text-success"></span>
                                <div class="details">
                                    <h3 class="mb-0 mt-0">Whatsapp Me</h3>
                                </div>
                            </div>
                        </a>
                        <div class="spacer d-md-none d-lg-none" data-height="30"></div>
                    </div>
                </div>
                    
            </div>
        </section>
@endsection