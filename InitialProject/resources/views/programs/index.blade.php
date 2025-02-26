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
            <h4 class="card-title" ">{{ __('manageProgram.course') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="javascript:void(0)" id="new-program" data-toggle="modal"><i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('manageProgram.add') }} </a>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('manageProgram.id') }}</th>
                        <th>{{ __('manageProgram.name_thai') }}</th>
                        <!-- <th>Name (Eng)</th> -->
                        <th>{{ __('manageProgram.degree') }}</th>
                        <th>{{ __('manageProgram.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $i => $program)
                    <tr id="program_id_{{ $program->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $program->program_name_th }}</td>
                        <!-- <td>{{ $program->program_name_en }}</td> -->
                        <td>{{ $program->degree->degree_name_en}}</td>
                        <td>
                            <form action="{{ route('programs.destroy',$program->id) }}" method="POST">
                                <!-- <a class="btn btn-info" id="show-program" data-toggle="modal" data-id="{{ $program->id }}">Show</a> -->

                                <!-- <a class="btn btn-outline-primary btn-sm" id="show-program" type="button" data-toggle="modal" data-placement="top" title="view" data-id="{{ $program->id }}"><i class="mdi mdi-eye"></i></a>
                                     -->
                                <!-- <a href="javascript:void(0)" class="btn btn-success" id="edit-program" data-toggle="modal" data-id="{{ $program->id }}">Edit </a> -->
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-success btn-sm" id="edit-program" type="button" data-toggle="modal" data-id="{{ $program->id }}" data-placement="top" title="Edit" href="javascript:void(0)"><i class="mdi mdi-pencil"></i></a>
                                </li>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <li class="list-inline-item">
                                    <button class="btn btn-outline-danger btn-sm " id="delete-program" type="submit" data-id="{{ $program->id }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
                                </li>
                            </form>
                            <!-- <a id="delete-program" data-id="{{ $program->id }}" class="btn btn-danger delete-user">Delete</a> -->

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
                <h4 class="modal-title" id="programCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="proForm" action="{{ route('programs.store') }}" method="POST">
                    <input type="hidden" name="pro_id" id="pro_id">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('manageProgram.education_level') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="degree" class="custom-select my-select" name="degree">
                                        @foreach($degree as $d)
                                        <option value="{{$d->id}}">{{$d->degree_name_th}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.major') }}:</strong>
                                <div class="col-sm-8">
                                    <select id="department" class="custom-select my-select" name="department">
                                        @foreach($department as $d)
                                        <option value="{{$d->id}}">{{$d->department_name_th}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.name_thai') }}:</strong>
                                <input type="text" name="program_name_th" id="program_name_th" class="form-control" placeholder="{{ __('manageProgram.enter_name_thai') }}" onchange="validate()">
                            </div>
                            <div class="form-group">
                                <strong>{{ __('manageProgram.name_english') }}:</strong>
                                <input type="text" name="program_name_en" id="program_name_en" class="form-control" placeholder="{{ __('manageProgram.enter_name_english') }}" onchange="validate()">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>{{ __('manageProgram.submit') }}</button>
                            <a href="{{ route('programs.index') }}" class="btn btn-danger">{{ __('manageProgram.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#example1')) { // ตรวจสอบว่า DataTable ถูกใช้งานไปแล้วหรือยัง
            var table1 = $('#example1').DataTable({
                responsive: true,
                language: {
                    search: "{{ __('reseracher.Search') }}",
                    lengthMenu: "{{ __('reseracher.Show') }} _MENU_ {{ __('reseracher.entries') }}",
                    info: "{{ __('reseracher.Showing') }} _START_ {{ __('reseracher.to') }} _END_ {{ __('reseracher.of') }} _TOTAL_ {{ __('reseracher.entries') }}",
                    paginate: {
                        previous: "{{ __('reseracher.Previous') }}",
                        next: "{{ __('reseracher.Next') }}",
                    }
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {

        /* When click New program button */
        $('#new-program').click(function() {
            $('#btn-save').val("create-program");
            $('#program').trigger("reset");
            $('#programCrudModal').html("Add New program");
            $('#crud-modal').modal('show');
        });

        /* Edit program */
        $('body').on('click', '#edit-program', function() {
            var program_id = $(this).data('id');
            $.get('programs/' + program_id + '/edit', function(data) {
                $('#programCrudModal').html("Edit program");
                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#pro_id').val(data.id);
                $('#program_name_th').val(data.program_name_th);
                $('#program_name_en').val(data.program_name_en);
                //$('#degree').val(data.program_name_en);
                $('#degree').val(data.degree_id);
            })
        });


        /* Delete program */
        $('body').on('click', '#delete-program', function(e) {
            var program_id = $(this).data("id");

            var token = $("meta[name='csrf-token']").attr("content");
            e.preventDefault();
            //confirm("Are You sure want to delete !");
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Delete Successfully", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        $.ajax({
                            type: "DELETE",
                            url: "programs/" + program_id,
                            data: {
                                "id": program_id,
                                "_token": token,
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
</script>
<script>
    error = false

    function validate() {
        if (document.proForm.program_name_th.value != '' && document.proForm.program_name_en.value != '')
            document.proForm.btnsave.disabled = false
        else
            document.proForm.btnsave.disabled = true
    }
</script>
@stop