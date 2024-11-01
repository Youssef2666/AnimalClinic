<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plutu\Services\PlutuLocalBankCards;

class LocalBankCardsController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $amount = $request->amount; // e.g., 5.0
        $invoiceNo = 'inv-' . uniqid(); // Unique invoice number
        $returnUrl = route('payment.callback');

        try {
            $api = new PlutuLocalBankCards;
            $api->setCredentials(env('PLUTU_API_KEY'), env('PLUTU_ACCESS_TOKEN'), env('PLUTU_SECRET_KEY'));
            $apiResponse = $api->confirm($amount, $invoiceNo, $returnUrl);

            if ($apiResponse->getOriginalResponse()->isSuccessful()) {
                $redirectUrl = $apiResponse->getRedirectUrl();

                return response()->json([
                    'message' => 'Payment initiated successfully',
                    'redirectUrl' => $redirectUrl,
                    'invoiceNo' => $invoiceNo,
                ]);
            } elseif ($apiResponse->getOriginalResponse()->hasError()) {
                $errorCode = $apiResponse->getOriginalResponse()->getErrorCode();
                $errorMessage = $apiResponse->getOriginalResponse()->getErrorMessage();

                return response()->json([
                    'message' => 'Payment failed',
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function handleCallback(Request $request)
    {
        $parameters = $request->all();
        info('Callback parameters:', $request->all());
    
        try {
            $api = new PlutuLocalBankCards;
            $api->setSecretKey(env('PLUTU_SECRET_KEY'));
            $callback = $api->callbackHandler($parameters);
    
            if ($callback->isApprovedTransaction()) {
                $transactionId = $callback->getParameter('transaction_id');
    
                return response()->json([
                    'message' => 'Payment successful',
                    'transactionId' => $transactionId,
                ]);
            } elseif ($callback->isCanceledTransaction()) {
                return response()->json([
                    'message' => 'Payment canceled',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Payment failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
