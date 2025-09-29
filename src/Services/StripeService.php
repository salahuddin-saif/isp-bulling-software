<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Env;

final class StripeService
{
    public function isEnabled(): bool
    {
        return (bool)Env::get('STRIPE_SECRET_KEY');
    }

    public function createCheckoutSession(int $amountCents, string $currency, string $successUrl, string $cancelUrl, ?int $clientReferenceId = null): array
    {
        // If not configured, return a demo session
        if (!$this->isEnabled()) {
            return ['id' => 'demo_session', 'url' => $successUrl];
        }

        $apiKey = Env::get('STRIPE_SECRET_KEY', '');
        $payload = [
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => ['name' => 'ISP Invoice'],
                    'unit_amount' => $amountCents,
                ],
                'quantity' => 1,
            ]],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];
        if ($clientReferenceId !== null) {
            $payload['client_reference_id'] = (string)$clientReferenceId;
        }

        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        $fields = http_build_query($this->flatten($payload));
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \RuntimeException('Stripe API error: ' . curl_error($ch));
        }
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException('Stripe API error HTTP ' . $status . ': ' . $response);
        }
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        return $data;
    }

    public function verifyWebhook(string $payload, string $signatureHeader): bool
    {
        // In a real app, verify with STRIPE_WEBHOOK_SECRET. Here we trust in dev when empty.
        $secret = Env::get('STRIPE_WEBHOOK_SECRET', '');
        if ($secret === '') {
            return true;
        }
        // Minimalistic verification placeholder: require header present.
        return $signatureHeader !== '';
    }

    private function flatten(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $newKey = $prefix ? $prefix . '[' . $key . ']' : (string)$key;
            if (is_array($value)) {
                $result += $this->flatten($value, $newKey);
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
}


