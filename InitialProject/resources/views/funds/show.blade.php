@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('funds.Fund Details') }}</h4>
            <p class="card-description">{{ __('funds.Fund Description') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.fund_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.Year') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.Fund Details') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_details }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.fund_type') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_type }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.fund_level') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_level }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.Support Organization') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_name }}</p>
            </div>
            <div class="row">
    <p class="card-text col-sm-3"><b>{{ __('funds.Added by') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'th')
            {{ $fund->user->fname_th ?? '-' }} {{ $fund->user->lname_th ?? '-' }}
        @elseif(app()->getLocale() == 'zh')
            {{ $fund->user->fname_zh ?? $fund->user->fname_en ?? '-' }} 
            {{ $fund->user->lname_zh ?? $fund->user->lname_en ?? '-' }}
        @else
            {{ $fund->user->fname_en ?? '-' }} {{ $fund->user->lname_en ?? '-' }}
        @endif
    </p>
</div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('funds.index') }}">{{ __('funds.Back') }}</a>
            </div>
        </div>

    </div>


</div>
@endsection