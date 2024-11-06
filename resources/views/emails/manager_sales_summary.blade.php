<!DOCTYPE html>
<html>
<head>
    <title>Total Sales Summary for Today</title>
</head>
<body>
    <h1>Total Sales Summary for Today</h1>
    <p>Total Sales: {{ $totalSales }}</p>
    <p>Total Value: $ {{ number_format($totalSalesValue, 2, '.', ',') }}</p>
</body>
</html>
