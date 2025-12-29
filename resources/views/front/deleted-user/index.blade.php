@extends('admin.layouts.app')

@section('content')
    <style>
        div.dt-buttons {
            float: none;
        }

        div#workstation-list_length {
            display: contents;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #9b7f7f;
        }

        .dropdown-menu {
            min-width: 6rem;
        }

        .admin_note:hover {
            cursor: pointer;
        }

        .select2-selection__rendered {
            margin-top: -14px !important;
        }
    </style>

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <!-- HTML5 Export Buttons table start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @if (session('status'))
                                                <div class="alert alert-{{ session('type') }} alert-dismissible fade show"
                                                    role="alert">
                                                    {{ session('status') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                            @endif
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                            @endif
                                            <div class="dt-responsive table-responsive">
                                                <table id="deleted-users-list"
                                                    class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th width="10%">User name</th>
                                                            <th width="10%">Email</th>
                                                            {{-- <th width="10%">Country Code</th>
                                                            <th width="10%">Mobile</th> --}}
                                                            <th width="10%">Deleted By</th>
                                                            <th width="10%">Created at</th>
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
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection('content')

@push('scripts')
    <script>
        var table = $('#deleted-users-list').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 2,
            ajax: {
                url: "{{ route('deleted_users') }}",
                error: handleAjaxError,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                // {
                //     data: 'country_code',
                //     name: 'country_code'
                // },
                // {
                //     data: 'mobile',
                //     name: 'mobile'
                // },

                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'deleted_by',
                    name: 'deleted_by'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ]
        });
    </script>
@endpush('scripts')
