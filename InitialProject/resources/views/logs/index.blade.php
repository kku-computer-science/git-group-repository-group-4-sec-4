@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <main class="col-md-9">
            

            <!-- Search Box -->
            <div class="d-flex mb-3">
                <input type="text" class="form-control me-2" id="search" placeholder="{{ trans('dashboard.search') }}">
                <input type="text" class="form-control me-2" id="userId" placeholder="{{ trans('dashboard.user_id') }}">
                <input type="date" class="form-control me-2" id="date">
                <button class="btn btn-primary">{{ trans('system_log.search') }}</button>
            </div>

            <!-- Log Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                    <tr>
                            <th>{{ trans('system_log.date') }}</th>
                            <th>{{ trans('system_log.time') }}</th>
                            <th>{{ trans('system_log.user') }}</th>
                            <th>{{ trans('system_log.event') }}</th>
                            <th>{{ trans('system_log.type') }}</th>
                            <th>{{ trans('system_log.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log['date'] }}</td>
                            <td>{{ $log['time'] }}</td>
                            <td>{{ $log['user'] ?? 'Guest' }}</td>
                            <td>{{ $log['event'] }}</td>
                            <td>{{ $log['type'] }}</td>
                            <td>{{ $log['description'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No logs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let logElement = document.getElementById('logChart');
    if (logElement) {
        let logData = logElement.dataset.logs ? JSON.parse(logElement.dataset.logs) : [];

        if (logData.length > 0) {
            let dates = logData.map(log => log.date);
            let counts = logData.map(log => log.count);

            let ctx = logElement.getContext('2d');
            let logChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: "{{ trans('dashboard.log_events') }}",
                        data: counts,
                        borderColor: 'blue',
                        fill: false
                    }]
                }
            });
        } else {
            logElement.remove();
        }
    }
});
</script>