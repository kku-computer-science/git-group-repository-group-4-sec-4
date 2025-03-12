@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<style>
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card" style="padding: 16px;">
            <div class="card-body">
            <h4 class="card-title">{{ __('funds.Edit Fund') }}</h4>
            <p class="card-description">{{ __('funds.fill') }}</p>
                <form class="forms-sample" action="{{ route('funds.update',$fund->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('funds.fund_type') }}</b></p>
                        <!-- <label for="exampleInputfund_type" class="col-sm-2 ">ประเภททุนวิจัย</label> -->
                        <div class="col-sm-4">
                            <select name="fund_type" class="custom-select my-select" id="fund_type" onchange='toggleDropdown(this);' required>
                            <option value="internal" {{ $fund->fund_type == 'internal' ? 'selected' : '' }}>
                                    {{ __('funds.internal_capital') }}
                                </option>
                                <option value="external" {{ $fund->fund_type == 'external' ? 'selected' : '' }}>
                                    {{ __('funds.external_capital') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div id="fund_code">
                        <div class="form-group row">
                            <p class="col-sm-3"><b>{{ __('funds.fund_level') }}</b></p>
                            <div class="col-sm-4">
                                <select name="fund_level" class="custom-select my-select">
                                    <option value=""{{ $fund->fund_level == '' ? 'selected' : '' }}>{{ __('funds.not_specified') }}</option>
                                    <option value="สูง" {{ $fund->fund_level == 'สูง' ? 'selected' : '' }}>{{ __('funds.high') }}</option>
                                    <option value="กลาง" {{ $fund->fund_level == 'กลาง' ? 'selected' : '' }}>{{ __('funds.medium') }}</option>
                                    <option value="ล่าง" {{ $fund->fund_level == 'ล่าง' ? 'selected' : '' }}>{{ __('funds.low') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-3 "><b>{{ __('funds.fund_name') }}</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="fund_name" value="{{ $fund->fund_name }}" class="form-control" placeholder="fund_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-3 "><b>{{ __('funds.Support') }}</b></p>
                        <div class="col-sm-8">
                            <input type="text" name="support_resource" value="{{ $fund->support_resource }}" class="form-control" placeholder="Support Resource">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">{{ __('funds.submit') }}</button>
                    <a class="btn btn-light mt-5" href="{{ route('funds.index')}}">{{ __('funds.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    const ac = document.getElementById("fund_code");
    const ab = document.getElementById("fund_type").value;
    //console.log(ab);
    if (ab === "ทุนภายนอก") {
        ac.style.display = "none";
    }

    //ac.style.display = "none";

    function toggleDropdown(selObj) {
        ac.style.display = selObj.value === "ทุนภายใน" ? "block" : "none";
    }
</script>
@endsection