@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<style>
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 5px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
    <strong>{{ __('funds.whoops') }}</strong>{{ __('funds.error_mes') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card col-md-12" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchProjects.edit_research_project') }}</h4>
            <p class="card-description">{{ __('researchProjects.fill_information') }}</p>
            <form action="{{ route('researchProjects.update',$researchProject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.name_of_research_project') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="project_name" value="{{ $researchProject->project_name }}" class="form-control" style="height:90px">{{ $researchProject->project_name }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.start_date') }}</b></p>
                    <div class="col-sm-4">
                        <input type="date" name="project_start" value="{{ $researchProject->project_start }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.end_date') }}</b></p>
                    <div class="col-sm-4">
                        <input type="date" name="project_end" value="{{ $researchProject->project_end }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <p for="exampleInputfund_details" class="col-sm-3"><b>{{ __('researchProjects.choose_scholarship') }}</b></p>
                    <div class="col-sm-9">
                    <select id='fund' style='width: 200px;' class="custom-select my-select" name="fund">
    <option value='' disabled selected>{{ __('researchProjects.choose_scholarship') }}</option>
    @foreach($funds as $fund)
        <option value="{{ $fund->id }}" 
            @if($fund->id == old('fund', $researchProject->fund_id)) selected @endif>
            @if(app()->getLocale() == 'th')
                {{ $fund->fund_name }}
            @elseif(app()->getLocale() == 'zh')
                {{ $fund->fund_name_zh ?? $fund->fund_name_en }}
            @else
                {{ $fund->fund_name_en }}
            @endif
        </option>
    @endforeach
</select>


                    </div>
                </div>
                <div class="form-group row mt-2">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.year_submission') }}</b></p>
                    <div class="col-sm-8">
                        <input type="year" name="project_year" class="form-control" placeholder="{{ __('researchProjects.year') }}" value="{{$researchProject->project_year}}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.budget') }}</b></p>
                    <div class="col-sm-4">
                        <input type="number" name="{{ __('researchProjects.baht_unit') }}" value="{{ $researchProject->budget }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-2">
    <p class="col-sm-3"><b>{{ __('researchProjects.responsible_agency') }}</b></p>
    <div class="col-sm-3">
        <select id='dep' style='width: 200px;' class="custom-select my-select" name="responsible_department">
            <option value="">{{ __('researchProjects.Choose_study') }}</option>
            @foreach($deps as $dep)
                <option value="{{ $dep->department_name_th }}"
                    {{ $dep->department_name_th == $researchProject->responsible_department ? 'selected' : '' }}>
                    
                    @if(app()->getLocale() == 'th')
                        {{ $dep->department_name_th }}
                    @elseif(app()->getLocale() == 'zh' && !empty($dep->department_name_zh))
                        {{ $dep->department_name_zh }}
                    @else
                        {{ $dep->department_name_en }} 
                    @endif

                </option>
            @endforeach
        </select>
    </div>
</div>

                
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.project_details') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="note" class="form-control" style="height:90px">{{ $researchProject->note }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchProjects.status') }}</b></p>
                    <div class="col-sm-8">
                        <select id='status' class="custom-select my-select" style='width: 200px;' name="status">
                            <option value="1" {{ 1 == $researchProject->status ? 'selected' : '' }}>{{ __('researchProjects.apply_for') }}</option>
                            <option value="2" {{ 2 == $researchProject->status ? 'selected' : '' }}>{{ __('researchProjects.carry_out') }}</option>
                            <option value="3" {{ 3 == $researchProject->status ? 'selected' : '' }}>{{ __('researchProjects.close_project') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table">
                        <tr>
                            <th>{{ __('researchProjects.person') }}</th>
                        <tr>
                            <td>
                            <select id="head0" style="width: 200px;" name="head">
    @foreach($users as $user)
        <option value="{{ $user->id }}">
            @if(app()->getLocale() == 'th')
                {{ $user->fname_th }} {{ $user->lname_th }} {{-- แสดงชื่อภาษาไทย --}}
            @elseif(app()->getLocale() == 'en')
                {{ $user->fname_en }} {{ $user->lname_en }} {{-- แสดงชื่อภาษาอังกฤษ --}}
            @elseif(app()->getLocale() == 'zh')
                {{ $user->fname_zh }} {{ $user->lname_zh }} {{-- แสดงชื่อภาษาจีน --}}
            @else
                {{ $user->fname_th }} {{ $user->lname_th }} {{-- ค่าเริ่มต้นเป็นภาษาไทย --}}
            @endif
        </option>
    @endforeach
</select>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <table class="table " id="dynamicAddRemove">
                        <tr>
                            <th width="522.98px">{{ __('researchProjects.internal_project') }}</th>
                            <th><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add"><i class="mdi mdi-plus"></i></button></th>
                        </tr>
                    </table>
                </div>
                <div class="form-group row">
                        <label for="exampleInputpaper_author" class="col-sm-3 col-form-label">{{ __('researchProjects.external') }}</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-bordered w-75" id="dynamic_field">

                                    <tr>
                                        <td><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button>
                                        </td>
                                    </tr>

                                </table>
                                <!-- <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" /> -->
                            </div>
                        </div>
                        </div>
                <button type="submit" class="btn btn-primary mt-5">{{ __('researchProjects.submit') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('researchProjects.index') }}"> {{ __('researchProjects.back') }}</a>
            </form>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script>
    $(document).ready(function() {
        
        $("#head0").select2();

        var researchProject = <?php echo $researchProject['user']; ?>;
        var i = 0;

        for (i = 0; i < researchProject.length; i++) {
            var obj = researchProject[i];

            if (obj.pivot.role === 2) {
                $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                    '][userid]"  style="width: 200px;">@foreach($users as $user)<option value="{{ $user->id }}" >{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
                );
                document.getElementById("selUser" + i).value = obj.id;
                $("#selUser" + i).select2();
            }
        }

        $("#add-btn2").click(function() {
    ++i;
    $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
        '][userid]" style="width: 200px;">' +
        '<option value="">{{ __("researchProjects.select_user") }}</option>' +
        '@foreach($users as $user)' +
        '<option value="{{ $user->id }}">' +
        '@if(app()->getLocale() == "th")' +
            '{{ trim($user->fname_th) }} {{ trim($user->lname_th) }}' +
        '@elseif(app()->getLocale() == "zh" && !empty($user->fname_zh) && !empty($user->lname_zh))' +
            '{{ trim($user->fname_zh) }} {{ trim($user->lname_zh) }}' +
        '@else' +
            '{{ trim($user->fname_en) }} {{ trim($user->lname_en) }}' + // fallback to English
        '@endif' +
        '</option>' +
        '@endforeach' +
        '</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">' +
        '<i class="mdi mdi-minus"></i></button></td></tr>'
    );
    $("#selUser" + i).select2();
});


        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

    });
</script>

<script>
    $(document).ready(function() {
        var outsider = <?php echo $researchProject->outsider; ?>;
        var i = 0;

        for (i = 0; i < outsider.length; i++) {
            var obj = outsider[i];
            $("#dynamic_field").append('<tr id="row' + i + '" class="dynamic-added">' +
                '<td>' +
                '<p>{{ __("researchProjects.position_or_title") }} :</p>' +
                '<input type="text" name="title_name[]" value="'+ obj.title_name +'" placeholder="{{ __("researchProjects.position_or_title") }}" style="width: 200px;" class="form-control name_list" /><br>' +
                '<p>{{ __("researchProjects.first_name") }} :</p>' +
                '<input type="text" name="fname[]" value="'+ obj.fname +'" placeholder="{{ __("researchProjects.first_name") }}" style="width: 300px;" class="form-control name_list" /><br>' +
                '<p>{{ __("researchProjects.last_name") }} :</p>' +
                '<input type="text" name="lname[]" value="'+ obj.lname +'" placeholder="{{ __("researchProjects.last_name") }}" style="width: 300px;" class="form-control name_list" />' +
                '</td>' +
                '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td>' +
                '</tr>'
            );
        }

        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added">' +
                '<td>' +
                '<p>{{ __("researchProjects.position_or_title") }} :</p>' +
                '<input type="text" name="title_name[]" placeholder="{{ __("researchProjects.position_or_title") }}" style="width: 200px;" class="form-control name_list" /><br>' +
                '<p>{{ __("researchProjects.first_name") }} :</p>' +
                '<input type="text" name="fname[]" placeholder="{{ __("researchProjects.first_name") }}" style="width: 300px;" class="form-control name_list" /><br>' +
                '<p>{{ __("researchProjects.last_name") }} :</p>' +
                '<input type="text" name="lname[]" placeholder="{{ __("researchProjects.last_name") }}" style="width: 300px;" class="form-control name_list" />' +
                '</td>' +
                '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="mdi mdi-minus"></i></button></td>' +
                '</tr>'
            );
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
</script>
@stop
