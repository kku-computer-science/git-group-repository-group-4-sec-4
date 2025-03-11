@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
@section('title','Dashboard')

@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('patents.oaw') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('patents.create') }}"><i class="mdi mdi-plus btn-icon-prepend"></i> {{ __('patents.add') }} </a>
            <!-- <div class="table-responsive"> -->
                <table id ="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('patents.no') }}</th>
                            <th>{{ __('patents.title') }}</th>
                            <th>{{ __('patents.type') }}</th>
                            <th>{{ __('patents.registration_date') }}</th>
                            <th>{{ __('patents.regis_number') }}</th>
                            <th>{{ __('patents.creator') }}</th>
                            <th width="280px">{{ __('patents.action') }}</th>
                        </tr>
                        <thead>
                        <tbody>
    @foreach ($patents as $i=>$paper)
    <tr>
        <td>{{ $i+1 }}</td>

        {{-- Title แสดงตามภาษา --}}
        <td>
            @if(app()->getLocale() == 'zh') 
                {{ Str::limit($paper->ac_name_zh, 50) }}
            @elseif(app()->getLocale() == 'en')
                {{ Str::limit($paper->ac_name_en, 50) }}
            @else
                {{ Str::limit($paper->ac_name, 50) }}
            @endif
        </td>

        {{-- Type แสดงตามภาษา --}}
        <td>
            @if(app()->getLocale() == 'zh') 
                {{ $paper->ac_type_zh }}
            @elseif(app()->getLocale() == 'en')
                {{ $paper->ac_type_en }}
            @else
                {{ $paper->ac_type }}
            @endif
        </td>

        <td>{{ $paper->ac_year }}</td>
        <td>{{ $paper->ac_refnumber }}</td>

        {{-- Creator แสดงตามภาษา --}}
        <td>
            @foreach($paper->user as $a)
                @if(app()->getLocale() == 'zh') 
                    {{ $a->fname_zh }} {{ $a->lname_zh }}
                @elseif(app()->getLocale() == 'en')
                    {{ $a->fname_en }} {{ $a->lname_en }}
                @else
                    {{ $a->fname_th }} {{ $a->lname_th }}
                @endif
                @if (!$loop->last), @endif
            @endforeach
        </td>

        <td>
            <form action="{{ route('patents.destroy', $paper->id) }}" method="POST">
                <li class="list-inline-item">
                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="view" 
                        href="{{ route('patents.show', $paper->id) }}">
                        <i class="mdi mdi-eye"></i>
                    </a>
                </li>
                
                @if(Auth::user()->can('update', $paper))
                <li class="list-inline-item">
                    <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" 
                        href="{{ route('patents.edit', $paper->id) }}">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                </li>
                @endif

                @if(Auth::user()->can('delete', $paper))
                @csrf
                @method('DELETE')
                <li class="list-inline-item">
                    <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </li>
                @endif
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

                </table>
            <!-- </div> -->
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
<script src = "https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer ></script>
<script src = "https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer ></script>
<script>
    $(document).ready(function() {
    var table = $('#example1').DataTable({
        fixedHeader: true,
        "language": {
            "lengthMenu": "{{ __('patents.show_entries') }}",
            "search": "{{ __('patents.search') }}",
            "info": "{{ __('patents.showing') }}",
            "paginate": {
                "previous": "{{ __('patents.previous') }}",
                "next": "{{ __('patents.next') }}"
            }
        }
    });
});
</script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
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
@stop