@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="section-header">
        <h1>Kategori Thread</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
          <div class="breadcrumb-item">Kategori Thread</div>
        </div>
      </div>
      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4>Kategori ({{ $categories->total() }})</h4>
            <div class="card-header-action">
              <button class="btn btn-icon icon-left btn-primary" id="btn-add"><i class="fas fa-plus"></i> Tambah
                Kategori</button>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <tr>
                  <th>Nama</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Action</th>
                </tr>
                @foreach ($categories as $category)
                  <tr>
                    <td>{{ $category->name }}</a></td>
                    <td class="font-weight-600">{{ $category->created_at }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                      <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button type="button" data-url="{{ route('admin.categories.update', $category->id) }}"
                          class="btn btn-warning btn-edit" data-name="{{ $category->name }}">Edit</button>
                        <button type="button" data-url="{{ route('admin.categories.destroy', $category->id) }}"
                          class="btn btn-danger btn-delete-cat">Hapus</button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </table>
              {{ $categories->links() }}
            </div>
          </div>
        </div>
      </div>

    </div>
    <form action="" method="POST" hidden id="form-delete-cat">@csrf @method('DELETE')</form>
  @endsection

  @section('modal')
    <div class="modal fade" id="modal-cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-cat" action="" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
              <div class="form-row mb-2">
                <label>Name</label>
                <input name="name" type="text" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  @endsection
  @push('javascript')
    <script>
      $(function() {
        $('.btn-edit').click(function() {
          const url = $(this).data('url');
          const name = $(this).data('name');

          $('#form-cat').prop('action', url);
          $('#form-cat input[name=name]').val(name);
          $('#modal-cat .modal-title').text('Edit cat');
          $('#form-cat input[name=_method]').val('PUT');
          $('#modal-cat').modal('show');
        });

        $('#btn-add').click(function() {
          $('#form-cat').prop('action', "{{ route('admin.categories.store') }}");
          $('#modal-cat .modal-title').text('Tambah cat');
          $('#form-cat input[name=_method]').val('POST');
          $('#modal-cat').modal('show');
        });


        $('#modal-cat').on('hidden.bs.modal', function(e) {
          $('#form-cat input[name=name]').val('');
          $('#modal-cat .modal-title').text('Modal cat');
        })
      });

      $('.btn-delete-cat').click(function() {
        $('#form-delete-cat').prop('action', $(this).data('url'));
        Swal.fire({
          title: 'Apa anda yakin?',
          text: "Jika anda yakin klik hapus",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#32CD32',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form-delete-cat').submit();
          }
        })
      });

    </script>
  @endpush
