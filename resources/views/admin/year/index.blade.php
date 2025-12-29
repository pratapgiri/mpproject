@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

<style>
    .toggle-text {
        position: absolute;
        color: white;
        font-size: 10px;
        font-weight: bold;
        top: 3px;
        left: 6px;
        pointer-events: none;
    }

    input:checked+.slider .toggle-text {
        left: 26px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 22px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        border-radius: 34px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }
</style>


@section('content')

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <button type="button" class="btn btn-primary btn-lg mb-4" data-toggle="modal" data-target="#addYearModal">
                            Add Year
                        </button>

                        <div class="card">
                            <div class="card-header">
                                <h5>Years List</h5>
                            </div>
                            <div class="card-body">

                                <table id="year-table" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Year</th>
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


<!-- ADD YEAR MODAL -->
<div class="modal fade" id="addYearModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="addYearForm" action="{{ route('year.add') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Year</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <label>Year <span class="text-danger">*</span></label>
                    <input type="number" name="year" class="form-control" placeholder="e.g. 2025">
                    <div class="invalid-feedback" id="year-error"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="addSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Add Year
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



<!-- EDIT YEAR MODAL -->
<div class="modal fade" id="editYearModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="editYearForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Year</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_year_id">

                    <label>Year <span class="text-danger">*</span></label>
                    <input type="number" id="edit_year" name="year" class="form-control">
                    <div class="invalid-feedback" id="edit-year-error"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Update Year
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script>
    let table = $('#year-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('year.index') }}",
        columns: [{
                data: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "year"
            },
            {
                data: "status"
            },
            {
                data: "created_at"
            },
            {
                data: "action",
                orderable: false,
                searchable: false
            }
        ]
    });


    // ADD YEAR
    $('#addYearForm').submit(function(e) {
        e.preventDefault();

        let btn = $('#addSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        let formData = {
            year: $('[name="year"]').val(),
            _token: "{{ csrf_token() }}"
        };

        $.post($(this).attr('action'), formData, function(res) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

            if (res.status) {
                $('#addYearModal').modal('hide');
                $('#addYearForm')[0].reset();
                table.ajax.reload(null, false);

                Swal.fire("Success", res.message, "success");
            }

        }).fail(function(xhr) {
            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');

            $.each(xhr.responseJSON.errors, function(field, msg) {
                $('[name="' + field + '"]').addClass('is-invalid');
                $('#' + field + '-error').text(msg[0]);
            });
        });

    });


    // STATUS TOGGLE
    $(document).on('change', '.toggle-status', function() {
        let id = $(this).data('id');
        let newStatus = $(this).is(':checked') ? 1 : 0;

        $.post("{{ url('admin/year/status') }}/" + id, {
            status: newStatus,
            _token: "{{ csrf_token() }}"
        }, function(res) {
            Swal.fire("Updated", res.message, "success");
            table.ajax.reload(null, false);
        });
    });



    // LOAD EDIT DATA
    $(document).on('click', '.edit-index', function() {

        let id = $(this).data('id');

        $.get("{{ url('admin/year/edit') }}/" + id, function(res) {

            $('#edit_year_id').val(res.id);
            $('#edit_year').val(res.year);

            $('#editYearForm').attr('action', "{{ url('admin/year/update') }}/" + res.id);

            $('#editYearModal').modal('show');

        });

    });


    // UPDATE YEAR
    $('#editYearForm').submit(function(e) {
        e.preventDefault();

        let btn = $('#editSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        let formData = {
            year: $('#edit_year').val(),
            _token: "{{ csrf_token() }}"
        };

        $.post($(this).attr('action'), formData, function(res) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

            $('#editYearModal').modal('hide');
            table.ajax.reload(null, false);

            Swal.fire("Updated", res.message, "success");

        }).fail(function(xhr) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');

            $.each(xhr.responseJSON.errors, function(field, msg) {
                $('#edit_' + field).addClass('is-invalid');
                $('#edit-' + field + '-error').text(msg[0]);
            });

        });

    });


    // DELETE YEAR
    $(document).on('click', '.delete-index', function() {

        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete"
        }).then(result => {

            if (result.isConfirmed) {
                $.get("{{ url('admin/year/delete') }}/" + id, function(res) {

                    Swal.fire("Deleted!", res.message, "success");
                    table.ajax.reload(null, false);

                });
            }

        });

    });
</script> -->



<script>
    let table = $('#year-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('year.index') }}",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "year" },
        { data: "status", orderable: false, searchable: false },
        { data: "created_at" },
        { data: "action", orderable: false, searchable: false }
    ]
});


// ---------------------- ADD YEAR ----------------------
$('#addYearForm').submit(function(e) {
    e.preventDefault();

    let btn = $('#addSubmitBtn');
    btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

    let formData = {
        year: $('[name="year"]').val(),
        _token: "{{ csrf_token() }}"
    };

    $.post($(this).attr('action'), formData, function(res) {

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

        if (res.status) {
            $('#addYearModal').modal('hide');
            $('#addYearForm')[0].reset();
            table.ajax.reload(null, false);

            Swal.fire("Success", res.message, "success");
        }

    }).fail(function(xhr) {
        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
        $('.is-invalid').removeClass('is-invalid');

        $.each(xhr.responseJSON.errors, function(field, msg) {
            $('[name="' + field + '"]').addClass('is-invalid');
            $('#' + field + '-error').text(msg[0]);
        });
    });

});


// ---------------------- STATUS UPDATE ----------------------
$(document).on('change', '.toggle-status', function () {
    let id = $(this).data('id');
    let newStatus = $(this).is(':checked') ? 1 : 0;

    $.post("{{ url('admin/year/status') }}/" + id, {
        status: newStatus,
        _token: "{{ csrf_token() }}"
    }, function (res) {
        Swal.fire("Updated", res.message, "success");
        table.ajax.reload(null, false);
    });
});


// ---------------------- LOAD EDIT DATA ----------------------
$(document).on('click', '.edit-index', function () {

    let id = $(this).data('id');

    $.get("{{ url('admin/year/edit') }}/" + id, function (res) {

        $('#edit_year_id').val(res.id);
        $('#edit_year').val(res.year);

        $('#editYearForm').attr('action', "{{ url('admin/year/update') }}/" + res.id);

        $('#editYearModal').modal('show');

    });

});


// ---------------------- UPDATE YEAR ----------------------
$('#editYearForm').submit(function(e) {
    e.preventDefault();

    let btn = $('#editSubmitBtn');
    btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

    let formData = {
        year: $('#edit_year').val(),
        _token: "{{ csrf_token() }}"
    };

    $.post($(this).attr('action'), formData, function(res) {

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

        $('#editYearModal').modal('hide');
        table.ajax.reload(null, false);

        Swal.fire("Updated", res.message, "success");

    }).fail(function(xhr) {

        btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
        $('.is-invalid').removeClass('is-invalid');

        $.each(xhr.responseJSON.errors, function(field, msg) {
            $('#edit_' + field).addClass('is-invalid');
            $('#edit-' + field + '-error').text(msg[0]);
        });

    });

});


// ---------------------- DELETE YEAR ----------------------
$(document).on('click', '.delete-index', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "This will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete"
    }).then(result => {

        if (result.isConfirmed) {
            $.get("{{ url('admin/year/delete') }}/" + id, function (res) {

                Swal.fire("Deleted!", res.message, "success");
                table.ajax.reload(null, false);

            });
        }

    });

});

</script>



@endpush