@extends('admin.layouts.app')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .switch{position:relative;display:inline-block;width:50px;height:24px;}
    .switch input{display:none;}
    .slider{position:absolute;cursor:pointer;background:#ccc;border-radius:34px;top:0;bottom:0;left:0;right:0;transition:.3s;}
    .slider:before{position:absolute;content:"";height:18px;width:18px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.3s;}
    input:checked + .slider{background:#28a745;}
    input:checked + .slider:before{transform:translateX(26px);}
    td img{border-radius:3px;border:1px solid #ddd;}
</style>
@endpush

@section('content')

<div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between mb-3">
        <h4>Article List</h4>
        <button class="btn btn-primary" id="addBtn">Add Article</button>
    </div>

    <table id="articleTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>QR</th>
                <th>Year</th>
                <th>Issue</th>
                <th>Category</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewArticleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5>Article Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div id="viewArticleContent"></div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

let table = $("#articleTable").DataTable({
    processing:true,
    serverSide:true,
    ajax:"{{ route('article.index') }}",
    columns:[
        {data:'DT_RowIndex', orderable:false},
        {data:'qr', orderable:false},
        {data:'year'},
        {data:'issue'},
        {data:'category'},
        {data:'title'},
        {data:'status', orderable:false},
        {data:'action', orderable:false},
    ]
});

/* ===================== VIEW (UPDATED) ===================== */
$(document).on("click",".view-article", function(){
    let id = $(this).data("id");

    $.get("{{ route('article.show','ID') }}".replace("ID",id), res => {

        let a = res.data;
        let authorsHtml =
            '<ul>' + a.authors.map(x => `<li>${x.author}</li>`).join("") + '</ul>';

        $("#viewArticleContent").html(`
            <h5 class="text-primary">${a.title}</h5>
            <p>${a.abstract}</p>

            <hr>
            <h6>Authors</h6>
            ${authorsHtml}

            <hr>
            <h6 class="text-center">QR Code</h6>
            <div class="text-center">
                <img src="${res.qr_code}"
                     width="160"
                     class="border p-2 bg-white shadow-sm">
            </div>
        `);

        $("#viewArticleModal").modal("show");
    });
});
</script>
@endpush
