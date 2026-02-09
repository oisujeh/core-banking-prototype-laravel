<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Partner;

use App\Domain\FinancialInstitution\Models\FinancialInstitutionPartner;
use App\Domain\FinancialInstitution\Services\SdkGeneratorService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerSdkController extends Controller
{
    public function __construct(
        private readonly SdkGeneratorService $sdkService,
    ) {
    }

    /**
     * Get available SDK languages.
     *
     * GET /api/partner/v1/sdk/languages
     */
    public function languages(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->sdkService->getAvailableLanguages(),
        ]);
    }

    /**
     * Generate an SDK.
     *
     * POST /api/partner/v1/sdk/generate
     */
    public function generate(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $validated = $request->validate([
            'language' => 'required|string',
        ]);

        $result = $this->sdkService->generate($partner, $validated['language']);

        return response()->json([
            'success' => $result['success'],
            'data'    => $result,
        ], $result['success'] ? 200 : 422);
    }

    /**
     * Get SDK status for a language.
     *
     * GET /api/partner/v1/sdk/{language}
     */
    public function status(Request $request, string $language): JsonResponse
    {
        $partner = $this->getPartner($request);
        $status = $this->sdkService->getSdkStatus($partner, $language);

        return response()->json([
            'success' => true,
            'data'    => $status,
        ]);
    }

    /**
     * Get the OpenAPI spec.
     *
     * GET /api/partner/v1/sdk/openapi-spec
     */
    public function openapiSpec(Request $request): JsonResponse
    {
        $spec = $this->sdkService->getOpenApiSpec();

        if ($spec === null) {
            return response()->json([
                'success' => false,
                'message' => 'OpenAPI spec not available',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => json_decode($spec, true),
        ]);
    }

    private function getPartner(Request $request): FinancialInstitutionPartner
    {
        return $request->attributes->get('partner');
    }
}
