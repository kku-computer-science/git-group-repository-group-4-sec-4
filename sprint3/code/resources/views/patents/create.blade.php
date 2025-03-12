@extends('dashboards.users.layouts.user-dash-layout')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@section('content')
<style type="text/css">
    .dropdown-toggle {
        height: 40px;
        width: 400px !important;
    }

    body label:not(.input-group-text) {
        margin-top: 10px;
    }

    body .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 6px 20px;
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
                <h4 class="card-title">{{ __('patents.Add_works') }}</h4>
                <p class="card-description">{{ __('patents.fill') }}</p>
                <form class="forms-sample" action="{{ route('patents.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="exampleInputac_name" class="col-sm-3">{{ __('patents.name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="ac_name" class="form-control" placeholder="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_type" class="col-sm-3 ">{{ __('patents.type') }}</label>
                        <div class="col-sm-4">
                        <select id="category" class="custom-select my-select" name="ac_type">
    <option value="" disabled selected>{{ __('patents.select_type') }}</option>
    <optgroup label="{{ __('patents.patent') }}">
        <option value="patent">{{ __('patents.patent') }}</option>
        <option value="patent_invention">{{ __('patents.patent_invention') }}</option>
        <option value="patent_design">{{ __('patents.patent_design') }}</option>
    </optgroup>
    <optgroup label="{{ __('patents.pettypatent') }}">
        <option value="pettypatent">{{ __('patents.pettypatent') }}</option>
    </optgroup>
    <optgroup label="{{ __('patents.copyright') }}">
        <option value="copyright">{{ __('patents.copyright') }}</option>
        <option value="copyright_literature">{{ __('patents.copyright_literature') }}</option>
        <option value="copyright_music">{{ __('patents.copyright_music') }}</option>
        <option value="copyright_movie">{{ __('patents.copyright_movie') }}</option>
        <option value="copyright_art">{{ __('patents.copyright_art') }}</option>
        <option value="copyright_broadcast">{{ __('patents.copyright_broadcast') }}</option>
        <option value="copyright_audio">{{ __('patents.copyright_audio') }}</option>
        <option value="copyright_other">{{ __('patents.copyright_other') }}</option>
    </optgroup>
    <optgroup label="{{ __('patents.other') }}">
        <option value="tradesecret">{{ __('patents.tradesecret') }}</option>
        <option value="trademark">{{ __('patents.trademark') }}</option>
    </optgroup>
</select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_year" class="col-sm-3 ">{{ __('patents.date') }}</label>
                        <div class="col-sm-4">
                            <input type="date" name="ac_year" class="form-control" placeholder="ac_year">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputac_refnumber" class="col-sm-3 ">{{ __('patents.registration_number') }}</label>
                        <div class="col-sm-4">
                            <input type="text" name="ac_refnumber" class="form-control" placeholder="{{ __('patents.registration_number') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputac_doi" class="col-sm-3 ">{{ __('patents.professor_field') }}</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-hover small-text" id="dynamicAddRemove">
                                    <tr>
                                        <td><select id="selUser0" style="width: 200px;" name="moreFields[0][userid]" class="form-control select2">
    <option value="">{{ __('patents.select_user') }}</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}">
            @php $locale = app()->getLocale(); @endphp
            @if($locale == 'zh')
                {{ $user->fname_zh ?? $user->fname_en }} {{ $user->lname_zh ?? $user->lname_en }}
            @elseif($locale == 'en')
                {{ $user->fname_en }} {{ $user->lname_en }}
            @else
                {{ $user->fname_th }} {{ $user->lname_th }}
            @endif
        </option>
    @endforeach
</select>



                                        </td>
                                        <td><button type="button" name="add" id="add-btn2" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <!-- <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />-->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="exampleInput" class="col-sm-3 ">บุคลลภายนอก</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamic_field">
                                    <tr>
                                        <td><input type="text" name="fname[]" placeholder="Enter Author FName" class="form-control name_list" /></td>
                                        <td><input type="text" name="lname[]" placeholder="Enter Author LName" class="form-control name_list" /></td>
                                        <td><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <!-- <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group row ">
                        <label for="exampleInputpaper_doi" class="col-sm-3 ">{{ __('patents.outsiders') }}</label>
                        <div class="col-sm-9">
                            <div class="table-responsive">
                                <table class="table table-hover small-text" id="tb">
                                    <tr class="tr-header">
                                        
                                        <th>{{ __('patents.fname') }}</th>
                                        <th>{{ __('patents.lname') }}</th>
                                        <!-- <th>Email Id</th> -->
                                            <!-- <button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i></button> -->
                                        <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore2" title="Add More Person"><i class="mdi mdi-plus"></i></span></a></th>
                                    <tr>
                                        <!--  -->
                                        <td><input type="text" name="fname[]" class="form-control" placeholder="{{ __('patents.fname') }}" ></td>
                                        <td><input type="text" name="lname[]" class="form-control" placeholder="{{ __('patents.lname') }}" ></td>
                                        <!-- <td><input type="text" name="emailid[]" class="form-control"></td> -->
                                        <td><a href='javascript:void(0);' class='remove'><span><i class="mdi mdi-minus"></span></a></td>
                                    </tr>
                                </table>
                                <!-- <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" /> -->
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" id="submit" class="btn btn-primary me-2">{{ __('patents.submit') }}</button>
                    <a class="btn btn-light" href="{{ route('patents.index')}}">{{ __('patents.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $(".select2").select2({
        width: '100%',  // ทำให้ dropdown กว้างเต็มพื้นที่ div
        dropdownAutoWidth: true,
        minimumResultsForSearch: 10 // ซ่อนช่องค้นหา ถ้ามีน้อยกว่า 10 รายการ
    });

    // เมื่อกดปุ่มเพิ่ม (+) ให้เพิ่ม dropdown ที่มีขนาดสมดุล
    $("#add-btn2").click(function() {
        var i = $("#dynamicAddRemove").find("tr").length; // นับจำนวน dropdown ที่มีอยู่

        var newRow = `<tr>
            <td>
                <select id="selUser${i}" name="moreFields[${i}][userid]" class="form-control select2" style="width: 100%;">
                    <option value="">{{ __('patents.select_user') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            @if(app()->getLocale() == 'zh') 
                                {{ $user->fname_zh ?? $user->fname_en }} {{ $user->lname_zh ?? $user->lname_en }}
                            @elseif(app()->getLocale() == 'en')
                                {{ $user->fname_en }} {{ $user->lname_en }}
                            @else
                                {{ $user->fname_th }} {{ $user->lname_th }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-tr">X</button>
            </td>
        </tr>`;

        $("#dynamicAddRemove").append(newRow);
        $("#selUser" + i).select2({ width: '100%' }); // ใช้ Select2 กับ dropdown ที่เพิ่มใหม่
    });

    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
});


</script>
@endsection
