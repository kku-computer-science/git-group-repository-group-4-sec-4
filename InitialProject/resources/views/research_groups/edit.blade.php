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
            <h4 class="card-title">{{ __('researchGroups.iedit_research_group') }}</h4>
            <p class="card-description">{{ __('researchGroups.fill_research_group_details') }}</p>
            <form action="{{ route('researchGroups.update',$researchGroup->id) }}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchGroups.research_group_name_th') }}</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_th" value="{{ $researchGroup->group_name_th }}" class="form-control"
                            placeholder="ชื่อกลุ่มวิจัย (ภาษาไทย)">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 "><b>{{ __('researchGroups.research_group_name_en') }}</b></p>
                    <div class="col-sm-8">
                        <input name="group_name_en" value="{{ $researchGroup->group_name_en }}" class="form-control"
                            placeholder="ชื่อกลุ่มวิจัย (English)">
                    </div>
                </div>
                <div class="row mt-2">
                    <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_name_zh') }}</b></p>
                    <div class="col-sm-8">
                        <input type="text" name="group_name_zh" value="{{ $researchGroup->group_name_zh }}" class="form-control">
                    </div>
                </div>
                <div class="row mt-2 mb-3">
                    <p class="col-sm-3"><b>{{ __('researchGroups.research_group_desc_th') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_th" value="{{ $researchGroup->group_desc_th }}" class="form-control"
                            style="height:80px">{{ $researchGroup->group_desc_th }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.research_group_desc_en') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_en" value="{{ $researchGroup->group_desc_en }}" class="form-control"
                            style="height:90px">{{ $researchGroup->group_desc_en }}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_desc_zh') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_desc_zh" class="form-control" style="height:90px">{{ $researchGroup->group_desc_zh }}</textarea>
                    </div>
                </div>
                <div class="row mt-2 mb-3">
                    <p class="col-sm-3"><b>{{ __('researchGroups.research_group_detail_th') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_th" value="{{ $researchGroup->group_detail_th }}" class="form-control"
                            style="height:90px">{{ $researchGroup->group_detail_th }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.research_group_detail_en') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_en" value="{{ $researchGroup->group_detail_en }}" class="form-control"
                            style="height:90px">{{ $researchGroup->group_detail_en }}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_detail_zh') }}</b></p>
                    <div class="col-sm-8">
                        <textarea name="group_detail_zh" class="form-control" style="height:90px">{{ $researchGroup->group_detail_zh }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3"><b>{{ __('researchGroups.image') }}</b></p>
                    <div class="col-sm-8">
                        <input type="file" name="group_image" class="form-control" >
                    </div>
                </div>
                <div class="row mt-3">
    <p class="card-text col-sm-3"><b>{{ __('researchGroups.research_group_leader') }}</b></p>
    <div class="col-sm-9">
        <select id="leader" name="leader" class="form-control">
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    @if($user->id == $researchGroup->leader_id) selected @endif>
                    @if(app()->getLocale() == 'zh') 
                        {{ $user->position_zh }} {{ $user->fname_zh }} {{ $user->lname_zh }}
                    @elseif(app()->getLocale() == 'en')
                        {{ $user->position_en }} {{ $user->fname_en }} {{ $user->lname_en }}
                    @else
                        {{ $user->position_th }} {{ $user->fname_th }} {{ $user->lname_th }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>
</div>

                <div class="form-group row">
                    <p class="col-sm-3 pt-4"><b>{{ __('researchGroups.research_group_members') }}</b></p>
                    <div class="col-sm-8">
                        <table class="table" id="dynamicAddRemove">
                            <tr>
                                <th><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm add"><i
                                            class="mdi mdi-plus"></i></button></th>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-5">{{ __('researchGroups.submit') }}</button>
                <a class="btn btn-light mt-5" href="{{ route('researchGroups.index') }}"> {{ __('researchGroups.back') }}</a>
            </form>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script>
$(document).ready(function() {
    $("#head0").select2()
    $("#fund").select2()


    var researchGroup = <?php echo $researchGroup['user']; ?>;
    var i = 0;

    for (i = 0; i < researchGroup.length; i++) {
        var obj = researchGroup[i];

        if (obj.pivot.role === 2) {
            $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
                '][userid]"  style="width: 200px;">@foreach($users as $user)<option value="{{ $user->id }}" >{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
            );
            document.getElementById("selUser" + i).value = obj.id;
            $("#selUser" + i).select2()

        }
        //document.getElementById("#dynamicAddRemove").value = "10";
    }
    $("#add-btn2").click(function() {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select id="selUser' + i + '" name="moreFields[' + i +
            '][userid]"  style="width: 200px;"><option value="">Select User</option>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->fname_th }} {{ $user->lname_th }}</option>@endforeach</select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="mdi mdi-minus"></i></button></td></tr>'
        );
        $("#selUser" + i).select2()

    });
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });

});
</script>
@stop