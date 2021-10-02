@extends('layouts.back')
@section('title')
Category
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="{{ asset('assets/back/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    label.error {
        color: #f1556c;
        font-size: 13px;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 5px;
        padding: 0;
    }

    input.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }

    #addFormIcon i {
        font-size: 23px;
    }

    #editFormIcon i {
        font-size: 23px;
    }

    .iconpicker-item i {
        color: #384c6d !important;
    }

    .btn-light:not(:disabled):not(.disabled).active,
    .btn-light:not(:disabled):not(.disabled):active,
    .show>.btn-light.dropdown-toggle {
        color: #384c6d !important;

    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-separator-1">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kategori</li>
                </ol>
            </nav>
            <h3>Kategori</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-body">
                @if ($msg = Session::get('success'))
                <div class="alert alert-success">
                    {{ $msg }}
                </div>
                @endif
                @if ($msg = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $msg }}
                </div>
                @endif
                @if(count($errors) > 0 )
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </div>
                @endif
                <h5 class="card-title">Daftar Kategori</h5>
                <button type="button" class="btn btn-info mb-1" data-toggle="modal" data-animation="slide"
                    data-overlaySpeed="200" data-overlayColor="#36404a" data-target="#addModal"><i
                        class="fa fa-plus-circle"></i> Tambah</button><br><br>
                <table id="categoryTable" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Icon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $number = 1;
                        @endphp
                        @foreach($category as $categories)
                        <tr>
                            <td>{{ $number++ }}</td>
                            <td>{{ $categories->nama }}</td>
                            <td><span class="badge badge-secondary"><i class="{{ $categories->category_icon }}"
                                        style="font-size: 16px;"></i></span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" type="button" data-toggle="modal"
                                        data-target="#editModal" onclick="setEditData({{ $categories }})"><i
                                            class="fa fa-edit"></i> </button>
                                    <button type="button" data-id="{{ $categories->id }}" data-toggle="modal"
                                        data-target="#confirmDeleteModal" class="btn btn-danger"
                                        onclick="setData({{ $categories }})"><i class="fa fa-trash"></i>
                                    </button>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('category-articles.store') }}" method="POST" id="addForm">
                @csrf
                <div class="modal-body">

                    <div class="row justify-content-between">
                        <div class="col-9 col-sm-10">
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Kategori">
                            <input type="hidden" name="category_icon" id="categoryIcon">
                        </div>
                        <div class="col-3 col-sm-2">
                            <div class="btn-group d-flex justify-content-end">
                                <div class="btn-group">
                                    <button data-selected="graduation-cap" type="button"
                                        class="icp demo btn btn-default dropdown-toggle iconpicker-component btn btn-sm btn-light"
                                        data-toggle="dropdown" id="addFormIcon"
                                        style="border-radius: 10px; padding: 10px;">
                                        <i class="far fa-circle" id="defaultIcon"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addForm()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Ubah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form class="form-horizontal" action="{{ route('category-articles.update', '') }}" id="editForm"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col-9 col-sm-10">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="checkCategory">
                            <input type="text" name="edit_nama" id="edit_nama" class="form-control"
                                placeholder="Nama Kategori">
                            <input type="hidden" name="edit_category_icon" id="categoryIconEdit">
                        </div>
                        <div class="col-3 col-sm-2">
                            <div class="btn-group d-flex justify-content-end">
                                <div class="btn-group">
                                    <button data-selected="graduation-cap" type="button"
                                        class="icp demo btn btn-default dropdown-toggle iconpicker-component btn btn-sm btn-light"
                                        data-toggle="dropdown" id="editFormIcon"
                                        style="border-radius: 10px; padding: 10px;">
                                        <i class="far fa-circle" id="defaultIconEdit"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editForm()">Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Hapus Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{ route('users.destroy', '') }}" method="post" id="confirmDeleteForm">
                @csrf
                @method('delete')
                <div class="modal-body">
                    apakah anda yakin untuk menghapus <b> kategori</b> ini beserta seluruh data terkait <b>(artikel)</b> ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya, Hapus !</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('assets/back/fontawesome-iconpicker.js') }}"></script>
<script>
    $(document).ready(function() {
    $('#categoryTable').DataTable( {
        responsive: true
    });
} );
</script>
<script>
    $('#addFormIcon').iconpicker();
    $('#editFormIcon').iconpicker();
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    function addForm() 
    {    
        var firstClass = $("#defaultIcon").attr('class').split(' ')[0];
        var secondClass = $("#defaultIcon").attr('class').split(' ')[1];
        var categoryIcon = firstClass + " " + secondClass;
        console.log(categoryIcon);
        $("#categoryIcon").val(categoryIcon);
        $("#addForm").submit();
    }

    function editForm() 
    {    
        var firstClass = $("#defaultIconEdit").attr('class').split(' ')[0];
        var secondClass = $("#defaultIconEdit").attr('class').split(' ')[1];
        var categoryIcon = firstClass + " " + secondClass;
        $("#categoryIconEdit").val(categoryIcon);
        $("#editForm").submit();
    }
</script>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#addForm").validate({
                rules: {
                    nama:{
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        remote: {
                                url: "{{ route('category_articles.checkCategory') }}",
                                type: "post",
                        }
                    },
                },
                messages: {
                    nama: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter",
                        remote: "Nama sudah tersedia"
                    },
                }
            });

            $("#editForm").validate({
                rules: {
                    edit_nama:{
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        remote: {
                            param: {
                                url: "{{ route('category_articles.checkCategory') }}",
                                type: "post",
                            },
                            depends: function(element) {
                                // compare name in form to hidden field
                                return ($(element).val() !== $('#checkCategory').val());
                            },
                           
                        }
                    },
                },
                messages: {
                    edit_nama: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter",
                        remote: "Nama sudah tersedia"
                    },
                }
            });
        });
</script>



<script>
    //  when modal is closed error validation removed 
    $('#editModal').on('hidden.bs.modal', function() {
        var $alertas = $('#editModal');
        $alertas.validate().resetForm();
        $alertas.find('.error').removeClass('error');
    });

    //  passing data to edit modal pop up 
    const updateLink = $('#editForm').attr('action');
    function setEditData(category) {
        $('#editForm').attr('action',  `${updateLink}/${category.id}`);
        $('#checkCategory').val(category.nama);
        $('[name="edit_nama"]').val(category.nama);
    }

    const updateLink2 = $('#confirmDeleteForm').attr('action');
    function setData(category) {
        $('#confirmDeleteForm').attr('action',  `${updateLink}/${category.id}`);
    }  
</script>
@endsection