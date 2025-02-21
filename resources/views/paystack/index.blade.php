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
            @forelse ($paymentData['data'] as $payment)
                <tr>
                    <td>{{ $payment['reference'] }}</td>
                    <td>{{ $payment['status'] }}</td>
                    <td>{{ $payment['amount'] }}</td>
                    <td>{{ $payment['channel'] }}</td>
                    <td>{{ $payment['created_at'] }}</td>
                </tr>
            @empty
                <p>No data</p>
            @endforelse

        </table>

    </body>

</html>
