<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Partner;

use App\Domain\FinancialInstitution\Models\FinancialInstitutionPartner;
use App\Domain\FinancialInstitution\Services\PartnerTierService;
use App\Domain\FinancialInstitution\Services\PartnerUsageMeteringService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerDashboardController extends Controller
{
    public function __construct(
        private readonly PartnerTierService $tierService,
        private readonly PartnerUsageMeteringService $meteringService,
    ) {
    }

    /**
     * Get partner profile and tier information.
     *
     * GET /api/partner/v1/profile
     */
    public function profile(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $tier = $this->tierService->getPartnerTier($partner);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                 => $partner->id,
                'partner_code'       => $partner->partner_code,
                'institution_name'   => $partner->institution_name,
                'tier'               => $tier->value,
                'tier_label'         => $tier->label(),
                'status'             => $partner->status,
                'sandbox_enabled'    => $partner->sandbox_enabled,
                'production_enabled' => $partner->production_enabled,
                'rate_limit'         => $partner->rate_limit_per_minute,
            ],
        ]);
    }

    /**
     * Get current period usage summary.
     *
     * GET /api/partner/v1/usage
     */
    public function usage(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $startDate = now()->startOfMonth();
        $endDate = now();

        $summary = $this->meteringService->getUsageSummary($partner, $startDate, $endDate);
        $limit = $this->meteringService->checkUsageLimit($partner);

        return response()->json([
            'success' => true,
            'data'    => [
                'period_start' => $startDate->toDateString(),
                'period_end'   => $endDate->toDateString(),
                'summary'      => $summary,
                'limit'        => $limit,
            ],
        ]);
    }

    /**
     * Get historical usage records.
     *
     * GET /api/partner/v1/usage/history
     */
    public function usageHistory(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $startDate = $request->date('start_date') ?? now()->subMonth();
        $endDate = $request->date('end_date') ?? now();

        $summary = $this->meteringService->getUsageSummary($partner, $startDate, $endDate);

        return response()->json([
            'success' => true,
            'data'    => $summary,
        ]);
    }

    /**
     * Get tier details.
     *
     * GET /api/partner/v1/tier
     */
    public function tier(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $tier = $this->tierService->getPartnerTier($partner);

        return response()->json([
            'success' => true,
            'data'    => [
                'tier'           => $tier->value,
                'label'          => $tier->label(),
                'monthly_price'  => $tier->monthlyPrice(),
                'api_call_limit' => $tier->apiCallLimit(),
                'features'       => $tier->features(),
                'has_sdk'        => $tier->hasSdkAccess(),
                'has_widgets'    => $tier->hasWidgets(),
            ],
        ]);
    }

    /**
     * Compare all tiers.
     *
     * GET /api/partner/v1/tier/comparison
     */
    public function tierComparison(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $currentTier = $this->tierService->getPartnerTier($partner);
        $comparison = $this->tierService->getTierComparison($currentTier);

        return response()->json([
            'success' => true,
            'data'    => $comparison,
        ]);
    }

    /**
     * Get current branding configuration.
     *
     * GET /api/partner/v1/branding
     */
    public function branding(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $branding = $partner->branding;

        return response()->json([
            'success' => true,
            'data'    => $branding ? $branding->getWidgetConfig() : null,
        ]);
    }

    /**
     * Update branding configuration.
     *
     * PUT /api/partner/v1/branding
     */
    public function updateBranding(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $validated = $request->validate([
            'primary_color'        => 'sometimes|string|max:7',
            'secondary_color'      => 'sometimes|string|max:7',
            'accent_color'         => 'sometimes|string|max:7',
            'text_color'           => 'sometimes|string|max:7',
            'background_color'     => 'sometimes|string|max:7',
            'logo_url'             => 'sometimes|nullable|url|max:500',
            'company_name'         => 'sometimes|string|max:255',
            'tagline'              => 'sometimes|nullable|string|max:500',
            'support_email'        => 'sometimes|email|max:255',
            'privacy_policy_url'   => 'sometimes|nullable|url|max:500',
            'terms_of_service_url' => 'sometimes|nullable|url|max:500',
        ]);

        $branding = $partner->branding;

        if ($branding) {
            $branding->update($validated);
        } else {
            $branding = $this->tierService->createDefaultBranding($partner);
            $branding->update($validated);
        }

        return response()->json([
            'success' => true,
            'data'    => $branding->fresh()?->getWidgetConfig(),
            'message' => 'Branding updated successfully',
        ]);
    }

    private function getPartner(Request $request): FinancialInstitutionPartner
    {
        return $request->attributes->get('partner');
    }
}
