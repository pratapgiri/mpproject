@extends('admin.layouts.app')

@push('styles')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        div.dt-buttons {
            float: none;
        }

        div#index-list_length {
            display: contents;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #9b7f7f;
        }

        .dropdown-menu {
            min-width: 6rem;
        }
        
        /* Modal image preview */
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            display: none;
            margin-top: 10px;
        }
        
        .sm-img {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
        }
        
        .current-image {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">

                                    <button type="button" class="btn btn-lg btn-primary mb-4 font-weight-bold" data-toggle="modal" data-target="#addIndexModal">
                                        Add Index
                                    </button>

                                    <div class="card">
                                        <div class="card-header table-card-header">
                                            <h5>Index List</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="index-list" class="w-100 table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>URL</th>
                                                            <th>Created at</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Index Modal -->
    <div class="modal fade" id="addIndexModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Index</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="addIndexForm" action="{{ route('index.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback" id="name-error"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" id="url" name="url" required>
                                <div class="invalid-feedback" id="url-error"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(this,'add')">
                                <div class="invalid-feedback" id="image-error"></div>

                                <img id="addImagePreview" class="image-preview img-thumbnail" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none"></span>
                            Add Index
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Edit Index Modal -->
    <div class="modal fade" id="editIndexModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Index</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="editIndexForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="edit_index_id" name="id">

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <div class="invalid-feedback" id="edit-name-error"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" id="edit_url" name="url" required>
                                <div class="invalid-feedback" id="edit-url-error"></div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label>Image</label>
                                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewImage(this,'edit')">
                                <div class="invalid-feedback" id="edit-image-error"></div>

                                <div class="mt-2" id="currentImageContainer">
                                    <strong>Current Image:</strong>
                                    <img id="currentImage" class="current-image img-thumbnail">
                                </div>

                                <img id="editImagePreview" class="image-preview img-thumbnail" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                            <span class="spinner-border spinner-border-sm d-none"></span>
                            Update Index
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- SweetAlert2 JS -->
    
    <script>
        // Image preview function
        function previewImage(input, type) {
            const preview = document.getElementById(type + 'ImagePreview');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (type === 'edit') $('#currentImageContainer').hide();
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '';
                if (type === 'edit') $('#currentImageContainer').show();
            }
        }

        // SweetAlert function for success/error messages
        function showSweetAlert(icon, title, text, timer = 3000) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                timer: timer,
                timerProgressBar: true,
                showConfirmButton: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        }

        // SweetAlert for confirmation
        function showConfirmAlert(title, text, confirmButtonText, cancelButtonText, callback) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: cancelButtonText,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        var table = $('#index-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: { 
                url: "{{ route('index') }}", 
                error: handleAjaxError 
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false 
                },
                { 
                    data: 'name', 
                    name: 'name' 
                },
                { 
                    data: 'image', 
                    name: 'image',
                    orderable: false, 
                    searchable: false,
                },
                { 
                    data: 'url',
                    name: 'url',
                    render: function(data){ 
                        return data ? `<a href="${data}" target="_blank">${data}</a>` : ''; 
                    }
                },
                { 
                    data: 'created_at',
                    name: 'created_at' 
                },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false, 
                    searchable: false 
                },
            ]
        });

        // Edit modal data loading
        $(document).on('click', '.edit-index', function() {
            let id = $(this).data('id');
            let editUrl = "{{ route('index.edit.data', ':id') }}".replace(':id', id);
            let updateUrl = "{{ route('index.update', ':id') }}".replace(':id', id);

            // Show loading state
            $('#editSubmitBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');

            $.ajax({
                url: editUrl,
                type: 'GET',
                success: function(response) {
                    // Populate form fields
                    $('#edit_index_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_url').val(response.url);

                    // Image assignment from response
                    if (response.image) {
                        $('#currentImage').attr('src', response.image);
                        $('#currentImageContainer').show();
                    } else {
                        $('#currentImageContainer').hide();
                    }

                    // Hide new image preview
                    $('#editImagePreview').hide();
                    
                    // Set form action
                    $('#editIndexForm').attr('action', updateUrl);

                    // Clear any previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Enable submit button
                    $('#editSubmitBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');

                    // Show modal
                    $('#editIndexModal').modal('show');
                },
                error: function(xhr) {
                    $('#editSubmitBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
                    showSweetAlert('error', 'Error!', 'Failed to load index data. Please try again.');
                }
            });
        });

        // Handle Add form submission with AJAX
        $('#addIndexForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var submitBtn = $('#addSubmitBtn');
            var spinner = submitBtn.find('.spinner-border');
            
            // Show loading state
            submitBtn.prop('disabled', true);
            spinner.removeClass('d-none');
            
            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    
                    if (response.status === 'true') {
                        // Close modal
                        $('#addIndexModal').modal('hide');
                        
                        // Reset form
                        $('#addIndexForm')[0].reset();
                        $('#addImagePreview').hide();
                        
                        // Show success SweetAlert
                        showSweetAlert('success', 'Success!', response.message || 'Index added successfully!');
                        
                        // Reload DataTable
                        table.ajax.reload(null, false);
                    } else {
                        // Show error SweetAlert
                        showSweetAlert('error', 'Error!', response.message || 'Error adding index!');
                    }
                },
                error: function(xhr) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            // Display field-specific errors
                            $.each(errors, function(field, messages) {
                                var input = $('[name="' + field + '"]');
                                var errorDiv = $('#' + field + '-error');
                                input.addClass('is-invalid');
                                errorDiv.text(messages[0]);
                            });
                            
                            // Show validation error SweetAlert
                            var firstError = Object.values(errors)[0][0];
                            showSweetAlert('error', 'Validation Error!', firstError);
                        } else {
                            showSweetAlert('error', 'Error!', 'Validation error occurred!');
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        showSweetAlert('error', 'Error!', xhr.responseJSON.message);
                    } else {
                        showSweetAlert('error', 'Error!', 'An unexpected error occurred!');
                    }
                }
            });
        });

        // Handle Edit form submission with AJAX
        $('#editIndexForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var submitBtn = $('#editSubmitBtn');
            var spinner = submitBtn.find('.spinner-border');
            
            // Show loading state
            submitBtn.prop('disabled', true);
            spinner.removeClass('d-none');
            
            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    
                    if (response.status === 'true') {
                        // Close modal
                        $('#editIndexModal').modal('hide');
                        
                        // Reset form
                        $('#editIndexForm')[0].reset();
                        $('#editImagePreview').hide();
                        
                        // Show success SweetAlert
                        showSweetAlert('success', 'Success!', response.message || 'Index updated successfully!');
                        
                        // Reload DataTable
                        table.ajax.reload(null, false);
                    } else {
                        // Show error SweetAlert
                        showSweetAlert('error', 'Error!', response.message || 'Error updating index!');
                    }
                },
                error: function(xhr) {
                    // Reset loading state
                    submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                    
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            // Display field-specific errors
                            $.each(errors, function(field, messages) {
                                var input = $('#edit_' + field);
                                var errorDiv = $('#edit-' + field + '-error');
                                input.addClass('is-invalid');
                                errorDiv.text(messages[0]);
                            });
                            
                            // Show validation error SweetAlert
                            var firstError = Object.values(errors)[0][0];
                            showSweetAlert('error', 'Validation Error!', firstError);
                        } else {
                            showSweetAlert('error', 'Error!', 'Validation error occurred!');
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        showSweetAlert('error', 'Error!', xhr.responseJSON.message);
                    } else {
                        showSweetAlert('error', 'Error!', 'An unexpected error occurred!');
                    }
                }
            });
        });

        // Delete index with SweetAlert confirmation
        $(document).on('click', '.delete_index', function() {
            let id = $(this).data('id');
            let deleteUrl = "{{ route('index.delete', ':id') }}".replace(':id', id);
            
            showConfirmAlert(
                'Are you sure?',
                'Once deleted, you will not be able to recover this index!',
                'Yes, delete it!',
                'Cancel',
                function() {
                    // Show loading SweetAlert
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the index.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Perform AJAX delete
                    $.ajax({
                        url: deleteUrl,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Index has been deleted successfully.',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            
                            // Reload DataTable
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete index. Please try again.',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            );
        });

        // Reset forms when modals are closed
        $('#addIndexModal').on('hidden.bs.modal', function() {
            $('#addIndexForm')[0].reset();
            $('#addImagePreview').hide();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#addSubmitBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
        });

        $('#editIndexModal').on('hidden.bs.modal', function() {
            $('#editIndexForm')[0].reset();
            $('#editImagePreview').hide();
            $('#currentImageContainer').show();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#editSubmitBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
        });

        // Handle AJAX errors for DataTable
        function handleAjaxError(xhr, error, thrown) {
            if (xhr.status === 419) {
                // CSRF token mismatch - reload the page
                showSweetAlert('error', 'Session Expired!', 'Please refresh the page and try again.');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                console.error('DataTables error:', error, thrown);
                showSweetAlert('error', 'Error!', 'Error loading table data. Please refresh the page.');
            }
        }

        // Clear validation errors when input changes
        $('#addIndexForm input').on('input', function() {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('name') + '-error').text('');
            }
        });

        $('#editIndexForm input').on('input', function() {
            var fieldName = $(this).attr('name');
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                $('#edit-' + fieldName + '-error').text('');
            }
        });

        // Success message for page load if any
        @if(session('success'))
            showSweetAlert('success', 'Success!', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showSweetAlert('error', 'Error!', '{{ session('error') }}');
        @endif
    </script>
@endpush