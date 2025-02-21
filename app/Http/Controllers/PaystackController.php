<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    public function create()
    {
        return view('paystack.create');
    }

    public function initiatePayment(Request $request)
    {
        $data =  $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric'
        ]);

        $url = "https://api.paystack.co/transaction/initialize";

        try {
            $response = Http::withHeaders([
                "Authorization" =>   "Bearer " . config('app.paystack_public_key'),
                "Cache-Control" => "no-cache",
            ])
                ->post(
                    $url,
                    $data + ['callback_url' => route('paystack.verify')]
                );
        } catch (\Exception $e) {
            Log::alert("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
            return back()->withError('Network Issues');
        }


        if (! $response) {
            return back()->withError($response->message);
        }

        $responseData = $response->json();

        if (! $responseData  || ! $responseData['status']) {
            return back()->withError($responseData->message);
        }

        return redirect($responseData['data']['authorization_url']);
    }

    public function verifyPayment()
    {
        $reference = request('reference');

        $url = "https://api.paystack.co/transaction/verify/{$reference}";

        try {
            $response = Http::withHeaders([
                "Authorization" =>   "Bearer " . config('app.paystack_public_key'),
                "Cache-Control" => "no-cache",
            ])
                ->get(
                    $url
                );
        } catch (\Exception $e) {
            Log::alert("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
            return back()->withError('Network Issues');
        }

        if (! $response) {
            return back()->withError($response->message);
        }

        $paymentData = $response->json();

        if (! $paymentData  || ! $paymentData['status']) {
            return back()->withError($paymentData->message);
        }

        return view('paystack.show')->with(['paymentData' => $paymentData]);
    }

    public function allTransactions()
    {
        $url = "https://api.paystack.co/transaction";

        try {
            $response = Http::withHeaders([
                "Authorization" =>   "Bearer " . config('app.paystack_public_key'),
                "Cache-Control" => "no-cache",
            ])
                ->get(
                    $url
                );
        } catch (\Exception $e) {
            Log::alert("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
            return back()->withError('Network Issues');
        }

        if (! $response) {
            return back()->withError($response->message);
        }

        $paymentData = $response->json();

        if (! $paymentData  || ! $paymentData['status']) {
            return back()->withError($paymentData->message);
        }

        return view('paystack.index')->with(['paymentData' => $paymentData]);
    }
}
