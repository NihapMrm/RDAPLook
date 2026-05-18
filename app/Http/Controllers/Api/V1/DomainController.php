<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\DomainNotFoundException;
use App\Services\RdapService;
use App\Services\RdapUnavailableException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Domain RDAP
 */
class DomainController extends Controller
{
    public function __construct(private RdapService $rdap) {}

    /**
     * Domain RDAP lookup
     *
     * Returns normalized RDAP data for the given domain including registrar,
     * dates, nameservers, status codes, DNSSEC, and contact information.
     *
     * @urlParam domain string required The domain name to look up. Example: example.com
     * @queryParam raw boolean Include the raw RDAP response in the output. Example: true
     *
     * @response 200 {
     *   "domain": "example.com",
     *   "registrar": {"name": "Example Registrar Inc.", "iana_id": "123", "url": "https://..."},
     *   "dates": {"registered": "1995-08-14T04:00:00Z", "updated": "2023-08-13T07:00:00Z", "expires": "2024-08-13T04:00:00Z"},
     *   "nameservers": ["ns1.example.com", "ns2.example.com"],
     *   "status": ["client delete prohibited", "client transfer prohibited"],
     *   "dnssec": false,
     *   "contacts": {"registrant": null, "admin": null, "tech": null}
     * }
     * @response 404 {"error": true, "code": "DOMAIN_NOT_FOUND", "message": "Domain not found."}
     * @response 503 {"error": true, "code": "RDAP_UNAVAILABLE", "message": "..."}
     */
    public function show(Request $request, string $domain): JsonResponse
    {
        if (!$this->isValidDomain($domain)) {
            return $this->error('INVALID_DOMAIN', 'The provided domain name is invalid.', 422);
        }

        $domain = strtolower(trim($domain, '.'));
        $showRaw = filter_var($request->query('raw', false), FILTER_VALIDATE_BOOLEAN);

        try {
            $data = $this->rdap->lookupDomain($domain);

            if (!$showRaw) {
                unset($data['_raw']);
            } else {
                $data['raw_rdap'] = $data['_raw'];
                unset($data['_raw']);
            }

            return response()->json($data);
        } catch (DomainNotFoundException $e) {
            return $this->error('DOMAIN_NOT_FOUND', 'Domain not found in RDAP registry.', 404);
        } catch (RdapUnavailableException $e) {
            return $this->error('RDAP_UNAVAILABLE', $e->getMessage(), 503);
        } catch (\Throwable $e) {
            report($e);
            return $this->error('RDAP_UNAVAILABLE', 'An unexpected error occurred while querying RDAP.', 503);
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
