@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ __('users.oops') }}</strong> {{ __('users.error_msg') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card" style="padding: 16px;">
                <div class="card-body">
                    <h4 class="card-title mb-5">{{ __('users.add_user') }}</h4>
                    <p class="card-description">{{ __('users.enter_details') }}</p>
                    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <p><b>{{ __('users.fname_th') }}</b></p>
                            {!! Form::text('fname_th', null, array('placeholder' => __('users.fname_th'),'class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-6">
                            <p><b>{{ __('users.lname_th') }}</b></p>
                            {!! Form::text('lname_th', null, array('placeholder' => __('users.lname_th'),'class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <p><b>{{ __('users.fname_en') }}</b></p>
                            {!! Form::text('fname_en', null, array('placeholder' => __('users.fname_en'),'class' => 'form-control')) !!}
                        </div>
                        <div class="col-sm-6">
                            <p><b>{{ __('users.lname_en') }}</b></p>
                            {!! Form::text('lname_en', null, array('placeholder' => __('users.lname_en'),'class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
    <div class="col-sm-6">
        <p><b>{{ __('users.fname_zh') }}</b></p>
        <input type="text" name="fname_zh" class="form-control" placeholder="{{ __('users.fname_zh') }}">
    </div>
    <div class="col-sm-6">
        <p><b>{{ __('users.lname_zh') }}</b></p>
        <input type="text" name="lname_zh" class="form-control" placeholder="{{ __('users.lname_zh') }}">
    </div>
</div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <p><b>{{ __('users.email') }}</b></p>
                            {!! Form::text('email', null, array('placeholder' => __('users.email'),'class' => 'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <p><b>{{ __('users.password') }}</b></p>
                            {!! Form::password('password', array('placeholder' => __('users.password'),'class' => 'form-control'))!!}
                        </div>
                        <div class="col-sm-6">
                            <p><b>{{ __('users.confirm_password') }}</b></p>
                            {!! Form::password('password_confirmation', array('placeholder' => __('users.confirm_password'),'class' =>'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
    <p class="col-sm-3"><b>{{ __('users.role') }}</b></p>
    <div class="col-sm-8">
        <select name="roles[]" class="form-control selectpicker"
            multiple data-live-search="true"
            data-none-selected-text="{{ __('users.nothing_selected') }}">
            @foreach ($roles as $role)
                <option value="{{ $role }}">
                    {{ __('roles.' . $role) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-4">
            <h6>{{ __('users.department') }} <span class="text-danger">*</span></h6>
            <select class="form-control selectpicker" name="cat" id="cat" style="width: 100%;" required>
                <option value="">{{ __('users.select_category') }}</option>
                @foreach ($departments as $cat)
                <option value="{{ $cat->id }}">
                    {{ app()->getLocale() == 'th' ? $cat->department_name_th : (app()->getLocale() == 'zh' ? $cat->department_name_zh : $cat->department_name_en) }}
                </option>
                @endforeach
            </select>
        </div>
                            
                            <div class="col-md-4">
                                <h6>{{ __('users.program') }} <span class="text-danger">*</span></h6>
                                <select class="form-control select2" name="sub_cat" id="subcat" required>
                                    <option value="">{{ __('users.select_subcategory') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('users.submit') }}</button>
                    <a class="btn btn-secondary" href="{{ route('users.index') }}">{{ __('users.cancel') }}</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->



<script>
    $('#cat').on('change', function() {
        var cat_id = $(this).val();
        console.log("Selected Department ID: " + cat_id); // Debug
        if (cat_id) {
            $.ajax({
                url: '/ajax-get-subcat?cat_id=' + cat_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("Received Data:", data); // Debug

                    $('#subcat').empty();
                    $('#subcat').append('<option value="">{{ __('users.select_subcategory') }}</option>');

                    $.each(data, function(key, value) {
                        var programName = value.program_name_en; // ค่าเริ่มต้นเป็นอังกฤษ
                        if ("{{ app()->getLocale() }}" == "th") {
                            programName = value.program_name_th;
                        } else if ("{{ app()->getLocale() }}" == "zh") {
                            programName = value.program_name_zh;
                        }
                        console.log("Adding Program: ", programName); // Debug
                        $('#subcat').append('<option value="' + value.id + '">' + programName + '</option>');
                    });

                    $('.selectpicker').selectpicker('refresh');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                }
            });
        } else {
            $('#subcat').empty();
            $('#subcat').append('<option value="">{{ __('users.select_subcategory') }}</option>');
            $('.selectpicker').selectpicker('refresh');
        }
    });
</script>


@endsection