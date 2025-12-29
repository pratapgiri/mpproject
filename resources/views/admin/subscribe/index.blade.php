@extends('admin.layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')

<div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between mb-3">
        <h4>Subscriber List</h4>
        <button class="btn btn-primary btn-sm" id="addSubscriberBtn">Add Subscriber</button>
    </div>

    <table class="table table-bordered table-striped" id="subscriberTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th width="90px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="subscriberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Subscriber</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form id="subscriberForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" class="form-control">
                        <span class="text-danger error name_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control">
                        <span class="text-danger error email_error"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="saveSubscriberBtn" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// SweetAlert Toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// Load DataTable
let table = $("#subscriberTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('subscribe.index') }}",
    columns: [
        { data: 'DT_RowIndex', orderable:false, searchable:false },
        { data: 'name' },
        { data: 'email' },
        { data: 'action', orderable:false, searchable:false }
    ]
});

// Open Modal
$("#addSubscriberBtn").click(function() {
    $("#subscriberForm")[0].reset();
    $(".error").text("");
    $("#subscriberModal").modal("show");
});

// Save Subscriber
$("#subscriberForm").submit(function(e) {
    e.preventDefault();
    $(".error").text("");

    $.post("{{ route('subscribe.add') }}", $(this).serialize(), function(res){
        if(res.success){
            table.ajax.reload();
            $("#subscriberModal").modal("hide");
            Toast.fire({ icon:'success', title: res.message });
        }
    }).fail(function(err){
        if(err.responseJSON.errors){
            $.each(err.responseJSON.errors, function(k, v){
                $("."+k+"_error").text(v[0]);
            });
        }
    });
});

// Delete Subscriber
$(document).on("click", ".delete_subscriber", function(){
    let id = $(this).data("id");

    Swal.fire({
        title: 'Are you sure?',
        text: "Delete this subscriber?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes!',
    }).then((result)=>{
        if(result.isConfirmed){
            $.get("{{ url('admin/subscriber/delete') }}/"+id, function(res){
                if(res.success){
                    table.ajax.reload();
                    Toast.fire({ icon:'success', title: res.message });
                }
            });
        }
    });
});
</script>
@endpush
