<!DOCTYPE html>
<html>
<head>
    <title>Historical Prices</title>
</head>
<body>
    <h2>Historical Prices - {{ $data['formData']['company_symbol'] }}</h2>
    <p>{{ $data['formData']['start_date'] }} to {{ $data['formData']['end_date'] }}</p>
    
    @if(isset($data['historicalData']))
        <h2>Historical Price Data</h2>
        <table>
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
                @foreach ($data['historicalData']['prices'] as $price)
                    <tr>
                        <td>{{ date('Y-m-d', $price['date']) }}</td>
                        <td>{{ $price['open'] ?? "" }}</td>
                        <td>{{ $price['high'] ?? ""}}</td>
                        <td>{{ $price['low'] ?? "" }}</td>
                        <td>{{ $price['close'] ?? "" }}</td>
                        <td>{{ $price['volume'] ?? "" }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
