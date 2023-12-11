<?php

namespace App\Http\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\OrderProductRepository;

class UpdateStatusOrderAction extends BaseAction
{
    protected $orderRepository;
    protected $orderProductRepository;

    public function __construct
    (
        OrderRepository $orderRepository,
        OrderProductRepository $orderProductRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    public function handle()
    {
        $orderID = $this->request['id'];
        $status = (int)$this->request['status'];

        Order::where(['id' => $orderID])->update([
            'status' => DB::raw("array_append(status, $status)")
        ]);
        
        return $this->setMessage('update_success', 'status', null, null);
    }
}
