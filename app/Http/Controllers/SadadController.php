<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plutu\Services\PlutuSadad;

class SadadController extends Controller
{
    public function sadad(Request $request){
        $mobileNumber = '0913632323'; // Mobile number should start with 09
        $birthYear = '2001'; // Birth year
        $amount = $request->amount; // amount in float format

        try {
            $api = new PlutuSadad;
            $api->setCredentials(env('PLUTU_API_KEY'), env('PLUTU_ACCESS_TOKEN'));
            $apiResponse = $api->verify($mobileNumber, $birthYear, $amount);

            if ($apiResponse->getOriginalResponse()->isSuccessful()) {

                $processId = $apiResponse->getProcessId();
                return response()->json([
                    'message' => 'Payment successful',
                    'data' => $apiResponse,
                    'processId' => $processId,
                    'amount' => $amount
                ]);

            } elseif ($apiResponse->getOriginalResponse()->hasError()) {

                // Possible errors from Plutu API
                // @see https://docs.plutu.ly/api-documentation/errors Plutu API Error Documentation
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
            return response()->json([
                'message' => 'Payment failed',
                'exception' => $exception
            ]);
        }

    }

    public function confirmPayment(Request $request){
        $processId = $request->process_id;
        $code = '111111'; // OTP
        $amount = $request->amount; // amount in float format
        $invoiceNo = 'inv-12345';

        try {

            $api = new PlutuSadad;
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
            return response()->json([
                'message' => 'Payment failed',
                'exception' => $exception
            ]);
        }
    }
}
