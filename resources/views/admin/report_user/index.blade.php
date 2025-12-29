@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">

                <div class="card">
                    <div class="card-body">
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="reportingTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Report Count</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#reportingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report_user') }}",
                error: handleAjaxError,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'user_name',
                    searchable: false
                },
                {
                    data: 'total_reported_user',
                    searchable: false
                },
                {
                    data: 'status',
                    searchable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            // order: [
            //     [0, 'desc']
            // ]
        });



        /*change post status activate and deactivate*/
        $(document).on('click', '.togbtn', function(event) {

            event.preventDefault();
            var id = $(this).data('id');
            var el = $(this);
            var url = "{{ route('report_user.status') }}";
            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(response) {

                    if (response.val) {
                        swal("Success", response.success, "success");

                    } else {
                        swal("Success", response.success, "success");
                    }

                    el.prop('checked', response.val);
                }
            });
        });
    </script>
@endsection
