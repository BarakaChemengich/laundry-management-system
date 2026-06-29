<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function initiateStkPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'phone' => 'required|string|min:10|max:15'
        ]);

        // Generate unique request IDs
        $merchantRequestId = 'MWM_' . uniqid();
        $checkoutRequestId = 'CHK_' . uniqid();

        // Create order with pending status
        $order = Order::create([
            'customer_id' => auth()->id(),
            'service_type' => $request->input('service_type', 'Wash & Fold'),
            'weight_quantity' => $request->input('weight', 5.00),
            'total_price' => $request->input('amount'),
            'collection_address' => $request->input('collection_address', ''),
            'scheduled_pickup_at' => $request->input('scheduled_pickup_at'),
            'status' => Order::STATUS_PENDING,
            'laundry_package_id' => $request->input('laundry_package_id')
        ]);

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'merchant_request_id' => $merchantRequestId,
            'checkout_request_id' => $checkoutRequestId,
            'amount' => $request->input('amount'),
            'phone_number' => $request->input('phone'),
            'status' => Payment::STATUS_PENDING,
            'payment_method' => 'M-Pesa'
        ]);

        // TODO: Actual Daraja API call would go here
        // For now, simulate success response

        return response()->json([
            'ResponseCode' => '0',
            'ResponseDescription' => 'Success. Request accepted for processing',
            'MerchantRequestID' => $merchantRequestId,
            'CheckoutRequestID' => $checkoutRequestId,
            'order_id' => $order->id
        ]);
    }

    public function processCallback(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $resultCode = $payload['Body']['stkCallback']['ResultCode'] ?? 1;
        $merchantRequestID = $payload['Body']['stkCallback']['MerchantRequestID'] ?? null;

        Log::info('M-Pesa Callback Received', ['payload' => $payload, 'resultCode' => $resultCode]);

        if ($resultCode === 0) {
            // Successful payment
            $metaData = $payload['Body']['stkCallback']['CallbackMetadata']['Item'] ?? [];
            $mpesaReceipt = collect($metaData)->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;
            $amount = collect($metaData)->firstWhere('Name', 'Amount')['Value'] ?? 0.00;
            $phone = collect($metaData)->firstWhere('Name', 'PhoneNumber')['Value'] ?? null;

            DB::transaction(function () use ($merchantRequestID, $mpesaReceipt, $amount) {
                $payment = Payment::where('merchant_request_id', $merchantRequestID)->firstOrFail();
                $payment->markAsCompleted($mpesaReceipt, $amount);

                // Update order status to ACCEPTED
                $payment->order->transitionTo(Order::STATUS_ACCEPTED);

                // Log the payment completion
                \App\Models\AuditLog::log(
                    'payment_completed',
                    'payments',
                    $payment->id,
                    ['status' => 'PENDING'],
                    ['status' => 'COMPLETED', 'receipt' => $mpesaReceipt]
                );
            });

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
        }

        // Payment failed
        if ($merchantRequestID) {
            $payment = Payment::where('merchant_request_id', $merchantRequestID)->first();
            if ($payment) {
                $payment->markAsFailed();
            }
        }

        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Declined']);
    }

    public function initiateRefund(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'reason' => 'required|string|max:500'
        ]);

        $payment = Payment::with('order')->findOrFail($request->payment_id);

        // Verify payment is completed
        if (!$payment->isCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'Only completed payments can be refunded.'
            ], 400);
        }

        // TODO: Actual M-Pesa reversal API call would go here

        DB::transaction(function () use ($payment) {
            $payment->markAsRefunded();
            $payment->order->transitionTo(Order::STATUS_CANCELLED);

            \App\Models\AuditLog::log(
                'refund_initiated',
                'payments',
                $payment->id,
                ['status' => 'COMPLETED'],
                ['status' => 'REFUNDED']
            );
        });

        return response()->json([
            'success' => true,
            'message' => 'Refund initiated successfully.'
        ]);
    }
}