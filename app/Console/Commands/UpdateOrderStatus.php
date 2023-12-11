<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:order-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status every 5 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Order payment_status updated successfully.');

        $orders = Order::whereIn('status', [Order::PENDING, Order::TOSHIP, Order::SHIPPING])
            ->get();
        
        foreach ($orders as $order) {
            
            if ($order->status == Order::PENDING && $order->payment_method == Order::VNPAY) {
                continue;
            }

            $newStatus = $order->status + 1;
            $order->update(['status' => $newStatus]);
            Log::info('Order status updated successfully.');

            if ($newStatus == Order::COMPLETED) {
                $order->update(['payment_status' => true]);

                $vat = $order->total_amount * 0.01;
                Log::info($vat);

                // update vat vào tài khoản admin
                $account_balance = User::where('email', 'admin@gmail.com')->first()->account_balance;
                $account_balance += $vat;

                User::where('email', 'admin@gmail.com')->update(['account_balance' => $account_balance]);
                Log::info('Order payment_status updated successfully.');

                // update số dư tài khoản vào tài khoản người bán
                $account_balance_seller = User::where('shop_id', $order->shop_id)->first()->account_balance;
                $account_balance_seller += $order->total_amount - $vat;
                Log::info('account_balance_seller', $account_balance_seller);
                User::where('shop_id', $order->shop_id)->update(['account_balance' => $account_balance_seller]);
            }
        }
    }
}
