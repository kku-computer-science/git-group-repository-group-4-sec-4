@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('content')

<!-- <div class="row">
    <div class="col-lg-12" style="text-align: center">
        <div>
            <h2>ความเชี่ยวชาญ</h2>
        </div>
        <br />
    </div>
</div> -->
<!-- <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a href="javascript:void(0)" class="btn btn-success mb-2" id="new-expertise" data-toggle="modal">Add
                Expertise</a>
        </div>
    </div>
</div> -->
<!-- <br />
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p id="msg">{{ $message }}</p>
</div>
@endif -->
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title" style="text-align: center;">{{ __('manageExpertise.teacher_expertise') }}</h4>
            <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('manageExpertise.id') }}</th>
                        @if(Auth::user()->hasRole('admin'))
                        <th>{{ __('manageExpertise.teacher_name') }}</th>
                        @endif
                        <th>{{ __('manageExpertise.name') }}</th>

                        <th>{{ __('manageExpertise.action') }}</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($experts as $i => $expert)
    <tr id="expert_id_{{ $expert->id }}">
        <td>{{ $i+1 }}</td>
        <td>
            @if(app()->getLocale() == 'th')
                {{ $expert->user->fname_th }} {{ $expert->user->lname_th }}
            @elseif(app()->getLocale() == 'en')
                {{ $expert->user->fname_en }} {{ $expert->user->lname_en }}
            @elseif(app()->getLocale() == 'zh')
                {{ $expert->user->fname_zh }} {{ $expert->user->lname_zh }}
            @else
                {{ $expert->user->fname_en }} {{ $expert->user->lname_en }}
            @endif
        </td>
        <td>
    @if(app()->getLocale() == 'th' && !empty($expert->expert_name_th))
        {{ $expert->expert_name_th }}
    @elseif(app()->getLocale() == 'en' && !empty($expert->expert_name))
        {{ $expert->expert_name}}
    @elseif(app()->getLocale() == 'zh' && !empty($expert->expert_name_zh))
        {{ $expert->expert_name_zh }}
    @else
        {{ $expert->expert_name ?? '-' }} {{-- ถ้าไม่มีค่าจะใส่ `-` --}}
    @endif
</td>



<td class="text-center">
    <a class="btn btn-outline-success btn-sm" id="edit-expertise" type="button" 
       data-toggle="modal" data-id="{{ $expert->id }}" data-placement="top" title="Edit">
       <i class="mdi mdi-pencil"></i>
    </a>
    <button class="btn btn-outline-danger btn-sm show_confirm" id="delete-expertise" 
        type="submit" data-id="{{ $expert->id }}" data-toggle="tooltip" 
        data-placement="top" title="Delete">
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
<!-- Add and Edit expertise modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
    <h4 class="modal-title" id="expertiseCrudModal">
        {{ __('manageExpertise.edit_expertise') }}
    </h4>
</div>
<div class="modal-body">
    <form name="expForm" action="{{ route('experts.store') }}" method="POST">
        <input type="hidden" name="exp_id" id="exp_id">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>{{ __('manageExpertise.expertise_name') }}:</strong>
                    <input type="text" name="expert_name" id="expert_name" class="form-control" placeholder="{{ __('manageExpertise.enter_name') }}" onchange="validate()">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary">
                    {{ __('manageExpertise.submit') }}
                </button>
                <a href="{{ route('experts.index') }}" class="btn btn-danger">
                    {{ __('manageExpertise.cancel') }}
                </a>
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
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js" defer></script>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#example1')) { // ตรวจสอบว่า DataTable ถูกใช้งานไปแล้วหรือยัง
            var table1 = $('#example1').DataTable({
                responsive: true,
                language: {
    search: "{{ __('manageExpertise.Search') }}",
    lengthMenu: "{{ __('manageExpertise.Show') }} _MENU_ {{ __('manageExpertise.entries') }}",
    info: "{{ __('manageExpertise.Showing') }} _START_ {{ __('manageExpertise.to') }} _END_ {{ __('manageExpertise.of') }} _TOTAL_ {{ __('manageExpertise.entries') }}",
    paginate: {
        previous: "{{ __('manageExpertise.Previous') }}",
        next: "{{ __('manageExpertise.Next') }}",
    }
}

            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* When click New expertise button */
        $('#new-expertise').click(function() {
            $('#btn-save').val("create-expertise");
            $('#expertise').trigger("reset");
            $('#expertiseCrudModal').html("Add New Expertise");
            $('#crud-modal').modal('show');
        });

        /* Edit expertise */
        $('body').on('click', '#edit-expertise', function() {
    var expert_id = $(this).data('id');
    $.get('experts/' + expert_id + '/edit', function(data) {
        $('#expertiseCrudModal').html("{{ __('manageExpertise.edit_expertise') }}"); 
        $('#btn-update').val("{{ __('manageExpertise.submit') }}");
        $('#btn-save').prop('disabled', false);
        $('#crud-modal').modal('show');
        $('#exp_id').val(data.id);

        // แสดงข้อมูลตามภาษาที่เลือก
        var locale = "{{ app()->getLocale() }}";
        if (locale === "th") {
            $('#expert_name').val(data.expert_name_th);
        } else if (locale === "en") {
            $('#expert_name').val(data.expert_name);
        } else if (locale === "zh") {
            $('#expert_name').val(data.expert_name_zh);
        } else {
            $('#expert_name').val(data.expert_name); // ค่าเริ่มต้นเป็นภาษาอังกฤษ
        }
    });
});




        /* Delete expertise */
        $('body').on('click', '#delete-expertise', function(e) {
    var expert_id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    e.preventDefault();

    // ใช้ข้อความที่แปลภาษาแล้ว
    swal({
        title: "{{ __('manageExpertise.delete_confirm_title') }}",
        text: "{{ __('manageExpertise.delete_confirm_text') }}",
        icon: "warning",
        buttons: {
            cancel: {
                text: "{{ __('manageExpertise.cancel') }}",
                value: null,
                visible: true,
                className: "btn btn-secondary",
                closeModal: true,
            },
            confirm: {
                text: "{{ __('manageExpertise.ok') }}",
                value: true,
                visible: true,
                className: "btn btn-danger",
                closeModal: true
            }
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            swal("{{ __('manageExpertise.deleted') }}", {
                icon: "success",
            }).then(function() {
                location.reload();
                $.ajax({
                    type: "DELETE",
                    url: "experts/" + expert_id,
                    data: {
                        "id": expert_id,
                        "_token": token,
                    },
                    success: function(data) {
                        $('#msg').html("{{ __('manageExpertise.delete_success') }}");
                        $("#expert_id_" + expert_id).remove();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        }
    });
});
$('body').on('click', '.show_confirm', function(e) {
        e.preventDefault(); // ป้องกันไม่ให้ฟอร์มส่งข้อมูลก่อน
        var expert_id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");

        // แสดง Alert การยืนยันลบ
        swal({
            title: "{{ __('manageExpertise.delete_confirm_title') }}",
            text: "{{ __('manageExpertise.delete_confirm_text') }}",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "{{ __('manageExpertise.cancel') }}",
                    value: null,
                    visible: true,
                    className: "btn btn-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: "{{ __('manageExpertise.ok') }}",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // ถ้าผู้ใช้กด OK ให้ส่ง AJAX ไปลบข้อมูล
                $.ajax({
                    type: "DELETE",
                    url: "experts/" + expert_id,
                    data: {
                        "id": expert_id,
                        "_token": token,
                    },
                    success: function(data) {
                        swal("{{ __('manageExpertise.deleted') }}", {
                            icon: "success",
                        }).then(function() {
                            $("#expert_id_" + expert_id).remove(); // ลบแถวที่ถูกลบออกจากตาราง
                        });
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
});

</script>

<script>
    error = false

    function validate() {
        if (document.expForm.expert_name.value != '')
            document.expForm.btnsave.disabled = false
        else
            document.expForm.btnsave.disabled = true
    }
</script>
@stop