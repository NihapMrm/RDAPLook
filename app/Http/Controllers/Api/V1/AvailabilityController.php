<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RdapService;
use App\Services\RdapUnavailableException;
use Illuminate\Http\JsonResponse;

/**
 * @group Availability
 */
class AvailabilityController extends Controller
{
    public function __construct(private RdapService $rdap) {}

    /**
     * Domain availability check
     *
     * Fast check whether a domain is registered or available.
     * Results are cached in Redis for 1 hour.
     *
     * @urlParam domain string required The domain name to check. Example: example.com
     *
     * @response 200 {
     *   "domain": "example.com",
     *   "registered": true,
     *   "expires": "2024-08-13T04:00:00Z",
     *   "checked_at": "2024-01-01T00:00:00+00:00"
     * }
     */
    public function show(string $domain): JsonResponse
    {
        if (!$this->isValidDomain($domain)) {
            return $this->error('INVALID_DOMAIN', 'The provided domain name is invalid.', 422);
        }

        $domain = strtolower(trim($domain, '.'));

        try {
            return response()->json($this->rdap->checkAvailability($domain));
        } catch (RdapUnavailableException $e) {
            return $this->error('RDAP_UNAVAILABLE', $e->getMessage(), 503);
        } catch (\Throwable $e) {
            report($e);
            return $this->error('RDAP_UNAVAILABLE', 'RDAP query failed.', 503);
        }
    }

    private function isValidDomain(string $domain): bool
    {
        return (bool) preg_match(
            '/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
            $domain
        );
    }

    private function error(string $code, string $message, int $status): JsonResponse
    {
        return response()->json(['error' => true, 'code' => $code, 'message' => $message], $status);
    }
}
