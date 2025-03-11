@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<style type="text/css">
    .dropdown-toggle {
        height: 40px;
        width: 400px !important;
    }
    body label:not(.input-group-text) {
        margin-top: 10px;
    }
    body .my-select {
        background-color: #EFEFEF;
        color: #212529;
        border: 0 none;
        border-radius: 10px;
        padding: 6px 20px;
        width: 100%;
    }
</style>
@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('manageProgram.course') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="javascript:void(0)" id="new-program" data-toggle="modal">
                <i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('manageProgram.add') }}
            </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('manageProgram.id') }}</th>
                        <th>{{ __('manageProgram.name') }}</th>
                        <th>{{ __('manageProgram.degree') }}</th>
                        <th>{{ __('manageProgram.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $i => $program)
                    <tr id="program_id_{{ $program->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>
                            @if(app()->getLocale() == 'th')
                                {{ $program->program_name_th }}
                            @elseif(app()->getLocale() == 'en')
                                {{ $program->program_name_en }}
                            @elseif(app()->getLocale() == 'zh')
                                {{ $program->program_name_zh }}
                            @else
                                {{ $program->program_name_en }}
                            @endif
                        </td>
                        <td>
                            @if(app()->getLocale() == 'th')
                                {{ $program->degree->degree_name_th }}
                            @elseif(app()->getLocale() == 'en')
                                {{ $program->degree->degree_name_en }}
                            @elseif(app()->getLocale() == 'zh')
                                {{ $program->degree->degree_name_zh }}
                            @else
                                {{ $program->degree->degree_name_en }}
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-outline-success btn-sm" id="edit-program" type="button" data-toggle="modal" data-id="{{ $program->id }}" title="{{ __('manageProgram.edit') }}">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <button class="btn btn-outline-danger btn-sm" id="delete-program" type="submit" data-id="{{ $program->id }}" title="{{ __('manageProgram.delete') }}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add and Edit program modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="programCrudModal">{{ __('manageProgram.edit_program') }}</h4>
            </div>
            <div class="modal-body">
                <form id="proForm" name="proForm" action="{{ route('programs.store') }}" method="POST">
                    <input type="hidden" name="pro_id" id="pro_id">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('manageProgram.education_level') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="degree" class="custom-select my-select" name="degree">
                                        @foreach($degree as $d)
                                        <option value="{{ $d->id }}">
                                            @if(app()->getLocale() == 'th')
                                                {{ $d->degree_name_th }}
                                            @elseif(app()->getLocale() == 'en')
                                                {{ $d->degree_name_en }}
                                            @elseif(app()->getLocale() == 'zh')
                                                {{ $d->degree_name_zh }}
                                            @else
                                                {{ $d->degree_name_en }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.major') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="department" class="custom-select my-select" name="department">
                                        @foreach($department as $d)
                                        <option value="{{ $d->id }}">
                                            @if(app()->getLocale() == 'th')
                                                {{ $d->department_name_th }}
                                            @elseif(app()->getLocale() == 'en')
                                                {{ $d->department_name_en }}
                                            @elseif(app()->getLocale() == 'zh')
                                                {{ $d->department_name_zh }}
                                            @else
                                                {{ $d->department_name_en }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.name_thai') }}:</strong>
                                <input type="text" name="program_name_th" id="program_name_th" class="form-control" 
                                       placeholder="{{ __('manageProgram.enter_name_thai') }}" 
                                       value="{{ isset($program) ? $program->program_name_th : '' }}" onkeyup="validate()">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.name_english') }}:</strong>
                                <input type="text" name="program_name_en" id="program_name_en" class="form-control" 
                                       placeholder="{{ __('manageProgram.enter_name_english') }}" 
                                       value="{{ isset($program) ? $program->program_name_en : '' }}" onkeyup="validate()">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.name_chinese') }}:</strong>
                                <input type="text" name="program_name_zh" id="program_name_zh" class="form-control" 
                                       placeholder="{{ __('manageProgram.enter_name_chinese') }}" 
                                       value="{{ isset($program) ? $program->program_name_zh : '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>
                                {{ __('manageProgram.submit') }}
                            </button>
                            <a href="{{ route('programs.index') }}" class="btn btn-danger">{{ __('manageProgram.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        // กำหนด DataTable
        if (!$.fn.DataTable.isDataTable('#example1')) {
            var table1 = $('#example1').DataTable({
                responsive: true,
                language: {
                    search: "{{ __('manageProgram.search') }}",
                    lengthMenu: "{{ __('manageProgram.show') }} _MENU_ {{ __('manageProgram.entries') }}",
                    info: "{{ __('manageProgram.showing') }} _START_ {{ __('manageProgram.to') }} _END_ {{ __('manageProgram.of') }} _TOTAL_ {{ __('manageProgram.entries') }}",
                    paginate: {
                        previous: "{{ __('manageProgram.previous') }}",
                        next: "{{ __('manageProgram.next') }}"
                    }
                }
            });
        }

        // เมื่อกดปุ่ม New Program
        $('#new-program').click(function() {
            $('#btn-save').val("create-program");
            $('form[name="proForm"]').trigger("reset");
            $('#programCrudModal').html("{{ __('manageProgram.add_new_program') }}");
            // เปิดใช้งานปุ่ม (หรือจะใช้ validate() หลังจากมีการพิมพ์ข้อมูล)
            $('#btn-save').prop('disabled', false);
            $('#crud-modal').modal('show');
        });

        // เมื่อกดปุ่ม Edit Program
        $('body').on('click', '#edit-program', function() {
            var program_id = $(this).data('id');
            $.get('programs/' + program_id + '/edit', function(data) {
                $('#programCrudModal').html("{{ __('manageProgram.edit_program') }}");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#pro_id').val(data.id);
                $('#program_name_th').val(data.program_name_th);
                $('#program_name_en').val(data.program_name_en);
                $('#program_name_zh').val(data.program_name_zh);
                $('#degree').val(data.degree_id);
            });
        });

        // เมื่อกดปุ่ม Delete Program
        $('body').on('click', '#delete-program', function(e) {
            var program_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            e.preventDefault();
            swal({
                title: "{{ __('manageProgram.are_you_sure') }}",
                text: "{{ __('manageProgram.delete_warning') }}",
                type: "warning",
                buttons: {
                    cancel: "{{ __('manageProgram.cancel') }}",
                    confirm: "{{ __('manageProgram.ok') }}"
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Delete Successfully", {
                        icon: "success"
                    }).then(function() {
                        location.reload();
                        $.ajax({
                            type: "DELETE",
                            url: "programs/" + program_id,
                            data: {
                                "id": program_id,
                                "_token": token
                            },
                            success: function(data) {
                                $('#msg').html('program entry deleted successfully');
                                $("#program_id_" + program_id).remove();
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    });
                }
            });
        });
    });

    // เรียกใช้งาน validate เมื่อ modal แสดง
    $('#crud-modal').on('shown.bs.modal', function () {
        validate();
    });

    // ฟังก์ชันตรวจสอบค่า input เพื่อเปิดใช้งานปุ่มบันทึก
    function validate() {
        if (document.proForm.program_name_th.value != '' && document.proForm.program_name_en.value != '') {
            document.proForm.btnsave.disabled = false;
        } else {
            document.proForm.btnsave.disabled = true;
        }
    }
</script>
@stop
