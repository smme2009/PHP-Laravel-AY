<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\Order as ReqOrder;
use App\Http\Service\Order as SrcOrder;

class Order extends Controller
{
    public function __construct(
        private SrcOrder $srcOrder,
    ) {
    }

    public function convertOrder(ReqOrder $request): JsonResponse
    {
        $orderData = $request->validated();

        $convertOrderData = $this->srcOrder->converData($orderData);

        if ($convertOrderData === false) {
            $data = [
                'message' => $this->srcOrder->getMessage(),
            ];

            $response = response()->json($data, 400);
            return $response;
        }

        $data = [
            'message' => 'Successfully',
            'orderData' => $convertOrderData,
        ];

        $response = response()->json($data);
        return $response;
    }
}
