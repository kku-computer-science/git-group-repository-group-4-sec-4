@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchProjects.project_details') }}</h4>
            <p class="card-description">{{ __('researchProjects.project_info') }}</p>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_name }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_start') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_start }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_end') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->project_end }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.fund_source') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->fund ? $researchProject->fund->fund_name : __('researchProjects.no_data') }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.budget') }}</b></p>
                <p class="card-text col-sm-9">{{ number_format($researchProject->budget) }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_description') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchProject->note }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_status') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($researchProject->status == 1)
                        {{ __('researchProjects.status_pending') }}
                    @elseif($researchProject->status == 2)
                        {{ __('researchProjects.status_in_progress') }}
                    @else
                        {{ __('researchProjects.status_closed') }}
                    @endif
                </p>
            </div>

            <div class="row">
    <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_leader') }}</b></p>
    @foreach($researchProject->user as $user)
        @if ($user->pivot->role == 1)
            <p class="card-text col-sm-9">
                @if(app()->getLocale() == 'en')
                    {{ $user->position_en }} {{ $user->fname_en }} {{ $user->lname_en }}
                @elseif(app()->getLocale() == 'zh')
                    {{ $user->position_zh }} {{ $user->fname_zh }} {{ $user->lname_zh }}
                @else
                    {{ $user->position_th }} {{ $user->fname_th }} {{ $user->lname_th }}
                @endif
            </p>
        @endif
    @endforeach
</div>


            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_members') }}</b></p>
                @foreach($researchProject->user as $user)
                    @if ($user->pivot->role == 2)
                        <p class="card-text col-sm-9">{{ $user->position_th }} {{ $user->fname_th }} {{ $user->lname_th }}
                        @if (!$loop->last), @endif
                        </p>
                    @endif
                @endforeach

                @foreach($researchProject->outsider as $user)
                    @if ($user->pivot->role == 2)
                        ,{{ $user->title_name }} {{ $user->fname }} {{ $user->lname }}
                        @if (!$loop->last), @endif
                    @endif
                @endforeach
            </div>

            <div class="pull-right mt-5">
                <a class="btn btn-primary" href="{{ route('researchProjects.index') }}">{{ __('researchProjects.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
