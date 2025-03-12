@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('researchGroups.whoops') }}</strong> {{ __('researchGroups.input_problem') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchGroups.create_group') }}</h4>
            <p class="card-description">{{ __('researchGroups.enter_details') }}</p>
            <form action="{{ route('researchGroups.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_name_th') }}</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_th" value="{{ old('group_name_th') }}" class="form-control" placeholder="{{ __('researchGroups.group_name_th') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_name_en') }}</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_en" value="{{ old('group_name_en') }}" class="form-control" placeholder="{{ __('researchGroups.group_name_en') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_desc_th') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_th" class="form-control" style="height:90px">{{ old('group_desc_th') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_desc_en') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_en" class="form-control" style="height:90px">{{ old('group_desc_en') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_detail_th') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_th" class="form-control" style="height:90px">{{ old('group_detail_th') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_detail_en') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_en" class="form-control" style="height:90px">{{ old('group_detail_en') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.image') }}</b></p>
                    <div class="col-sm-8">
                        <input type="file" name="group_image" class="form-control" value="{{ old('group_image') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.group_head') }}</b></p>
                    <div class="col-sm-8">
                    <select id='head0' name="head">
    <option value="">{{ __('researchGroups.select_user') }}</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}">
            @if(app()->getLocale() == 'th')
                {{ $user->fname_th }} {{ $user->lname_th }}
            @elseif(app()->getLocale() == 'zh')
                {{ $user->fname_zh ?? $user->fname_en }} {{ $user->lname_zh ?? $user->lname_en }}
            @else
                {{ $user->fname_en }} {{ $user->lname_en }}
            @endif
        </option>
    @endforeach
</select>

                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 pt-4"><b>{{ __('researchGroups.group_members') }}</b></p>
                    <div class="col-sm-8">
                        <table class="table" id="dynamicAddRemove">
                            <tr>
                                <th>
                                    <button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary upload mt-5">{{ __('researchGroups.submit') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('researchGroups.index') }}">{{ __('researchGroups.back') }}</a>
            </form>
        </div>
    </div>
</div>
@section('javascript')
<script>
    $(document).ready(function () {
        var i = 0; // ตัวนับจำนวนแถวที่เพิ่ม
        var selectUserText = @json(__('researchGroups.select_user'));

        $("#add-btn2").click(function () {
            i++;

            var newRow = `
                <tr id="row${i}">
                    <td>
                        <select id="selUser${i}" name="members[${i}][userid]" class="form-control select2">
                            <option value="">${selectUserText}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    @if(app()->getLocale() == 'th')
                                        {{ $user->fname_th }} {{ $user->lname_th }}
                                    @elseif(app()->getLocale() == 'zh')
                                        {{ $user->fname_zh ?? $user->fname_en }} {{ $user->lname_zh ?? $user->lname_en }}
                                    @else
                                        {{ $user->fname_en }} {{ $user->lname_en }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-tr">
                            <i class="mdi mdi-minus"></i>
                        </button>
                    </td>
                </tr>`;

            $("#dynamicAddRemove").append(newRow);
            $("#selUser" + i).select2();
        });

        // ปุ่มลบสมาชิก
        $(document).on("click", ".remove-tr", function () {
            $(this).closest("tr").remove();
        });

        // ทำให้ select2 ทำงานกับ dropdown ที่โหลดมาพร้อมหน้า
        $(".select2").select2();
    });
</script>
@endsection
@stop