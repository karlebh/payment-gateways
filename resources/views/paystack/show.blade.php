<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Paystack payment</title>
    </head>

    <body>
        <table border="1">
            <tr>
                <th>Transaction Reference</th>
                <th>Status</th>
                <th>Amount (NGN)</th>
                <th>Payment Channel</th>
                <th>Transaction Date</th>
            </tr>
            @if ($paymentData)
                <tr>
                    <td>{{ $paymentData['data']['reference'] }}</td>
                    <td>{{ $paymentData['status'] }}</td>
                    <td>{{ $paymentData['data']['amount'] }}</td>
                    <td>{{ $paymentData['data']['channel'] }}</td>
                    <td>{{ $paymentData['data']['created_at'] }}</td>
                </tr>
            @endif

        </table>

    </body>

</html>
