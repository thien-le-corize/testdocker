<?php

namespace App\Http\Actions\Order;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;

class PrintOrderAction extends BaseAction
{
    protected $orderRepository;

    public function __construct
    (
        OrderRepository $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;
    }

    public function handle()
    {
        $orderCode = $this->params['orderCode'];
        $token = $this->getTokenPrintOrder($orderCode);
        $urlPrintA5 = config('ghn.api.print'). '?token=' . str_replace('"', '', $token);

        return $urlPrintA5;
    }

    public function getTokenPrintOrder($orderCode)
    {
        $response = Http::withHeaders([
            'Token' => config('ghn.token'),
            'Content-Type' => 'application/json',
        ])
        ->post(config('ghn.api.gen_token'),[
                'order_codes' => [$orderCode]
        ]);
        Log::info($orderCode);
        Log::info(json_encode($response['data']));
        return json_encode($response['data']['token']);
    }
}
