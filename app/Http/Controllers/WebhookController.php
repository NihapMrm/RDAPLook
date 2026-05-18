<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function lemonSqueezy(Request $request): Response
    {
        $signatureResult = $this->verifySignature($request);

        if ($signatureResult !== null) {
            return $signatureResult;
        }

        $event = $request->input('meta.event_name');
        $data  = $request->input('data', []);

        match ($event) {
            'subscription_created'   => $this->handleSubscriptionCreated($data),
            'subscription_updated'   => $this->handleSubscriptionUpdated($data),
            'subscription_cancelled' => $this->handleSubscriptionCancelled($data),
            default                  => Log::info('Unhandled LemonSqueezy event', ['event' => $event]),
        };

        return response()->json(['received' => true]);
    }

    /**
     * Verify the Lemon Squeezy HMAC-SHA256 webhook signature.
     *
     * Returns null on success (proceed), or a JsonResponse on failure.
     *
     * Guards:
     *  - No signature header at all (distinct message from wrong signature)
     *  - Wrong signature (constant-time comparison via hash_equals)
     *  - Secret not configured → skip verification in local dev only
     */
    private function verifySignature(Request $request): ?JsonResponse
    {
        $secret = config('services.lemon_squeezy.webhook_secret');

        if (!$secret) {
            // Skip only when secret is explicitly not configured (local dev)
            return null;
        }

        $signature = $request->header('X-Signature');

        if (!$signature) {
            return response()->json([
                'error'   => true,
                'code'    => 'WEBHOOK_SIGNATURE_MISSING',
                'message' => 'X-Signature header is required.',
            ], 401);
        }

        $computed = hash_hmac('sha256', $request->getContent(), $secret);

        // hash_equals is constant-time; $computed (known) is first argument
        if (!hash_equals($computed, $signature)) {
            return response()->json([
                'error'   => true,
                'code'    => 'WEBHOOK_SIGNATURE_INVALID',
                'message' => 'Webhook signature verification failed.',
            ], 401);
        }

        return null;
    }

    private function handleSubscriptionCreated(array $data): void
    {
        $attrs     = $data['attributes'] ?? [];
        $lsId      = $data['id'] ?? null;
        $variantId = (string) ($attrs['variant_id'] ?? '');
        $userEmail = $attrs['user_email'] ?? null;
        $status    = $attrs['status'] ?? 'active';
        $renewsAt  = $attrs['renews_at'] ?? null;

        $user = User::where('email', $userEmail)->first();

        if (!$user) {
            Log::warning('LemonSqueezy: user not found for subscription_created', ['email' => $userEmail]);
            return;
        }

        $plan = Plan::where('lemon_squeezy_variant_id', $variantId)->first();

        Subscription::updateOrCreate(
            ['lemon_squeezy_id' => $lsId],
            [
                'user_id'   => $user->id,
                'plan_id'   => $plan?->id,
                'status'    => $status,
                'renews_at' => $renewsAt,
            ]
        );

        if ($plan) {
            $user->update(['plan_id' => $plan->id]);
        }
    }

    private function handleSubscriptionUpdated(array $data): void
    {
        $attrs     = $data['attributes'] ?? [];
        $lsId      = $data['id'] ?? null;
        $variantId = (string) ($attrs['variant_id'] ?? '');
        $status    = $attrs['status'] ?? 'active';
        $renewsAt  = $attrs['renews_at'] ?? null;

        $subscription = Subscription::where('lemon_squeezy_id', $lsId)->first();

        if (!$subscription) {
            Log::warning('LemonSqueezy: subscription not found for subscription_updated', ['id' => $lsId]);
            return;
        }

        $plan = Plan::where('lemon_squeezy_variant_id', $variantId)->first();

        $subscription->update([
            'plan_id'   => $plan?->id,
            'status'    => $status,
            'renews_at' => $renewsAt,
        ]);

        if ($plan) {
            $subscription->user()->update(['plan_id' => $plan->id]);
        }
    }

    private function handleSubscriptionCancelled(array $data): void
    {
        $lsId = $data['id'] ?? null;

        $subscription = Subscription::where('lemon_squeezy_id', $lsId)->first();

        if (!$subscription) {
            Log::warning('LemonSqueezy: subscription not found for subscription_cancelled', ['id' => $lsId]);
            return;
        }

        $freePlan = Plan::where('slug', 'free')->first();

        $subscription->update(['status' => 'cancelled']);
        $subscription->user()->update(['plan_id' => $freePlan?->id]);
    }
}
