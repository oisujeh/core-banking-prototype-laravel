<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\MobilePayment;

use App\Domain\MobilePayment\Services\ReceiptService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct(
        private readonly ReceiptService $receiptService,
    ) {
    }

    /**
     * Generate a receipt for a transaction.
     *
     * POST /v1/transactions/{txId}/receipt
     */
    public function store(Request $request, string $txId): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $receipt = $this->receiptService->generateReceipt($txId, $user->id);

        if (! $receipt) {
            return response()->json([
                'success' => false,
                'error'   => [
                    'code'    => 'RECEIPT_UNAVAILABLE',
                    'message' => 'Receipt can only be generated for confirmed transactions.',
                ],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data'    => $receipt->toApiResponse(),
        ]);
    }
}
