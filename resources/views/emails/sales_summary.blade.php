<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Summary</title>
</head>
<body>
    <h1>Daily Sales Summary</h1>
    <p>Total Sales: {{ $totalSales }}</p>
    <p>Total Value: $ {{ number_format($totalValue, 2, '.', ',') }}</p>
    <p>Total Commission: $ {{ number_format($totalCommission, 2, '.', ',') }}</p>
</body>
</html>
