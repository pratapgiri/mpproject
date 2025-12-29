@extends('frontend.layouts.master')

@section('title', 'WJAM | Home')

@section('content')
<section class="middile-panel">
    <div class="container">
        <div class="head">
            <h1>Manuscript Form</h1>
        </div>
        <div class="text">
            <div class="menuscript">
                <form method="post" action="{{ route('article.store') }}" id="regForm" name="regForm" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div id="ajax-success-msg" style="text-align:center; color:#0C0; font-size:15px; display:none;"></div>
                        <div id="ajax-error-msg" style="color: red;text-align:center; display:none;">
                            <ul id="ajax-error-list" style="list-style-type:none;padding:0;margin:0;"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row clearfix">
                                <div class="col-md-12 column">
                                    <div class="list-group form-horizontal">
                                        <div class="head">
                                            <h5>Personal Information</h5>
                                        </div>
                                        <div class="fill-form col-sm-12 manuscript_box">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-12 control-label">
                                                            Name <span class="msg_required_field">*</span>
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="fname" name="fname" value="" required placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-12 control-label">Email<span
                                                                class="msg_required_field">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="email" class="form-control" required name="email"
                                                                placeholder="Enter Email " value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-12 control-label">Phone</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="phone" placeholder="Enter Phone "
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-12 control-label">Category <span
                                                                class="msg_required_field">*</span></label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" required name="category_id">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $category)
                                                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-12 control-label">Address</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="address" placeholder="Enter Address"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group"><input type="hidden" value="12345" name="captcha"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="list-group ">
                        <div class="head">
                            <h5 class="mt-2">Article Details</h5>
                        </div>
                        <div class="col-sm-12 manuscript_box ">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="year_id" style='margin-bottom:5px;' class="col-sm-12 control-label">Year <span class="msg_required_field">*</span></label>
                                        <div class="col-sm-12">
                                            <select class="form-control" required name="year_id" id="year_id">
                                                <option value="">Select Year</option>
                                                @foreach ($years as $year)
                                                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="issues_id" style='margin-bottom:5px;' class="col-sm-12 control-label">Issue <span class="msg_required_field">*</span></label>
                                        <div class="col-sm-12">
                                            <select class="form-control" required name="issues_id" id="issues_id">
                                                <option value="">Select Issue</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" style='margin-bottom:5px;' class="col-sm-12 control-label">Article Title<span class="msg_required_field">*</span></label>
                                <div class="col-sm-12">
                                    <textarea name="title" class="form-control" rows="3" required="required" placeholder="Enter Article Title"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="abstract" style='margin-bottom:5px;' class="col-sm-12 control-label">Abstract<span class="msg_required_field">*</span></label>
                                <div class="col-sm-12">
                                    <textarea name="abstract" class="form-control" rows="5" required="required" placeholder="Enter Abstract"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keyword" style='margin-bottom:5px;' class="col-sm-12 control-label">Keywords<span class="msg_required_field">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="keyword" class="form-control" required="required" placeholder="Enter Keywords (comma separated)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="authors" style='margin-bottom:5px;' class="col-sm-12 control-label">Authors<span class="msg_required_field">*</span></label>
                                <div class="col-sm-12">
                                    <div id="authors-container">
                                        <div class="author-input-group mb-2">
                                            <input type="text" name="authors[]" class="form-control" required="required" placeholder="Enter Author Name">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-author-btn">Add Another Author</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="article" style='margin-bottom:5px;' class="col-sm-12 control-label">Upload Full Manuscript File (PDF)<span class="msg_required_field">*</span></label>
                                <div class="col-sm-12">
                                    <input type="file" name="article" required="required" id="upload_article" accept=".pdf" placeholder="">
                                    <small class="form-text text-muted">Only PDF files are allowed (Max: 10MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success" id="submit-btn">Submit</button>
        </div>
        </form>
      </div>
    </div>
    </div>
</section>

<!-- Ajax Form Submit Script -->
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    // Base URL for API calls
    var baseUrl = '{{ url("/") }}';
    
    // Load issues when year is selected
    $('#year_id').on('change', function() {
        var yearId = $(this).val();
        var issuesSelect = $('#issues_id');
        
        issuesSelect.html('<option value="">Loading...</option>');
        issuesSelect.prop('disabled', true);
        
        if (yearId) {
            var url = baseUrl + '/get-issues-by-year/' + yearId;
            
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    issuesSelect.html('<option value="">Select Issue</option>');
                    issuesSelect.prop('disabled', false);
                    if (response && response.length > 0) {
                        $.each(response, function(index, issue) {
                            issuesSelect.append('<option value="' + issue.id + '">' + (issue.issues || issue.issue || 'Issue ' + issue.id) + '</option>');
                        });
                    } else {
                        issuesSelect.html('<option value="">No issues available for this year</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading issues:', error);
                    console.error('Status:', xhr.status);
                    console.error('Response:', xhr.responseText);
                    issuesSelect.html('<option value="">Error loading issues. Please try again.</option>');
                    issuesSelect.prop('disabled', false);
                }
            });
        } else {
            issuesSelect.html('<option value="">Select Issue</option>');
            issuesSelect.prop('disabled', false);
        }
    });

    // Add author field
    $('#add-author-btn').on('click', function() {
        var authorHtml = '<div class="author-input-group mb-2">' +
            '<div class="input-group">' +
            '<input type="text" name="authors[]" class="form-control" required="required" placeholder="Enter Author Name">' +
            '<div class="input-group-append">' +
            '<button type="button" class="btn btn-danger remove-author-btn">Remove</button>' +
            '</div>' +
            '</div>' +
            '</div>';
        $('#authors-container').append(authorHtml);
    });

    // Remove author field
    $(document).on('click', '.remove-author-btn', function() {
        if ($('#authors-container .author-input-group').length > 1) {
            $(this).closest('.author-input-group').remove();
        } else {
            alert('At least one author is required.');
        }
    });

    // Form submission
    $('#regForm').on('submit', function (e) {
        e.preventDefault();

        var form = $('#regForm')[0];
        var data = new FormData(form);

        $("#submit-btn").prop("disabled", true);
        $('#ajax-success-msg').hide().text('');
        $('#ajax-error-msg').hide();
        $('#ajax-error-list').empty();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                $('#ajax-success-msg').text('Manuscript submitted successfully!').show();
                $('#ajax-error-msg').hide();
                $('#ajax-error-list').empty();
                $('#regForm')[0].reset();
                $('#issues_id').html('<option value="">Select Issue</option>');
                // Reset authors to single field
                $('#authors-container').html('<div class="author-input-group mb-2"><input type="text" name="authors[]" class="form-control" required="required" placeholder="Enter Author Name"></div>');
            },
            error: function (xhr) {
                // Improved error display: show each error in a list, and display the error box.
                let errorsHtml = '';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errs = xhr.responseJSON.errors;
                    Object.values(errs).flat().forEach(function(err){
                        errorsHtml += '<li>' + err + '</li>';
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorsHtml = '<li>' + xhr.responseJSON.message + '</li>';
                } else {
                    errorsHtml = '<li>An error occurred.</li>';
                }

                $('#ajax-error-list').html(errorsHtml);
                $('#ajax-error-msg').show();
            },
            complete: function() {
                $("#submit-btn").prop("disabled", false);
            }
        });
    });
});
</script>
@endsection

@endsection