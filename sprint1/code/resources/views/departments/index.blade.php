<!-- @php
   if(Auth::user()->hasRole('admin')) {
      $layoutDirectory = 'dashboards.admins.layouts.admin-dash-layout';
   } else {
      $layoutDirectory = 'dashboards.users.layouts.user-dash-layout';
   }
@endphp -->

@extends('dashboards.users.layouts.user-dash-layout')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header">{{ __('department.department') }}
                @can('departments-create')

                <a class="btn btn-primary" href="{{ route('departments.create') }}">{{ __('department.new_department') }}</a>

                @endcan
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('department.name') }}</th>
                            <th width="280px">{{ __('department.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>
    @if(app()->getLocale() == 'th')
        {{ $department->department_name_th }}
    @elseif(app()->getLocale() == 'en')
        {{ $department->department_name_en }}
    @elseif(app()->getLocale() == 'zh')
        {{ $department->department_name_zh }}
    @else
        {{ $department->department_name_en }} {{-- ค่าเริ่มต้นเป็นภาษาอังกฤษ --}}
    @endif
</td>

                            <td>
                                <form action="{{ route('departments.destroy',$department->id) }}" method="POST">
                                    

                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="view" href="{{ route('departments.show',$department->id) }}"><i class="mdi mdi-eye"></i></a>

                                    @can('departments-edit')

                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ route('departments.edit',$department->id) }}"><i class="mdi mdi-pencil"></i></a>

                                    @endcan


                                    @can('departments-delete')
                                    <!-- {!! Form::open(['method' => 'DELETE','route' => ['departments.destroy', $department->id],'style'=>'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit','class' => 'btn btn-danger btn-sm rounded-0','type'=>'button','data-toggle'=>'tooltip' ,'data-placement'=>'top', 'title'=>'Delete']) !!}
                                    {!! Form::close() !!} -->
                                    @csrf
                                    @method('DELETE')

                                    <li class="list-inline-item">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
                                    </li>


                                    @endcan
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
    title: `{{ __('department.confirm_title') }}`,
    text: "{{ __('department.confirm_text') }}",
    icon: "warning",
    buttons: {
        cancel: {
            text: "{{ __('department.cancel') }}",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true,
        },
        confirm: {
            text: "{{ __('department.ok') }}",
            value: true,
            visible: true,
            className: "btn btn-danger",
            closeModal: true
        }
    },
    dangerMode: true,
})

            .then((willDelete) => {
                if (willDelete) {
                    swal("Delete Successfully", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>
@endsection