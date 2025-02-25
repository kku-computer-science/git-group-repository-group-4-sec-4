@extends('layouts.layout')
@section('content')
<div class="container card-3 ">
    <h1>{{ __('message.research_group') }}</h1>
    @foreach ($resg as $rg)
    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="card-body">
                    <img src="{{ asset('img/'.$rg->group_image) }}" alt="...">
                    <h2 class="card-text-1"> {{ __('message.laboratory_supervisor') }} </h2>
                    <h2 class="card-text-1"> {{ __('message.student') }} </h2>


                    <h2 class="card-text-2">
                        @foreach ($rg->user as $r)
                            @if($r->hasRole('teacher'))
                                @php 
                                    // ตรวจสอบว่าอยู่ในโหมดภาษาจีน (zh) หรือไม่
                                    $position = $r->{'position_'.app()->getLocale()} ?? $r->position_en;
                                    $fname = $r->{'fname_'.app()->getLocale()} ?? $r->fname_en;
                                    $lname = $r->{'lname_'.app()->getLocale()} ?? $r->lname_en;
                                    $phdSuffix = ($r->doctoral_degree == 'Ph.D.') ? ', Ph.D.' : '';
                                @endphp
                                
                                {{ $position }} {{ $fname }} {{ $lname }}{{ $phdSuffix }}
                                <br>
                            @endif
                        @endforeach
                    </h2>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                <h5 class="card-title"> {{ $rg->{'group_name_'.app()->getLocale()} }}</h5>
                <h3 class="card-text">{{ Str::limit($rg->{'group_desc_'.app()->getLocale()}, 350) }}</h3>
                </div>
                <div>
                <a href="{{ route('researchgroupdetail', ['id' => $rg->id]) }}" class="btn btn-outline-info">
                {{ trans('message.details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop
