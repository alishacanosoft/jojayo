<?php

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $key => $each) {
            Order::create([
                'transaction_id' => null,
                'amount' => 20 + $each,
                'payment_status' => 0,
            ]);
        }
    }
}
