<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\StripeService;
use App\Services\NetworkAccessService;

final class PaymentController extends Controller
{
    public function pay(int $invoiceId): void
    {
        require_auth();
        $invoice = (new Invoice())->find($invoiceId);
        if (!$invoice || $invoice['status'] !== 'pending') {
            http_response_code(404);
            echo 'Invoice not found';
            return;
        }
        $stripe = new StripeService();
        $success = app_url('/payment/success/' . $invoiceId);
        $cancel = app_url('/dashboard');
        $session = $stripe->createCheckoutSession((int)$invoice['amount_cents'], 'USD', $success, $cancel, $invoiceId);
        if (!empty($session['url'])) {
            header('Location: ' . $session['url']);
            exit;
        }
        $this->redirect('/dashboard');
    }

    public function success(int $invoiceId): void
    {
        require_auth();
        $invoiceModel = new Invoice();
        $invoice = $invoiceModel->find($invoiceId);
        if (!$invoice) {
            http_response_code(404);
            echo 'Invoice not found';
            return;
        }
        // Demo: mark paid and record payment
        (new Payment())->record($invoiceId, 'demo', 'demo_ok', (int)$invoice['amount_cents']);
        $invoiceModel->markPaid($invoiceId);
        (new NetworkAccessService())->enableAccessForUser((int)$invoice['user_id']);
        $this->redirect('/dashboard');
    }

    public function webhookStripe(): void
    {
        $payload = file_get_contents('php://input') ?: '';
        $sig = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $stripe = new StripeService();
        if (!$stripe->verifyWebhook($payload, $sig)) {
            http_response_code(400);
            echo 'Invalid signature';
            return;
        }
        $event = json_decode($payload, true);
        if (($event['type'] ?? '') === 'checkout.session.completed') {
            $session = $event['data']['object'] ?? [];
            $invoiceId = (int)($session['client_reference_id'] ?? 0);
            if ($invoiceId > 0) {
                $invoiceModel = new Invoice();
                $invoice = $invoiceModel->find($invoiceId);
                if ($invoice && $invoice['status'] !== 'paid') {
                    (new Payment())->record($invoiceId, 'stripe', $session['id'] ?? null, (int)$invoice['amount_cents']);
                    $invoiceModel->markPaid($invoiceId);
                    (new NetworkAccessService())->enableAccessForUser((int)$invoice['user_id']);
                }
            }
        }
        http_response_code(200);
        echo 'ok';
    }
}


