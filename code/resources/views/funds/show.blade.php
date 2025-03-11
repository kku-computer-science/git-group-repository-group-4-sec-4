@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('funds.Fund Details') }}</h4>
            <p class="card-description">{{ __('funds.Fund Description') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.fund_name') }}</b></p>
                <p class="card-text col-sm-9">
                    @if(app()->getLocale() == 'th')
                        {{ $fund->fund_name ?? '-' }}
                    @elseif(app()->getLocale() == 'zh')
                        {{ $fund->fund_name_zh ?? $fund->fund_name_en ?? '-' }}
                    @else
                        {{ $fund->fund_name_en ?? '-' }}
                    @endif
                </p>
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
                <p class="card-text col-sm-9">
                    @if(app()->getLocale() == 'th')
                        {{ $fund->fund_type_th }}
                    @elseif(app()->getLocale() == 'zh')
                        {{ $fund->fund_type_zh }}
                    @else
                        {{ $fund->fund_type_en }}
                    @endif
                </p>
                </div>

                <div class="row">
                    <p class="card-text col-sm-3"><b>{{ __('funds.fund_level') }}</b></p>
                    <p class="card-text col-sm-9">
                        @if(app()->getLocale() == 'th')
                            {{ $fund->fund_level_th }}
                        @elseif(app()->getLocale() == 'zh')
                            {{ $fund->fund_level_zh }}
                        @else
                            {{ $fund->fund_level_en }}
                        @endif
                    </p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('funds.Support Organization') }}</b></p>
                <p class="card-text col-sm-9">
                    @if(app()->getLocale() == 'th')
                        {{ $fund->support_resource ?? '-' }}
                    @elseif(app()->getLocale() == 'zh')
                        {{ $fund->support_resource_zh ?? $fund->support_resource_en ?? '-' }}
                    @else
                        {{ $fund->support_resource_en ?? '-' }}
                    @endif
                </p>
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