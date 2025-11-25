<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoiceNumber }}</title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; font-size: 13px; direction: rtl; }
        .header { text-align: center; margin-bottom: 30px; background-color: #6366f1; color: white; padding: 20px; border-radius: 10px; }
        .header h1 { margin: 0 0 10px 0; font-size: 26px; font-weight: bold; }
        .header h2 { margin: 0; font-size: 20px; color: #e0e7ff; font-weight: normal; }
        .info-box { background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
        .info-row { margin-bottom: 10px; padding: 5px 0; font-size: 14px; text-align: right; }
        .label { font-weight: bold; color: #6366f1; display: inline-block; width: 60px; font-size: 14px; margin-left: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #6366f1; color: white; padding: 12px; text-align: right; font-weight: bold; font-size: 14px; }
        td { border: 1px solid #e5e7eb; padding: 10px; background-color: #ffffff; font-size: 13px; text-align: right; }
        tr:nth-child(even) td { background-color: #f9fafb; }
        .total-box { background-color: #10b981; color: white; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; }
        .total-box .amount { font-size: 26px; font-weight: bold; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <h2>#{{ $invoiceNumber }}</h2>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span>{{ $storeName }}</span>
            <span class="label">{{ $storeLabel }}</span>
        </div>
        <div class="info-row">
            <span>{{ $marketerName }}</span>
            <span class="label">{{ $marketerLabel }}</span>
        </div>
        <div class="info-row">
            <span>{{ $date }}</span>
            <span class="label">{{ $dateLabel }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ $totalLabel }}</th>
                <th>{{ $priceLabel }}</th>
                <th>{{ $quantityLabel }}</th>
                <th>{{ $productLabel }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $currency }} {{ number_format($item->total, 2) }}</td>
                <td>{{ $currency }} {{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div>{{ $grandTotalLabel }}</div>
        <div class="amount">{{ $currency }} {{ number_format($totalAmount, 2) }}</div>
    </div>
</body>
</html>
