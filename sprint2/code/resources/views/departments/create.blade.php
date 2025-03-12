@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ __('department.error_title') }}</strong> {{ __('department.error_message') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('department.create_department') }}
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('departments.index') }}">{{ __('department.departments') }}</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'departments.store', 'method'=>'POST')) !!}
                
                    <div class="form-group">
                        <strong>{{ __('department.department_name_th') }}:</strong>
                        {!! Form::text('department_name_th', null, array('placeholder' => __('department.placeholder_th'),'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <strong>{{ __('department.department_name_en') }}:</strong>
                        {!! Form::text('department_name_en', null, array('placeholder' => __('department.placeholder_en'),'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <strong>{{ __('department.department_name_zh') }}:</strong>
                        {!! Form::text('department_name_zh', null, array('placeholder' => __('department.placeholder_zh'),'class' => 'form-control')) !!}
                    </div>
                    
                    <button type="submit" class="btn btn-primary">{{ __('department.submit') }}</button>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
