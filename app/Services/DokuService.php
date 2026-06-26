<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokuService
{
    protected $clientId;
    protected $secretKey;
    protected $isProduction;
    protected $apiUrl;

    public function __construct()
    {
        $this->clientId = env('DOKU_CLIENT_ID');
        $this->secretKey = env('DOKU_SECRET_KEY');
        
        // Handle env string "false" correctly
        $prodValue = env('DOKU_IS_PRODUCTION', false);
        $this->isProduction = ($prodValue === true || $prodValue === 'true' || $prodValue === 1 || $prodValue === '1');

        if ($this->isProduction) {
            $this->apiUrl = "https://api.doku.com/checkout/v1/payment";
        } else {
            $this->apiUrl = "https://api-sandbox.doku.com/checkout/v1/payment";
        }
    }

    private function generateDigest($body)
    {
        $hash = hash('sha256', $body, true);
        return base64_encode($hash);
    }

    private function generateSignature($requestId, $requestTimestamp, $digest)
    {
        $requestTarget = "/checkout/v1/payment";
        
        $signaturePayload = "Client-Id:" . $this->clientId . "\n" .
                           "Request-Id:" . $requestId . "\n" .
                           "Request-Timestamp:" . $requestTimestamp . "\n" .
                           "Request-Target:" . $requestTarget;
        
        if ($digest) {
            $signaturePayload .= "\nDigest:" . $digest;
        }

        $signature = hash_hmac('sha256', $signaturePayload, $this->secretKey, true);
        return "HMACSHA256=" . base64_encode($signature);
    }

    private function getCurrentTimestamp()
    {
        return now()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
    }

    public function createTransaction($orderId, $amount, $customerName, $customerEmail, $customerPhone = null)
    {
        try {
            $requestId = (string) Str::uuid();
            $requestTimestamp = $this->getCurrentTimestamp();

            $body = [
                "order" => [
                    "invoice_number" => $orderId,
                    "amount" => $amount,
                    "currency" => "IDR",
                    "callback_url" => env('APP_URL', 'http://localhost:8000') . "/payment-success?orderId=" . $orderId,
                    "callback_url_cancel" => env('APP_URL', 'http://localhost:8000') . "/checkout?orderId=" . $orderId,
                    "auto_redirect" => true
                ],
                "payment" => [
                    "payment_due_date" => 60,
                    "payment_method_types" => ["VIRTUAL_ACCOUNT_BCA"]
                ],
                "customer" => [
                    "name" => $customerName,
                    "email" => $customerEmail,
                    "phone" => $customerPhone ?: "628121212121"
                ]
            ];

            $jsonBody = json_encode($body);
            $digest = $this->generateDigest($jsonBody);
            $signature = $this->generateSignature($requestId, $requestTimestamp, $digest);

            Log::info("DOKU Request", [
                'url' => $this->apiUrl,
                'body' => $body,
                'headers' => [
                    'Client-Id' => $this->clientId,
                    'Request-Id' => $requestId,
                    'Request-Timestamp' => $requestTimestamp,
                    'Signature' => $signature,
                    'Digest' => $digest
                ]
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Client-Id' => $this->clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $requestTimestamp,
                'Signature' => $signature,
                'Digest' => $digest
            ])->withOptions([
                'verify' => false, // Disable SSL verification for local dev (fix cURL error 60)
                'timeout' => 30,    // 30 seconds timeout
                'connect_timeout' => 10, // 10 seconds connect timeout
            ])->post($this->apiUrl, $body);

            if ($response->successful()) {
                $data = $response->json();
                Log::info("DOKU Success Response", $data);

                // DOKU structure can vary, try common paths
                $redirectUrl = $data['response']['payment']['url'] ?? $data['payment_url'] ?? null;

                if ($redirectUrl) {
                    return [
                        'success' => true,
                        'redirectUrl' => $redirectUrl,
                        'paymentId' => $requestId
                    ];
                }
            }

            Log::error("DOKU Error Response", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal membuat transaksi DOKU: ' . ($response->json('message') ?: 'Unknown error')
            ];

        } catch (\Exception $e) {
            Log::error("DOKU Exception", ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem DOKU'
            ];
        }
    }
}
