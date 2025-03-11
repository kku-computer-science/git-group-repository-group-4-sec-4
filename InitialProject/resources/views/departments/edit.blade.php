@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('department.edit_department') }}
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('departments.index') }}">{{ __('department.departments') }}</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($department, ['route' => ['departments.update', $department->id], 'method' => 'PATCH']) !!}
                
                <div class="form-group">
                    <strong>{{ __('department.department_name_th') }}:</strong>
                    {!! Form::text('department_name_th', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <strong>{{ __('department.department_name_en') }}:</strong>
                    {!! Form::text('department_name_en', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <strong>{{ __('department.department_name_zh') }}:</strong>
                    {!! Form::text('department_name_zh', null, ['class' => 'form-control']) !!}
                </div>

                <button type="submit" class="btn btn-primary">{{ __('department.submit') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
