<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpayController extends Controller
{
    public function create()
    {
        return view('opay.create');
    }

    public function initiatePayment(Request $request)
    {
        $userData = $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric'
        ]);

        $opayData = [
            'country' => 'NG',
            'reference' => random_int(1000000000000, 9999999999999),
            'amount' => [
                "total" => $userData['amount'] * 1000,
                "currency" => 'NGN',
            ],
            'returnUrl' => route('opay.verify'),
            'callbackUrl' => route('opay.verify'),
            'cancelUrl' => route('opay.create'),
            'evokeOpay' => true,
            'userInfo' => [
                "userEmail" => $userData['email'],
                "userMobile" => "+2347038520433",
            ],
            'product' => [
                "name" => 'Cool Product',
                "description" => 'Cool description'
            ],
            'payMethod' => 'BankCard',
        ];

        $cards = [

            [
                "type" => "Mastercard",
                "number" => 5123450000000008,
                "cvv" => 100,
                "expiry" => "05/25",
                "description" => "This card will always return successful payment"
            ],
            [
                "type" => "Mastercard",
                "number" => 2223000000000007,
                "cvv" => 100,
                "expiry" => "05/21",
                "description" => "This card will always return failure due to invalid expiry date"
            ],
        ];


        $url = 'https://testapi.opaycheckout.com/api/v1/international/cashier/create';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('app.opay_test_public_key'),
                'Content-Type' => 'application/json',
                'MerchantId' => config('app.opay_merchant_id'),
                "Cache-Control" => "no-cache",
            ])
                ->timeout(60)
                ->post($url, $opayData);

            if ($response->failed()) {
                throw new \Exception("Invalid HTTP status: {$response->status()}, Response: {$response->body()}");
            }
        } catch (\Exception $e) {
            throw new \Exception("HTTP Request failed: " . $e->getMessage());
        }

        if (! $response) {
            return back()->withError($response->message);
        }

        $responseData = $response->json();

        if (! $responseData  || $responseData['message'] !== 'SUCCESSFUL') {
            return back()->withError($responseData->message);
        }

        return redirect($responseData['data']['cashierUrl']);
    }

    public function verifyPayment()
    {
        $reference = request('reference');

        dd($reference);
    }
}
