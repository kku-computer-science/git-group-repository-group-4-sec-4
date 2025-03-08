@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-10" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchGroups.research_group_details') }}</h4>
            <p class="card-description">{{ __('researchGroups.research_group_details') }}</p>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_name_th') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_th }}</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_name_en') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_en }}</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_name_zh') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_zh ?? $researchGroup->group_name_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_desc_th') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_th }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_desc_en') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_desc_zh') }}</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_zh ?? $researchGroup->group_desc_en }}</p>
            </div>
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_leader') }}</b></p>
                <p class="card-text col-sm-9">
                @foreach($researchGroup->user as $user)
    @if ($user->pivot->role == 1)
        @if(app()->getLocale() == 'th')
            {{$user->position_th}} {{ $user->fname_th }} {{ $user->lname_th }}
        @elseif(app()->getLocale() == 'en')
            {{$user->position_en}} {{ $user->fname_en }} {{ $user->lname_en }}
        @elseif(app()->getLocale() == 'zh')
            {{$user->position_zh}} {{ $user->fname_zh }} {{ $user->lname_zh }}
        @endif
    @endif
@endforeach</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_members') }}</b></p>
                <p class="card-text col-sm-9">
                @foreach($researchGroup->user as $user)
    @if ($user->pivot->role == 2)  {{-- เช็คว่าบุคคลนี้เป็นสมาชิก --}}
        @if(app()->getLocale() == 'th')
            {{$user->position_th}} {{ $user->fname_th }} {{ $user->lname_th }}
        @elseif(app()->getLocale() == 'en')
            {{$user->position_en}} {{ $user->fname_en }} {{ $user->lname_en }}
        @elseif(app()->getLocale() == 'zh')
            {{$user->position_zh}} {{ $user->fname_zh }} {{ $user->lname_zh }}
        @endif
        @if (!$loop->last),@endif
    @endif
@endforeach
</p>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('researchGroups.index') }}">{{ __('researchGroups.back') }}</a>
        </div>
    </div>
    
@stop
@section('javascript')
<script>
$(document).ready(function() {

    /* When click New customer button */
    $('#new-customer').click(function() {
        $('#btn-save').val("create-customer");
        $('#customer').trigger("reset");
        $('#customerCrudModal').html("Add New Customer EiEi");
        $('#crud-modal').modal('show');
    });
    /* When click New customer button */
    $('#new-customer2').click(function() {
        $('#btn-save').val("create-customer");
        $('#customer').trigger("reset");
        $('#customerCrudModal').html("Add New Customer EiEi");
        $('#crud-modal').modal('show');
    });
});
</script>

@stop