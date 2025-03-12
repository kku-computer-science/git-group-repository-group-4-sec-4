@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('books.Book_Detail') }}</h4>
            <p class="card-description">{{ __('books.Book_Information') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.Book_Name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.Year') }}</b></p>
                <p class="card-text col-sm-9">{{ date('Y', strtotime($paper->ac_year))+543 }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.Publication_Source') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_sourcetitle }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('books.Page') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_page }}</p>
            </div>

            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}">{{ __('books.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
