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

                        <button type="button" class="btn btn-lg btn-primary mb-4 font-weight-bold" data-toggle="modal" data-target="#addIssueModal">
                            Add Issue
                        </button>

                        <div class="card">
                            <div class="card-header">
                                <h5>Issue List</h5>
                            </div>
                            <div class="card-body">
                                <table id="issue-table" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Year</th>
                                            <th>Issues</th>
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

<!-- Add Issue Modal -->
<div class="modal fade" id="addIssueModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="addIssueForm" method="POST" action="{{ route('issue.add') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Issue</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <label>Year <span class="text-danger">*</span></label>
                    <select name="year" class="form-control">
                        <option value="">Select Year</option>
                        @foreach($year as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="year-error"></div>

                    <label class="mt-3">Issues <span class="text-danger">*</span></label>
                    <input type="text" name="issues" class="form-control">
                    <div class="invalid-feedback" id="issues-error"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="addSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Add Issue
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- Edit Issue Modal -->
<div class="modal fade" id="editIssueModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="editIssueForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Edit Issue</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_issue_id">

                    <label>Year <span class="text-danger">*</span></label>
                    <select name="year" id="edit_year" class="form-control">
                        <option value="">Select Year</option>
                        @foreach($year as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="edit-year-error"></div>

                    <label class="mt-3">Issues <span class="text-danger">*</span></label>
                    <input type="text" name="issues" id="edit_issues" class="form-control">
                    <div class="invalid-feedback" id="edit-issues-error"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        Update Issue
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var table = $('#issue-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('issue.index') }}",
        columns: [{
                data: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "year"
            },
            {
                data: "issues"
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


    // ADD ISSUE
    $('#addIssueForm').submit(function(e) {
        e.preventDefault();

        let btn = $('#addSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        $.post($(this).attr('action'), $(this).serialize(), function(res) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

            if (res.status) {
                $('#addIssueModal').modal('hide');
                $('#addIssueForm')[0].reset();
                table.ajax.reload(null, false);
                Swal.fire('Success', res.message, 'success');
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


    // LOAD EDIT DATA
    $(document).on('click', '.edit-index', function() {
        let id = $(this).data('id');

        $.get("{{ url('admin/issue/edit') }}/" + id, function(res) {

            $('#edit_issue_id').val(res.id);
            $('#edit_year').val(res.year);
            $('#edit_issues').val(res.issues);
            $('#edit_status').val(res.status);

            $('#editIssueForm').attr('action', "{{ url('admin/issue/update') }}/" + res.id);

            $('#editIssueModal').modal('show');

        });

    });


    // SUBMIT EDIT
    $('#editIssueForm').submit(function(e) {
        e.preventDefault();

        let btn = $('#editSubmitBtn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        $.post($(this).attr('action'), $(this).serialize(), function(res) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');

            $('#editIssueModal').modal('hide');
            table.ajax.reload(null, false);

            Swal.fire('Updated', res.message, 'success');

        }).fail(function(xhr) {

            btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');

            $.each(xhr.responseJSON.errors, function(field, msg) {
                $('#edit_' + field).addClass('is-invalid');
                $('#edit-' + field + '-error').text(msg[0]);
            });

        });

    });


    // TOGGLE STATUS
    $(document).on('click', '.status-toggle', function() {
        let id = $(this).data('id');
        let current = $(this).data('status');
        let newStatus = current == 1 ? 0 : 1;

        $.post("{{ url('admin/issue/status') }}/" + id, {
            status: newStatus,
            _token: "{{ csrf_token() }}"
        }, function(res) {
            Swal.fire("Updated", res.message, "success");
            table.ajax.reload(null, false);
        });

    });


    // DELETE ISSUE
    $(document).on('click', '.delete_index', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete"
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("{{ url('admin/issue/delete') }}/" + id, function(res) {
                    Swal.fire("Deleted!", res.message, "success");
                    table.ajax.reload(null, false);
                });
            }
        });

    });
</script>
@endpush