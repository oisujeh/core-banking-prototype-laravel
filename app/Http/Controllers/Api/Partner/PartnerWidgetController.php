<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Partner;

use App\Domain\FinancialInstitution\Models\FinancialInstitutionPartner;
use App\Domain\FinancialInstitution\Services\EmbeddableWidgetService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerWidgetController extends Controller
{
    public function __construct(
        private readonly EmbeddableWidgetService $widgetService,
    ) {
    }

    /**
     * Get available widget types.
     *
     * GET /api/partner/v1/widgets
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->widgetService->getAvailableWidgets(),
        ]);
    }

    /**
     * Generate embed code for a widget.
     *
     * POST /api/partner/v1/widgets/{type}/embed
     */
    public function embed(Request $request, string $type): JsonResponse
    {
        $partner = $this->getPartner($request);

        $options = $request->validate([
            'container_id' => 'sometimes|string|max:100',
            'width'        => 'sometimes|string|max:20',
            'height'       => 'sometimes|string|max:20',
        ]);

        $result = $this->widgetService->generateEmbedCode($partner, $type, $options);

        return response()->json([
            'success' => $result['success'],
            'data'    => $result,
        ], $result['success'] ? 200 : 422);
    }

    /**
     * Preview a widget with branding.
     *
     * GET /api/partner/v1/widgets/{type}/preview
     */
    public function preview(Request $request, string $type): JsonResponse
    {
        $partner = $this->getPartner($request);
        $result = $this->widgetService->previewWidget($partner, $type);

        return response()->json([
            'success' => $result['success'],
            'data'    => $result,
        ], $result['success'] ? 200 : 422);
    }

    private function getPartner(Request $request): FinancialInstitutionPartner
    {
        return $request->attributes->get('partner');
    }
}
