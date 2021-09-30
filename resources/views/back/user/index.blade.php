@extends('layouts.back')
@section('title')
    Pengguna
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-separator-1">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
              </ol>
            </nav>
            <h3>Pengguna</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-body">
                @if ($msg = Session::get('success'))
                    <div class="alert alert-success">
                        {{$msg}}
                    </div>
                @endif
                @if ($msg = Session::get('error'))
                    <div class="alert alert-danger">
                        {{$msg}}
                    </div>
                @endif
                <h5 class="card-title">Daftar Pengguna</h5>
                <a href="{{route('users.create')}}" class="btn btn-info mb-1"><i class="fa fa-plus-circle"></i> Tambah</a><br><br>
                <table id="userTable" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            @role('admin')
                            <th>Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($list as $item)
                            <tr id="item_{{$item->id}}">
                                <th>{{$no++}}</th>
                                <td>
                                    @php
                                        $path = asset('assets/back/images/avatars/default_user.png');
                                        if ($item->photo) {
                                            $path = Storage::url($item->photo);
                                        }
                                    @endphp
                                    <img src="{{$path}}" width="35" height="35" style="object-fit: cover" class="rounded" alt="">
                                </td>
                                <td>
                                    <a href="{{route('users.show', $item->id)}}">
                                       {{$item->name}}
                                    </a>
                                </td>
                                <td>{{$item->email}}</td>
                                @role('admin')
                                <td>
                                    <a href="{{route('users.edit', $item->id)}}" class="btn btn-success"><i class="fa fa-edit"></i> </a>
                                    <a href="javascript:void(0)" data-name="{{$item->name}}" data-uid="{{$item->id}}" onclick="deleteUserModal(this)" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
                                </td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>       
            </div>
        </div>
    </div>
</div>
<!-- Modal delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalTitle">Hapus user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form id="confirmDeleteForm">
            <input type="hidden" name="id_user" id="id_user">
            <div class="modal-body">
                apakah anda yakin menghapus <b id="namaUserModal"></b> ?
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
<script>
$(document).ready(function() {
    $('#userTable').DataTable( {
        responsive: true
    });
} );
</script>
    <script>
        function deleteUserModal(obj){
            var id = obj.getAttribute('data-uid');
            var nama = obj.getAttribute('data-name');
            $('#id_user').val(id);
            $('#namaUserModal').html(nama);
            $('#confirmDeleteModal').modal('show');
        }

        const form = document.getElementById('confirmDeleteForm');
 
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const uid = form.id_user.value;
            const _token = "{{ csrf_token() }}";

            try {
                let response = await fetch("{{url('users')}}/"+uid, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": _token,
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });
                var datasend = await response.json();

                    $('#confirmDeleteModal').modal('hide');

                    if (datasend.errors !== undefined) {
                        toastr.error('Silahkan coba lagi.', 'Error !');
                    }else{
                        if (datasend.status == 'Error') {
                            toastr.error('Silahkan coba lagi.', 'Error !');
                        }else{
                            toastr.success('Data berhasil dihapus.', 'Success !');
                            document.getElementById('item_'+uid).remove();
                        }
                    }

                return false;
            } catch (err) {
                console.log(err);
            }
        });

    </script>
@endsection