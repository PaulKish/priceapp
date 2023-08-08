@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="table-tab" data-toggle="tab" data-target="#table" type="button" role="tab" aria-controls="table" aria-selected="true">Price Table</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="chart-tab" data-toggle="tab" data-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">Chart</button>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane" id="table" role="tabpanel" aria-labelledby="table-tab">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Historical Price Data - {{ $symbol }}</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Volume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historicalData['prices'] as $price)
                        <tr>
                            <td>{{ date('Y-m-d', $price['date']) }}</td>
                            <td>{{ $price['open'] ?? '' }}</td>
                            <td>{{ $price['high'] ?? '' }}</td>
                            <td>{{ $price['low'] ?? '' }}</td>
                            <td>{{ $price['close'] ?? '' }}</td>
                            <td>{{ $price['volume'] ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane active" id="chart" role="tabpanel" aria-labelledby="chart-tab">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Opening and Closing Price Chart - {{ $symbol }}</h2>
                <div id="priceChart" style="width: 100%; height: 600px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function() {
        @if(isset($historicalData))
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Open Price');
            data.addColumn('number', 'Close Price');

            var rows = @json($historicalData['prices']);
            var chartRows = [];

            for (var i = 0; i < rows.length; i++) {
                chartRows.push([new Date(rows[i]['date'] * 1000), rows[i]['open'], rows[i]['close']]);
            }

            data.addRows(chartRows);

            var options = {
                title: 'Historical Open and Close Prices',
                legend: {
                    position: 'bottom'
                },
                chartArea: {
                    width: '80%',
                    height: '70%'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('priceChart'));
            chart.draw(data, options);
        }
        @endif
    });
</script>
@endsection