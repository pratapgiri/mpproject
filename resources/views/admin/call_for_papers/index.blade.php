@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <button type="button" class="btn btn-primary btn-lg mb-4 font-weight-bold"
                                data-toggle="modal" data-target="#addCallModal">
                            Add Call For Paper
                        </button>

                        <div class="card">
                            <div class="card-header">
                                <h5>Call For Papers List</h5>
                            </div>
                            <div class="card-body">
                                <table id="call-table" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
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

{{-- ADD CALL MODAL --}}
<div class="modal fade" id="addCallModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="addCallForm" action="{{ route('admin.call.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Call For Paper</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control">
                    <div class="invalid-feedback" id="title-error"></div>

                    <label class="mt-3">Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="add_description" class="form-control"></textarea>
                    <div class="invalid-feedback" id="description-error"></div>

                    <label class="mt-3">Date & Time</label>
                    <input type="datetime-local" name="date" class="form-control">

                    <label class="mt-3">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="addSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span> Add Call
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT CALL MODAL --}}
<div class="modal fade" id="editCallModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editCallForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Call For Paper</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_call_id">

                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" id="edit_title" name="title" class="form-control">
                    <div class="invalid-feedback" id="edit-title-error"></div>

                    <label class="mt-3">Description <span class="text-danger">*</span></label>
                    <textarea id="edit_description" name="description" class="form-control"></textarea>
                    <div class="invalid-feedback" id="edit-description-error"></div>

                    <label class="mt-3">Date & Time</label>
                    <input type="datetime-local" id="edit_date" name="date" class="form-control">

                    <label class="mt-3">Status</label>
                    <select id="edit_status" name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span> Update Call
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.25.1-lts/full/ckeditor.js"></script>

<script>
$(document).ready(function() {

    CKEDITOR.replace('add_description');
    CKEDITOR.replace('edit_description');

    // Initialize DataTable
    let table = $('#call-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.call.index') }}",
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title" },
            { data: "description" },
            { data: "date" },
            { data: "status" },
            { data: "created_at" },
            { data: "action", orderable: false, searchable: false }
        ]
    });

    // =========================
    // ADD CALL SUBMIT
    // =========================
    $('#addCallForm').submit(function(e){
        e.preventDefault();
        let btn = $('#addSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        $('.is-invalid').removeClass('is-invalid'); // Clear previous errors

        let formData = {
            title: $('[name="title"]').val(),
            description: CKEDITOR.instances.add_description.getData(),
            date: $('[name="date"]').val(),
            status: $('[name="status"]').val(),
            _token: "{{ csrf_token() }}"
        };

        $.post($(this).attr('action'), formData, function(res){
            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            if(res.status){
                $('#addCallModal').modal('hide');
                $('#addCallForm')[0].reset();
                CKEDITOR.instances.add_description.setData(""); 
                table.ajax.reload(null, false);
                Swal.fire("Success", res.message, "success");
            }
        }).fail(function(xhr){
            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            if(xhr.status === 422){
                $.each(xhr.responseJSON.errors, function(field, msg){
                    $('[name="'+field+'"]').addClass('is-invalid');
                    $('#'+field+'-error').text(msg[0]);
                });
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        });
    });

    // =========================
    // LOAD EDIT DATA
    // =========================
    $(document).on('click','.edit-call', function(){
        let id = $(this).data('id');
        let url = "{{ route('admin.call.edit.data', ':id') }}";
        url = url.replace(':id', id);

        $.get(url, function(res){
            $('#edit_call_id').val(res.id);
            $('#edit_title').val(res.title);
            CKEDITOR.instances.edit_description.setData(res.description);
            
            // Use the formatted_date we created in Controller
            $('#edit_date').val(res.formatted_date); 
            $('#edit_status').val(res.status);

            let updateUrl = "{{ route('admin.call.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', res.id);
            $('#editCallForm').attr('action', updateUrl);

            $('#editCallModal').modal('show');
        });
    });

    // =========================
    // EDIT SUBMIT
    // =========================
    $('#editCallForm').submit(function(e){
        e.preventDefault();
        let btn = $('#editSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        $('.is-invalid').removeClass('is-invalid');

        let formData = {
            title: $('#edit_title').val(),
            description: CKEDITOR.instances.edit_description.getData(),
            date: $('#edit_date').val(),
            status: $('#edit_status').val(),
            _token: "{{ csrf_token() }}"
        };

        $.post($(this).attr('action'), formData, function(res){
            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            $('#editCallModal').modal('hide');
            table.ajax.reload(null, false);
            Swal.fire("Updated", res.message, "success");
        }).fail(function(xhr){
            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            if(xhr.status === 422){
                $.each(xhr.responseJSON.errors, function(field, msg){
                    $('#edit_'+field).addClass('is-invalid');
                    $('#edit-'+field+'-error').text(msg[0]);
                });
            } else {
                Swal.fire("Error", "Something went wrong", "error");
            }
        });
    });

    // =========================
    // DELETE
    // =========================
    $(document).on('click', '.delete-call', function(){
        let id = $(this).data('id');
        let url = "{{ route('admin.call.delete', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: "Are you sure?",
            text: "This will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete"
        }).then(result => {
            if(result.isConfirmed){
                $.get(url, function(res){
                    if(res.status){
                        Swal.fire("Deleted!", res.message, "success");
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                });
            }
        });
    });

    // =========================
    // STATUS TOGGLE
    // =========================
    $(document).on('click', '.status-toggle', function(){
        let id = $(this).data('id');
        let current = $(this).data('status');
        let newStatus = current == 1 ? 0 : 1;
        
        let url = "{{ route('admin.call.status', ':id') }}";
        url = url.replace(':id', id);

        $.post(url, {
            status: newStatus,
            _token: "{{ csrf_token() }}"
        }, function(res){
            Swal.fire("Updated", res.message, "success");
            table.ajax.reload(null, false);
        });
    });

});
</script>
@endpush