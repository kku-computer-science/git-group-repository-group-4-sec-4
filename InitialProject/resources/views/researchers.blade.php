@extends('layouts.layout')
@section('content')
<div class="container card-2">
    <p class="title">{{ trans('research.title') }}</p>
    @foreach($request as $res)
    <span>
        @if(app()->getLocale() == 'th')
        <ion-icon name="caret-forward-outline" size="small"></ion-icon> {{$res->program_name_th}}
        @elseif(app()->getLocale() == 'en')
        <ion-icon name="caret-forward-outline" size="small"></ion-icon> {{$res->program_name_en}}
        @elseif(app()->getLocale() == 'zh')
        <ion-icon name="caret-forward-outline" size="small"></ion-icon> {{$res->program_name_zh}}
        @endif
    </span>

    <div class="d-flex">
        <div class="ml-auto">
            <form class="row row-cols-lg-auto g-3" method="GET" action="{{ route('searchresearchers',['id'=>$res->id])}}">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="textsearch" placeholder={{  trans('research.search')  }}>
                    </div>
                </div>
                <!-- <div class="col-12">
                        <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
                        <select class="form-select" id="inlineFormSelectPref">
                            <option selected> Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div> -->
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary">{{ trans('research.search') }}</button>
                </div>
            </form>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-2 g-0">
        @foreach($users as $r)
        <a href=" {{ route('detail',Crypt::encrypt($r->id))}}">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-sm-4">
                        <img class="card-image" src="{{ $r->picture}}" alt="">
                    </div>
                    <div class="col-sm-8 overflow-hidden" style="text-overflow: clip; @if(app()->getLocale() == 'en') max-height: 220px; @else max-height: 210px;@endif">
                        <div class="card-body">

                            @if(app()->getLocale() == 'en')
                            @if($r->doctoral_degree == 'Ph.D.')
                            <h5 class="card-title">{{ $r->{'academic_ranks_en'} }} {{ $r->{'fname_en'} }} {{ $r->{'lname_en'} }}, {{$r->doctoral_degree}}</h5>
                            @else
                            <h5 class="card-title">{{ $r->{'academic_ranks_en'} }} {{ $r->{'fname_en'} }} {{ $r->{'lname_en'} }}</h5>
                            @endif

                            @elseif(app()->getLocale() == 'zh')
                            @if($r->doctoral_degree == 'Ph.D.')
                            <h5 class="card-title">{{ $r->{'academic_ranks_zh'} }} {{ $r->{'fname_en'} }} {{ $r->{'lname_en'} }}, {{$r->doctoral_degree}}</h5>
                            @else
                            <h5 class="card-title">{{ $r->{'academic_ranks_zh'} }} {{ $r->{'fname_en'} }} {{ $r->{'lname_en'} }}</h5>
                            @endif
                            
                            @else
                            <h5 class="card-title">{{ $r->{'position_' . app()->getLocale()} }} {{ $r->{'fname_' . app()->getLocale()} }} {{ $r->{'lname_' . app()->getLocale()} }}</h5>
                            @endif

                            <p class="card-text-1">{{ trans('message.expertise') }}</p>
                            <div class="card-expertise">
                                @foreach($r->expertise->sortBy('expert_name') as $exper)
                                <p class="card-text">
                                    @if(app()->getLocale() == 'zh')
                                    {{$exper->expert_name_zh}}
                                    @elseif(app()->getLocale() == 'th')
                                    {{$exper->expert_name_th}}
                                    @elseif(app()->getLocale() == 'en')
                                    {{$exper->expert_name}}
                                    @endif
                                </p>
                                @endforeach
                            </div>

                        </div>

                    </diV>
                </div>
            </div>
        </a>
        @endforeach
        @endforeach
    </div>
</div>

@stop