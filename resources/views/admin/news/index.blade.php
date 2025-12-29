@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> 
@endpush

@section('content')

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <button type="button" class="btn btn-primary btn-lg mb-4" data-toggle="modal" data-target="#addNewsModal">
                            Add News
                        </button>

                        <div class="card">
                            <div class="card-header">
                                <h5>News List</h5>
                            </div>
                            <div class="card-body">

                                <table id="news-table" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal">
    <div class="modal-dialog modal-xl">   <!-- BIG MODAL -->
        <div class="modal-content">

            <form id="addNewsForm" action="{{ route('news.add') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add News</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control">
                    <div class="invalid-feedback" id="title-error"></div>

                    <label class="mt-3">Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="add_description" class="form-control"></textarea>
                    <div class="invalid-feedback" id="description-error"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="addSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Add News
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal">
    <div class="modal-dialog modal-xl">   <!-- BIG MODAL -->
        <div class="modal-content">

            <form id="editNewsForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit News</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_news_id">

                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" id="edit_title" name="title" class="form-control">
                    <div class="invalid-feedback" id="edit-title-error"></div>

                    <label class="mt-3">Description <span class="text-danger">*</span></label>
                    <textarea id="edit_description" name="description" class="form-control"></textarea>
                    <div class="invalid-feedback" id="edit-description-error"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Update News
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
CKEDITOR.replace('add_description');
CKEDITOR.replace('edit_description');

let table = $('#news-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('news.index') }}",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "title" },
        { data: "description" },
        { data: "status" },
        { data: "created_at" },
        { data: "action", orderable: false, searchable: false }
    ]
});


// ADD NEWS
$('#addNewsForm').submit(function(e){
    e.preventDefault();

    let btn = $('#addSubmitBtn');
    btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

    let formData = {
        title: $('[name="title"]').val(),
        description: CKEDITOR.instances.add_description.getData(),
        _token: "{{ csrf_token() }}"
    };

    $.post($(this).attr('action'), formData, function(res){

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

        if(res.status){
            $('#addNewsModal').modal('hide');
            $('#addNewsForm')[0].reset();
            CKEDITOR.instances.add_description.setData("");
            table.ajax.reload(null, false);

            Swal.fire("Success", res.message, "success");
        }

    }).fail(function(xhr){

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
        $('.is-invalid').removeClass('is-invalid');

        $.each(xhr.responseJSON.errors, function(field, msg){
            $('[name="'+field+'"]').addClass('is-invalid');
            $('#'+field+'-error').text(msg[0]);
        });

    });

});


// LOAD EDIT DATA
$(document).on('click', '.edit-news', function(){

    let id = $(this).data('id');

    $.get("{{ url('admin/news/edit') }}/" + id, function(res){

        $('#edit_news_id').val(res.id);
        $('#edit_title').val(res.title);
        CKEDITOR.instances.edit_description.setData(res.description);

        $('#editNewsForm').attr('action', "{{ url('admin/news/update') }}/" + res.id);

        $('#editNewsModal').modal('show');

    });

});


// SUBMIT EDIT
$('#editNewsForm').submit(function(e){
    e.preventDefault();

    let btn = $('#editSubmitBtn');
    btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

    let formData = {
        title: $('#edit_title').val(),
        description: CKEDITOR.instances.edit_description.getData(),
        _token: "{{ csrf_token() }}"
    };

    $.post($(this).attr('action'), formData, function(res){

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

        $('#editNewsModal').modal('hide');
        table.ajax.reload(null, false);

        Swal.fire("Updated", res.message, "success");

    }).fail(function(xhr){

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

        $('.is-invalid').removeClass('is-invalid');

        $.each(xhr.responseJSON.errors, function(field, msg){
            $('#edit_'+field).addClass('is-invalid');
            $('#edit-'+field+'-error').text(msg[0]);
        });

    });

});


// STATUS TOGGLE
$(document).on('click', '.status-toggle', function(){

    let id = $(this).data('id');
    let current = $(this).data('status');
    let newStatus = current == 1 ? 0 : 1;

    $.post("{{ url('admin/news/status') }}/" + id, {
        status: newStatus,
        _token: "{{ csrf_token() }}"
    }, function(res){

        Swal.fire("Updated", res.message, "success");
        table.ajax.reload(null, false);

    });

});


// DELETE NEWS
$(document).on('click', '.delete-news', function(){

    let id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "This will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete"
    }).then(result => {

        if(result.isConfirmed){

            $.get("{{ url('admin/news/delete') }}/" + id, function(res){

                Swal.fire("Deleted!", res.message, "success");
                table.ajax.reload(null, false);

            });

        }

    });

});
</script>
@endpush
