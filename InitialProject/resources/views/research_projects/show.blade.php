@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchProjects.project_details') }}</h4>
            <p class="card-description">{{ __('researchProjects.project_info') }}</p>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_name') }}</b></p>
                <p class="card-text col-sm-9">
    @if(app()->getLocale() == 'th')
        {{ $researchProject->project_name }}
    @elseif(app()->getLocale() == 'zh')
        {{ $researchProject->project_name_zh ?? $researchProject->project_name_en }}
    @else
        {{ $researchProject->project_name_en }}
    @endif
</p>

            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_start') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($researchProject->project_start)
                        {{ $researchProject->project_start }}
                    @else
            <span class="text-muted">{{ __('researchProjects.no_start_source') }}</span> <!-- ถ้าไม่มีข้อมูล แสดง "No Data" -->
                    @endif
            </p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_end') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($researchProject->project_end)
                        {{ $researchProject->project_end }}
                    @else
            <span class="text-muted">{{ __('researchProjects.no_end_source') }}</span> <!-- ถ้าไม่มีข้อมูล แสดง "No Data" -->
                    @endif
            </p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.fund_source') }}</b></p>
                <p class="card-text col-sm-9">
    @if($researchProject->fund) 
        @if(app()->getLocale() == 'th')
            {{ $researchProject->fund->support_resource }}
        @elseif(app()->getLocale() == 'zh')
            {{ $researchProject->fund->support_resource_zh ?? $researchProject->fund->support_resource_en }}
        @else
            {{ $researchProject->fund->support_resource_en }}
        @endif
    @else
        {{ __('researchProjects.no_funding_source') }} <!-- กรณีไม่มีข้อมูล -->
    @endif
</p>



            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.budget') }}</b></p>
                <p class="card-text col-sm-9">{{ number_format($researchProject->budget) }}</p>
            </div>

            <div class="row">
                <p class="card-text col-sm-3"><b>{{ __('researchProjects.project_description') }}</b></p>
                <p class="card-text col-sm-9">
                    @if($researchProject->project_description)
                        {{ $researchProject->project_description }}
                    @else
            <span class="text-muted">{{ __('researchProjects.no_desc_source') }}</span> <!-- ถ้าไม่มีข้อมูล แสดง "No Data" -->
                    @endif
            </p>
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
    <p class="card-text col-sm-9">
        @php
            $hasMembers = false; // ตัวแปรตรวจสอบว่ามีสมาชิกหรือไม่
        @endphp

        @foreach($researchProject->user as $user)
            @if ($user->pivot->role == 2)
                @php $hasMembers = true; @endphp
                @if(app()->getLocale() == 'en')
                    {{ $user->position_en }} {{ $user->fname_en }} {{ $user->lname_en }}
                @elseif(app()->getLocale() == 'zh')
                    {{ $user->position_zh }} {{ $user->fname_zh ?? $user->fname_en }} {{ $user->lname_zh ?? $user->lname_en }}
                @else
                    {{ $user->position_th }} {{ $user->fname_th }} {{ $user->lname_th }}
                @endif
                @if (!$loop->last), @endif
            @endif
        @endforeach

        @foreach($researchProject->outsider as $user)
            @if ($user->pivot->role == 2)
                @php $hasMembers = true; @endphp
                @if(app()->getLocale() == 'en')
                    {{ $user->title_name }} {{ $user->fname }} {{ $user->lname }}
                @elseif(app()->getLocale() == 'zh')
                    {{ $user->title_name }} {{ $user->fname }} {{ $user->lname }}
                @else
                    {{ $user->title_name }} {{ $user->fname }} {{ $user->lname }}
                @endif
                @if (!$loop->last), @endif
            @endif
        @endforeach

        @if (!$hasMembers)
            <span class="text-muted">{{ __('researchProjects.no_member_source') }}</span>
        @endif
    </p>
</div>



            <div class="pull-right mt-5">
                <a class="btn btn-primary" href="{{ route('researchProjects.index') }}">{{ __('researchProjects.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
