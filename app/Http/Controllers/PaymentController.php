<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plutu\Services\PlutuAdfali;

class PaymentController extends Controller
{
    public function adfali(Request $request){
        $mobileNumber = '0913632323'; // Mobile number should start with 09
        $amount = $request->amount; // amount in float format
        try {

            $api = new PlutuAdfali;
            $api->setCredentials(env('PLUTU_API_KEY'), env('PLUTU_ACCESS_TOKEN'), env('PLUTU_SECRET_KEY'));
            $apiResponse = $api->verify($mobileNumber, $amount);

            if ($apiResponse->getOriginalResponse()->isSuccessful()) {
                $processId = $apiResponse->getProcessId();
            } elseif ($apiResponse->getOriginalResponse()->hasError()) {
                $errorCode = $apiResponse->getOriginalResponse()->getErrorCode();
                $errorMessage = $apiResponse->getOriginalResponse()->getErrorMessage();
                return response()->json([
                    'message' => 'Payment failed',
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage
                ]);
            }
            return response()->json([
                'message' => 'Payment successful',
                'data' => $apiResponse,
                'processId' => $processId,
                'amount' => $amount
            ]);

        // Handle exceptions that may be thrown during the execution of the code
        } catch (\Exception $e) {
            $exception = $e->getMessage();
        }
    }

    public function confirmPayment(Request $request){
        $processId = $request->process_id; // the Process ID that received in the verification step
        $code = '1111'; // OTP
        $amount = $request->amount; // amount in float format
        $invoiceNo = 'inv-12345';

        try {

            $api = new PlutuAdfali;
            $api->setCredentials(env('PLUTU_API_KEY'), env('PLUTU_ACCESS_TOKEN'));
        
            $apiResponse = $api->confirm($processId, $code, $amount, $invoiceNo);
        
            if($apiResponse->getOriginalResponse()->isSuccessful()){
        
                // The transaction has been completed
                // Plutu Transaction ID
                $transactionId = $apiResponse->getTransactionId();
                // Response Data
                $data = $apiResponse->getOriginalResponse()->getBody();

                return response()->json([
                    'message' => 'Payment successful',
                    'data' => $apiResponse,
                    'transactionId' => $transactionId,
                    'data' => $data,
                    'invoiceNo' => $invoiceNo
                ]);
        
            } elseif($apiResponse->getOriginalResponse()->hasError()) {
                $errorCode = $apiResponse->getOriginalResponse()->getErrorCode();
                $errorMessage = $apiResponse->getOriginalResponse()->getErrorMessage();
                $statusCode = $apiResponse->getOriginalResponse()->getStatusCode();
                $responseData = $apiResponse->getOriginalResponse()->getBody();

                return response()->json([
                    'message' => 'Payment failed',
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage,
                    'statusCode' => $statusCode,
                    'responseData' => $responseData
                ]);
        
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
        }

    }
}
