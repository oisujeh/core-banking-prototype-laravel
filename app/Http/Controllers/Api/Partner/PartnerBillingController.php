<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Partner;

use App\Domain\FinancialInstitution\Models\FinancialInstitutionPartner;
use App\Domain\FinancialInstitution\Models\PartnerInvoice;
use App\Domain\FinancialInstitution\Services\PartnerBillingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerBillingController extends Controller
{
    public function __construct(
        private readonly PartnerBillingService $billingService,
    ) {
    }

    /**
     * List partner invoices.
     *
     * GET /api/partner/v1/billing/invoices
     */
    public function invoices(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $invoices = PartnerInvoice::where('partner_id', $partner->id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $invoices,
        ]);
    }

    /**
     * Get a specific invoice.
     *
     * GET /api/partner/v1/billing/invoices/{id}
     */
    public function invoice(Request $request, int $id): JsonResponse
    {
        $partner = $this->getPartner($request);

        $invoice = PartnerInvoice::where('partner_id', $partner->id)
            ->where('id', $id)
            ->first();

        if (! $invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $invoice,
        ]);
    }

    /**
     * Get outstanding balance.
     *
     * GET /api/partner/v1/billing/outstanding
     */
    public function outstanding(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);
        $balance = $this->billingService->getOutstandingBalance($partner);

        return response()->json([
            'success' => true,
            'data'    => [
                'outstanding_balance_usd' => $balance,
                'currency'                => 'USD',
            ],
        ]);
    }

    /**
     * Get current period billing breakdown preview.
     *
     * GET /api/partner/v1/billing/breakdown
     */
    public function breakdown(Request $request): JsonResponse
    {
        $partner = $this->getPartner($request);

        $periodStart = now()->startOfMonth();
        $periodEnd = now();

        $breakdown = $this->billingService->calculateBillingBreakdown($partner, $periodStart, $periodEnd);

        return response()->json([
            'success' => true,
            'data'    => $breakdown,
        ]);
    }

    private function getPartner(Request $request): FinancialInstitutionPartner
    {
        return $request->attributes->get('partner');
    }
}
