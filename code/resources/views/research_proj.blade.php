@extends('layouts.layout')
@section('content')

<div class="container refund">
    <p>{{ trans('researchPJ.title') }}</p>

    <div class="table-refund table-responsive">
        <table id="example1" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="font-weight: bold;">{{ trans('researchPJ.no') }}</th>
                    <th class="col-md-1" style="font-weight: bold;">{{ trans('researchPJ.year') }}</th>
                    <th class="col-md-4" style="font-weight: bold;">{{ trans('researchPJ.projectName') }} </th> 
                    <!-- <th>ระยะเวลาโครงการ</th>
                    <th>ผู้รับผิดชอบโครงการ</th>
                    <th>ประเภททุนวิจัย</th>
                    <th>หน่วยงานที่สนันสนุนทุน</th>
                    <th>งบประมาณที่ได้รับจัดสรร</th> -->
                    <th class="col-md-4" style="font-weight: bold;">{{ trans('researchPJ.detail') }}</th>
                    <th class="col-md-2" style="font-weight: bold;">{{ trans('researchPJ.responsible') }}</th>
                    <!-- <th class="col-md-5">หน่วยงานที่รับผิดชอบ</th> -->
                    <th class="col-md-1" style="font-weight: bold;">{{ trans('researchPJ.status') }}</th>
                </tr>
            </thead>


            <tbody>
                @foreach($resp as $i => $re)
                <tr>
                <td style="vertical-align: top;text-align: left;">{{$i+1}}</td>
                    <td style="vertical-align: top;text-align: left;">
                        {{ app()->getLocale() == 'th' ? $re->project_year + 543 : $re->project_year }}
                    </td>
                    <td style="vertical-align: top;text-align: left;">
                        {{ $re->{'project_name_'.app()->getLocale()} ?? $re->project_name }}
                    </td>
                    <td>
                        <div style="padding-bottom: 10px">
                            <span style="font-weight: bold;">{{ __('reseracher.Project_Duration') }}</span>
                            <span style="padding-left: 10px;">
                                @if ($re->project_start != null)
                                    {{\Carbon\Carbon::parse($re->project_start)->translatedFormat('j F Y') }} 
                                    {{ __('reseracher.To') }} 
                                    {{\Carbon\Carbon::parse($re->project_end)->translatedFormat('j F Y') }}
                                @endif
                            </span>
                        </div>

                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ __('reseracher.Funding_Type') }}</span>
                            <span style="padding-left: 10px;">{{ $re->fund->{'fund_type_' . (app()->getLocale() == 'zh' ? 'cn' : app()->getLocale())} ?? $re->fund->fund_type }}</span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ __('reseracher.Support_Agency') }}</span>
                            <span style="padding-left: 10px;">{{ $re->fund->{'support_resource_' . (app()->getLocale() == 'zh' ? 'cn' : app()->getLocale())} ?? $re->fund->support_resource }}</span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ __('reseracher.Responsible_Department') }}</span>
                            <span style="padding-left: 10px;">
                                {{ $re->{'responsible_department_' . (app()->getLocale() == 'zh' ? 'cn' : app()->getLocale())} ?? $re->responsible_department_en }}
                            </span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ __('reseracher.Budget_Allocated') }}</span>
                            <span style="padding-left: 10px;">{{ number_format($re->budget) }} {{ __('researcher.Currency') }}


                            </span>
                        </div>
                    </td>

                    <td style="vertical-align: top;text-align: left;">
                        <div style="padding-bottom: 10px;">
                            <span>@foreach($re->user as $user)

                                    @if(app()->getLocale() == 'en')
                                        {{$user->position_en }} {{$user->fname_en}} {{$user->lname_en}}<br>
                                    @elseif(app()->getLocale() == 'th')
                                        @if($user->fname_th == NULL)
                                        {{$user->position_en }} {{$user->fname_en}} {{$user->lname_en}}<br>
                                        @else
                                        {{$user->position_th }} {{$user->fname_th}} {{$user->lname_th}}<br>
                                        @endif
                                    @elseif(app()->getLocale() == 'zh')
                                        @if($user->fname_zh == NULL)
                                        {{$user->position_en }} {{$user->fname_en}} {{$user->lname_en}}<br>
                                        @else
                                        {{$user->position_zh }} {{$user->fname_zh}} {{$user->lname_zh}}<br>
                                        @endif
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    </td>

                    @if($re->status == 1)
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge badge-success">{{ trans('researchPJ.apply') }}</label></h6>
                    </td>
                    @elseif($re->status == 2)
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge bg-warning text-dark">{{ trans('researchPJ.carryOut') }}</label></h6>
                    </td>
                    @else
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge bg-dark">{{ trans('researchPJ.close') }}</label></h6>
                    </td>

                    @endif
                    <!-- <td></td>
                    <td></td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>
    $(document).ready(function() {

        var table1 = $('#example1').DataTable({
            responsive: true,
        });
    });
</script>
@stop