<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MpesaGatewayController extends Controller
{
    public function initiateStkPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'phone' => 'required'
        ]);

        // Simulating standard Safaricom Daraja Sandbox Dispatch Handshake response
        $merchantRequestId = 'MWM_' . uniqid();
        $checkoutRequestId = 'CHK_' . uniqid();

        // Instantiate transactional order footprint internally
        $order = Order::create([
            'customer_id' => 1, // Simulated active authenticated reference placeholder
            'service_type' => $request->input('service_type', 'Wash & Fold'),
            'weight_quantity' => $request->input('weight', 5.00),
            'total_amount' => $request->input('amount'),
            'status' => 'PENDING'
        ]);

        Payment::create([
            'order_id' => $order->id,
            'merchant_request_id' => $merchantRequestId,
            'checkout_request_id' => $checkoutRequestId,
            'status' => 'PENDING'
        ]);

        return response()->json([
            'ResponseCode' => '0',
            'ResponseDescription' => 'Success. Request accepted for processing',
            'MerchantRequestID' => $merchantRequestId,
            'CheckoutRequestID' => $checkoutRequestId
        ]);
    }

    public function processCallback(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $resultCode = $payload['Body']['stkCallback']['ResultCode'] ?? 1;
        $merchantRequestID = $payload['Body']['stkCallback']['MerchantRequestID'] ?? null;

        if ($resultCode === 0) {
            $metaData = $payload['Body']['stkCallback']['CallbackMetadata']['Item'] ?? [];
            $mpesaReceipt = collect($metaData)->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;
            $amount = collect($metaData)->firstWhere('Name', 'Amount')['Value'] ?? 0.00;

            DB::transaction(function () use ($merchantRequestID, $mpesaReceipt, $amount) {
                $payment = Payment::where('merchant_request_id', $merchantRequestID)->firstOrFail();
                $payment->update([
                    'status' => 'PAID',
                    'mpesa_receipt' => $mpesaReceipt,
                    'amount_paid' => $amount
                ]);

                $payment->order->transitionTo('ACCEPTED');
            });

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
        }

        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Declined']);
    }
}