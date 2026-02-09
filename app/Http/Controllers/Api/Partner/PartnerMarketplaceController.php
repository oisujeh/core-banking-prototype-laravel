<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Partner;

use App\Domain\FinancialInstitution\Models\FinancialInstitutionPartner;
use App\Domain\FinancialInstitution\Services\PartnerMarketplaceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerMarketplaceController extends Controller
{
    public function __construct(
        private readonly PartnerMarketplaceService $marketplaceService,
    ) {
    }

    /**
     * List available integrations.
     *
     * GET /api/partner/v1/marketplace
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->marketplaceService->listAvailableIntegrations(),
        ]);
    }

    /**
     * Get partner's active integrations.
     *
     * GET /api/partner/v1/marketplace/integrations
     */
    public function integrations(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $integrations = $this->marketplaceService->getPartnerIntegrations($partner);

        return response()->json([
            'success' => true,
            'data'    => $integrations,
        ]);
    }

    /**
     * Enable an integration.
     *
     * POST /api/partner/v1/marketplace/integrations
     */
    public function enable(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $validated = $request->validate([
            'category' => 'required|string',
            'provider' => 'required|string',
            'config'   => 'sometimes|array',
        ]);

        $result = $this->marketplaceService->enableIntegration(
            $partner,
            $validated['category'],
            $validated['provider'],
            $validated['config'] ?? [],
        );

        return response()->json([
            'success' => $result['success'],
            'data'    => $result,
        ], $result['success'] ? 201 : 422);
    }

    /**
     * Disable an integration.
     *
     * DELETE /api/partner/v1/marketplace/integrations/{id}
     */
    public function disable(Request $request, int $id): JsonResponse
    {
        $partner = $this->getPartner($request);
        $result = $this->marketplaceService->disableIntegration($partner, $id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['success'] ? 200 : 404);
    }

    /**
     * Test an integration connection.
     *
     * POST /api/partner/v1/marketplace/integrations/{id}/test
     */
    public function test(Request $request, int $id): JsonResponse
    {
        $partner = $this->getPartner($request);
        $result = $this->marketplaceService->testConnection($partner, $id);

        return response()->json([
            'success' => $result['success'],
            'data'    => $result,
        ], $result['success'] ? 200 : 404);
    }

    /**
     * Get integration health overview.
     *
     * GET /api/partner/v1/marketplace/health
     */
    public function health(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $health = $this->marketplaceService->getIntegrationHealth($partner);

        return response()->json([
            'success' => true,
            'data'    => $health,
        ]);
    }

    private function getPartner(Request $request): FinancialInstitutionPartner
    {
        return $request->attributes->get('partner');
    }
}
