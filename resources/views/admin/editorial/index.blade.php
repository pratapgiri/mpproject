@extends('admin.layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    .switch input{display:none;}
    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        border-radius: 34px;
        top: 0; left: 0; right: 0; bottom: 0;
        transition: .4s;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 25px;
        width: 25px;
        left: 3px;
        bottom: 2px;
        background: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked+.slider {background-color: #28a745;}
    input:checked+.slider:before {transform: translateX(28px);}

    .ck-editor__editable {
        min-height: 180px !important;
    }
</style>
@endpush

@section('content')

<div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between mb-3">
        <h4>Editorial List</h4>
        <button class="btn btn-primary" id="addBtn">Add Editorial</button>
    </div>

    <table class="table table-bordered table-striped" id="editorialTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>University</th>
                <th>Image</th>
                <th>Status</th>
                <th width="120px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

{{-- ================= ADD/EDIT MODAL ================= --}}
<div class="modal fade" id="editorialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 id="modalTitle">Add Editorial</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form id="editorialForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editorial_id">

                <div class="modal-body">

                    <label>Name *</label>
                    <input type="text" class="form-control" name="name" id="name">
                    <span class="text-danger error name_error"></span>
                    <br>

                    <label>Type *</label>
                    <select class="form-control" name="type" id="type">
                        <option value="">Select Type</option>
                        <option value="Editor in Chief">Editor in Chief</option>
                        <option value="Associate Editors">Associate Editors</option>
                        <option value="Editorial Board Members">Editorial Board Members</option>
                        <option value="Advisory Board Members">Advisory Board Members</option>
                    </select>
                    <span class="text-danger error type_error"></span>
                    <br>

                    <label>University</label>
                    <input type="text" class="form-control" name="university" id="university">
                    <br>

                    <label>Description</label>
                    <textarea class="form-control" name="description" id="editor_description"></textarea>
                    <br>

                    <label>Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*">
                    <small id="oldImage"></small>

                </div>

                <div class="modal-footer">
                    <button type="submit" id="saveBtn" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ================= VIEW MODAL ================= --}}
<div class="modal fade" id="viewEditorialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5>Editorial Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="viewEditorialContent"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
const ASSET_URL = "{{ asset('') }}";

let descriptionEditor;

ClassicEditor
    .create(document.querySelector('#editor_description'))
    .then(editor => {
        descriptionEditor = editor;
    })
    .catch(error => {
        console.error(error);
    });

// DataTable Load
let table = $("#editorialTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('editorial.index') }}",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "type" },
        { data: "university" },
        { data: "image", orderable: false, searchable: false },
        { data: "status", orderable: false, searchable: false },
        { data: "action", orderable: false, searchable: false }
    ]
});

$("#addBtn").click(function(){
    $("#editorialForm")[0].reset();
    $("#editorial_id").val("");
    descriptionEditor.setData("");
    $("#oldImage").html("");
    $(".error").text("");
    $("#modalTitle").text("Add Editorial");
    $("#editorialModal").modal("show");
});

function clearErrors(){ $(".error").text(""); }

// Save / Update
$("#editorialForm").submit(function(e){
    e.preventDefault();
    clearErrors();

    let id = $("#editorial_id").val();
    let url = id ? "{{ url('admin/editorial/update') }}/" + id : "{{ route('editorial.add') }}";

    let formData = new FormData(this);
    formData.set('description', descriptionEditor.getData());

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res){
            $("#editorialModal").modal("hide");
            table.ajax.reload();
            Swal.fire("Success", res.message, "success");
        },
        error: function(err){
            let errors = err.responseJSON.errors;
            $.each(errors, (k,v)=>$("."+k+"_error").text(v[0]));
        }
    });
});

// Edit
$(document).on("click", ".edit-editorial", function(){
    let id = $(this).data("id");

    $.get("{{ url('admin/editorial/edit') }}/"+id, function(res){
        let d = res.data;

        $("#modalTitle").text("Edit Editorial");
        $("#editorial_id").val(d.id);
        $("#name").val(d.name);
        $("#type").val(d.type).trigger("change");
        $("#university").val(d.university);
        descriptionEditor.setData(d.description ?? "");

        $("#oldImage").html(d.image ? `<img src="${ASSET_URL+d.image}" width="80" class="mt-2 border rounded">` : "");

        $("#editorialModal").modal("show");
    });
});

// Delete
$(document).on("click",".delete-editorial",function(){
    let id = $(this).data("id");

    Swal.fire({
        title:"Are you sure?",
        icon:"warning",
        showCancelButton:true,
        confirmButtonText:"Delete"
    }).then(res=>{
        if(res.isConfirmed){
            $.post("{{ url('admin/editorial/delete') }}/"+id,function(res){
                table.ajax.reload();
                Swal.fire("Deleted!",res.message,"success");
            });
        }
    });
});

// Status
$(document).on("change",".status-toggle",function(){
    let id = $(this).data("id");
    $.post("{{ url('admin/editorial/status') }}/"+id, ()=>{
        Swal.fire("Success","Status Updated!","success");
    });
});

// View
$(document).on("click",".view-editorial",function(){
    let id = $(this).data("id");

    $.get("{{ url('admin/editorial/edit') }}/"+id,function(res){
        let e = res.data;

        let html =
        `<table class="table table-bordered">
            <tr><th>Name</th><td>${e.name}</td></tr>
            <tr><th>Type</th><td>${e.type}</td></tr>
            <tr><th>University</th><td>${e.university ?? 'N/A'}</td></tr>
            <tr><th>Status</th><td>${e.status ? 'Active' : 'Inactive'}</td></tr>
            ${e.description ? `<tr><th>Description</th><td>${e.description}</td></tr>` : ""}
            <tr><th>Image</th><td>${e.image ? `<img src="${ASSET_URL+e.image}" width="100">` : '-'}</td></tr>
        </table>`;

        $("#viewEditorialContent").html(html);
        $("#viewEditorialModal").modal("show");
    });
});
</script>
@endpush
