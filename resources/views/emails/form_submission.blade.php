<!DOCTYPE html>
<html>
<head>
    <title>Historical Prices</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
    <h2>Historical Prices - {{ $data['formData']['company_symbol'] }} {{ $data['formData']['start_date'] }} to {{ $data['formData']['end_date'] }}</h2>
    
    @if(isset($data['historicalData']))
        <table style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ccc; padding: 8px;">Date</th>
                    <th style="border: 1px solid #ccc; padding: 8px;">Open</th>
                    <th style="border: 1px solid #ccc; padding: 8px;">High</th>
                    <th style="border: 1px solid #ccc; padding: 8px;">Low</th>
                    <th style="border: 1px solid #ccc; padding: 8px;">Close</th>
                    <th style="border: 1px solid #ccc; padding: 8px;">Volume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['historicalData']['prices'] as $price)
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ date('Y-m-d', $price['date']) }}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $price['open'] ?? "" }}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $price['high'] ?? ""}}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $price['low'] ?? "" }}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $price['close'] ?? "" }}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $price['volume'] ?? "" }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
