@extends('admin.layouts.app')
@section('content')

    <div class="row">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">


                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="" accept-charset="UTF-8" id="submit-form" enctype="multipart/form-data">
                            @csrf
                            <div class="tile-body">

                                <div class="form-group">
                                    <label class="">Current Password</label>
                                    <div class="input-group" id="current_password">
                                        <input class="form-control currentPassword" placeholder="" 
                                        name="current_password" type="password" autocomplete="new-password">

                                        <span id="span-password-eye">
                                            <i class="mdi mdi-eye-off text-primary password-eye-icon current_password"></i>
                                        </span> 
                                    </div>       
                                </div>

                                

                                <div class="form-group">
                                    <label class="">New Password</label>
                                    <div class="input-group" id="new_password">
                                        <input class="form-control newPassword" placeholder="" 
                                        name="new_password" type="password" autocomplete="new-password">

                                        <span id="span-password-eye">
                                            <i class="mdi mdi-eye-off text-primary password-eye-icon new_password"></i>
                                        </span> 
                                    </div>      
                                    
                                </div>


                                <div class="form-group">
                                    <label class="">Confirm Password</label>

                                    <div class="input-group" id="confirm_password">
                                        <input class="form-control confirmPassword" placeholder="" 
                                        name="confirm_password" type="password" autocomplete="new-password">

                                        <span id="span-password-eye">
                                            <i class="mdi mdi-eye-off text-primary password-eye-icon confirm_password"></i>
                                        </span> 
                                    </div>

                                   
                                </div>


                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>
                                    @lang("Update Password")
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>


        $('.current_password').on('click', function() {
            if ($(".currentPassword").attr('type') == 'password') {
                $(".currentPassword").attr('type', 'text');
                $('.current_password').addClass('mdi-eye').removeClass('mdi-eye-off');

            } else {
                $(".currentPassword").attr('type', 'password');
                $('.current_password').addClass('mdi-eye-off').removeClass('mdi-eye');
            }
        });

        $('.new_password').on('click', function() {
            if ($(".newPassword").attr('type') == 'password') {
                $(".newPassword").attr('type', 'text');
                $('.new_password').addClass('mdi-eye').removeClass('mdi-eye-off');

            } else {
                $(".newPassword").attr('type', 'password');
                $('.new_password').addClass('mdi-eye-off').removeClass('mdi-eye');
            }
        });

        $('.confirm_password').on('click', function() {
            if ($(".confirmPassword").attr('type') == 'password') {
                $(".confirmPassword").attr('type', 'text');
                $('.confirm_password').addClass('mdi-eye').removeClass('mdi-eye-off');

            } else {
                $(".confirmPassword").attr('type', 'password');
                $('.confirm_password').addClass('mdi-eye-off').removeClass('mdi-eye');
            }
        });

        $(function() {
            $('#submit-form').ajaxForm({

                beforeSubmit: function() {
                    $(".error").remove();
                    disable("#submit-btn", true);
                    $("body").LoadingOverlay("show");
                },
                error: function(err) {
                    $("body").LoadingOverlay("hide");
                    handleError(err);
                    disable("#submit-btn", false);
                },

                success: function(response) {
                    disable("#submit-btn", false);
                    $("body").LoadingOverlay("hide");
                    if (response.status == 'true') {
                        $('#turn-up-error').html('');
                        swal({
                            title: response.message,
                            icon: "success",
                            dangerMode: false,
                        }).then(function(isConfirm) {
                            if (isConfirm) {}
                        });

                        $('#submit-form')[0].reset();

                    } else {
                        $('#turn-up-error').html('');
                        swal({
                            title: response.message,
                            icon: "error",
                            dangerMode: true,
                        }).then(function(isConfirm) {
                            if (isConfirm) {}
                        });
                    }
                }

            });
        });
    </script>
@endsection
