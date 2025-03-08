@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('researchGroups.research_group') }}</h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="{{ route('researchGroups.create') }}"><i
                    class="mdi mdi-plus btn-icon-prepend"></i> {{ __('researchGroups.add') }}</a>
            <!-- <div class="table-responsive"> -->
                <table id ="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('researchGroups.no') }}</th>
                            <th>{{ __('researchGroups.group_name') }}</th>
                            <th>{{ __('researchGroups.head') }}</th>
                            <th>{{ __('researchGroups.member') }}</th>
                            <th width="280px">{{ __('researchGroups.action') }}</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($researchGroups as $i=>$researchGroup)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
    @if(app()->getLocale() == 'zh') 
        {{ Str::limit($researchGroup->group_name_zh,50) }}
    @elseif(app()->getLocale() == 'en')
        {{ Str::limit($researchGroup->group_name_en,50) }}
    @else
        {{ Str::limit($researchGroup->group_name_th,50) }}
    @endif
</td>

<td>
    @foreach($researchGroup->user as $user)
    @if ( $user->pivot->role == 1)
        @if(app()->getLocale() == 'zh') 
            {{ $user->fname_zh }} {{ $user->lname_zh }}
        @elseif(app()->getLocale() == 'en')
            {{ $user->fname_en }} {{ $user->lname_en }}
        @else
            {{ $user->fname_th }} {{ $user->lname_th }}
        @endif
    @endif
    @endforeach
</td>

<td>
    @foreach($researchGroup->user as $user)
    @if ( $user->pivot->role == 2)
        @if(app()->getLocale() == 'zh') 
            {{ $user->fname_zh }} {{ $user->lname_zh }}
        @elseif(app()->getLocale() == 'en')
            {{ $user->fname_en }} {{ $user->lname_en }}
        @else
            {{ $user->fname_th }} {{ $user->lname_th }}
        @endif
        @if (!$loop->last),@endif
    @endif
    @endforeach
</td>

                            <td>
                                <form action="{{ route('researchGroups.destroy',$researchGroup->id) }}" method="POST">

                                    <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip"
                                        data-placement="top" title="view"
                                        href="{{ route('researchGroups.show',$researchGroup->id) }}"><i
                                            class="mdi mdi-eye"></i></a>

                                    @if(Auth::user()->can('update',$researchGroup))
                                    <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip"
                                        data-placement="top" title="Edit"
                                        href="{{ route('researchGroups.edit',$researchGroup->id) }}"><i
                                            class="mdi mdi-pencil"></i></a>
                                    @endif

                                    @if(Auth::user()->can('delete',$researchGroup))
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip"
                                        data-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
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
            "lengthMenu": "{{ __('researchGroups.show_entries') }}",
            "search": "{{ __('researchGroups.search') }}",
            "info": "{{ __('researchGroups.showing') }}",
            "paginate": {
                "previous": "{{ __('researchGroups.previous') }}",
                "next": "{{ __('researchGroups.next') }}"
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
                title: "{{ __('researchGroups.Are you sure?') }}",
                text: "{{ __('researchGroups.Delete warning') }}",
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