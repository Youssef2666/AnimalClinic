<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plutu\Services\PlutuLocalBankCards;

class LocalBankCardsController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $amount = $request->amount;
        $invoiceNo = 'inv-' . uniqid();
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
        try {
            $api = new PlutuLocalBankCards;
            $api->setSecretKey(env('PLUTU_SECRET_KEY'));
            $callback = $api->callbackHandler($parameters);

            if ($callback->isApprovedTransaction()) {
                $transactionId = $callback->getParameter('transaction_id');
                return view('auth.payment-success', [
                    'message' => 'تم الدفع بنجاح',
                ]);
            } elseif ($callback->isCanceledTransaction()) {
                return view('auth.payment-failed', [
                    'message' => 'تم الغاء الدفع',
                ]);
            }
        } catch (\Exception $e) {
            return view('auth.payment-failed', [
                'message' => 'حدث خطأ أثناء معالجة الدفع',
            ]);
        }
    }

    public function checkPaymentStatus(Request $request)
    {
        $transactionId = $request->transactionId;
        try {
            $api = new PlutuLocalBankCards;
            $api->setSecretKey(env('PLUTU_SECRET_KEY'));
            $status = $api->getPaymentStatus($transactionId);

            if ($status->isApproved()) {
                return response()->json([
                    'message' => 'Payment successful',
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'Payment failed or pending',
                    'status' => 'failed',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error checking payment status',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
