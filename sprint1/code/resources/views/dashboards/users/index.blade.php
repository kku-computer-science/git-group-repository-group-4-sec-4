@extends('dashboards.users.layouts.user-dash-layout')
@section('title','Dashboard')

@section('content')

<h3 style="padding-top: 10px;" id="title-dashboard-admin">{{ __('dashboard.text1') }}</h3>
<br>
<h4>{{ __('dashboard.hello') }}
                @if(app()->getLocale() == 'zh')
                    @if(Auth::user()->fname_zh == null)
                        {{ Auth::user()->position_en }} {{ Auth::user()->fname_en }} {{ Auth::user()->lname_en }}
                    @else
                        {{ Auth::user()->position_zh }} {{ Auth::user()->fname_zh }} {{ Auth::user()->lname_zh }}
                    @endif
                @elseif(app()->getLocale() == 'th')
                        {{ Auth::user()->position_th }} {{ Auth::user()->fname_th }} {{ Auth::user()->lname_th }}
                @else
                        {{ Auth::user()->position_en }} {{ Auth::user()->fname_en }} {{ Auth::user()->lname_en }}
                @endif
</h2>

@endsection
