@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('patents.detail') }}</h4>
            <p class="card-description">{{ __('patents.detail2') }}</p>
            <div class="row">
            <p class="card-text col-sm-3"><b>{{ __('patents.name2') }}</b></p>
            <p class="card-text col-sm-9">
                @if(app()->getLocale() == 'zh' && !empty($patent->ac_name_zh))
                    {{ $patent->ac_name_zh }}
                @elseif(app()->getLocale() == 'en' && !empty($patent->ac_name_en))
                    {{ $patent->ac_name_en }}
                @else
                    {{ $patent->ac_name }}
                @endif
            </p>

            </div>
            <div class="row">
            <p class="card-text col-sm-3"><b>{{ __('patents.type') }}</b></p>
            <p class="card-text col-sm-9">
                @if(app()->getLocale() == 'zh' && !empty($patent->ac_type_zh))
                    {{ $patent->ac_type_zh }}
                @elseif(app()->getLocale() == 'en' && !empty($patent->ac_type_en))
                    {{ $patent->ac_type_en }}
                @else
                    {{ $patent->ac_type }}
                @endif
            </p>

            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.registration_date') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('patents.regis_number') }}</b></p>
                <p class="card-text col-sm-9">{{ __('patents.registration_number') }} {{ $patent->ac_refnumber }}</p>
            </div>
            <div class="row">
            <p class="card-text col-sm-3"><b>{{ __('patents.creator') }}</b></p>
            <p class="card-text col-sm-9">
                @foreach($patent->user as $a)
                    @if(app()->getLocale() == 'zh')
                        {{ $a->fname_zh }} {{ $a->lname_zh }}
                    @elseif(app()->getLocale() == 'en')
                        {{ $a->fname_en }} {{ $a->lname_en }}
                    @else
                        {{ $a->fname_th }} {{ $a->lname_th }}
                    @endif
                    @if (!$loop->last),@endif
                @endforeach
            </p>

            </div>
            <div class="row">
            <p class="card-text col-sm-3"><b>{{ __('patents.creator_joint') }}</b></p>
<p class="card-text col-sm-9">
    @foreach($patent->author as $a)
        @if(app()->getLocale() == 'zh')
            {{ $a->author_fname_zh ?? $a->author_fname }} {{ $a->author_lname_zh ?? $a->author_lname }}
        @elseif(app()->getLocale() == 'en')
            {{ $a->author_fname_en ?? $a->author_fname }} {{ $a->author_lname_en ?? $a->author_lname }}
        @else
            {{ $a->author_fname }} {{ $a->author_lname }}
        @endif
        @if (!$loop->last),@endif
    @endforeach
</p>

            </div>
            
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('patents.index') }}"> {{ __('patents.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection