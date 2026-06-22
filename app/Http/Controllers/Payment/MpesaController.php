<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    private function getAccessToken()
    {
        $url = env('MPESA_ENVIRONMENT') === 'live' 
            ? 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = Http::withBasicAuth(env('MPESA_CONSUMER_KEY'), env('MPESA_CONSUMER_SECRET'))->get($url);

        return $response->json()['access_token'];
    }

    public function initiateStkPush(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^2547[0-9]{8}$|^2541[0-9]{8}$/',
            'amount' => 'required|numeric|min:1',
        ]);

        $endpoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);
        
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)->post($endpoint, [
            'BusinessShortCode' => env('MPESA_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $request->phone,
            'PartyB' => env('MPESA_SHORTCODE'),
            'PhoneNumber' => $request->phone,
            'CallBackURL' => env('MPESA_CALLBACK_URL'),
            'AccountReference' => 'LaundrySystem',
            'TransactionDesc' => 'Payment for Laundry Services'
        ]);

        return response()->json($response->json());
    }

    public function handleCallback(Request $request)
    {
        $callbackData = $request->all();
        Log::info('M-Pesa Callback Payload:', $callbackData);

        $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
        
        if ($resultCode == 0) {
            $meta = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];
            
            $mpesaReceiptNumber = collect($meta)->firstWhere('Name', 'MpesaReceiptNumber')['Value'];
            $amount = collect($meta)->firstWhere('Name', 'Amount')['Value'];
            $phoneNumber = collect($meta)->firstWhere('Name', 'PhoneNumber')['Value'];

            Log::info("Payment Successful. Receipt: {$mpesaReceiptNumber}, Amount: {$amount}");
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Callback Processed']);
    }
}